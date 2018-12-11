<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

$user_id = $_SESSION['user_id'];

$remark = isset($_GPC['remark']) ? trim($_GPC['remark']) : '';
$status = in_array($_GPC['status'], array('0', '1', '2', '3')) ? $_GPC['status'] : false;
$order_time = preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $_GPC['order_time']) ? $_GPC['order_time'] : false;
$oid = isset($_GPC['oid']) ? intval($_GPC['oid']) : 0;

if(check_role('shoper')){
    die(json_encode(in_error(1, '无权限操作')));
}

$shop = pdo_fetch("SELECT shop_id,province,city FROM ".tablename('jkj_shops')." WHERE shoper_id=:user_id AND uniacid=:uniacid", array(':user_id' => $user_id, ':uniacid' => $_W['uniacid']));

$order = pdo_fetch("SELECT * FROM ".tablename('jkj_reser_order')." WHERE shop_id=:shop_id AND uniacid=:uniacid AND oid=:oid", array(':shop_id' => $shop_id, ':uniacid' => $_W['uniacid'], ':oid' => $oid));
if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}
if($order['order_status'] == '3'){
    die(json_encode(in_error(1, '订单已取消，不可操作')));
}

$status = $status === false ? $order['order_status'] : $status;
$order_time = $order_time === false ? $order['order_time'] : strtotime($order_time);

switch($status){
    case '0':
        pdo_update('jkj_reser_order', array('order_status'=> 0, 'remark' => $remark, 'order_time' => $order_time), array('oid' => $oid));
        break;
    case '1':
        pdo_update('jkj_reser_order', array('order_status'=> 1, 'remark' => $remark, 'order_time' => $order_time), array('oid' => $oid));
        break;
    case '2':
        pdo_update('jkj_reser_order', array('order_status'=> 2, 'remark' => $remark, 'come_time' => TIMESTAMP, 'order_time' => $order_time), array('oid' => $oid));
        break;
    case '3':
        pdo_update('jkj_reser_order', array('order_status'=> 3, 'remark' => $remark, 'order_time' => $order_time), array('oid' => $oid));
        break;
}

die(json_encode(in_success(0)));

