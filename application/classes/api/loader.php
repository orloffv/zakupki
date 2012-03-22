<?php defined('SYSPATH') or die('No direct script access.');

class Api_Loader{

    /**
     * @static
     * @param $module
     * @return Api
     */
    public static function load($module, $new = true)
    {
        static $instance = array();

        if (!isset($instance[$module]) || $new)
        {
            $class_name = 'Api_'. Text::ucfirst($module);

            if ( ! class_exists($class_name))
            {
                $class_name = 'Api_Base';
            }

            $instance[$module] = new $class_name();
            $instance[$module]->set_module($module);
        }

        return $instance[$module];
    }

}