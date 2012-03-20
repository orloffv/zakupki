<?php defined('SYSPATH') or die('No direct script access.');

class System_Core {

    public static $domain_name      = 'kohana-base.local';
    public static $site_title = 'Title';
    public static $module_name;
    const ITEMS_PER_PAGE = 20;
    const VERSION = '0.1-alpha';

    public static function get_site_title()
    {
        return self::$site_title;
    }

    /**
     * Возвращает домен основного сайта
     * @return string
     */
    public static function get_main_domain_name()
    {
        return self::$domain_name;
    }

    /**
     * Возвращает id текущего пользователя
     * @return mixed member_id OR FALSE;
     */
    public static function get_member_id()
    {
        if (self::member_logged())
        {
            return A1::instance()->get_user()->id;
        }
        
        return FALSE;
    }

    /**
     * Проверяет залогинен ли member
     * @return boolean
     */
    public static function member_logged()
    {
        return A1::instance()->logged_in();
    }

    /**
     * Возвращает объект Model_Member
     * например ->id, ->email...
     * @return mixed FALSE OR Model_Member
     */
    public static function get_member()
    {
        if (self::member_logged())
        {
            return A1::instance()->get_user();
        }

        return FALSE;
    }
}
