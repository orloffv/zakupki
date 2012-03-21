<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Home extends Controller_Frontend_Template
{
    public function action_index()
    {
        $session = Session::instance();
        $last = $session->get('last');

        $new_items = Jelly::query('zakupki')->where('date', '>', $last)->count();

        $last_item = Jelly::query('zakupki')->limit(1)->order_by('date', 'desc')->execute();

        $session->set('last', $last_item->date);

        $query = Jelly::query('zakupki')->order_by('date', 'desc');

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
        $this->context['new_items'] = $new_items;
    }
}

