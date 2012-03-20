<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Zakupki extends Jelly_Model {

    public static function initialize(Jelly_Meta $meta)
    {
        $meta->table('zakupki')
            ->fields(array(
            'id'            => Jelly::field('primary'),
            'title'         => Jelly::field('text'),
            'price'         => Jelly::field('float'),
            'customer'      => Jelly::field('text'),
            'owner_id'      => Jelly::field('integer'),
            'date'          => Jelly::field('integer'),
            'type'          => Jelly::field('enum', array(
                'choices' => array('open_auction',  'request_quotations', 'open_contest')
            )),
            'dt_create'        => Jelly::field('integer', array(
                'default' => time()
            ))
        ));
    }
}