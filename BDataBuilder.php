<?php defined('SYSPATH') or die;

    class Dealroom_BDataBuilder {

        public static function factory() {
            return new self();
        }

        protected $_preset_fields;

        protected $types = array();
        protected $fields = array();
        protected $with = array();
        protected $additional = array();
        protected $params = array();
        protected $special = array();
        protected $offset;
        protected $limit;
        protected $sort;
        protected $where = array();
        protected $joins = array();
        protected $post_process = array();

        protected $only_values;
        protected $keys_values;
        protected $first;

        protected $ext_params_array = false;
        protected $ext_params_array_key = 'params';

        public function __construct() {
            $this->_preset_fields = Kohana::$config->load('bdatabuilder.preset_fields');
        }

        public function types($types) {

            if (is_array($types)) {

                $this->types = $types;

            } else {

                $this->types = array($types);

            }

            return $this;

        }


        public function fields($fields) {

            if (is_array($fields)) {

                $this->fields = $fields;

            } else {

                $this->fields = array($fields);

            }

            return $this;

        }


        public function with($with) {

            if (is_array($with)) {

                $this->with = $with;

            } else {

                $this->with = array($with);

            }

            return $this;

        }


        public function params($params, $ext_params_array = false, $ext_params_array_key = null) {

            if (is_array($params)) {

                $this->params = $params;

            } else {

                $this->params = array($params);

            }

            $this->ext_params_array = $ext_params_array;

            if ($ext_params_array_key) {

                $this->ext_params_array_key = $ext_params_array_key;

            }

            return $this;

        }


        public function post_process($post_process) {

            if (is_array($post_process)) {

                $this->post_process = $post_process;

            } else {

                $this->post_process = array($post_process);

            }

            return $this;

        }


        public function special($special) {

            if (is_array($special)) {

                $this->special = $special;

            } else {

                $this->special = array($special);

            }

            return $this;

        }


        public function where($field, $operator, $value) {

            $this->where[] = array(
                'field' => $field,
                'operator' => $operator,
                'value' => $value,
            );

            return $this;

        }


        public function limit($limit) {

            if (!is_numeric($limit)) throw new Kohana_Exception('BDataBuilder: Limit must be a numeric');

            $this->limit = $limit;

            return $this;

        }


        public function offset($offset) {

            if (!is_numeric($offset)) throw new Kohana_Exception('BDataBuilder: Limit must be a numeric');

            $this->offset = $offset;

            return $this;

        }


        public function sort($field,$order = null) {

            $this->sort = array(
                'field' => $field,
                'order' => $order,
            );

            return $this;

        }

        // still not used...
        public function additional($additional) {

            $this->keys_values = null;
            $this->only_values = null;

            if (is_array($additional)) {

                $this->additional = $additional;

            } else {

                $this->additional = array($additional);

            }

            return $this;

        }


        public function only_values($key) {

            $this->only_values = $key;
            $this->keys_values = null;

            return $this;

        }


        public function keys_values($key, $value) {

            $this->keys_values = array(
                'key' => $key,
                'value' => $value,
            );

            return $this;

        }


        public function first() {

            $this->first = true;

            return $this;

        }


        public function execute() {

            // TODO do this HUGE job :)

            $this->_process_withes($this->with);
            $this->_process_special($this->special);

            $query = null;

            $fields = $this->_format_fields($this->fields);

            $query = call_user_func_array('DB::select',$fields);

            $query = $query->from(ORM::factory('Bobject')->table_name());

            // joins comes here
            if ($this->joins && !empty($this->joins)) {

                foreach ($this->joins as $join) {

                    $query = $query->join($join['table'],$join['type']);

                    if ($join['conditions'] && !empty($join['conditions'])) {

                        foreach ($join['conditions'] as $condition) {

                            $query = $query->on($condition[0],$condition[1],$condition[2]);

                        }

                    }

                }

            }

            // where comes here
            if ($this->where && !empty($this->where)) {

                foreach ($this->where as $where) {

                    $query = $query->and_where(
                        $this->_get_preset_key($where['field']),
                        $where['operator'],
                        $where['value']
                    );

                }

            }

            if ($this->types && !empty($this->types)) {

                if (count($this->types) == 1) {

                    $query = $query->and_where(
                        $this->_get_preset_key('type'),
                        '=',
                        array_shift($this->types)
                    );

                } else {

                    $query = $query->and_where(
                        $this->_get_preset_key('type'),
                        'IN',
                        $this->types
                    );

                }

            }

            // sort comes here
            if ($this->sort) {

                $query = $query->order_by(
                    $this->_get_preset_key($this->sort['field']),
                    $this->sort['order']
                );

            }

            // limit/offset comes here
            if ($this->limit) {

                $query = $query->limit($this->limit);

            }

            if ($this->offset) {

                $query = $query->offset($this->offset);

            }

//            var_dump($query->__toString());

            $result = $query->execute()->as_array();

            // additional goes here
            if ($this->params && !empty($this->params)) {

                $this->_process_params($result);

            }

            if ($this->post_process && !empty($this->post_process)) {

                $this->_post_process($result);

            }

            // check key/value or value_only here
            if ($this->only_values) {

                return Utils::make_value_array($result,$this->only_values);

            }

            if ($this->first) {

                $result = array_shift($result);

            }

            return $result;

        }



        protected function _format_fields($fields) {

            if (!$fields || empty($fields)) return array('*');

            $formatted_fields = array();

            foreach ($fields as $field) {

                if (is_array($field)) {

                    $key = $this->_get_preset_key($field[0]);

                    $formatted_fields[] = array($key,$field[1]);

                } else {

                    $key = $this->_get_preset_key($field);

                    $formatted_fields[] = array($key,$field);

                }

            }

            return $formatted_fields;

        }

        protected function _get_preset_key($field) {

            if (is_object($field)) {

                return $field;

            }

            if (!isset($this->_preset_fields[$field])) throw new Kohana_Exception('No field preset: '.$field);

            return $this->_preset_fields[$field];

        }




        protected function _process_withes() {

            if ($this->with && !empty($this->with)) {

                foreach ($this->with as $with) {

                    if (is_array($with)) {

                        $method = '_process_with_'.$with[0];
                        $args = $with[1];

                    } else {

                        $method = '_process_with_'.$with;
                        $args = null;

                    }

                    if (method_exists($this,$method)) {

                        $this->$method($args);

                    } else {

                        throw new Kohana_Exception('No method for "with" condition: '.(is_array($with) ? $with[0] : $with));

                    }

                }

            }

        }

        /**
         * Block of "with" methods
         * _process_with_{with name} ()
         */

        protected function _process_with_avatar() {

            $this->fields = array_merge($this->fields,array(
                array('image_url','avatar_url'),
                array('photo','image_id'),
            ));

            $this->joins[] = array(
                'table' => ORM::factory('Image')->table_name(),
                'type' => 'LEFT',
                'conditions' => array(
                    array(
                        $this->_get_preset_key('image_id'),
                        '=',
                        $this->_get_preset_key('photo'),
                    ),
                ),
            );

        }

        protected function _process_with_user_data($fields) {

            if (empty($this->types)) {

                $this->types(array(
                    Model_Bobject::BOBJECT_INVESTOR,
                    Model_Bobject::BOBJECT_USER,
                ));

            } else {

                if (in_array(Model_Bobject::BOBJECT_COMPANY,$this->types) || in_array(Model_Bobject::BOBJECT_FUND,$this->types)) {
                    throw new Kohana_Exception('Cannot use with "email" company/fund types');
                }

            }

            if ($fields && !empty($fields)) {

                $this->fields = array_merge($this->fields,$fields);

            }

            $this->joins[] = array(
                'table' => ORM::factory('User')->table_name(),
                'type' => 'LEFT',
                'conditions' => array(
                    array(
                        $this->_get_preset_key('user_id'),
                        '=',
                        $this->_get_preset_key('object_id'),
                    ),
                ),
            );

        }


        protected function _process_special() {

            if ($this->special && !empty($this->special)) {

                foreach ($this->special as $special) {

                    if (is_array($special)) {

                        $method = '_process_special_'.$special[0];
                        $args = $special[1];

                    } else {

                        $method = '_process_special_'.$special;
                        $args = null;

                    }

                    if (method_exists($this,$method)) {

                        $this->$method($args);

                    } else {

                        throw new Kohana_Exception('No method for "special" condition: '.(is_array($special) ? $special[0] : $special));

                    }

                }

            }

        }

        /**
         * Block of "special" methods
         * _process_special_{special name} ()
         */

        protected function _process_special_editorial() {

            if (empty($this->types)) {

                $this->types(array(
                    Model_Bobject::BOBJECT_COMPANY,
                    Model_Bobject::BOBJECT_FUND,
                ));

            } else {

                if (in_array(Model_Bobject::BOBJECT_INVESTOR,$this->types) || in_array(Model_Bobject::BOBJECT_USER,$this->types)) {
                    throw new Kohana_Exception('Cannot use "editorial" special condition for user/investor types');
                }

            }

//            $this->fields = array_merge($this->fields,array(
//                'cu_id',
//            ));

            $this->joins[] = array(
                'table' => ORM::factory('Company_User')->table_name(),
                'type' => 'LEFT',
                'conditions' => array(
                    array(
                        $this->_get_preset_key('cu_company_id'),
                        '=',
                        $this->_get_preset_key('bobject_id'),
                    ),
                ),
            );

            $this->where[] = array(
                'field' => 'cu_id',
                'operator' => 'IS',
                'value' => NULL,
            );

        }





        protected function _process_params(&$result) {

            if (!$this->params || empty($this->params)) return;
            if (!$result || empty($result)) return;

            foreach ($result as &$row) {

                foreach ($this->params as $param) {

                    if (is_array($param)) {

                        $key = $param[0];
                        $method = '_process_param_'.$key;
                        $args = $param[1];

                    } else {

                        $key = $param;
                        $method = '_process_param_'.$key;
                        $args = array();

                    }

//                    if (!isset($row['bobject_id'])) {
//
//                        throw new Kohana_Exception('Cannot proceed "param" conditions. No bobject_id provided');
//
//                    }

                    if (method_exists($this,$method)) {

                        if ($this->ext_params_array) {
                            $row[$this->ext_params_array_key][$key] = $this->$method($row,$args);
                        } else {
                            $row[$key] = $this->$method($row,$args);
                        }

                    } else {

                        throw new Kohana_Exception('No method for "param" condition: '.(is_array($param) ? $param[0] : $param));

                    }

                }

            }

        }

        /**
         * Block of "param" methods
         * _process_param_{param name} ()
         */

        protected function _process_param_locations($row,$lower = true) {

            return ORM::factory('Bobject_Locations')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_tg_locations($row,$lower = true) {

            return ORM::factory('Bobject_TGLocations')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_categories($row,$lower = true) {

            return ORM::factory('Bobject_Categories')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_occupations($row,$lower = true) {

            return ORM::factory('Bobject_Occupations')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_skills($row,$lower = true) {

            return ORM::factory('Bobject_Skills')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_revenues($row,$lower = true) {

            return ORM::factory('Bobject_Revenues')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_sectors($row,$lower = true) {

            return ORM::factory('Bobject_Sectors')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_ownerships($row,$lower = true) {

            return ORM::factory('Bobject_Ownerships')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_momentums($row,$lower = true) {

            return ORM::factory('Bobject_Momentums')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_momentum($row,$lower = true) {

            return ORM::factory('Bobject_Momentums')->get_bobject_params($row['bobject_id'],$lower);

        }

        protected function _process_param_fundings($row) {

            return ORM::factory('Funding')->get_bobject_fundings_formatted($row['bobject_id']);

        }

        protected function _process_param_total_fundings($row) {

            return ORM::factory('Funding')->get_bobject_total_fundings($row['bobject_id']);

        }

        protected function _process_param_last_funding($row) {

            $fundings = ORM::factory('Funding')->get_bobject_fundings_formatted($row['bobject_id'],1, 'DESC');
            return $fundings && !empty($fundings) ? array_shift($fundings) : false;

        }

        protected function _process_param_check_tracking($row, $bobject_id) {

            return ORM::factory('Follow')->check_follow($bobject_id,$row['bobject_id']);

        }

        protected function _process_param_client_focus($row) {

            $client_focus = Utils::get_client_focus_short();
            $cs = array();
            foreach ($client_focus as $key=>$clfo) {
                if ($row[$key] == 1) {
                    $cs[] = array(
                        'name' => $clfo,
                    );
                }
            }
            return $cs;

        }

        protected function _process_param_client_focus_text($row) {

            $client_focus = Utils::get_client_focus_short();
            $cs = array();
            foreach ($client_focus as $key=>$clfo) {
                if ($row[$key] == 1) {
                    $cs[] = $clfo;
                }
            }
            return implode(',',$cs);

        }

        protected function _process_param_investment_stages($row) {

            $growth_stages = Utils::get_growth_stages();
            $is = array();
            for ($i=1;$i<=4;$i++) {
                if ($row['investment_stage_'.$i] == 1) {
                    $is[] = array(
                        'id' => $i,
                        'name' => $growth_stages[$i],
                    );
                }
            }
            return $is;

        }

        protected function _process_param_deal_structures($row) {

            $deal_structure = Utils::get_deal_structure();
            $ds = array();
            for ($i=2;$i<=6;$i++) {
                if ($row['security_'.$i] == 1) {
                    $ds[] = array(
                        'id' => $i,
                        'name' => $deal_structure[$i]
                    );
                }
            }
            return $ds;

        }

        protected function _process_param_deal_structures_additional($row) {

            $deal_structure = Utils::get_deal_structure();
            $ds_additional = false;
            if ($row['security_5'] == 1 && $row['security_6'] == 1) {
                $ds_additional = 'equity(<a href="'.Navigator::get_search_link('investors',array('params'=>'deal_structures'.':'.$deal_structure[5])).'">minority</a> and <a href="'.Navigator::get_search_link('investors',array('params'=>'deal_structures'.':'.$deal_structure[6])).'">majority</a>)';
            }
            return $ds_additional;

        }

        protected function _process_param_deal_structures_default($row) {

            $deal_structure = Utils::get_deal_structure();
            $ds_default = array();
            $ds_default_to = $row['security_5'] == 1 && $row['security_6'] == 1 ? 4 : 6;
            for ($i=2;$i<=$ds_default_to;$i++) {
                if ($row['security_'.$i] == 1) {
                    $ds_default[] = array(
                        'id' => $i,
                        'name' => $deal_structure[$i]
                    );
                }
            }
            return $ds_default;

        }

        protected function _process_param_deal_size($row) {

            $deal_size = Utils::format_deal_size($row['min_deal_size']).' - '.Utils::format_deal_size($row['max_deal_size']);
            if ($deal_size == '0-0' || $deal_size == '0 - 0' || $deal_size == '0K-0K' || $deal_size == '0K - 0K'/* || $deal_size == '0 - no limit' || $deal_size == '0-no limit'*/) {
                $deal_size = '';
            }
            return $deal_size;

        }

        protected function _process_param_growth_stages($row) {

            if ($row['fund_stage'] != 0) {
                $growth_stages = Utils::get_growth_stages();
                return array(array('name'=>$growth_stages[$row['fund_stage']]));
            } else {
                return array();
            }

        }

        protected function _process_param_growth_stage($row) {

            return $this->_process_param_growth_stages($row);

        }

        protected function _process_param_launch_date($row) {

            if ($row['launch_year']) {
                if ($row['launch_year'] == 1) {
                    return 'pre-1980';
                } else {
                    $monthes = Utils::get_launch_date_monthes();
                    return $row['launch_year'].($row['launch_month'] && isset($monthes[$row['launch_month']]) ? ', '.$monthes[$row['launch_month']] : '');
                }
            } else {
                return 'N/A';
            }

        }

        protected function _process_param_delivery_method($row) {

            if ($row['delivery_method'] && $row['delivery_method'] !== null && $row['delivery_method'] != 0) {
                $dms = Utils::get_delivery_methods();
                if (isset($dms[$row['delivery_method']])) {
                    return $dms[$row['delivery_method']];
                }
            } else {
                return false;
            }

        }

        protected function _process_param_category_str($row) {

            $categories_ids = array();
            if($row['category'] > 0){
                $categories_ids[] = $row['category'];
            }
            if ($row['category_2'] > 0) {
                $categories_ids[] = $row['category_2'];
            }
            if (!empty($categories_ids)) {
                return implode(', ',Utils::make_value_array(ORM::factory('Param_Category')->get_params($categories_ids,true),'name'));
            }

        }

        protected function _process_param_categories_company($row) {

            $categories_ids = array();
            if($row['category'] > 0){
                $categories_ids[] = $row['category'];
            }
            if ($row['category_2'] > 0) {
                $categories_ids[] = $row['category_2'];
            }
            if (!empty($categories_ids)) {
                return ORM::factory('Param_Category')->get_params($categories_ids,true);
            }

        }

        protected function _process_param_media($row) {

            return ORM::factory('Media')->get_bobject_medias($row['bobject_id'],false);

        }

        protected function _process_param_team($row, $approved = true) {

            return ORM::factory('Company_User')->get_company_users($row['bobject_id'],$approved);

        }

        protected function _process_param_investors($row, $approved = true) {

            return ORM::factory('Company_Investor')->get_company_investors($row['bobject_id'],$approved);

        }

        protected function _process_param_investments($row, $approved = true) {

            return ORM::factory('Company')->get_bobject_investments_formatted($row['bobject_id'],$approved);

        }

        protected function _process_param_board_members($row, $approved = true) {

            return ORM::factory('Company_BoardMember')->get_bobject_board_members_formatted($row['bobject_id'],$approved);

        }

        protected function _process_param_companies($row, $approved = true) {

            return ORM::factory('Bobject')->get_bobject_companies_formatted($row['bobject_id'],$approved);

        }

        protected function _process_param_board_companies($row, $approved = true, $can_edit = false) {

            return ORM::factory('Company_BoardMember')->get_bobject_board_companies_formatted($row['bobject_id'],$approved,$can_edit);

        }

        protected function _process_param_investment_opportunity($row) {

            return ORM::factory('InvestmentOpportunity')->get_company_active_opportunity($row['bobject_id']);

        }

        protected function _process_param_is_exited($row,$investor_id) {

            $is_exited = DB::select('is_exited')->from('companies_investors')->where('investor_bobject_id','=',$investor_id)->and_where('company_bobject_id','=',$row['bobject_id'])->execute()->get('is_exited');
            return $is_exited == 1;

        }

        protected function _process_param_has_dataroom($row) {

            return ORM::factory('Dataroom')->have_opened_dataroom($row['bobject_id']);

        }

        protected function _process_param_co_investments($row,$bobject_id) {

            // get companies where investors $row['bobject_id'] and $bobject_id
            return ORM::factory('Company_Investor')->get_bobjects_co_investments($bobject_id,$row['bobject_id']);

        }

        protected function _process_param_kpi_summary($row,$approved=true) {

            return ORM::factory('Dataroom_KPISummary')->get_bobject_kpi_summary($row['bobject_id'],$approved);

        }

        protected function _process_param_traffic($row,$formatted=true) {

            return ORM::factory('Company_SimilarWeb')->get_bobject_traffic($row['bobject_id'],$formatted);

        }



        protected function _post_process(&$result) {

            if (!$this->post_process || empty($this->post_process)) return;
            if (!$result || empty($result)) return;

            foreach ($result as &$row) {

                foreach ($this->post_process as $post_process) {

                    if (is_array($post_process)) {

                        $key = $post_process[0];
                        $method = '_post_process_'.$key;
                        $args = $post_process[1];
                        array_unshift($args,$row);

                    } else {

                        $key = $post_process;
                        $method = '_post_process_'.$key;
                        $args = array($row);

                    }

                    if (method_exists($this,$method)) {

                        $row = call_user_func_array(array($this,$method),$args);

                    } else {

                        throw new Kohana_Exception('No method for "param" condition: '.(is_array($post_process) ? $post_process[0] : $post_process));

                    }

                }

            }

        }

        /**
         * Block of "post_process" methods
         * _post_process_{name} ()
         */


        protected function _post_process_rename($row, $from, $to) {

            if (array_key_exists($from,$row)) {

                $row[$to] = $row[$from];
                unset($row[$from]);
                return $row;

            } else {

                throw new Kohana_Exception('No key '.$from.' found in row for post process data');

            }

        }


        protected function _post_process_profile_link($row, $key = null) {

            if (!isset($row['profile_url']) || !isset($row['type'])) {

                throw new Kohana_Exception('To use post process for profile link you need to get profile_url');

            }

            if (!$key) $key = 'profile_link';

            $row[$key] = Navigator::get_bobject_link($row['type'],$row['profile_url']);

            return $row;

        }

        protected function _post_process_image($row) {

            if (!isset($row['photo']) || !isset($row['type'])) {

                throw new Kohana_Exception('For using image post process, please get photo and type');

            }

            $row['image'] = ORM::factory('Image')->get_image($row['photo'],array('avatar_100','avatar_98','avatar_74','avatar_32'),Utils::get_bobject_type_by_int($row['type']));

            return $row;

        }

        protected function _post_process_avatar_link($row, $key, $image_tag) {

            if (!array_key_exists('avatar_url',$row) || !isset($row['type'])) {

                throw new Kohana_Exception('For using avatar_link post process, please get avatar_url and type');

            }

            $row[$key] = $row['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($row['avatar_url'], $image_tag, Utils::get_bobject_type_by_int($row['type'])) : Utils::get_null_image($image_tag,Utils::get_bobject_type_by_int($row['type']));

            return $row;

        }

        protected function _post_process_fake_tagline($row) {

            if (!array_key_exists('tagline',$row) || !isset($row['type'])) {

                throw new Kohana_Exception('For using fake_tagline post process, please get tagline and type');

            }

            if ($row['type'] != 1 && $row['type'] != 0) return $row;

            $row['tagline'] = $row['tagline'] && !empty($row['tagline']) ? $row['tagline'] : ORM::factory('Bobject')->get_user_fake_tagline($row['bobject_id']);

            return $row;

        }

    }