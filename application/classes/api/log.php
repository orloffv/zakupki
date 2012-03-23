<?php defined('SYSPATH') or die('No direct script access.');

class Api_Log extends Api_Core implements Api_Interface {

    public function get_items(&$pagination, $limit = null, array $pagination_config = array())
    {
        return $this->get_query()->order_by('dt_create', 'desc')->ln_paging($pagination, $limit, $pagination_config);
    }
}