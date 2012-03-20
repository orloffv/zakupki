<?php defined('SYSPATH') or die('No direct script access.');

System::$domain_name = 'kohana-base.local';
System::$site_title = 'Dev Title';

Cache::$need = array(
    'route'     => FALSE,
    'widget'    => FALSE,
    'block'     => FALSE,
    'media'     => FALSE,
    'menu'      => FALSE,
);

Cache::$lifetime = array(
    'route'     => Date::WEEK,
    'widget'    => Date::HOUR,
    'block'     => Date::HOUR,
    'media'     => Date::HOUR,
    'menu'      => Date::HOUR,
);
