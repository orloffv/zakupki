<?php defined('SYSPATH') or die('No direct script access.');

class Route extends Kohana_Route {

    public static function get_frontend_route()
    {
        Route::set('frontend', '(<controller>(/<action>(/<id>)))')
            ->defaults(array(
            'directory' => 'frontend',
            'controller' => 'home',
            'action'     => 'index',
        ));

        Route::set('frontend_error', 'error/<code>')
            ->defaults(array(
            'directory' => 'frontend',
            'controller' => 'error',
            'action'     => 'index',
        ));
    }

    public static function get_backend_route()
    {
        self::set('backend/ajax_default', 'backend/<module>/ajax/<action>(/<id>)', array(
           'id' => '\d+',
        ))
        ->defaults(array(
           'controller' => 'ajax',
           'directory' => 'backend',
        ));

        self::set('backend/ajax', 'backend/ajax/<controller>/<action>(/<id>)', array(
           'id' => '\d+',
        ))
        ->defaults(array(
           'directory' => 'backend/ajax',
           'action' => 'index',
        ));

        // backend default
        self::set('backend', 'backend(/<controller>(/<action>(/<id>)))', array(
            'id' => '\d+',
        ))
        ->defaults(array(
            'directory' => 'backend',
            'controller' => 'dashboard',
            'action' => 'index',
        ));
    }

    public static function cache($save = FALSE, $prefix = '', $lifetime = NULL)
    {
        $cache_key = 'Route::cache()-'.$prefix;

        if ($save === TRUE)
        {
            // Cache all defined routes
            Cache::init('route')->set($cache_key, Route::$_routes, $lifetime);
        }
        else
        {
            if ($routes = Cache::init('route')->get($cache_key))
            {
                Route::$_routes = $routes;

                // Routes were cached
                return TRUE;
            }
            else
            {
                // Routes were not cached
                return FALSE;
            }
        }
    }
}
