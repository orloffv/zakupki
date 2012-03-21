<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Home extends Controller_Frontend_Template
{
    public function action_index()
    {
        Frontend::set_title('Список закупок');

        $session = Session::instance();
        $last = $session->get('last');

        $new_items = Jelly::query('zakupki')->where('date', '>', $last)->count();

        $last_item = Jelly::query('zakupki')->limit(1)->order_by('date', 'desc')->execute();
        $last_check = Jelly::query('log')->limit(1)->order_by('dt_create', 'desc')->execute();

        $session->set('last', $last_item->date);

        $query = Jelly::query('zakupki')->order_by('date', 'desc');

        $pagination = Frontend::paging(
            $this->module_name,
            $query->count(),
            array(
                'items_per_page' => 100,
                'counter_show' => true
            )
        );

        $items = $query->paging($pagination, $pagination);

        $this->context['items'] = $items;
        $this->context['pagination'] = $pagination->render();
        $this->context['new_items'] = $new_items;
        $this->context['last_check'] = $last_check;
    }

    public function action_update()
    {
        Cron_Zakupki::factory()->run();

        $this->request->redirect('/');
    }

    /*
    public function action_filter()
    {
        $text = 'расходные материалы картридж вычислительная техника компьютер локальная монтаж пожарная сигнализация тревожная кнопка тревожная сигнализация телефония инженерные сети';

        $line = $this->words2AllForms($text).' пк опс слаботочка';
        var_dump($line);
    }

    public function action_updateindex()
    {
        $items = Jelly::query('zakupki')->where('words_index', '=', '')->limit(10)->execute();

        foreach ($items as $item)
        {
            var_dump('123');
            var_dump($this->words2BaseForm($item->title));
            exit();
        }
    }

    public function words2AllForms($text)
    {
        $morphy = new Morphy();
        $phpMorphy = $morphy->factory();

        $words = preg_replace('#\[.*\]#isU', '', $text);
        $words = explode(' ', str_replace(array(',','.',':',';','!','?','"','\'','(',')'), '', $words));

        $line = '';
        foreach ( $words as $v )
        {
            if ( strlen($v) > 3 )
            {
                $bulk_words = $phpMorphy->getAllForms(UTF8::strtoupper($v));
                if ($bulk_words)
                {
                    $line .= ' '.implode(" ", $bulk_words);
                }
            }
        }

        return UTF8::strtolower($line);
    }

    public function words2BaseForm($text)
    {
        $morphy = new Morphy();
        $phpMorphy = $morphy->factory();

        $words = preg_replace('#\[.*\]#isU', '', $text);
        $words = explode(' ', str_replace(array(',','.',':',';','!','?','"','\'','(',')'), '', $words));

        $bulk_words = array();
        foreach ( $words as $v )
        {
            if ( strlen($v) > 3 )
            {
                $bulk_words[] = UTF8::strtoupper($v);
            }
        }
        unset($bulk_words['3']);

        $base_form = $phpMorphy->getBaseForm($bulk_words);

        $fullList = array();

        if ( is_array($base_form) && count($base_form) )
        {
            foreach ( $base_form as $k => $v )
            {
                if ( is_array($v) )
                {
                    foreach ( $v as $v1 )
                    {
                        if ( strlen($v1) > 3 )
                        {
                            $fullList[$v1] = 1;
                        }
                    }
                }
            }
        }

        $words = join(' ', array_keys($fullList));

        return UTF8::strtolower($words);
    }
    */
}

