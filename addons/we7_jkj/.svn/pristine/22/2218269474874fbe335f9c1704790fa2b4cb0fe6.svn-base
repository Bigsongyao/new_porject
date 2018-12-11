<?php
include(FUN_ROOT.'user.fun.php');

$user_id = $_SESSION['user_id'];

$fields = 'a.product_id,a.product_thumb,a.price,a.product_name,a.product_type';
$sql = "SELECT {$fields} FROM ".tablename("jkj_product")." AS a LEFT JOIN ".tablename("jkj_collect")." AS b ON a.product_id=b.product_id WHERE b.user_id=:user_id AND a.uniacid=:uniacid ORDER BY b.add_time DESC";
$list = pdo_fetchall($sql, array(':user_id' => $user_id, ':uniacid' => $_W['uniacid']));

foreach($collect_list as $k => $v){
    $list[$k]['product_thumb'] = tomedia($v['product_thumb']);
    $list[$k]['format_price'] = format_price($v['price']);
}

die(json_encode(in_success(0,$list)));