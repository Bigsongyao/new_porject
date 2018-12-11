<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('shoper')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GPC['order_id']);
$design_id = intval($_GPC['design_id']);

$sql = "SELECT * FROM ".tablename('jkj_order')." WHERE order_id=:order_id AND shop_id=:shop_id AND uniacid=:uniacid";
$order = pdo_fecth($sql, array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));

if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}

$shop_info = get_shop_info($order['shop_id']);
if($user_id != $shop_info['shoper_id']){
    die(json_encode(in_error(1, '无权限操作')));
}

if($order['is_cancel']){
    die(json_encode(in_error(1, '订单已取消')));
}

if($order['designer_id'] || $order['order_status'] != 1){
    die(json_encode(in_error(1, '已派送设计师')));
}

$shop_designer = explode(',', $shop_info['designer']);
if(!in_array($design_id, $shop_designer)){
    die(json_encode(in_error(1, '选择的设计师不在该店铺')));
}

$update = array(
    'design_id' => $design_id,
    'deliver_time' => TIMESTAMP,
    'order_status' => 2,
);

pdo_update('jkj_order', $update, array('order_id' => $order_id));
order_remind($order_id, $update['order_status'], 1);

die(json_encode(in_success(0)));






