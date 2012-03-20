<?php defined('SYSPATH') or die('No direct script access.');

class Url extends Kohana_Url {

    public static function is_url($string)
    {
        $temp = parse_url($string);

        if (! $temp OR ! Arr::get($temp, 'scheme') OR ! Arr::get($temp, 'host') OR ! Arr::get($temp, 'path'))
        {
            return FALSE;
        }

        if ( ! (
                Arr::get($temp, 'scheme') == 'http' OR
                Arr::get($temp, 'scheme') == 'https' OR
                Arr::get($temp, 'scheme') == 'ftp'
                )
            )
        {
            return false;
        }

        return true;
    }

    public static function auto($route, array $attributes = array())
    {
        if (Arr::get($attributes, 'controller') == 'current')
        {
            $attributes['controller'] = Request::current()->controller();
        }

        if (Arr::get($attributes, 'action') == 'current')
        {
            $attributes['action'] = Request::current()->action();
        }

        $protocol = NULL;

        if (Arr::get($attributes, 'protocol'))
        {
            $protocol = $attributes['protocol'];
            unset($attributes['protocol']);
        }

        $query = Arr::get($attributes, 'query') ? Url::query(Arr::get($attributes, 'query')) : '';

        return Url::site(Route::get($route)->uri($attributes).$query, $protocol);

    }
}
