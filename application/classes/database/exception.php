<?php defined('SYSPATH') or die('No direct script access.');

class Database_Exception extends Kohana_Database_Exception {

    public static $sql_error;
    
    protected $_messages = array
    (
        1004 => 'Не могу создать таблицу',
        1005 => 'Не могу создать таблицу',
        1006 => 'Не могу создать таблицу',
        1007 => 'Не могу создать таблицу, уже существует',
        1008 => 'Не могу удалить таблицу',
        1045 => 'Нет доступа',
        1046 => 'Не выбрана база данных',
        1049 => 'Таблица не существует',
        1050 => 'Таблица уже существует',
        1054 => 'Неизвестное имя колонки',
        1062 => 'Попытка записать уже имеющееся значение в ключевую колонку',
        1064 => 'Синтаксическая ошибка',
        1048 => 'Поле должно быть заполнено',
        1146 => 'Таблица не существует',
        1451 => 'Не могу удалить запись, так как она используется в других таблицах.',
        2002 => 'Не могу подключиться к серверу MySQL',
        2005 => 'Не могу подключиться к серверу MySQL',
        2006 => 'Не могу подключиться к серверу MySQL',
    );
    
    protected $_show_for_user = array(
        1062, 1451
    );

    public function __construct($message, array $variables = NULL, $code = 0)
    {
        self::$sql_error = $variables[':error'];
        
        if (in_array($code, $this->_show_for_user))
        {
            $message = $this->_messages[$code];
            $variables = array();
        }
        
        parent::__construct($message, $variables, $code);
    }
    
    public function frontend_ajax($owner)
    {
        $owner->context['error'] = TRUE;
    }
    
    public function frontend($owner)
    {
        $owner->context['form_errors'] = $this->getMessage();
        
        $owner->message('error', 'Ошибка базы данных');
        
        if (is_object(Kohana::$log))
        {
            // Add this exception to the log
            Kohana::$log->add(Log::ERROR, Kohana_Exception::text($this));

            // Make sure the logs are written
            Kohana::$log->write();
        }
    }
    
    public function backend($owner)
    {
        if ($owner->is_action_delete())
        {
            Message::error($this->getMessage());
        }
        else
        {
            Message::error(Message::FAIL_DB);
        }
    }
    
    public function widget($owner)
    {
        
    }
}
