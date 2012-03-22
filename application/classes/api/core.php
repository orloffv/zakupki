<?php defined('SYSPATH') or die('No direct script access.');

abstract class Api_Core {

    protected $module;
    protected $filter;

    public function set_module($module)
    {
        $this->module = $module;
    }

    public function delete($id)
    {
        $item = Jelly::factory($this->module, $id);

        if ($item->loaded())
        {
            if ((Jelly::meta($this->module)->field('is_system') && !$item->is_system) OR !Jelly::meta($this->module)->field('is_system'))
            {
                return $item->delete();
            }
        }

        return null;
    }

    public function put($data, $id = null, $validation = true)
    {
        $update = Jelly::factory($this->module, $id)->set($data)->save($validation);

        if ($update->saved() AND !$id)
        {
            if (Jelly::meta($this->module)->field('sort'))
            {
                Jelly::factory($this->module, $update->id)->set(array('sort' => $update->id))->save();
            }
        }

        return $update;
    }

    public function get_last_by($column)
    {
        return $this->get_query()->limit(1)->order_by($column, 'desc')->execute();
    }

    public function filter(Filter $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function get_query()
    {
        $query = Jelly::query($this->module);

        if ($this->filter instanceof Filter)
        {
            $filters = $this->filter->get_where();

            if (count($filters))
            {
                foreach ($filters as $filter)
                {
                    $query->where($filter['column'], $filter['op'], $filter['value']);
                }
            }
        }

        return $query;
    }
}