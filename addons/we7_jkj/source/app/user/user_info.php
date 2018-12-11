<?php
include(FUN_ROOT.'user.fun.php');

$user_id = $_SESSION['user_id'];

$user_info = user_info($user_id);
if(!$user_info){
    die(json_encode(in_error(1, '用户不存在')));
}

$user_info['province_list'] = get_region(1, 1);
$user_info['city_list'] = get_region($user_info['province'], 2);
$user_info['district_list'] = get_region($user_info['city'], 3);

die(json_encode(in_success(0,$user_info)));