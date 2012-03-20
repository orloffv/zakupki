<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cache extends Kohana_Cache {

    public static $need = array(
        'route'     => FALSE,
        'widget'    => FALSE,
        'block'     => FALSE,
        'media'     => FALSE,
        'menu'      => FALSE,
    );
    
    public static $lifetime = array(
        'route'     => Date::WEEK,
        'widget'    => Date::HOUR,
        'block'     => Date::HOUR,
        'media'     => Date::HOUR,
        'menu'      => Date::HOUR,
    );
    
    public static $default_lifetime = Date::DAY;
    
    public static function init($type = NULL)
    {
        if (is_null($type) OR ! isset(self::$need[$type]) OR self::$need[$type])
        {
            $driver = NULL;
        }
        elseif (isset(self::$need[$type])  AND ! self::$need[$type])
        {
            $driver = 'fake';
        }
        
        if (isset(Cache::$instances[$driver]))
        {
            // Get the existing cache instance directly (faster)
            $cache = Cache::$instances[$driver];
        }
        else
        {
            // Get the cache driver instance (slower)
            $cache = Cache::instance($driver);
        }

        return $cache;
    }
}
