<?php defined('SYSPATH') or die('No direct script access.');

class Zakupki {

    public function go($url)
    {
        $data = $this->parser($url);
        $result = $this->save($data);

        return $result;
    }

    public function save($data)
    {
        $add_data = array();

        $last_item = Jelly::query('zakupki')->limit(1)->order_by('date', 'desc')->execute();

        if ( ! $last_item)
        {
            $add_data = $data;
        }

        foreach ($data as $item)
        {
            if ($item['date'] > $last_item->date || $item['date'] == $last_item->date && $item['owner_id'] != $last_item->owner_id)
            {
                $add_data[] = $item;
            }
        }

        $saved = 0;

        foreach ($add_data as $item)
        {
            $result = Jelly::factory('zakupki')->set($item)->save();

            if ($result)
            {
                $saved++;
            }
        }

        return $saved;
    }

    private function parser($url)
    {
        $curl = new Curl($url);

        $items = Feed::parse($curl->getData());

        $return_data = array();

        foreach ($items as $item)
        {
            $data = array();

            $data['date'] = strtotime($item['pubDate']);
            $data['owner_id'] = (int)str_replace('http://zakupki.gov.ru/pgz/public/action/orders/info/common_info/show?notificationId=', '', $item['link']);

            preg_match_all('#<b>([\s\S]*?)</b>([\s\S]*?)<br/>#', $item['description'], $parsed_description, PREG_SET_ORDER);

            foreach($parsed_description as $line)
            {
                $key = trim(str_replace(array(':', ';'), ' ', Text::remove_entities($line['1'])));
                $value = trim(str_replace(array(':', ';'), ' ', Text::remove_entities($line['2'])));

                if ($key == 'Начальная (максимальная) цена контракта')
                {
                    $data['price'] = (float)$value;
                }
                elseif ($key == 'Способ размещения заказа')
                {
                    $value = UTF8::ucfirst($value);

                    switch ($value) {
                        case "Открытый аукцион в электронной форме":
                            $data['type'] = 'open_auction';
                            break;
                        case "Запрос котировок":
                            $data['type'] = 'request_quotations';
                            break;
                        case "Открытый конкурс":
                            $data['type'] = "open_contest";
                            break;
                        default :
                            $data['type'] = null;
                            break;
                    }
                }
                elseif($key == 'Заказчик')
                {
                    $data['customer'] = UTF8::ucfirst($value);
                }
                elseif($key == 'Наименование заказа')
                {
                    $data['title'] = UTF8::ucfirst($value);
                }
            }

            $return_data[] = $data;
        }

        return $return_data;
    }
}