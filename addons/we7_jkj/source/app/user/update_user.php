<?php
include(FUN_ROOT.'user.fun.php');
include(CLASS_ROOT.'user.class.php');

$user_id = $_SESSION['user_id'];

$user_info = user_info($user_id);
if(!$user_info){
    die(json_encode(in_error(1, '用户不存在')));
}

$user = new User();

$data['user_id'] = $user_id;
$data['realname'] = isset($_GPC['realname']) ? trim($_GPC['realname']) : $user_info['realname'];
$data['headimg'] = isset($_GPC['headimg']) ? trim($_GPC['headimg']) : $user_info['headimg'];
$data['sex'] = in_array($_GPC['sex'], [0,1]) ? intval($_GPC['sex']) : $user_info['sex'];
$data['birth_year'] = isset($_GPC['birth_year']) ? intval($_GPC['birth_year']) : $user_info['birth_year'];
$data['birth_month'] = isset($_GPC['birth_month']) ? intval($_GPC['birth_month']) : $user_info['birth_month'];
$data['birth_day'] = isset($_GPC['birth_day']) ? intval($_GPC['birth_day']) : $user_info['birth_day'];
$data['home_phone'] = isset($_GPC['home_phone']) ? trim($_GPC['home_phone']) : $user_info['home_phone'];
$data['email'] = preg_match('/^[\w\-]+@[a-z0-9]{2,9}(\.[a-z]{2,5}){1,4}$/', $_GPC['email']) ? trim($_GPC['email']) : $user_info['email'];
$data['province'] = isset($_GPC['province']) ? intval($_GPC['province']) : $user_info['province'];
$data['city'] = isset($_GPC['city']) ? intval($_GPC['city']) : $user_info['city'];
$data['district'] = isset($_GPC['district']) ? intval($_GPC['district']) : $user_info['district'];
$data['address'] = isset($_GPC['address']) ? trim($_GPC['address']) : $user_info['address'];

if($user->updateUserInfo($data)){
    die(json_encode(in_success(0)));
}else{
    die(json_encode(in_error(1, $user->getErr())));
}


