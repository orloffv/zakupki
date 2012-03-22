<?php defined('SYSPATH') or die('No direct script access.');

class Api_Zakupki extends Api_Core implements Api_Interface {

    public function count_new($date)
    {
        return $this->get_query()->where('date', '>', $date)->count();
    }

    public function get_items(&$pagination, $limit = null, array $pagination_config = array())
    {
        return $this->get_query()->order_by('date', 'desc')->my_paging($pagination, $limit, $pagination_config);
    }

    public function get_days($limit = null)
    {
        return $this->get_query()->select_column(Db::expr("FROM_UNIXTIME(date, '%d.%m.%Y')"), 'day')->order_by('day', 'desc')->limit($limit)->group_by('day')->execute()->as_array('day', 'day');
    }
}