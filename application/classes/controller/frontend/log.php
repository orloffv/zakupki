<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Log extends Controller_Frontend_Template
{
    public function action_index()
    {
        $query = Jelly::query('log')->order_by('dt_create', 'desc');

        $pagination = Frontend::paging(
            $this->module_name,
            $query->count(),
            array(
                'items_per_page' => 100
            )
        );

        $items = $query->paging($pagination, $pagination);

        $this->context['items'] = $items;
        $this->context['pagination'] = $pagination->render();
    }
}

