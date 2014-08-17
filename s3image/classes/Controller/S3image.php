<?php defined('SYSPATH') or die;

    class Controller_S3image extends Controller {

        // DEPRECATED
        public function action_index() {

            $image_path = $this->request->query('image');

            if (!$image_path || empty($image_path)) {
                $image = $this->get_fish_image($image_path);
                $this->show_image($image);
            }

            if ($image_path == 'robots.txt') {
                $robots_data = @file_get_contents('https://s3-eu-west-1.amazonaws.com/storage.dealroom.co/robots.txt');
                $this->response->headers('Content-Type','text/plain');
                $this->response->send_headers();
                echo $this->response->body($robots_data);
                die;
            }

            $image = S3image::instance()->process($image_path);
            if (!$image) {
                $image = $this->get_fish_image($image_path);
            }

            $this->show_image($image);

        }

        protected function get_fish_image($image) {

            $image_data = S3image::instance()->decrypt($image);
            $image_path = Utils::get_null_image('avatar_'.$image_data['width'],$image_data['type']);
            $image = Image::factory($image_path);
            return $image;

        }

        protected function show_image($image) {

            $this->response->headers('Content-type',$image->mime);
            $this->response->send_headers();
            echo $this->response->body($image->render(null,100));
            die;

        }

        public function action_test() {

            $url = '//s3-eu-west-1.amazonaws.com/staging-storage.dealroom.co/2014/08/05/574537525092b7a4105f5c7beb00001b.jpg';
            $path = '2014/08/05/574537525092b7a4105f5c7beb00001b.jpg';

//            if (isset($_POST['upload'])) {
//
//                $file = $_FILES['file'];
//
//                $image = Image::factory($file['tmp_name']);
//
//                $name = md5(microtime());
//                $path = date('Y').'/'.date('m').'/'.date('d').'/';
//                $ext = substr($file['name'],strrpos($file['name'],'.')+1);
//
//                $tmp_imagefile = S3image::instance()->set_tmp_file($image->render($ext,100));
//
//                $url = S3image::instance()->set_file($tmp_imagefile,$image->mime,$path.$name.'.'.$ext);
//
//                $image_saved = array(
//                    'file' => $path.$name.'.'.$ext,
//                    'url'  => $url,
//                    'tag'  => 'original',
//                );
//                unlink($tmp_imagefile);
//
//                var_dump($image_saved);
//
//            } else {
//
//                echo Form::open('',array('method'=>'post','enctype'=>'multipart/form-data'));
//
//                echo Form::file('file');
//                echo Form::submit('upload','Upload');
//
//                echo Form::close();
//
//            }

            echo "<pre>";

//            $thumb = '//s3-eu-west-1.amazonaws.com/staging-storage.dealroom.co/32/xHd9O64e4t7dXGe9yY0yYlJ-0USC3f3k7fsPp-tkpv7s2wshgCMdF547iVH9SrUOjgoUAi4Poh6coUy8GMwhBJA68~JNqoVizDXBasOAB7voK3~FfblMk6IWqU6hee0V~GvUe5yw5x-iiA2yvw__.jpg';
//            $thumb2 = '98/xHF9O6ge4t7dXGe9js8ldhhsmlOTkaC44~kD8-dl6LuvxFth3DxBU8tz1VujXvUchxtCUHJCp03PqAi2FJFqXskk8fBE-J5nkS0_.jpg';

//            S3image::instance()->process($thumb);
//            S3image::instance()->process($thumb2);


        }

    }