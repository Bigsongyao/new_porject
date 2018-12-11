<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('user')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$page = max(1, $_GPC['page']);
$order_status = isset($_GPC['order_status']) ? $_GPC['order_status'] : 'all';

$list = get_order_list('user', $order_status, $page, 15, true);

die(json_encode(in_success(0, $list)));
