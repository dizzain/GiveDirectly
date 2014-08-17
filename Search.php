<?php defined('SYSPATH') or die;

    abstract class Dealroom_Search {

        public static function factory($type) {

            $classname = 'Dealroom_Search_'.ucfirst($type);
            return new $classname($type);

        }

        protected $_search_type;
        protected $_config;
        protected $_facets_top_n = 1000;
        protected $_facets;
        protected $_query_key;
        protected $_growth_stages;
        protected $_deal_structures;
        protected $_investor_types;
        protected $_url;
        protected $_session;
        protected $_cache;

        protected $_session_facets_key;
        protected $_session_keyword_key = '_search_keyword';

        protected $_cache_facets_key;
        protected $_cache_total_key;
        protected $_cache_stock_key;

        public function __construct($type) {

            $this->_search_type = $type;

            $this->_config = Kohana::$config->load('cloud_search.'.$type);
            if (!$this->_config) throw new Kohana_Exception('Config file not loaded');

            $this->_growth_stages = Utils::get_growth_stages();
            $this->_growth_stages[0] = array_values($this->_growth_stages);

            $this->_deal_structures = Utils::get_deal_structure();
            $this->_deal_structures[0] = array_values($this->_deal_structures);
            $this->_investor_types = Utils::get_investor_types();
            $this->_investor_types[0] = array_values($this->_investor_types);

            $this->_url = 'http://'.$this->_config['search_endpoint'].'/2011-02-01/search?';
            $this->_session = Session::instance();
            $this->_cache = Cache::instance();

        }

        protected function _implode_values($name,array $values,$int=false) {

            $arr = array();
            foreach ($values as $value) {
                $arr[] = $int ? $name.":".$value : $name.":'".urlencode(addslashes($value))."'";
            }
            return implode('+',$arr);

        }

        protected function _request_data($url) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

            $json = curl_exec($ch);
            curl_close($ch);

            return json_decode($json, true);

        }

        protected function _get_facets_data() {

            $cached_facets = $this->_get_cached($this->_cache_facets_key);

            if ($cached_facets !== FALSE) {
    //                ChromeLogger::log('Use cached facets');
                return $cached_facets;
            }

            $response = array();
            $str = '';
            foreach (range('a','z') as $l) {
                $str .= "+".$this->_query_key.":'*".$l."*'";
            }

            $bq = "bq=(or".$str.")".$this->_build_facets($this->_facets,$this->_facets_top_n);
            $data = $this->_request_data($this->_url.$bq);

            if (isset($data['facets']) && !empty($data['facets'])) {
                $response = $this->_make_facets_array($data['facets']);
            }
            if (!empty($response)) {
    //                ChromeLogger::log('Set facets cache');
                $this->_set_cached($this->_cache_facets_key,$response,Date::HOUR*12);
            }

    //            ChromeLogger::log('Use not cached facets');
            return $response;

        }

        protected function _make_facets_array(array $facets_data,$form_data = array()) {

            $result = array();
            if (!empty($form_data)) {
                $form_data = Arr::map('strtolower',$form_data);
                foreach ($this->_facets as $facet) {
                    if (isset($facets_data[$facet['facet_key']]['constraints'])) {
                        $active = array(); $inactive = array();
                        foreach ($facets_data[$facet['facet_key']]['constraints'] as $v) {
                            if (isset($form_data[$facet['form_key']]) && in_array(strtolower($v['value']),$form_data[$facet['form_key']])) {
                                //active
                                $active[] = array('title'=>$v['value'],'count'=>$v['count'],'active'=> true);
                            } else {
                                // inactive
                                $inactive[] = array('title'=>$v['value'],'count'=>$v['count'],'active'=> false);
                            }
                            $result[$facet['form_key']] = array_merge($active,$inactive);
                        }
                    } else if ($facet['facet_int'] && isset($form_data[$facet['form_key']])) {
                        $result['literal'][] = array('key'=>$facet['form_key'],'value'=>array_shift($form_data[$facet['form_key']]));
                    }
                }

            } else {
                foreach ($this->_facets as $facet) {
                    if (isset($facets_data[$facet['facet_key']]['constraints'])) {
                        foreach ($facets_data[$facet['facet_key']]['constraints'] as $v) {
                            $result[$facet['form_key']][] = array('title'=>$v['value'],'count'=>$v['count']);
                        }
                    }
                }
            }
    //            $result = $this->_resort_facets($result);
            return $result;

        }

        // UNUSED
        protected function _resort_facets($result) {

    //            ChromeLogger::log('Do resorting facets');
            if (isset($result['investment_stages']) && !empty($result['investment_stages'])) {
                $resorted = array();
                foreach ($result['investment_stages'] as $stage) {
                    switch ($stage['title']) {
                        case 'mature stage':
                            $resorted[0] = $stage;
                            break;
                        case 'late growth stage':
                            $resorted[1] = $stage;
                            break;
                        case 'early growth stage':
                            $resorted[2] = $stage;
                            break;
                        case 'seed stage':
                            $resorted[3] = $stage;
                            break;
                    }
                }
    //                ChromeLogger::log(array_values($resorted));
                $result['investment_stages'] = $resorted;
    //                ChromeLogger::log($result['investment_stages']);
            }
            return $result;

        }


        protected function _build_facets($facets,$facets_num) {

            if (!empty($facets)) {
                $f1 = '&facet=';
                $f2 = '';
                foreach ($facets as $facet) {
                    if ($facet['sort'] === true) continue;
                    $f1 .= $facet['facet_key'].',';
                    $f2 .= '&facet-'.$facet['facet_key'].'-top-n='.$facets_num;
                }
                return rtrim($f1,',').$f2;
            }
            return '';

        }

        protected function _set_data($key,$value) {

            if (is_array($value)) {
                $value = serialize($value);
            }
            $this->_session->set($key,$value);

        }

        protected function _get_data($key) {

            $value = $this->_session->get($key);
            $unserialized = @unserialize($value);
            if (!$value !== null && $unserialized !== FALSE) {
                return $unserialized;
            }
            return $value;

        }

        protected function _unset_data($key) {

            $this->_session->delete($key,null);

        }

        public function reset_data() {
            $this->_set_data($this->_session_keyword_key,'');
            $this->_set_data($this->_session_facets_key,'');
        }

        protected function _get_cached($key) {

            if (!$this->_cache) throw new Kohana_Exception('No cache configured');

            $cached_data = $this->_cache->get($key);
            if (!$cached_data) return false;
            $unserialized = @unserialize($cached_data);
            if ($unserialized !== FALSE) {
                return $unserialized;
            }
            return $cached_data;

        }

        protected function _set_cached($key, $data, $expire = Date::HOUR) {

            if (!$this->_cache) throw new Kohana_Exception('No cache configured');

            if (is_array($data)) {
                $data = serialize($data);
            }
            $this->_cache->set($key,$data, $expire);

        }

        protected function _delete_cached($key) {

            $this->_cache->delete($key);

        }

        protected function _build_boolean_query($keyword,$data) {

            $bq = "bq=(and";
            if ($keyword != '') {
    //                $words = explode(' ',$keyword);
    //                if (!empty($words)) {
    //                    $bq .= "+(or";
    //                    foreach ($words as $w) {
    //                        $bq .= "+".$this->_query_key.":'*".urlencode(addslashes($w))."*'";
    //                    }
    //                    foreach ($words as $w) {
    //                        $bq .= "+".$this->_query_key.":'".urlencode(addslashes($w))."'";
    //                    }
    //                    $bq .= ")";
    //                }
                $bq .= "+(or+".$this->_query_key.":'*".urlencode(addslashes($keyword))."*'+".$this->_query_key.":'".urlencode(addslashes($keyword))."')";
            } else {
                $str = '';
                foreach (range('a','z') as $l) {
                    $str .= "+".$this->_query_key.":'*".$l."*'";
                }
                $bq .= "+(or".$str.")";
            }
            foreach ($this->_facets as $facet) {

                if (!empty($data[$facet['form_key']])) {
                    $bq .= "+(or+".$this->_implode_values($facet['facet_key'],$data[$facet['form_key']],$facet['facet_int']).")";
                }

            }
            $bq .= ")";
            return $bq;

        }

        protected function  _build_sort($data,$add_text_relevance = false,$sort_by=null,$sort_order=null) {

            $sort_str = '';

            if ($add_text_relevance) {
                $sort_str = '&rank=-text_relevance';
            }

            foreach ($this->_facets as $facet) {

                if (!$facet['sort']) continue;

                if ($sort_by && $facet['form_key'] == $sort_by) {
                    if (empty($sort_str)) {
                        $sort_str = '&rank='.($sort_order == 'asc' ? '' : '-').$facet['facet_key'];
                    } else {
                        $sort_str .= ','.($sort_order == 'asc' ? '' : '-').$facet['facet_key'];
                    }
                } else if (!empty($data[$facet['form_key']]) && $facet['sort'] == true) {
                    if (empty($sort_str)) {
                        $sort_str = '&rank=-'.$facet['facet_key'];
                    } else {
                        $sort_str .= ',-'.$facet['facet_key'];
                    }
                }

            }

            if ($sort_by == 'deal_size') {
                if (empty($sort_str)) {
                    $sort_str = '&rank='.($sort_order == 'asc' ? '' : '-').'investor_max_deal';
                } else {
                    $sort_str .= ','.($sort_order == 'asc' ? '' : '-').'investor_max_deal';
                }
            }

            return $sort_str;

        }

        public function make_search($keyword,$page,$form_data,$need_facets = false,$sort_by=null,$sort_order=null) {

            // TODO кэш для нулевых поисков
            $data = array();
            parse_str($form_data,$data);

//            $this->_set_data($this->_session_keyword_key,$keyword);
            $this->_set_data($this->_session_facets_key,$data);

            $data = $this->_format_form_data($data);

            $bq = $this->_build_boolean_query($keyword,$data);
            $start = $page > 0 ? ($page-1)*$this->_config['per_page'] : 0;
            $facets = '';
            if ($need_facets) {
                $facets = $this->_build_facets($this->_facets,$this->_facets_top_n);
            }

            $sort = $this->_build_sort($data,$keyword && !empty($keyword) ? true : false,$sort_by,$sort_order);

            $request_url = $this->_url.$bq.'&size='.$this->_config['per_page'].'&start='.$start.$sort.$facets;
            ChromeLogger::log($request_url);
            $search_response = $this->_request_data($request_url);

            $response = $this->_make_response($search_response,$data,$need_facets);

            return $response;

        }

        public function get_all_results($keyword,$form_data) {

            $data = array();
            parse_str($form_data,$data);

            $data = $this->_format_form_data($data);

            $bq = $this->_build_boolean_query($keyword,$data);
            $start = 0;

            $sort = $this->_build_sort($data,$keyword && !empty($keyword) ? true : false);

            $request_url = $this->_url.$bq.'&size=10000&start='.$start.$sort;
//            ChromeLogger::log($request_url);
            $search_response = $this->_request_data($request_url);

            $bobject_ids = array();

            if ($search_response['hits']['hit'] && !empty($search_response['hits']['hit'])) {

                $bobject_ids = array();
                foreach ($search_response['hits']['hit'] as $hit) {
                    $bobject_ids[] = str_replace('bobject','',$hit['id']);
                }

            }

            return $bobject_ids;

        }

        protected function _make_response($data,$form_data,$need_facets = false) {

            $response = array();
            $response['results'] = array();
            $response['total'] = $data['hits']['found'];
            $response['expr'] = $data['match-expr'];

            if ($data['hits']['hit'] && !empty($data['hits']['hit'])) {

                $bobjects = array();
                foreach ($data['hits']['hit'] as $hit) {
                    $bobjects[] = str_replace('bobject','',$hit['id']);
    //                    ChromeLogger::log($hit['id']);
                }
                $response['results'] = $this->_get_response_data($bobjects);
    //                var_dump($response['results']);

            }

            if ($need_facets) {
                $response['facets'] = array();
                if (isset($data['facets']) && !empty($data['facets'])) {
                    $response['facets'] = $this->_make_facets_array($data['facets'],$form_data);
                } else {
                    foreach ($form_data as $key=>$row) {
                        if (is_array($row) && !empty($row)) {
                            foreach ($row as $item) {
                                $response['facets'][$key][] = array(
                                    'title' => $item,
                                    'count' => 0,
                                    'active' => true,
                                );
                            }
                        }

                    }
                }
            }

            return $response;

        }

        public function get_saved_init() {

            $keyword = $this->_get_data($this->_session_keyword_key);
            $facets = $this->_get_data($this->_session_facets_key);

            if (!empty($keyword) || (!empty($facets) && (http_build_query($facets) !== 'min_deal=0&max_deal=11000000000' && http_build_query($facets) !== 'is_recommended%5B0%5D=0..'))) {

                $result = $this->make_search($keyword,0,!empty($facets) ? http_build_query($facets) : '',true);
                return array($result['facets'],$result['results'],$result['total'],$keyword,true);

            }

            return array(null,null,null,null,false);

        }

        public function get_saved_keyword() {

            $keyword = $this->_get_data($this->_session_keyword_key);

            if (!empty($keyword)) {

                $result = $this->make_search($keyword,0,'',true);
                return array($result['facets'],$result['results'],$result['total'],$keyword,true);

            }

            return array(null,null,null,null,false);

        }

        public function format_locations($data) {
            $locations = array();
            foreach ($data as $location) {
                $location_model = ORM::factory('Param_Location')->where('name','=',$location)->find();
                if ($location_model->loaded()) {
                    if ($location_model->is_country == 1) {
                        $locations[] = $location_model->name;
                    } else {
                        if (ORM::factory('Param_Location')->check_is_region($location_model->id)) {
                            $locations[] = $location_model->name;
                        } else {
                            $i = 0;
                            do {
                                $location_model = ORM::factory('Param_Location')->where('id','=',$location_model->parent)->find();
                                if ($location_model->loaded() && $location_model->is_country == 1) {
                                    $locations[] = $location_model->name;
                                    break;
                                }
                                $i++;
                                if ($i == 3) break;
                            } while (true);
                        }
                    }
                }
            }
            return $locations;
        }

        public function clear_stock_cache() {

            // clear only 10 steps
            for ($i=0;$i<=9;$i++) {

                $this->_delete_cached($this->_cache_stock_key.'_'.(15*($i+1)).'_'.(15*$i));
                $this->_delete_cached($this->_cache_stock_key.'_'.(25*($i+1)).'_'.(25*$i));

            }

        }

        public function reset_keyword() {
            $this->_unset_data($this->_session_keyword_key);
        }

        public function get_search_type() {
            return $this->_search_type;
        }

        public function get_per_page_num() {
            return $this->_config['per_page'];
        }


        abstract function get_facets();

    //        abstract function make_search($keyword,$page,$form_data,$need_facets = false);

        abstract protected function _format_form_data($data);

    //        abstract protected function _make_response($response,$data,$need_facets);

        abstract protected function _get_response_data($ids);

        abstract protected function _get_total();


    }