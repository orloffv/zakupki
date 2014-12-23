<?php defined('SYSPATH') or die('No direct script access.');

class Api_Prices extends Api_Core implements Api_Interface {

    public function count_new($date)
    {
        return $this->get_query()->where('date', '>', $date)->count();
    }

    public function get_days($limit = null)
    {
        return $this->get_query()->select_column(Db::expr("FROM_UNIXTIME(date, '%d.%m.%Y')"), 'day')->select_column('date')->order_by('date', 'desc')->limit($limit)->group_by('day')->execute()->as_array('date', 'day');
    }
}
