<?php
/* 订单提醒 */
defined('IN_IA') or exit('Access Denied');
/*订单类型*/
define('RESERORDER', 0);
define('ORDER', 1);
/*订单状态*/
define('ADD', 0);           //待分配
define('DELIVER', 1);       //客服已派单
define('ASSIGN', 2);        //负责人已派单
define('MEASUE', 3);        //已量尺
define('DISCUSS', 4);       //已沟通
define('SIGN', 5);          //已签约
define('PRODUCTION', 6);    //已下单
define('SHIPPING', 7);      //已配送
define('COMMENT', 8);       //已评价/已完成
define('CANCEL', 9);        //取消
define('REFUND', 10);        //退款
define('RESTART', 11);        //重启

$remind[RESERORDER]['shop'] = [
    ADD => '您有新的体验订单,订单号%s',
];

$remind[ORDER]['shop'] = [
    DELIVER => '您有新的定制订单,订单号%s',
    PRODUCTION => '订单%s已设置下单生产',
    COMMENT => '订单%s已评价',
    CANCEL => '订单%s已取消',
];

$remind[ORDER]['designer'] = [
    ASSIGN => '您有新的定制订单,订单号%s',
    COMMENT => '订单%s已评价',
];

$remind[ORDER]['user'] = [
    ASSIGN => '订单%s分配给设计师',
    MEASUE => '订单%s已量尺',
    DISCUSS => '订单%s已沟通',
    SIGN => '订单%s已签约',
    PRODUCTION => '订单%s已下单生产',
    SHIPPING => '订单%s已配送安装',
    CANCEL => '订单%s已取消',
];
?>