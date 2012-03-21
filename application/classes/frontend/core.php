<?php defined('SYSPATH') or die('No direct script access.');

class Frontend_Core {

    const VERSION = '1.1-beta';
    const DEFAULT_ITEMS_PER_PAGE = 20;

    public static $title_separator = ' / ';
    
    public static $labels = array();
    public static $item = array();
    public static $form_errors = array();
    public static $no_data = FALSE;

    protected static $_top = array(
        'editor' => FALSE,
        'counter' => 0,
        'links' => array(),
    );

    /**
     * @return Frontend_Menu
     */
    public static function menu()
    {
        return Frontend_Menu::factory();
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
            return self::DEFAULT_ITEMS_PER_PAGE;
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
            'counter_show' => false
        );

        if (is_array($config) AND count($config))
        {
            $_config = Arr::merge($_config, $config);
        }
        
        return Pagination::factory($_config);
    }
    
    /**
     * @var string заголовок страницы
     */
    protected static $_title = '';
    
    /**
     * @var array заголовок страницы
     */
    protected static $_titles = array();

    /**
     * Устанавливает заголовок страницы
     * @param string $title
     */
    public static function set_title($title)
    {
        self::$_title = (string) $title;
    }

    /**
     * Append'ить к заголовку страницы
     * @param string $title
     */
    public static function add_title($title)
    {
        self::$_titles[] = $title;
    }

    /**
     * Возвращает заголовок страницы
     * @return string
     */
    public static function get_title()
    {
        $title = '';
        
        if ( ! empty(self::$_title))
        {
            $title = self::$_title;
        }
        elseif (count(self::$_titles))
        {
            foreach(self::$_titles as $title_path)
            {
                $title = $title_path.(empty($title) ? '' : self::$title_separator).$title;
            }
            
            $title .= self::$title_separator.System::get_site_title();
        }
        else
        {
            $title = System::get_site_title();
        }
        
        return HTML::chars($title);
    }
    
    /**
     * Возвращает последний элемент Title
     */
    public static function get_last_title()
    {
        $title = '';
        
        if (count(self::$_titles))
        {
            $title = self::$_titles[count(self::$_titles)-1];
        }
        
        return HTML::chars($title);
    }
    
    public static function set_top($data)
    {
        foreach ($data as $key => $value)
        {
            self::$_top[$key] = $value;
        }
    }
    
    public static function get_top($key = NULL)
    {
        self::$_top['title'] = self::get_last_title();
        
        return is_null($key) ? self::$_top : (isset(self::$_top[$key]) ? self::$_top[$key] : NULL);
    }

    /**
     * @var array мета данные страницы
     */
    protected static $_meta = array();

    /**
     * Добавляет meta к странице
     * @param string $name
     * @param string $value
     */
    public static function add_meta($name, $value)
    {
        self::$_meta[] = '<meta name="'.HTML::chars($name).'" value="'.HTML::chars($value).'">';
    }

    /**
     * Добавляет meta feed к странице
     * @param string $title
     * @param string $url
     */
    public static function add_feed($title, $url = NULL)
    {
        self::$_meta[] = '<link rel="alternate" type="application/rss+xml" title="'.Html::chars($title).'" href="'.$url.'" />';
    }

    /**
     * Возвращает все ранее добавленные meta теги
     * @return string
     */
    public static function get_meta()
    {
        return implode("\n", self::$_meta);
    }

    public static function is_pda()
    {
        return defined('SYSTEM_IS_PDA') AND SYSTEM_IS_PDA === TRUE;
    }

    /**
     * Печатаем страницу?
     * @return boolean
     */
    public static function is_print()
    {
        return isset($_GET['print']);
    }
    
}