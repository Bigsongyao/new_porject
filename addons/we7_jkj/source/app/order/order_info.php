<?php
include(FUN_ROOT.'user.fun.php');
include(FUN_ROOT.'product.fun.php');

$user_id = $_SESSION['user_id'];
$order_id = isset($_GPC['order_id']) ? intval($_GPC['order_id']) : 0;
$role = in_array($_GPC['role'], ['designer', 'shoper']) ? $_GPC['role'] : 'designer';

if(check_role($role)){
    die(json_encode(in_error(1, '无权限操作')));
}

$result = pdo_fetch("SELECT * FROM ".tablename('jkj_order')." WHERE order_id=:order_id AND uniacid=:uniacid", array(
    ':order_id' => $order_id,
    ':uniacid' => $_W['uniacid'],
));
if(!$result){
    die(json_encode(in_error(1, '订单不存在')));
}

if($role == 'designer' && $result['designer'] == $user_id){
    die(json_encode(in_error(1, '无权限操作')));
}else{
    $shop_info = get_shop_info($result['shop_id']);
    if($shop_info['shoper_id']!=$user_id){
        die(json_encode(in_error(1, '无权限操作')));
    }
}

$user_info = user_info($user_id);
$comment = pdo_fetch("SELECT * FROM ".tablename('jkj_comments')." WHERE user_id=:user_id AND uniacid=:uniacid AND order_id=:order_id AND comment_type=1", array(
    ':user_id' => $user_id,
    ':uniacid' => $_W['uniacid'],
    ':order_id' => $order_id,
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
$result['order_time'] = date('Y-m-d H:i:s',$result['order_time']);

die(json_encode(in_success(0, $result)));

