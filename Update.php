<?php defined('SYSPATH') or die;

    class Task_Gearman_Search_Update extends Task_Gearman_Search {

        protected $_task_name = self::GEARMAN_TASK_SEARCH_UPDATE;

        public function _callback() {

            if (!isset($this->_data['bobject_id'])) throw new Kohana_Exception('Invalid bobject_id');

            $bobject = ORM::factory('Bobject',$this->_data['bobject_id']);
            if (!$bobject->loaded()) throw new Kohana_Exception('No bobject loaded');

            switch ($bobject->type) {
                case 0:
                    $search_data = SearchData::factory('user');
                    $search_data->make_one($bobject->id);
                    $search_data->upload_data();
                    break;
                case 1:
                    $search_data = SearchData::factory('user');
                    $search_data->make_one($bobject->id);
                    $search_data->upload_data();
                    $search_data = SearchData::factory('investor');
                    $search_data->make_one($bobject->id);
                    $search_data->upload_data();
                    break;
                case 2:
                    $search_data = SearchData::factory('company');
                    $search_data->make_one($bobject->id);
                    $search_data->upload_data();
                    break;
                case 3:
                    $search_data = SearchData::factory('investor');
                    $search_data->make_one($bobject->id);
                    $search_data->upload_data();
                    break;
            }
            $search_data = SearchData::factory('composite');
            $search_data->make_one($bobject->id);
            $search_data->upload_data();

        }

    }