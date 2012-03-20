<?php defined('SYSPATH') or die('No direct script access.');

class Ajax_Core {

    protected static function response($status, $message = null)
    {
        $return = array();

        $return['status'] = $status;

        if ($message)
        {
            if (utf8::strlen($message) == 7)
            {
                foreach(Message::$messages as $code => $_message)
                {
                    if ($message === $code)
                    {
                        $message = __($_message);
                        break;
                    }
                }
            }

            $return['message'] = $message;
        }

        return (object) $return;
    }

    public static function fail($message = null)
    {
        return self::response('fail', $message);
    }

    public static function success($message = null)
    {
        return self::response('success', $message);
    }
}