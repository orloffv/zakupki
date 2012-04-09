<?php defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {

    public static function add_first_item_list($array, $type = null, $title = NULL, $value = NULL)
    {
        if (!$type)
        {
            return Arr::array_push_array(array($value ? $value : '' => $title ? $title : '- Выбрать -'), $array);
        }
        elseif ($type == 'assoc')
        {
            return Arr::array_push_array(array(array('id' => $value ? $value : '', 'name' => $title ? $title : '- Выбрать -')), $array);
        }
    }

    public static function value_value(array $array)
    {
        $return_array = array();

        foreach ($array as $value)
        {
            $return_array[$value] = $value;
        }

        return $return_array;
    }

    /**
     * push an array to an array: push(@array, @array2, @array3)
     *
     * @param array $arr
     * @return array
     */
    public static function array_push_array($arr)
    {
        $args = func_get_args();
        array_shift($args);

        if (is_array($arr))
        {
            foreach ($args as $v)
            {
                if (is_array($v))
                {
                    if (count($v) > 0)
                    {
                        foreach($v as $v_item)
                        {
                            $arr[] = $v_item;
                        }
                    }
                }
                else
                {
                    $arr[] = $v;
                }
            }
        }

        return $arr;
    }

}