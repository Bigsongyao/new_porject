<?php

if(empty($_SESSION['user_id'])){
	die('0');
}

$sql = "SELECT COUNT(*) FROM ".tablename('jkj_order_remind')." WHERE user_id=:user_id AND uniacid=:uniacid AND status=:status";
$message_total = pdo_fetchcolumn($sql, array(':user_id' => $user_id, ':uniacid' => $_W['uniacid'], ':status' => 0));

die($message_total);