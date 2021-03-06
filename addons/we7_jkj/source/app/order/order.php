<?php
include(FUN_ROOT.'order.fun.php');
include(CLASS_ROOT.'sms.class.php');

$product_id = isset($_GPC['product_id']) ? intval($_GPC['product_id']) : 0;
$name = isset($_GPC['name']) ? trim($_GPC['name']) : '';
$mobile = isset($_GPC['mobile']) ? trim($_GPC['mobile']) : '';
$province = isset($_GPC['province']) ? intval($_GPC['province']) : 0;
$city = isset($_GPC['city']) ? intval($_GPC['city']) : 0;
$code = isset($_GPC['code']) ? trim($_GPC['code']) : '';
$user_id = $_SESSION['user_id'];
$is_pay = isset($_GPC['is_pay']) ? intval($_GPC['is_pay']) : 0;
$pay_money = 100;

if(!preg_match('/^\S{2,}$/', $name)){
    die(json_encode(in_error(1, '请输入正确的姓名')));
}
if(!preg_match('/^1(3|4|5|7|8)\d{9}$/', $mobile)){
    die(json_encode(in_error(1, '请输入正确的电话')));
}
if(empty($province)||empty($city)){
    die(json_encode(in_error(1, '请选择所在城市')));
}
if(empty($user_id)){
    $sms = new Sms();
    if($sms->checkCode($mobile, $code)){
        die(json_encode(in_error(1, $sms->getErr())));
    }
    $user_info = $user->getUserByMobile($mobile);
    $user_id = $user_info['user_id'];
}

$order = array(
    'order_sn' => order_sn($city),
    'user_id' => $user_id,
    'province' => $province,
    'city' => $city,
    'username' => $name,
    'mobile' => $mobile,
    'source_type' => $product_id ? 'product' : 'quickOrder',
    'source_id' => $product_id,
    'pay_money' => $is_pay ? $pay_money : 0,
	'order_status' => 0,
    'add_time' => TIMESTAMP,
    'uniacid' => $_W['uniacid']
);
if(pdo_insert('jkj_order', $order)){
    $order_id = pdo_insertid();

    order_record($order_id, $update['order_status'], true);
    die(json_encode(in_success(0)));
}else{
    die(json_encode(in_error(1, '预约失败')));
}
