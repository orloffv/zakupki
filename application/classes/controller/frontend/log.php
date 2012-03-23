<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Log extends Controller_Frontend_Template
{
    public function action_index()
    {
        $this->context['items'] = Api_Loader::load('log')->get(
            $this->context['pagination'], 100
        );
    }
}

