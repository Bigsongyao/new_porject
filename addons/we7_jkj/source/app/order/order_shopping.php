<?php
include(FUN_ROOT.'order.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('shoper')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GPC['order_id']);
$build_day = preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $_GPC['build_day']) ? $_GPC['build_day'] : false;
$build_time = preg_match('/^\d{1,2}:\d{1,2}$/', $_GPC['build_time']) ? $_GPC['build_time'] : false;
$acceptance_images = json_decode($_GPC['acceptance_images'], true);
$real_images = json_decode($_GPC['real_images'], true);

if($build_day === false || $build_time === false){
	die(json_encode(in_error(1, '请选择预约安装时间')));
}

$build_date = $build_day.' '.$build_time;
if(strtotime($build_date)<TIMESTAMP){
	die(json_encode(in_error(1, '预约安装时间不能小于当前时间')));
}

if(!is_array($acceptance_images) || count($acceptance_images)<=0){
	die(json_encode(in_error(1, '请上传合同照片')));
}

if(!is_array($real_images) || count($real_images)<=0){
	die(json_encode(in_error(1, '请上传票据照片')));
}

$sql = "SELECT * FROM ".tablename('jkj_order')." WHERE order_id=:order_id AND shop_id=:shop_id AND uniacid=:uniacid";
$order = pdo_fecth($sql, array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));

if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}

if($order['is_cancel']){
    die(json_encode(in_error(1, '订单已取消')));
}

$shop_info = get_shop_info($order['shop_id']);
if($user_id != $shop_info['shoper_id'] || $order['order_status'] != 6){
	die(json_encode(in_error(1, '无权限操作')));
}

$update = array(
    'shipping_time' => TIMESTAMP,
    'order_status' => 7,
	'build_time' => strtotime($build_date),
	'acceptance_images' => serialize($acceptance_images),
	'real_images' => serialize($real_images),
);

pdo_update('jkj_order', $update, array('order_id' => $order_id));
order_record($order_id, $update['order_status'], 1);

die(json_encode(in_success(0)));