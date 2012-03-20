<?php defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date {

    public static function reverse($value, $delim = '-')
    {
        list($date, $time) = is_array($value) ? $value : explode(' ', $value);
        return implode($delim, array_reverse(explode('-', str_replace('.', '-', $date)))).' '.$time;
    }

    public static function check_part_day(array $texts = array())
    {
        if (count($texts) !== 4)
        {
            return null;
        }

        $hour = date('H');

        if ($hour >= 6 AND $hour < 12)
        {
            return Arr::get($texts, 0);
        }
        elseif ($hour >= 12 AND $hour < 18)
        {
            return Arr::get($texts, 1);
        }
        elseif ($hour >= 18 AND $hour < 24)
        {
            return Arr::get($texts, 2);
        }
        elseif ($hour >= 0 AND $hour < 6)
        {
            return Arr::get($texts, 3);
        }
    }

    protected static function parse_time($date_input)
    {
        return is_numeric($date_input) ? $date_input : strtotime($date_input);
    }

    public static function fuzzy_span($date_input, $local_timestamp = NULL)
    {
        $timestamp = self::parse_time($date_input);

        $local_timestamp = ($local_timestamp === NULL) ? time() : (int) $local_timestamp;

        // Determine the difference in seconds
        $offset = abs($local_timestamp - $timestamp);

        if ($offset <= Date::MINUTE)
        {
            $span = 'только что';
        }
        elseif ($offset < (Date::MINUTE * 20))
        {
            $span = 'несколько минут назад';
        }
        elseif ($offset < Date::HOUR)
        {
            $span = 'меньше часа назад';
        }
        elseif ($offset < (Date::HOUR * 4))
        {
            $span = 'несколько часов назад';
        }
        elseif ($offset < Date::DAY)
        {
            $span = 'сегодня';
        }
        elseif ($offset < (Date::DAY * 2))
        {
            $span = 'вчера';
        }
        elseif ($offset < (Date::DAY * 4))
        {
            $span = 'несколько дней назад';
        }
        elseif ($offset < Date::WEEK)
        {
            $span = 'неделю назад';
        }
        elseif ($offset < (Date::WEEK * 2))
        {
            $span = 'несколько недель назад';
        }
        elseif ($offset < Date::MONTH)
        {
            $span = 'месяц назад';
        }
        elseif ($offset < (Date::MONTH * 2))
        {
            $span = 'несколько месяцев назад';
        }
        elseif ($offset < (Date::MONTH * 4))
        {
            $span = 'несколько месяцев назад';
        }
        elseif ($offset < Date::YEAR)
        {
            $span = 'несколько месяцев назад';
        }
        elseif ($offset < (Date::YEAR * 2))
        {
            $span = 'год назад';
        }
        elseif ($offset < (Date::YEAR * 4))
        {
            $span = 'несколько лет назад';
        }
        elseif ($offset < (Date::YEAR * 8))
        {
            $span = 'несколько лет назад';
        }
        elseif ($offset < (Date::YEAR * 12))
        {
            $span = 'несколько лет назад';
        }
        elseif ($offset < (Date::YEAR * 24))
        {
            $span = 'давно';
        }
        elseif ($offset < (Date::YEAR * 64))
        {
            $span = 'давно';
        }
        else
        {
            $span = 'давно';
        }

        return $span;
    }

}