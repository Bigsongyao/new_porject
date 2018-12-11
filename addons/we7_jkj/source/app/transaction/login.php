<?php
include(FUN_ROOT.'transaction.fun.php');
include(CLASS_ROOT.'user.class.php');

$user = new User();

$is_remember = empty($_GPC['is_remember']) ? false : true;
if(isset($_GPC['pwd'])){
    /*密码登录*/
    if(!preg_match('/^[0-9A-Za-z_]{3,}$/', $_GPC['username'])){
        die(json_encode(in_error(1, '用户名只能由英文数字和下划线组成且不能小于3位')));
    }
    if(!preg_match('/^[\s\S]{6,}$/', $_GPC['pwd'])){
        die(json_encode(in_error(1, '密码长度不能小于6位')));
    }

    if($info = $user->login($_GPC['username'], $_GPC['pwd'], $is_remember)){
        die(json_encode(in_success(0, $info)));
    }else{
        die(json_encode(in_error(1, $user->getErr())));
    }
}else{
    include(CLASS_ROOT.'sms.class.php');

    /*短信登录*/
    if(!preg_match('/^1(3|4|5|7|8)\d{9}$/', $_GPC['mobile'])){
        die(json_encode(in_error(1, '手机号码格式不正确')));
    }
    $sms = new Sms();
    if($sms->checkCode($_GPC['mobile'], $_GPC['code'])){
        die(json_encode(in_error(1, $sms->getErr())));
    }

    if($user->loginByMobile($_GPC['mobile'], $is_remember)){
        die(json_encode(in_success(0)));
    }else{
        die(json_encode(in_error(1, $user->getErr())));
    }
}

