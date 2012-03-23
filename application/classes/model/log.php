<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Log extends Jelly_Model {

    public static function initialize(Jelly_Meta $meta)
    {
        $meta->table('log')
            ->sorting(array('dt_create' => 'desc'))
            ->fields(array(
            'id'            => Jelly::field('primary'),
            'status'         => Jelly::field('text'),
            'dt_create'        => Jelly::field('integer', array(
                'default' => time()
            ))
        ));
    }
}