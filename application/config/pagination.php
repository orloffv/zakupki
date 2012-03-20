<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'default' => array(
		'current_page'   => array('source' => 'query_string', 'key' => 'p'), // source: "query_string" or "route"
		'total_items'    => 0,
		'count_out'      => 5,
		'items_per_page' => 30,
		'view'           => 'pagination/backend',
		'auto_hide'      => TRUE,
	),

);
