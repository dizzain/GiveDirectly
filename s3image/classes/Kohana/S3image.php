<?php defined('SYSPATH') or die;
require_once Kohana::find_file('vendor','CRC4Crypt');
require_once Kohana::find_file('vendor','S3');

    class Kohana_S3image {

        static $instance = NULL;

        public static function instance(array $config = array()) {
            if (!empty($config)) {
                return new S3image($config);
            }
            if (self::$instance == null) {
                self::$instance = new S3image();
            }
            return self::$instance;
        }

        protected $_s3 = NULL;
        protected $_buckets;
        protected $_config;

        public function __construct(array $config = array()) {

            $default_config = Kohana::$config->load('s3image')->as_array();
            $this->_config = array_merge($config,$default_config);
            $this->_s3 = $this->_s3();

        }

        protected function _s3() {

            if ($this->_s3 == null) {
                $this->_s3 = new S3($this->_config['access_key'],$this->_config['secret_key']);
                $this->_s3->setEndpoint($this->_config['endpoint']);
            }
            return $this->_s3;

        }

        protected function _url_encode($url) {
            return str_replace(array(
                '+',
                '=',
                '/'
            ), array(
                '-',
                '_',
                '~'
            ), CRC4Crypt::base64_encrypt($this->_config['crypt_password'], $url));
        }

        protected function _url_decode($url) {
            return CRC4Crypt::base64_decrypt($this->_config['crypt_password'], str_replace(array(
                '-',
                '_',
                '~'
            ), array(
                '+',
                '=',
                '/'
            ), $url));
        }


        protected function _ext($url) {
            return mb_substr($url, 1 + mb_strrpos($url, "."));
        }

        protected function _get_bucket($fl) {
            $ab = array(
                '0',
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                'a',
                'b',
                'c',
                'd',
                'e',
                'f'
            );

            $key = array_search($fl, $ab);
            $col = 16 / sizeof($this->_config['buckets']);
            $id = sizeof($this->_config['buckets']) - ceil((16 - $key) / $col);
            return $this->_config['buckets'][$id];
        }

        public function url($url, $width, $height, $type = 'user', $array = false) {
            $ext = $this->_ext($url);
            $url = str_replace(array(
                '.' . $ext,
                'http://',
                'https://',
                '//',
            ), '', $url);
            $crypt = $width . ':'. $height . ':' . $type . '@' . $url;
            $path = $this->_url_encode($crypt) . '.' . $ext;

            if ($array) {
                return array(
                    'protocol' => '//',
                    'host' => $this->_config['endpoint'],
                    'bucket' => $this->_get_bucket(mb_substr(md5($path), 0, 1)),
                    'folder' => mb_substr(md5($path), 0, 2),
                    'path' => $path,
                    'ext' => $ext,
                );
            } else {
                return '//' . $this->_config['endpoint'] . '/' . $this->_get_bucket(mb_substr(md5($path), 0, 1)) . '/' . mb_substr(md5($path), 0, 2) . '/' . $path;
            }

        }

        public function decrypt($path) {

            $params = preg_split('/(.*?)\/((.*?)\.(.*))/', $path, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            $decrypt = preg_split('/(.*?):(.*?):(.*?)@(.*)/', $this->_url_decode($params[2]), null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            // проверка на верность крипта
            if (empty($decrypt[2]))
                return false;

            return array(
                'folder' => $params[0],
                'file' => $params[1],
                'ext' => $params[3],
                'width' => $decrypt[0],
                'height' => $decrypt[1],
                'type' => $decrypt[2],
                'src' => preg_match('/:\/\//', $decrypt[3]) ? $decrypt[3] . '.' . $params[3] : 'http://' . $decrypt[3] . '.' . $params[3],
            );

        }

        public function process($path) {

//            $params = preg_split('/(.*?)\/((.*?)\.(.*))/', $path, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
//
//            $folder = $params[0];
//            $file = $params[1];
//            $ext = $params[3];
//            $decrypt = preg_split('/(.*?):(.*?):(.*?)@(.*)/', $this->_url_decode($params[2]), null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
//
//            // проверка на верность крипта
//            if (empty($decrypt[2]))
//                return false;
//
//            $width = $decrypt[0];
//            $height = $decrypt[1];
//            $type = $decrypt[2];
//            $src = preg_match('/:\/\//', $decrypt[3]) ? $decrypt[3] . '.' . $ext : 'http://' . $decrypt[3] . '.' . $ext;

            $file_data = $this->decrypt($path);

            if (!$file_data) return false;

            $uri = $file_data['folder'] . '/' . $file_data['file'];
            $bucket = $this->_get_bucket(mb_substr($file_data['folder'], 0, 1));

            $remote_tmp_file = $this->get_remote_file($file_data['src']);

            $image = Image::factory($remote_tmp_file);

            switch ($file_data['type']) {
                case 'user':

                    // resize than crop
                    $image->resize($file_data['width'],$file_data['height'],Image::INVERSE)->crop($file_data['width'],$file_data['height']);

                    break;
                case 'company':

                    // resize with white background
                    $image->resize($file_data['width'],$file_data['height'],Image::AUTO)->create_thumb_with_white_background($file_data['width'],$file_data['height']);

                    break;
                case 'media':

                    // just resize
                    $image->resize($file_data['width'],$file_data['height'],Image::AUTO);

                    break;
                default: throw new Kohana_Exception('Invalid type');
            }

            $image->save($remote_tmp_file,100);
            $this->set_file($remote_tmp_file,$image->mime,$uri,$bucket);
            unlink($remote_tmp_file);

            return $image;

        }

        public function process_file($file,$url,$width,$height,$type = 'user') {

            $url_data = $this->url($url,$width,$height,$type,true);

            $uri = $url_data['folder'] . '/' . $url_data['path'];
            $bucket = $this->_get_bucket(mb_substr($url_data['folder'], 0, 1));

            $image = Image::factory($file);

            switch ($type) {
                case 'user':

                    // resize than crop
                    $image->resize($width,$height,Image::INVERSE)->crop($width,$height);

                    break;
                case 'company':

                    // resize with white background
                    $image->resize($width,$height,Image::AUTO)->create_thumb_with_white_background($width,$height);

                    break;
                case 'media':

                    // just resize
                    $image->resize($width,$height,Image::AUTO);

                    break;
                default: throw new Kohana_Exception('Invalid type');
            }

            $tmp_imagefile = $this->set_tmp_file($image->render($url_data['ext'],100));

            $this->set_file($tmp_imagefile,$image->mime,$uri,$bucket);
            unlink($tmp_imagefile);

            return '//' . $this->_config['endpoint'] . '/' . $bucket . '/' . $uri;

        }


        public function set_file($path,$mime,$uri,$bucket=null) {

            if ($bucket == null) {
                $bucket = $this->_get_bucket('');
            }

            $this->_s3()->putObject($this->_s3()->inputFile($path), $bucket, $uri, S3::ACL_PUBLIC_READ, array(), array(
                "Cache-Control" => "max-age=315360000",
                "Expires" => gmdate("D, d M Y H:i:s T", strtotime("+5 years")),
                "Content-Type" => $mime
            ));
            return '//' . $this->_config['endpoint'] . '/' . $bucket . '/' . $uri;

        }

        public function get_remote_file($path) {
            $ch = curl_init($path);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
            $content = curl_exec($ch);
            return $this->set_tmp_file($content);
        }

        public function set_tmp_file($content) {
            $fileName = tempnam(sys_get_temp_dir(), 'file_');
            file_put_contents($fileName, $content);
            return $fileName;
        }

        public function delete_file($url, $encrypted = true) {

            if (!$encrypted) {
                $bucket = $this->_get_bucket('');
                $uri = str_replace('//' . $this->_config['endpoint'] . '/' .$bucket . '/','',$url);
            } else {
                $params = preg_split('/(.*?)\/((.*?)\.(.*))/', $url, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                $folder = $params[0];
                $file = $params[1];
                $bucket = $this->_get_bucket(mb_substr($folder, 0, 1));
                $uri = $folder.'/'.$file;
            }

            $this->_s3()->deleteObject($bucket, $uri);
        }


    }