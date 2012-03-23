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

    /**
     * Сохраняет и/или возвращает по сколько показывать элементов на странице
     * используется с Pagination
     * @param string $module_name
     * @return string
     */
    public static function items_per_page($module_name = 'default')
    {
        $name = $module_name.'_items_per_page';

        if (isset($_GET['c']) AND (int) $_GET['c'])
        {
            $value = (int) $_GET['c'];

            if (Cookie::get($name) != $value)
            {
                Cookie::set($name, $value);
            }

            if (Session::instance()->get($name) != $value)
            {
                Session::instance()->set($name, $value);
            }

            return $value;
        }
        elseif ($value = Cookie::get($name))
        {
            return $value;
        }
        elseif ($value = Session::instance()->get($name))
        {
            return $value;
        }
        else
        {
            return self::ITEMS_PER_PAGE;
        }
    }

    /**
     * Frontend Pagination::factory wrapper
     * @param string $module_name
     * @param integer $total_items
     * @param array $config
     * @return Pagination
     */
    public static function paging($module_name, $total_items, array $config = NULL)
    {
        $_config = array(
            'total_items'    => $total_items,
            'items_per_page' => self::items_per_page($module_name),
            'view'           => 'pagination/frontend',
            'show_pagi_number'           => FALSE,
            'title' => NULL,
            'counter_show' => true
        );

        if (is_array($config) AND count($config))
        {
            $_config = Arr::merge($_config, $config);
        }

        return Pagination::factory($_config);
    }
}
