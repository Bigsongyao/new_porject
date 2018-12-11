<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('designer')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GPC['order_id']);
$measue_day = preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $_GPC['measue_day']) ? $_GPC['measue_day'] : false;
$measue_time = preg_match('/^\d{1,2}:\d{1,2}$/', $_GPC['measue_time']) ? $_GPC['measue_time'] : false;

if($measue_day === false || $measue_time === false){
    die(json_encode(in_error(1, '请选择预约量尺时间')));
}

$measue_date = $measue_day.' '.$measue_time;
if(strtotime($measue_date)>TIMESTAMP){
    die(json_encode(in_error(1, '预约量尺时间不能大于当前时间')));
}

$sql = "SELECT * FROM ".tablename('jkj_order')." WHERE order_id=:order_id AND shop_id=:shop_id AND uniacid=:uniacid";
$order = pdo_fecth($sql, array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));

if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}

if($order['is_cancel']){
    die(json_encode(in_error(1, '订单已取消')));
}

if($order['designer_id'] != $user_id || $order['order_status'] != 2){
    die(json_encode(in_error(1, '无权限操作')));
}

$update = array(
    'measue_time' => strtotime($measue_date),
    'order_status' => 3,
);

pdo_update('jkj_order', $update, array('order_id' => $order_id));
order_record($order_id, $update['order_status'], true);

die(json_encode(in_success(0)));






