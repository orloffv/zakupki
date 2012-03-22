<?php defined('SYSPATH') or die('No direct script access.');

interface Api_Interface {

    //public function get();

    public function put($data, $id = null, $validation = false);

    public function delete($id);
}