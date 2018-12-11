<?php
/**
 * 用户角色操作类
*
*/
defined('IN_IA') or exit('Access Denied');
class User{
	private $err;
	public $user;

	public function __construct() {

	}

	public function register($username, $mobile, $password, $salt = '', $wx = array()){
		global $_W;

		if($this->getUserInfo(array('username' => $username))){
			$this->err = '用户名已存在';
			return false;
		}

		if($this->getUserInfo(array('mobile' => $mobile))){
			$this->err = '手机号码已存在';
			return false;
		}

		$salt = empty($salt) ? random(4) : $salt;

		$user = array(
			'username' => $username,
			'password' => md5(md5($password).$salt),
			'mobile' => $mobile,
			'salt' => $salt,
			'status' => 1,
			'uniacid' => $_W['uniacid'],
			'addtime' => TIMESTAMP,
		);

		pdo_insert('jkj_user', $user);
		$user_id = pdo_insertid();

		return $user_id;
	}

	public function getUserByMobile($mobile){
		global $_W;

		$userInfo = pdo_fetch("SELECT * FROM ".tablename('jkj_user')." WHERE mobile LIKE :mobile AND uniacid=:uniacid", array(
			':mobile' => "'$mobile'",
			':uniacid' => $_W['uniacid']
		));

		if($userInfo){
			return $userInfo;
		}else{
			return false;
		}
	}

	public function login($username, $password = '', $is_remember = false){
		if(!$this->checkUser($username, $password)){
			$this->err = '用户名或密码不正确';
			return false;
		}

		if($is_remember){
			$this->setCookie($username, 30*24*3600);
		}else{
			$this->setCookie($username, 24*3600);
		}

		return $this->user;
	}

	public function loginByMobile($mobile, $is_remember = false){
		$user = $this->getUserInfo(array('mobile' => $mobile), 'username');
		$username = $user['username'];

		if(empty($user)){
			$this->err = '没有此用户';
			return false;
		}

		if($is_remember){
			$this->setCookie($username, 30*24*3600);
		}else{
			$this->setCookie($username, 24*3600);
		}

		return true;
	}

	public function checkUser($username, $password = NULL){
		global $_W;

		$user = $this->getUserInfo(array('username' => $username), 'user_id,username,password,salt');

		if(empty($user)){
			return false;
		}

		if($password !== NULL){
			$md5_pwd = md5(md5($password).$user['salt']);
			return $md5_pwd==$user['password'];
		}

		return true;
	}

	public function checkEmail($email){
		global $_W;

		$user = $this->getUserInfo(array('email' => $email), 'user_id');

		if(empty($user)){
			return true;
		}else{
			return false;
		}
	}

	public function logout(){
		return $this->setCookie();
	}

	public function getUserInfo($where = array(), $fields = '*'){
		global $_W;

		if(count($where) == 0){
			return false;
		}

		$sql = "SELECT {$fields} FROM ".tablename('jkj_user')." WHERE uniacid=:uniacid ";
		$par[':uniacid'] = $_W['uniacid'];

		foreach($where as $key => $val){
			$sql .= " AND {$key}=:{$key}";
			$par[':'.$key] = $val;
		}

		$userInfo = pdo_fetch($sql, $par);

		if($userInfo){
			return $userInfo;
		}else{
			return false;
		}
	}

	public function updateUserInfo($data = array()){
		if(!empty($data['username'])){
			$where = array('username' => $data['username']);
		}elseif(!empty($data['mobile'])){
			$where = array('mobile' => $data['mobile']);
		}elseif(!empty($data['user_id'])){
			$where = array('user_id' => $data['user_id']);
		}else{
			return false;
		}

		$user = $this->getUserInfo($where, 'openid,headimg,nickname,realname,sex,birth_year,birth_month,birth_day,province,city,district,home_phone,address,status');
		if(!$user){
			$this->err = '用户不存在';
			return false;
		}

		$update = array();

		if(!empty($data['password'])){
			$salt = random(4);
			$update['password'] = md5(md5($data['password']).$salt);
			$update['salt'] = $salt;
		}

		if(!empty($data['email'])){
			if($this->checkEmail($data['email'])){
				$this->err = '邮箱已存在';
				return false;
			}else{
				$update['email'] = $data['email'];
			}
		}

		foreach($user as $user_field => $val){
			if(isset($data[$user_field])){
				$update[$user_field] = $data[$user_field];
			}
		}

		if(!pdo_update('jkj_user', $update, $where)){
			$this->err = '更新失败';
			return false;
		}else{
			return true;
		}
		return pdo_update('jkj_user', $update, $where);
	}

	public function setCookie($username = '', $expire = 0){
		$user = $this->getUserInfo(array('username' => $username), 'user_id,username,realname,headimg,is_designer,is_shoper');
		if($user){
			$this->user = array(
				'user_id' => $user['user_id'],
				'username' => $user['username'],
				'headimg' => tomedia($user['headimg']),
				'is_designer' => $user['is_designer'],
				'is_shoper' => $user['is_shoper'],
			);
			insert_cookie('user', $this->user);

			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['headimg'] = tomedia($user['headimg']);
			$_SESSION['is_designer'] = $user['is_designer'];
			$_SESSION['is_shoper'] = $user['is_shoper'];
		}else{
			insert_cookie('user', '', -3600);
			unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['headimg'], $_SESSION['is_designer'], $_SESSION['is_shoper']);
		}

		return true;
	}


	public function clearErr(){
		$this->err = '';
	}

	public function getErr(){
		return $this->err;
	}

}