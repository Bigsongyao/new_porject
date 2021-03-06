<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function load() {
	static $loader;
	if(empty($loader)) {
		$loader = new Loader();
	}
	return $loader;
}


function table($name) {
	load()->classs('table');
	load()->table($name);
	$service = false;
	
	$class_name = "{$name}Table";
	if (class_exists($class_name)) {
		$service = new $class_name();
	}
	return $service;
}


class Loader {
	
	private $cache = array();
	private $singletonObject = array();
	private $libraryMap = array(
		'agent' => 'agent/agent.class',
		'captcha' => 'captcha/captcha.class',
		'pdo' => 'pdo/PDO.class',
		'qrcode' => 'qrcode/phpqrcode',
		'ftp' => 'ftp/ftp',
		'pinyin' => 'pinyin/pinyin',
		'pkcs7' => 'pkcs7/pkcs7Encoder',
		'json' => 'json/JSON',
		'phpmailer' => 'PHPMailerAutoload',
	);
	private $loadTypeMap = array(
		'func' => '/framework/function/%s.func.php',
		'model' => '/framework/model/%s.mod.php',
		'classs' => '/framework/class/%s.class.php',
		'library' => '/framework/library/%s.php',
		'table' => '/framework/table/%s.table.php',
		'web' => '/web/common/%s.func.php',
		'app' => '/app/common/%s.func.php',
	);
	
	public function __call($type, $params) {
		global $_W;
		$name = array_shift($params);
		if (!empty($this->cache[$type]) && isset($this->cache[$type][$name])) {
			return true;
		}
		if (empty($this->loadTypeMap[$type])) {
			return true;
		}
				if ($type == 'library' && !empty($this->libraryMap[$name])) {
			$name = $this->libraryMap[$name];
		}
		$file = sprintf($this->loadTypeMap[$type], $name);
		if (file_exists(IA_ROOT . $file)) {
			include IA_ROOT . $file;
			$this->cache[$type][$name] = true;
			return true;
		} else {
			trigger_error('Invalid ' . ucfirst($type) . $file, E_USER_ERROR);
			return false;
		}
	}
	
	
	function singleton($name) {
		if (isset($this->singletonObject[$name])) {
			return $this->singletonObject[$name];
		}
		$this->singletonObject[$name] = $this->object($name);
		return $this->singletonObject[$name];
	}
	
	
	function object($name) {
		$this->classs(strtolower($name));
		if (class_exists($name)) {
			return new $name();
		} else {
			return false;
		}
	}
}
