<?php

use Tygh\Registry;

if ($mode == 'view') {

	$params = array_merge(
		['items_per_page' => Registry::get('settings.Appearance.admin_elements_per_page')],
		$_REQUEST
	);
	list($data, $search) = fn_get_order_status_history($params);

	Tygh::$app['view']
		->assign('data', $data)
		->assign('statuses', fn_get_statuses())
		->assign('search', $search);

}
