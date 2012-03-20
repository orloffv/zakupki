<?php defined('SYSPATH') or die('No direct script access.');

interface Cron_Interface {
    public static function factory();
    public function run();

}