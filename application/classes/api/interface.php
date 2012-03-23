<?php defined('SYSPATH') or die('No direct script access.');

interface Api_Interface {

    public function get(&$pagination, $limit = null, array $pagination_config = array());

    public function put($data, $id = null, $validation = false);

    public function delete($id);
}