<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Cli extends Controller {
    
    public function before()
    {
        if ( ! Kohana::$is_cli)
        {
            die('Access denied;');
        }

        return parent::before();
    }

    public function action_ls()
    {
        echo "All available tasks:\n";
        $methods = get_class_methods($this);

        foreach($methods as $method)
        {
            $prefix = substr($method, 0, 7);
            if (substr($method, 0, 6) == 'action' AND $method != 'action_ls')
            {
                echo substr($method, 7)."\n";
            }
        }
    }

    protected function write($text)
    {
        echo $text."\n";
    }
}

