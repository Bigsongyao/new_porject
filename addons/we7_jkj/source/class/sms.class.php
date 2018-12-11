<?php
/**
 * 短信操作类
*
*/
defined('IN_IA') or exit('Access Denied');
class Sms{
	private $error;

	public function __construct() {

	}

	public function sendSms($mobile, $content){

	}

	public function checkSms($mobile, $code){
		if(empty($_SESSION['mobile'])||empty($_SESSION['code'])){
			$this->error = '请先获取验证码';
			return false;
		}

		if($code != $_SESSION['code'] || $mobile != $_SESSION['mobile']){
			$this->error = '验证码错误';
			return false;
		}

		unset($_SESSION['mobile'], $_SESSION['code']);

		return true;
	}

	public function getErr(){
		return $this->error;
	}
}