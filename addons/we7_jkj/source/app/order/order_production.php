<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('designer')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GPC['order_id']);
$production_day = isset($_GPC['production_day']) ? intval($_GPC['production_day']) : false;

if(!$production_day){
    die(json_encode(in_error(1, '请选择生产时间')));
}

$sql = "SELECT * FROM ".tablename('jkj_order')." WHERE order_id=:order_id AND shop_id=:shop_id AND uniacid=:uniacid";
$order = pdo_fecth($sql, array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));

if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}

if($order['is_cancel']){
    die(json_encode(in_error(1, '订单已取消')));
}

if($order['designer_id'] != $user_id || $order['order_status'] != 5){
    die(json_encode(in_error(1, '无权限操作')));
}

$update = array(
    'production_day' => $production_day,
    'order_status' => 6,
    'production_sn' => order_sn(),
    'production_time' => TIMESTAMP
);

pdo_update('jkj_order', $update, array('order_id' => $order_id));
order_record($order_id, $update['order_status'], true);

die(json_encode(in_success(0)));






