<?php defined('SYSPATH') or die('No direct script access.');

class Order {

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function get_field()
    {
        $meta = Jelly::meta($this->table);

        if (!$meta)
        {
            return null;
        }

        $meta_fields = $meta->fields();

        $field = Request::initial()->query('s_field');

        $field_result = is_null($field) ? null : (array_key_exists($field, $meta_fields) ? $field : null);

        return $field_result;
    }

    public function get_direction()
    {
        $allow = array('desc', 'asc');

        $direction = Request::initial()->query('s_direction');

        $direction_result = is_null($direction) ? $allow[0] : (in_array($direction, $allow) ? $direction : $allow[0]);

        return $direction_result;
    }
}