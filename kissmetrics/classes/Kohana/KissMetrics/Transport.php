<?php defined('SYSPATH') or die;

    abstract class Kohana_KissMetrics_Transport {

        public static function factory($type,array $data = array()) {
            $classname = 'Kohana_KissMetrics_Transport_'.ucfirst($type);
            if (!class_exists($classname)) throw new Kohana_Exception("Kissmetrics transport class not exists: ".$classname);
            return new $classname($data);
        }

        abstract public function submitData(array $data);

    }