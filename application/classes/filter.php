<?php defined('SYSPATH') or die('No direct script access.');

class Filter {

    private $filters = array();

    public function add($field, array $options = array(), $op = '=', $column = null)
    {
        $filter = array($field => array('field' => $field, 'options' => $options, 'op' => $op, 'column' => $column));

        $this->filters = Arr::merge($filter, $this->filters);
    }

    public function get_options()
    {
        $return = array();

        foreach ($this->filters as $filter)
        {
            $return[$filter['field']] = array('options' => $filter['options'], 'value' => Request::current()->query($filter['field']));
        }

        return $return;
    }

    public function get_where()
    {
        $return = array();

        foreach ($this->filters as $filter)
        {
            if ($this->get_value($filter['field']))
            {
                $return[] = array('column' => Arr::get($filter, 'column', $filter['field']), 'op' => $filter['op'], 'value' => $this->get_value($filter['field']));
            }
        }

        return $return;
    }

    private function get_value($field)
    {
        return Request::current()->query($field);
    }
}