<?php
include(FUN_ROOT.'product.fun.php');include(FUN_ROOT.'order.fun.php');

$page = max(1, intval($_GPC['page']));
$type = isset($_GPC['type']) ? intval($_GPC['type']) : 0;
$filter_item_str = isset($_GPC['filter_item']) ? htmlspecialchars(trim($_GPC['filter_item']),ENT_COMPAT) : '0';

$filter_item_str = trim(urldecode($filter_item_str));
$filter_item_str = preg_match('/^[\d\.]+$/',$filter_item_str) ? $filter_item_str : '';
$filter_item = empty($filter_item_str) ? '' : explode('.', $filter_item_str);

$data = get_product_list($type, $filter_item, $page, 9);

die(json_encode(in_success(0, $data)));