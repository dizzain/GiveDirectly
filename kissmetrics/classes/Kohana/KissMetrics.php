<?php defined('SYSPATH') or die;

    class Kohana_KissMetrics {

        const KM_TRANSPORT_SOCKETS = 'sockets';

        public static function factory($transport_type = self::KM_TRANSPORT_SOCKETS) {
            return new self($transport_type);
        }

        /**
         * API key
         * @var string
         */
        private $key;

        /**
         * User identification
         * @var string
         */
        private $id;

        /**
         * Queries queued for submission
         * @var array
         */
        private $queries;

        /**
         * Transport instance
         * @var Kohana_KissMetrics_Transport
         */
        protected $transport;

        /**
         * Transport type
         * @var $transport_type
         */
        protected $transport_type;

        /**
         * Only production
         * @var boolean $only_production
         */
        protected $only_production;

        /**
         * Initialize
         * @param string $transport_type
         */
        public function __construct($transport_type = self::KM_TRANSPORT_SOCKETS) {
            $this->key = Kohana::$config->load('kissmetrics.api_key');
            $this->only_production = Kohana::$config->load('kissmetrics.only_production');

            $this->queries   = array();
            $this->transport_type = $transport_type;
        }

        /**
         * Get API key
         * @return string
         */
        public function getKey() {
            return $this->key;
        }

        /**
         * Identify user
         * @param  string $id
         * @return Kohana_KissMetrics
         */
        public function identify($id) {
            $this->id = $id;
            return $this;
        }

        /**
         * Get identification
         * @return string
         */
        public function getId() {
            return $this->id;
        }

        /**
         * Alias an alternative name to the currently identified user
         * @param  string $old_id
         * @return Kohana_KissMetrics
         */
        public function alias($old_id) {
            $this->ensureSetup();

            array_push($this->queries, array(
                'a',
                array(
                    '_p' => $old_id,
                    '_n' => $this->id,
                    '_k' => $this->key
                )
            ));

            return $this;
        }

        /**
         * Record an event with properties
         * @param  string  $event
         * @param  array   $properties
         * @param  integer $time
         * @return Kohana_KissMetrics
         */
        public function record($event, $properties = array(), $time = null) {
            $this->ensureSetup();

            if(is_null($time)) {
                $time = time();
            }

            array_push($this->queries, array(
                'e',
                array_merge($properties, array(
                    '_n' => $event,
                    '_p' => $this->id,
                    '_k' => $this->key,
                    '_t' => $time
                ))
            ));

            return $this;
        }

        /**
         * Set a property on the user
         * @param  array   $properties
         * @param  integer $time
         * @return Kohana_KissMetrics
         */
        public function set($properties, $time = null) {
            $this->ensureSetup();

            if(is_null($time)) {
                $time = time();
            }

            array_push($this->queries, array(
                's',
                array_merge($properties, array(
                    '_k' => $this->key,
                    '_p' => $this->id,
                    '_t' => $time
                ))
            ));

            return $this;
        }

        /**
         * Ensure that all data is setup before doing any things
         * @throws Kohana_Exception
         * @return void
         */
        private function ensureSetup() {
            if(is_null($this->key)) {
                throw new Kohana_Exception("KISSmetrics API key not specified");
            }
            if(is_null($this->id)) {
                throw new Kohana_Exception("KISSmetrics user not identified yet");
            }
            if (is_null($this->transport_type)) {
                throw new Kohana_Exception("Kissmetrics transport not set");
            }
            if (is_null($this->transport)) {
                $this->initTransport();
            }
        }

        /**
         * Get queued events
         * @return array
         */
        public function getQueries() {
            return $this->queries;
        }

        /**
         * Submit the things to the remote host
         * @return void
         */
        public function submit() {
            if ($this->only_production && Kohana::$environment != Kohana::PRODUCTION) {
                return;
            }
            $this->transport->submitData($this->queries);
        }

        protected function initTransport() {
            $this->transport = Kohana_KissMetrics_Transport::factory($this->transport_type);
        }

    }