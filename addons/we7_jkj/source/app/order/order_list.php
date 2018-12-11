<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

$user_id = $_SESSION['user_id'];
$page = max(1, $_GPC['page']);
$role = in_array($_GPC['role'], ['designer', 'shoper']) ? $_GPC['role'] : 'designer';
$order_status = isset($_GPC['order_status']) ? $_GPC['order_status'] : 'all';
if(check_role($role)){
    die(json_encode(in_error(1, '无权限操作')));
}

$list = get_reser_order_list($role, $order_status, $page, 15, true);

die(json_encode(in_success(0, $list)));
