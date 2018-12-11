<?php
include(FUN_ROOT.'user.fun.php');
include(FUN_ROOT.'product.fun.php');

if(check_role('shoper')){
    die(json_encode(in_error(1, '无权限操作')));
}

$user_id = $_SESSION['user_id'];
$oid = isset($_GPC['oid']) ? intval($_GPC['oid']) : 0;

$par[':oid'] = $oid;
$par[':uniacid'] = $_W['uniacid'];

$sql = "SELECT oid,order_sn,shop_id,name,order_time FROM ".tablename('jkj_reser_order')." WHERE oid=:oid AND uniacid=:uniacid";
$result = pdo_fetch($sql, $par);
if(!$result){
    die(json_encode(in_error(1, '订单不存在')));
}

$shop_info = get_shop_info($result['shop_id']);
if($shop_info['shoper_id']!=$user_id){
    die(json_encode(in_error(1, '无权限操作')));
}
$user_info = user_info($user_id);
$comment = pdo_fetch("SELECT * FROM ".tablename('jkj_comments')." WHERE user_id=:user_id AND uniacid=:uniacid AND order_id=:oid AND comment_type=0", array(
    ':user_id' => $user_id,
    ':uniacid' => $_W['uniacid'],
    ':oid' => $oid,
));
if($comment){
    $result['comment']['tag'] = empty($comment['tag']) ? array() : explode(',', $comment['tag']);
    $result['comment']['star'] = $comment['star'];
    $result['comment']['content'] = $comment['content'];
    $result['is_comment'] = true;
}else{
    $result['is_comment'] = false;
}

$result['username'] = $user_info['username'];
$result['headimg'] = tomedia($user_info['headimg']);
$result['shop_name'] = $shop_info['shop_name'];
$result['order_time'] = date('Y-m-d H:i:s',$result['order_time']);

die(json_encode(in_success(0, $result)));

