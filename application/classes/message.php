<?php defined('SYSPATH') or die('No direct script access.');

class Message extends Kohana_Message {
    
    const SUCCESS_CREATE    = 'msg:100';
    const FAIL_CREATE       = 'msg:101';
    const SUCCESS_UPDATE    = 'msg:102';
    const FAIL_UPDATE       = 'msg:103';
    const SUCCESS_DELETE    = 'msg:104';
    const FAIL_DELETE       = 'msg:105';
    const FAIL_DB           = 'msg:200';
    const FAIL_GET          = 'msg:000';
    const SUCCESS_GET       = 'msg:000';

    public static $messages = array
    (
        self::SUCCESS_CREATE    => 'Запись успешно создана!',
        self::FAIL_CREATE       => 'При создании записи произошла ошибка!',
        self::SUCCESS_UPDATE    => 'Запись успешно обновлена!',
        self::FAIL_UPDATE       => 'При обновлении записи произошла ошибка!',
        self::SUCCESS_DELETE    => 'Запись успешно удалена!',
        self::FAIL_DELETE       => 'При удалении записи произошла ошибка!',
        self::FAIL_DB           => 'Ошибка базы данных!',
        self::FAIL_GET          => 'Ошибка базы данных!',
        self::SUCCESS_GET       => 'Данные успешно получены!',

    );
    
    public static function error($message)
    {
        if (Kohana::$environment == Kohana::DEVELOPMENT AND $message == self::FAIL_DB)
        {
            $message = Database_Exception::$sql_error;
        }   
        
        self::set(self::ERROR, $message);
    }

    public static function notice($message)
    {
        self::set(self::NOTICE, $message);
    }

    public static function success($message)
    {
        self::set(self::SUCCESS, $message);
    }

    public static function warn($message)
    {
        self::set(self::WARN, $message);
    }

    public static function set($type, $message, array $options = NULL)
    {
        // не будем в пустую бегать по массиву
        // т.е. если это 'msg:***'
        if (utf8::strlen($message) == 7) 
        {
            foreach(self::$messages as $code => $_message)
            {
                if ($message === $code)
                {
                    $message = __($_message);
                    break;
                }
            }
        }
		if ( ! is_null($message))
		{
	        parent::set($type, $message, $options);
		}
    }
    
    public static function display($template = 'basic', $clear = TRUE)
	{
        // Nothing to render
        if (($messages = self::get()) === NULL)
        {
            return '';
        }

        // Clear all messages
        if ($clear)
        {
            self::clear();
        }

        if ( ! $template instanceof Kohana_View)
        {
            // Load the view file
            $template = View::factory('message/'.$template);
        }

        // Return the rendered view
        return $template->set('messages', $messages)->render();
	}
    
    public static function render($template = 'basic', $clear = TRUE)
	{
		return self::display($template, $clear);
	}
}