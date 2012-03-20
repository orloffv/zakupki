<?php defined('SYSPATH') or die('No direct script access.');

class Security extends Kohana_Security {

    protected static $save_token = NULL;

    public static function token($new = FALSE)
	{
		$session = Session::instance();

        $token = self::$save_token;

        if ($new === TRUE OR ! $token)
        {
            // Generate a new unique token
            $token = sha1(uniqid(NULL, TRUE));

            $session_tokens = self::get_tokens();

            if ( ! $session_tokens)
            {
                $session_tokens  = array($token);
            }
            else
            {
                //храним только последние 5 токенов
                if (count($session_tokens) >= 5)
                {
                    reset($session_tokens);
                    unset($session_tokens[key($session_tokens)]);
                    $session_tokens = array_values($session_tokens);
                }

                $session_tokens[] = $token;
            }

            $session->set(Security::$token_name, $session_tokens);

            self::$save_token = $token;
        }

		return $token;
	}

    protected static function get_tokens()
    {
        $tokens = Session::instance()->get(Security::$token_name);

        return ! is_array($tokens) ? array() : $tokens;
    }

	public static function check($token)
	{
        if ( ! $token)
        {
            return FALSE;
        }

        if ( ! ($tokens = self::get_tokens()))
        {
            $tokens = array($tokens);
        }

		return in_array($token, $tokens);
	}
}