<?php
$comment_tags = array(
	'1' => '评论1',
	'2' => '评论2',
	'3' => '评论3',
	'4' => '评论4',
	'5' => '评论5',
);

$user_id = $_SESSION['user_id'];
$order_id = isset($_GPC['order_id']) ? $_GPC['order_id'] : 0;
$content = trim($_GPC['content']);
$star = isset($_GPC['star']) ? intval($_GPC['star']) : 0;
$tag_str = preg_match('/^[\d\,]+$/',$_GPC['tags']) ? $_GPC['tags'] : '';
$tags = empty($tag_str) ? array() : explode(',', $tag_str);

$order = pdo_fetch("SELECT order_id,order_status,product_id FROM ".tablename('jkj_order')." WHERE user_id=:user_id AND uniacid=:uniacid AND oid=:oid", array(
	':user_id' => $user_id,
	':uniacid' => $_W['uniacid'],
	':oid' => $oid
));
if(!$order){
    die(json_encode(in_error(1, '订单不存在')));
}

$is_comment = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jkj_comments')." WHERE user_id=:user_id AND uniacid=:uniacid AND order_id=:order_id AND comment_type=1", array(
	':user_id' => $user_id,
	':uniacid' => $_W['uniacid'],
	':order_id' => $order_id,
));
if($is_comment){
	die(json_encode(in_error(1, '订单已评价')));
}

if($order['product_id']>0){
	foreach($tags as $tag_id){
		if(isset($comment_tags[$tag_id])){
			$comment_tag[] = $comment_tags[$tag_id];

			$product_tag = pdo_fetch('SELECT id,num FROM '.tablename('jkj_product_tag').' WHERE product_id=:product_id AND tag_id=:tag_id AND uniacid=:uniacid',array(
				':product_id' => $order['product_id'],
				':tag_id' => $tag_id,
				':uniacid' => $_W['uniacid'],
			));

			if($product_tag){
				pdo_update('jkj_product_tag', array('num' => $product_tag['num']+1), array('id' => $product_tag['id']));
			}else{
				pdo_insert('jkj_product_tag', array(
					'product_id' => $order['product_id'],
					'tag_id' => $tag_id,
					'summary' => $comment_tags[$tag_id],
					'num' => 1,
					'uniacid' => $_W['uniacid'],
				));
			}
		}
	}
}

$data = array(
	'product_id' => $order['source_type'] == 'product' ? $order['source_id'] : 0,
	'user_id' => $user_id,
	'order_id' => $order_id,
	'content' => $content,
	'star' => $star,
	'tag' => isset($comment_tag) ? implode(',', $comment_tag) : '',
	'add_time' => TIMESTAMP,
	'comment_type' => 1,
	'uniacid' => $_W['uniacid'],
);
pdo_insert('jkj_comments', $data);

$update = array(
	'comment_time' => TIMESTAMP,
	'order_status' => 8,
);

pdo_update('jkj_order',$update, array('order_id' => $order_id));
order_record($order_id, $update['order_status'], true);

die(json_encode(in_success(0)));

