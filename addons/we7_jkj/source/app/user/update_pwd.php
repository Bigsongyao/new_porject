<?php
include(FUN_ROOT.'user.fun.php');
include(CLASS_ROOT.'user.class.php');

$user_id = $_SESSION['user_id'];
$pwd = trim($_GPC['pwd']);
$cpwd = trim($_GPC['cpwd']);

if(!preg_match('/^[\s\S]{6,}$/', $pwd) || !preg_match('/^[\s\S]{6,}$/', $cpwd)){
    die(json_encode(in_error(1, '密码长度不能小于6位')));
}
if($pwd != $cpwd){
    die(json_encode(in_error(1, '密码和确认密码不一致')));
}

$user_info = user_info($user_id);
if(!$user_info){
    die(json_encode(in_error(1, '用户不存在')));
}

$user = new User();

$data['user_id'] = $user_id;
$data['password'] = $pwd;

if($user->updateUserInfo($data)){
    die(json_encode(in_success(0)));
}else{
    die(json_encode(in_error(1, $user->getErr())));
}


