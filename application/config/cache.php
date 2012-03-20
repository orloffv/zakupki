<?php defined('SYSPATH') or die('No direct script access.');

return array
(
    'filetag' => array
	(
		'driver'             => 'filetag',
		'cache_dir'          => APPPATH.'cache/frontend',
		'default_expire'     => 3600,
	),

    'fake' => array(
        'driver'             => 'fake',
    )
);