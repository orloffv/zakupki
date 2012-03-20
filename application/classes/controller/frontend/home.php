<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Home extends Controller_Frontend_Template
{
    public function action_index()
    {
        $query = Jelly::query('zakupki')->order_by('date', 'desc');

        $pagination = Frontend::paging(
            $this->module_name,
            $query->count(),
            array(
                'items_per_page' => 100
            )
        );

        $items = $query->paging($pagination->items_per_page, $pagination->offset);

        $this->context['items'] = $items;
        $this->context['pagination'] = $pagination->render();
    }
}

