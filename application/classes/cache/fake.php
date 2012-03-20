<?php defined('SYSPATH') or die('No direct script access.');

class Cache_Fake extends Kohana_Cache {

    public function get($id, $default = NULL)
    {
        return FALSE;
    }

    public function set($id, $data, $lifetime = 3600)
    {
        return FALSE;
    }

    public function delete($id)
    {
        return FALSE;
    }

    public function delete_all()
    {
        return FALSE;
    }

    protected function _sanitize_id($id)
    {
        // Change slashes and spaces to underscores
        return str_replace(array('/', '\\', ' '), '_', $id);
    }
}