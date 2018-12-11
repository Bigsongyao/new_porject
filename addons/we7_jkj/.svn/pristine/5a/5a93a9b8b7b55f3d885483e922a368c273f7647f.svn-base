<?php
include(FUN_ROOT.'product.fun.php');

$step = isset($_GPC['step']) ? trim($_GPC['step']) : '';

if($step == 'products'){
    $page = max(1, intval($_GPC['page']));
    $type = isset($_GPC['type']) ? intval($_GPC['type']) : 0;
    $filter_item_str = isset($_GPC['filter_item']) ? htmlspecialchars(trim($_GPC['filter_item']),ENT_COMPAT) : '0';

    $filter_item_str = trim(urldecode($filter_item_str));
    $filter_item_str = preg_match('/^[\d\.]+$/',$filter_item_str) ? $filter_item_str : '';
    $filter_item = empty($filter_item_str) ? '' : explode('.', $filter_item_str);

    $data = get_product_list($type, $filter_item, $page);

    die(json_encode(in_success(0, $data)));
}elseif($step == 'commonts'){
    $page = max(1, intval($_GPC['page']));
    $product_id = intval($_GPC['product_i']);

    $data = get_commont_list($product_id, $page);
    die(json_encode(in_success(0, $data)));
}


