<?php defined('SYSPATH') or die('No direct script access.');

class Myexception extends Exception {
   
    public function __construct($action, $e, $own, $data = NULL)
    {
        if ($e instanceof ErrorException OR get_class($e) == 'Kohana_Exception')
        {
            Kohana_Core::error_handler($e->getCode(), $e, $e->getFile(), $e->getLine());
        }
        else
        {
            $e->{$action}($own, $data);
        }
    }
}