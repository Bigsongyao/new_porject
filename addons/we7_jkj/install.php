<?php


$sql = "
	DROP TABLE IF EXISTS `ims_jkj_attribute`;
	CREATE TABLE `ims_jkj_attribute` (
	  `attr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `attr_name` varchar(60) NOT NULL,
	  `is_suite` tinyint(1) NOT NULL COMMENT '是否套件',
	  `attr_sort` smallint(8) NOT NULL COMMENT '属性排序',
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  PRIMARY KEY (`attr_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_category`;
	CREATE TABLE `ims_jkj_category` (
	  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `cat_name` varchar(50) NOT NULL,
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  `is_show` tinyint(1) NOT NULL,
	  `sort_by` smallint(8) NOT NULL,
	  `type` tinyint(1) NOT NULL COMMENT '0:全屋定制，1:预约',
	  PRIMARY KEY (`cat_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_collect`;
	CREATE TABLE `ims_jkj_collect` (
	  `cid` int(10) NOT NULL AUTO_INCREMENT,
	  `user_id` int(10) DEFAULT NULL,
	  `product_id` int(10) DEFAULT NULL,
	  `add_time` int(10) DEFAULT NULL,
	  `uniacid` int(10) DEFAULT NULL,
	  PRIMARY KEY (`cid`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_comments`;
	CREATE TABLE `ims_jkj_comments` (
	  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
	  `user_id` int(10) DEFAULT NULL,
	  `order_id` int(10) DEFAULT NULL,
	  `product_id` int(10) DEFAULT NULL,
	  `content` text,
	  `star` tinyint(2) DEFAULT NULL,
	  `add_time` int(10) DEFAULT NULL,
	  `uniacid` int(10) DEFAULT NULL,
	  `tag` text,
	  `comment_type` tinyint(1) DEFAULT NULL,
	  PRIMARY KEY (`comment_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_designer`;
	CREATE TABLE `ims_jkj_designer` (
	  `shop_id` int(10) DEFAULT NULL,
	  `user_id` int(10) DEFAULT NULL,
	  `uniacid` int(10) DEFAULT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_link_product`;
	CREATE TABLE `ims_jkj_link_product` (
	  `product_id` smallint(8) NOT NULL,
	  `link_product_id` smallint(8) NOT NULL,
	  `uid` smallint(8) NOT NULL,
	  `uniacid` int(10) NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_order`;
	CREATE TABLE `ims_jkj_order` (
	  `order_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `user_id` int(10) NOT NULL,
	  `username` varchar(100) NOT NULL,
	  `mobile` varchar(20) NOT NULL,
	  `shop_id` int(10) NOT NULL,
	  `province` varchar(20) NOT NULL COMMENT '省',
	  `city` varchar(20) NOT NULL COMMENT '市',
	  `remark` text NOT NULL COMMENT '需求',
	  `uniacid` int(10) NOT NULL,
	  `source_id` int(10) NOT NULL,
	  `source_type` varchar(20) NOT NULL,
	  `order_sn` varchar(50) NOT NULL COMMENT '订单号',
	  `contract_sn` varchar(50) NOT NULL COMMENT '合同号',
	  `production_sn` varchar(50) NOT NULL COMMENT '生产号',
	  `add_time` int(10) NOT NULL COMMENT '客户预约时间',
	  `deliver_time` int(10) NOT NULL COMMENT '派单时间',
	  `measue_time` int(10) NOT NULL COMMENT '测量时间',
	  `discuss_time` int(10) NOT NULL COMMENT '方案沟通时间',
	  `sign_time` int(10) NOT NULL COMMENT '签约时间',
	  `production_time` int(10) NOT NULL COMMENT '生产时间',
	  `shopping_time` int(10) NOT NULL COMMENT '配送时间',
	  `comment_time` int(10) NOT NULL COMMENT '评论时间',
	  `pay_type` varchar(10) NOT NULL,
	  `contract_price` decimal(10,2) NOT NULL COMMENT '合同金额',
	  `contract_images` text NOT NULL COMMENT '合同图片',
	  `invoice_images` text NOT NULL COMMENT '票据图片',
	  `acceptance_images` text NOT NULL COMMENT '安装图片',
	  `real_images` text NOT NULL COMMENT '现场图片',
	  `order_status` tinyint(2) NOT NULL COMMENT '0：待分配，1：客服已派单，2：负责人已派单，3:已量尺。4：已沟通：5已签约，6：已下单，7：已配送，8：已评价/已完成',
	  `designer_id` int(10) NOT NULL,
	  `is_cancel` tinyint(2) NOT NULL,
	  `refund_status` tinyint(2) NOT NULL,
	  `pay_money` decimal(10,2) NOT NULL,
	  `pay_status` tinyint(2) NOT NULL,
	  `order_time` int(10) NOT NULL COMMENT '预定交货时间',
	  `pay_time` int(10) NOT NULL COMMENT '支付时间',
	  `refund_time` int(10) NOT NULL COMMENT '退款时间',
	  `production_day` smallint(8) NOT NULL,
	  `build_time` int(10) NOT NULL COMMENT '预计安装时间',
	  PRIMARY KEY (`order_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_order_record`;
	CREATE TABLE `ims_jkj_order_record` (
	  `record_id` int(10) NOT NULL AUTO_INCREMENT,
	  `order_id` int(10) DEFAULT NULL,
	  `order_status` varchar(20) DEFAULT NULL,
	  `order_record` text,
	  `add_time` int(10) DEFAULT NULL,
	  `action_user_id` int(10) DEFAULT NULL,
	  `uniacid` int(11) DEFAULT NULL,
	  PRIMARY KEY (`record_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_order_remind`;
	CREATE TABLE `ims_jkj_order_remind` (
	  `rid` int(10) NOT NULL AUTO_INCREMENT,
	  `user_id` int(10) NOT NULL,
	  `title` varchar(100) NOT NULL,
	  `content` text NOT NULL,
	  `role` tinyint(2) NOT NULL,
	  `status` tinyint(2) NOT NULL,
	  `type` tinyint(2) NOT NULL,
	  `add_time` int(10) NOT NULL,
	  `uniacid` int(10) NOT NULL,
	  PRIMARY KEY (`rid`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_product_attr`;
	CREATE TABLE `ims_jkj_product_attr` (
	  `product_attr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `product_id` int(10) NOT NULL,
	  `attr_id` int(10) NOT NULL,
	  `attr_value` varchar(60) NOT NULL,
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  PRIMARY KEY (`product_attr_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_product_cat`;
	CREATE TABLE `ims_jkj_product_cat` (
	  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `cat_id` int(10) DEFAULT NULL,
	  `item_id` int(10) DEFAULT NULL,
	  `product_id` int(10) DEFAULT NULL,
	  `uniacid` int(10) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_product_cat_item`;
	CREATE TABLE `ims_jkj_product_cat_item` (
	  `item_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `cat_id` int(10) NOT NULL,
	  `title` varchar(255) NOT NULL,
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  PRIMARY KEY (`item_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_product_tag`;
	CREATE TABLE `ims_jkj_product_tag` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `product_id` int(11) DEFAULT NULL,
	  `tag_id` smallint(8) DEFAULT NULL,
	  `num` int(11) DEFAULT NULL,
	  `summary` varchar(255) DEFAULT NULL,
	  `uniacid` int(10) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_products`;
	CREATE TABLE `ims_jkj_products` (
	  `product_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `product_name` varchar(255) NOT NULL,
	  `product_thumb` varchar(255) NOT NULL,
	  `product_img` text NOT NULL,
	  `description` text NOT NULL,
	  `price` varchar(20) NOT NULL,
	  `product_details` text NOT NULL COMMENT '商品详情',
	  `product_shipping` text NOT NULL COMMENT '配送安装',
	  `product_suite` text NOT NULL COMMENT '配置清单',
	  `status` int(2) NOT NULL COMMENT '1为默认',
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  `linkurl` varchar(255) NOT NULL,
	  `sort_by` smallint(8) NOT NULL,
	  `product_type` tinyint(1) NOT NULL,
	  `is_hot` tinyint(1) NOT NULL,
	  `is_new` tinyint(1) NOT NULL,
	  `shop_id` int(10) NOT NULL,
	  PRIMARY KEY (`product_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_region`;
	CREATE TABLE `ims_jkj_region` (
	  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
	  `region_name` varchar(120) NOT NULL DEFAULT '',
	  `region_type` tinyint(1) NOT NULL DEFAULT '2',
	  `region_code` varchar(20) NOT NULL DEFAULT '',
	  PRIMARY KEY (`region_id`),
	  KEY `parent_id` (`parent_id`),
	  KEY `region_type` (`region_type`)
	) ENGINE=MyISAM AUTO_INCREMENT=3514 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_reser_order`;
	CREATE TABLE `ims_jkj_reser_order` (
	  `oid` int(11) NOT NULL AUTO_INCREMENT,
	  `order_sn` varchar(50) NOT NULL,
	  `user_id` int(11) NOT NULL,
	  `product_id` int(10) NOT NULL,
	  `shop_id` smallint(8) NOT NULL,
	  `name` varchar(50) NOT NULL,
	  `mobile` varchar(20) NOT NULL,
	  `order_time` int(10) NOT NULL,
	  `remark` text NOT NULL,
	  `order_status` tinyint(2) NOT NULL COMMENT '0：未联系，1：已联系，2：已体验，3：已取消',
	  `come_time` int(10) NOT NULL,
	  `add_time` int(10) NOT NULL,
	  `order_id` int(10) NOT NULL COMMENT '定制订单id，未生成为0',
	  `uniacid` int(10) NOT NULL,
	  PRIMARY KEY (`oid`)
	) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_shops`;
	CREATE TABLE `ims_jkj_shops` (
	  `shop_id` smallint(8) NOT NULL AUTO_INCREMENT,
	  `shop_name` varchar(100) DEFAULT NULL,
	  `shoper_id` int(10) DEFAULT NULL,
	  `province` smallint(8) DEFAULT NULL,
	  `city` smallint(8) DEFAULT NULL,
	  `district` smallint(8) DEFAULT NULL,
	  `address` varchar(255) DEFAULT NULL,
	  `lng` varchar(20) DEFAULT NULL,
	  `lat` varchar(20) DEFAULT NULL,
	  `content` text,
	  `uniacid` int(10) DEFAULT NULL,
	  `add_time` int(10) DEFAULT NULL,
	  PRIMARY KEY (`shop_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `ims_jkj_user`;
	CREATE TABLE `ims_jkj_user` (
	  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	  `openid` varchar(28) NOT NULL,
	  `username` varchar(100) NOT NULL,
	  `password` varchar(32) NOT NULL COMMENT '密码',
	  `salt` varchar(10) NOT NULL,
	  `headimg` varchar(255) NOT NULL,
	  `nickname` varchar(100) NOT NULL COMMENT '昵称',
	  `realname` varchar(100) NOT NULL COMMENT '真实姓名',
	  `sex` tinyint(1) NOT NULL,
	  `birth_year` smallint(8) NOT NULL,
	  `birth_month` smallint(8) NOT NULL,
	  `birth_day` smallint(8) NOT NULL,
	  `province` int(10) NOT NULL COMMENT '省',
	  `city` int(10) NOT NULL COMMENT '市',
	  `district` int(10) NOT NULL COMMENT '县(区)',
	  `mobile` varchar(20) NOT NULL,
	  `home_phone` varchar(20) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `address` varchar(225) NOT NULL COMMENT '详细地址',
	  `uniacid` int(10) NOT NULL COMMENT '公众号id',
	  `addtime` varchar(45) NOT NULL,
	  `status` int(2) NOT NULL COMMENT '1为默认',
	  `is_designer` tinyint(1) NOT NULL,
	  `is_shoper` tinyint(1) NOT NULL,
	  PRIMARY KEY (`user_id`)
	) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
";

pdo_run($sql);
