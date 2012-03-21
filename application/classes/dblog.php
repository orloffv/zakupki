<?php defined('SYSPATH') or die('No direct script access.');

class Dblog
{
    public static function add($message)
    {
        return Jelly::factory('log')->set('status', $message)->save();
    }


}