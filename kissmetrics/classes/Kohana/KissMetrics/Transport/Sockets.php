<?php

    class Kohana_KissMetrics_Transport_Sockets extends Kohana_KissMetrics_Transport {

        /**
        * Host
        * @var string
        */
        protected $host;

        /**
        * Port
        * @var integer
        */
        protected $port;

        /**
        * Request timeout
        * @var integer
        */
        protected $timeout;

        /**
        * Constructor
        * @param array  $data
        */
        public function __construct(array $data = array()) {
            $this->host = isset($data['host']) ? $data['host'] : 'trk.kissmetrics.com';
            $this->port = isset($data['port']) ? $data['port'] : 80;
            $this->timeout = isset($data['timeout']) ? $data['timeout'] : 30;
        }

        /**
        * Get host
        * @return string
        */
        public function getHost() {
          return $this->host;
        }

        /**
        * Get port
        * @return integer
        */
        public function getPort() {
            return $this->port;
        }

        /**
        * @see Transport
        */
        public function submitData(array $queries) {

            $fp = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);

            if(! $fp) {
                throw new Kohana_Exception("Cannot connect to the KISSmetrics server: " . $errstr);
            }

            stream_set_blocking($fp, 0);

            $i = 0;

            foreach($queries as $data) {
                $query = http_build_query($data[1], '', '&');
                $query = str_replace(
                   array('+', '%7E'),
                   array('%20', '~'),
                   $query
               );

               $req  = 'GET /' . $data[0] . '?' . $query . ' HTTP/1.1' . "\r\n";
                $req .= 'Host: ' . $this->host . "\r\n";

                if(++$i == count($queries)) {
                    $req .= 'Connection: Close' . "\r\n\r\n";
                } else {
                    $req .= 'Connection: Keep-Alive' . "\r\n\r\n";
                }

                $written = fwrite($fp, $req);

                if($written === false) {
                    throw new Kohana_Exception("Could not submit the query: /" . $data[0] . "?" . $query);
                }
            }

            fclose($fp);

        }
    }
