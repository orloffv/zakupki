<?php defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text
{
    public static function remove_entities($str)
    {
        if (substr_count($str, '&') && substr_count($str, ';'))
        {
            // Find amper
            $amp_pos = strpos($str, '&');
            //Find the ;
            $semi_pos = strpos($str, ';');
            // Only if the ; is after the &
            if ($semi_pos > $amp_pos)
            {
                //is a HTML entity, try to remove
                $tmp = substr($str, 0, $amp_pos);
                $tmp = $tmp . substr($str, $semi_pos + 1, strlen($str));
                $str = $tmp;
                //Has another entity in it?
                if (substr_count($str, '&') && substr_count($str, ';'))
                {
                    $str = self::remove_entities($tmp);
                }
            }
        }

        return $str;
    }

    public static function ru_num($num, $word = null, $word1 = null, $word2 = null, $word5 = null, $word0 = null)
    {
        if ((int) $num == 0)
        {
            return $word0;
        }

        if ($num % 10 == 1 && $num % 100 != 11 )
        {
            $wordEnd = $word1;
        }
        else if ($num % 10 >= 2 && $num % 10 <= 4 && ( $num % 100 < 10 || $num % 100 >= 20 ) )
        {
            $wordEnd = $word2;
        }
        else
        {
            $wordEnd = $word5;
        }

        return $num . ' ' . $word . $wordEnd;
    }
}