<?php

//decode by QQ:1031199343 https://www.xiaoyinnet.com/
load()->func('communication');
class Printer
{
	private $user = '';
	private $key = '';
	private $sn = '';
	private $times = 1;
	private $api = 'http://api.feieyun.cn/Api/Open/';
	private $sig = '';
	private $stime = TIMESTAMP;
	private $params = array();
	public function __construct($user, $key, $sn)
	{
		$this->user = $user;
		$this->key = $key;
		$this->sn = $sn;
		$this->params = array('user' => $user, 'stime' => TIMESTAMP, 'sig' => sha1($user . $key . TIMESTAMP));
	}
	public function printOrderAction($content, $times = 1)
	{
		$this->params['sn'] = $this->sn;
		$this->params['apiname'] = 'Open_printMsg';
		$this->params['content'] = implode($content);
		$this->params['times'] = $times;
		$result = ihttp_post($this->api, $this->params);
		if (is_error($result)) {
			return error(-1, "错误: {$result['message']}");
		}
		$result = @json_decode($result['content'], true);
		return $result;
	}
	public function queryOrderStateAction($orderindex)
	{
		$this->params['apiname'] = 'Open_queryOrderState';
		$this->params['orderid'] = $orderindex;
		$result = ihttp_post($this->api, $this->params);
		if (is_error($result)) {
			return error(-1, "错误: {$result['message']}");
		}
		$result = @json_decode($result['content'], true);
		return $result;
	}
	public function queryPrinterStatusAction()
	{
		$this->params['apiname'] = 'Open_queryPrinterStatus';
		$this->params['sn'] = $this->sn;
		$result = ihttp_post($this->api, $this->params);
		if (is_error($result)) {
			return error(-1, "错误: {$result['message']}");
		}
		$result = @json_decode($result['content'], true);
		return $result;
	}
}