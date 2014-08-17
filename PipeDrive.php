<?php defined('SYSPATH') or die;

    class Dealroom_PipeDrive {

        /**
         * config array will overwrite default config values
         * @param null $config
         * @return object Dealroom_PipeDrive
         */

        public static function factory($config = null) {
            return new self($config);
        }

        protected $config;

        public function __construct($config = null) {

            $this->config = Kohana::$config->load('pipedrive')->as_array();
            if ($config && is_array($config) && !empty($config)) {
                $this->config = Arr::overwrite($this->config,$config);
            }

        }


        /**
         * Export user to pipedrive. Checck company exists
         * @param $bobject_user_id
         * @param null $bobject_company_id
         * @return mixed
         * @throws Kohana_Exception
         */

        public function export_user($bobject_user_id,$bobject_company_id = null) {

            $pipedrive_org_id = null;
            if ($bobject_company_id || !empty($bobject_company_id) && $bobject_company_id != 0) {
                $pipedrive_org_id = $this->get_company_id($bobject_company_id);
            }

            $user_data = ORM::factory('User')->get_user_for_pipedrive($bobject_user_id,$bobject_company_id);

            if (!$user_data || empty($user_data)) throw new Kohana_Exception('No user found');
            if (!isset($user_data['title']) && empty($user_data['title'])) $user_data['title'] = null;

            return $this->create_user($user_data['name'],$user_data['email'],$user_data['title'],$pipedrive_org_id);

        }


        /**
         * Get or create company at pipedrive
         * @param $bobject_company_id
         * @return int|null
         */

        public function get_company_id($bobject_company_id) {

            $pipedrive_org_id = null;

            $company_data = ORM::factory('Company')->get_company_for_pipedrive($bobject_company_id);

            if ($company_data && isset($company_data['name']) && !empty($company_data['name'])) {

                $search_company = $this->search_company($company_data['name']);

                if ($search_company['data']) {
                    if (!empty($search_company['data'])) {
                        foreach ($search_company['data'] as $c) {
                            if (strtolower($c['name']) == strtolower($company_data['name'])) {
                                $pipedrive_org_id = $c['id'];
                                break;
                            }
                        }
                    }
                } else {
                    $created_company = $this->create_company($company_data['name']);
                    $pipedrive_org_id = $created_company['data']['id'];
                }

            }

            return $pipedrive_org_id;

        }


        /**
         * Organization search api request
         * @param $name
         * @return mixed
         */

        public function search_company($name) {
            return $this->make_api_request('GET','organizations/find',$this->make_pipedrive_keys(array(
                'companies_search.name' => $name,
            )));
        }


        /**
         * Create pipedrive organization
         * @param $name
         * @return mixed
         */

        public function create_company($name) {
            return $this->make_api_request('POST','organizations',$this->make_pipedrive_keys(array(
                'company.name' => $name,
            )));
        }


        /**
         * Create pipedrive user
         * @param $name
         * @param $email
         * @param $title
         * @param $pipedrive_org_id
         * @return mixed
         */

        public function create_user($name,$email,$title,$pipedrive_org_id) {

            $data = array(
                'user.name' => $name,
                'user.email' => array(
                    array(
                        'label' => '',
                        'value' => $email,
                        'primary' => true,
                    )
                ),
            );
            if ($title) {
                $data['user.title'] = $title;
            }
            if ($pipedrive_org_id && $pipedrive_org_id > 0) {
                $data['user.company'] = $pipedrive_org_id;
            }

            return $this->make_api_request('POST','persons',$this->make_pipedrive_keys($data));
        }


        /**
         * Make pipedrive api request
         * @param $method
         * @param $action
         * @param array $params
         * @return mixed
         * @throws Kohana_Exception
         */

        protected function make_api_request($method,$action,array $params) {

            $endpoint_url = $this->config['api_endpoint'] . $action . '?api_token=' . $this->config['api_key'];

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$endpoint_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            switch ($method) {
                case 'POST':
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    break;
                case 'PUT':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    break;
                case 'GET':
                    curl_setopt($ch,CURLOPT_URL,$endpoint_url.'&'.http_build_query($params));
                    break;
                case 'DELETE':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    break;
            }

            $result = json_decode(curl_exec($ch),true);
            curl_close($ch);

//            $result = json_decode($response->body(),true);

            if (!$result['success']) {
                throw new Kohana_Exception('Pipedrive api request fails: '.$result['error']);
            }
            return $result;

        }


        /**
         * Replace keys for pipedrive associates
         * @param array $params
         * @return array
         * @throws Kohana_Exception
         */

        protected function make_pipedrive_keys(array $params) {

            if (empty($params)) return array();
            $result = array();
            foreach ($params as $key=>$value) {
                if (!isset($this->config['fields'][$key])) throw new Kohana_Exception('No pipedrive key for '.$key);
                $result[$this->config['fields'][$key]] = $value;
            }
            return $result;

        }

    }