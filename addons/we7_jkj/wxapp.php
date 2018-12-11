<?php
/**
 * 极客家网上预约系统模块小程序接口定义
 *
 * @author О⒈㈢
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class We7_jkjModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
}