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

}