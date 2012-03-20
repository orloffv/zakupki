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
}

