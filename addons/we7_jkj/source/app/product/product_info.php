<?php
include(FUN_ROOT.'product.fun.php');

$product_id = isset($_GPC['product_id']) ? intval($_GPC['product_id']) : 0;

$product = get_product_info($product_id);
if(!$product){
    die(json_encode(in_error(1, '商品不存在或已下架')));
}

$sql = "SELECT AVG(star) as star, COUNT(comment_id) as total FROM ".tablename('jkj_comments')." WHERE product_id=:product_id AND uniacid=:uniacid";
$commont = pdo_fetch($sql, array(':product_id'=>$product_id, ':uniacid'=>$_W['uniacid']));

$sql = "SELECT summary,num FROM ".tablename('jkj_product_tag')." WHERE product_id=:product_id AND uniacid=:uniacid";
$product_tag = pdo_fetchall($sql, array(':product_id'=>$product_id, ':uniacid'=>$_W['uniacid']));

$product['commont']['star'] = $commont['star'] ? round($commont['star'], 1) : 0;
$product['commont']['total'] = $commont['total'] ? $commont['total'] : 0;
$product['tag']['total'] = $product_tag ? $product_tag : array();

die(json_encode(in_success(0, $product)));