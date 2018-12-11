<?php
include(FUN_ROOT.'transaction.fun.php');
include(CLASS_ROOT.'user.class.php');
include(CLASS_ROOT.'sms.class.php');

$username = trim($_GPC['username']);
$mobile = trim($_GPC['mobile']);
$pwd = trim($_GPC['pwd']);
$cpwd = trim($_GPC['cpwd']);
$code = trim($_GPC['code']);

if(!preg_match('/^[0-9A-Za-z_]{3,}$/', $username)){
    die(json_encode(in_error(1, '用户名只能由英文数字和下划线组成且不能小于3位')));
}
if(!preg_match('/^[\s\S]{6,}$/', $pwd) || !preg_match('/^[\s\S]{6,}$/', $cpwd)){
    die(json_encode(in_error(1, '密码长度不能小于6位')));
}
if($pwd != $cpwd){
    die(json_encode(in_error(1, '密码和确认密码不一致')));
}
if(!preg_match('/^1(3|4|5|7|8)\d{9}$/', $mobile)){
    die(json_encode(in_error(1, '手机号码格式不正确')));
}
$sms = new Sms();
/*if($sms->checkCode($mobile, $code)){
    die(json_encode(in_error(1, $sms->getErr())));
}*/

$user = new User();
if($user->register($username, $mobile, $pwd)){
    die(json_encode(in_success(0)));
}else{
    die(json_encode(in_error(1, $user->getErr())));
}

