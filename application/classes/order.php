<?php defined('SYSPATH') or die('No direct script access.');

class Order {

    const ASC               = 'asc';
    const DESC              = 'desc';
    const QUERY_FIELD       = 's_field';
    const QUERY_DIRECTION   = 's_direction';

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function get_field($field = null)
    {
        $meta = Jelly::meta($this->table);

        if (!$meta)
        {
            return null;
        }

        $meta_fields = $meta->fields();

        $field = ! is_null($field) ? $field : Request::initial()->query(self::QUERY_FIELD);

        $field_result = is_null($field) ? null : (array_key_exists($field, $meta_fields) ? $field : null);

        return $field_result;
    }

    public function get_direction()
    {
        $allow = array(self::DESC, self::ASC);

        $direction = Request::initial()->query(self::QUERY_DIRECTION);

        $direction_result = is_null($direction) ? $allow[0] : (in_array($direction, $allow) ? $direction : $allow[0]);

        return $direction_result;
    }

    public function get_next_direction($field)
    {
        if (Request::initial()->query(self::QUERY_FIELD) == $field)
        {
            return $this->get_direction() == self::ASC ? self::DESC : self::ASC;
        }
        else
        {
            return self::DESC;
        }
    }

    public function get_uri($field)
    {
        if ($this->get_field($field))
        {
            return URL::site(Request::current()->uri()).URL::query(array(self::QUERY_FIELD => $field, self::QUERY_DIRECTION => $this->get_next_direction($field)));
        }
        else
        {
            return URL::site(Request::current()->uri()).URL::query(array(self::QUERY_FIELD => null, self::QUERY_DIRECTION => null));
        }
    }

    public function get_class($field)
    {
        if (Request::initial()->query(self::QUERY_FIELD) == $field)
        {
            return 'header '. ($this->get_direction() == self::ASC ? 'headerSortDown' : 'headerSortUp');
        }

        return 'header';
    }
}