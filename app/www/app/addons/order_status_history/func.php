<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_order_status_history_change_order_status($status_to, $status_from, $order_info)
{
	$data = [
		'user_id' => Tygh::$app['session']['auth']['user_id'],
		'status_old' => $status_from,
		'status_new' => $status_to,
		'order_id' => $order_info['order_id'],
		'created_at' => (new DateTime())->format('Y-m-d H:i:s')
	];

	db_query('INSERT INTO ?:order_status_history ?e', $data);
}

function fn_get_order_status_history($params)
{
	$params = array_merge(array(
		'items_per_page' => 0,
		'page' => 1,
	), $params);

	$limit = '';

	if (!empty($params['items_per_page'])) {
		$params['total_items'] = db_get_field(
			"SELECT COUNT(id) FROM ?:order_status_history"
		);
		$limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
	}

	$items = db_get_array(
		"SELECT osh.*, u.user_login"
		. " FROM ?:order_status_history osh"
		. " LEFT JOIN ?:users u ON u.user_id = osh.user_id"
		. " ORDER BY osh.id DESC"
		. $limit
	);

	$format = Registry::get('settings.Appearance.date_format');
	foreach ($items as &$item) {
		$date = new \DateTime($item['crated_at']);
		$item['created_at'] = fn_date_format($date->getTimestamp(), $format);
	}

	return [$items, $params];
}
