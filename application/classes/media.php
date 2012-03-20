<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Класс предназначен для работы с media.
 *
 * @author Orloffv
 */
class Media {

    /**
     * @var string Media url (abs, rel).
     */
    public static $url = '/static/media/';
    
    protected static $upload_url = 'static/media/';

    public static function get_dir($module)
    {
        return self::$upload_url.'/'.$module.'/';
    }

    public static function get_uri($module, $filename)
    {
        return self::get_dir($module).$filename;
    }

    public static function get_url($module, $filename)
    {
        return Url::site(self::get_uri($module, $filename), true);
    }
}
