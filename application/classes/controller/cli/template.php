<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Cli_Template extends Controller {
    
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
            if (substr($method, 0, 6) == 'action' AND $method != 'action_ls')
            {
                $this->write(substr($method, 7));
            }
        }
    }

    protected function write($text)
    {
        echo $text."\n";
    }
}

