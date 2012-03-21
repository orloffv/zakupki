<?php defined('SYSPATH') or die('No direct script access.');

class Pagination extends Kohana_Pagination {

    public $counter_show = false;

    public function render($view = NULL)
    {
        $this->counter_show = Arr::get($this->config, 'counter_show', false);

        return parent::render($view);
    }
}