<?php

defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;
$ops = array('personal_info', 'personal_update', 'credits_record', 'address_lists', 'current_address', 'address_post', 'address_default', 'address_delete', 'extend_switch', 'credit_password', 'check_password_lock', 'set_credit_password', 'credit_pay', 'footer', 'code_mode', 'send_code', 'set_password');
$op = in_array(trim($_GPC['op']), $ops) ? trim($_GPC['op']) : 'error';

check_params();
load()->model('mc');
mload()->model('card');
load()->model('cache');
$uid = mc_openid2uid($_W['openid']);

if (in_array($op, array('address_post', 'address_default', 'address_delete')) && !empty($_GPC['id'])) {
	$address_info = pdo_get('mc_member_address', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'id' => intval($_GPC['id'])));
	if (empty($address_info)) {
		wmessage(error(-1, '设置失败'), '', 'ajax');
	}
}

if ($op == 'extend_switch') {
	$extend_switch = extend_switch_fetch();
	$notices = card_notices();
	$notice_unread_num = 0;
	if (!empty($notices)) {
		foreach ($notices as $val) {
			if (empty($val['read_status'])) {
				$notice_unread_num++;
			}
		}
	}
	if (check_ims_version()) {
		$plugin_list = get_plugin_list();
		$extend_switch['plugin_list'] = $plugin_list;
	}
	$extend_switch['notice_unread_num'] = $notice_unread_num;
	$store_set = get_storex_set();
	$extend_switch['location'] = !empty($store_set['location']) ? $store_set['location'] : 2;
	$extend_switch['credit_pw'] = !empty($store_set['credit_pw']) ? $store_set['credit_pw'] : 2;
	wmessage(error(0, $extend_switch), '', 'ajax');
}

if ($op == 'personal_info') {
	$user_info = mc_fetch($_W['openid']);
	$storex_clerk = pdo_get('storex_clerk', array('weid' => intval($_W['uniacid']), 'from_user' => trim($_W['openid']), 'status !=' => -1, 'storeid !=' => 0), array('id', 'from_user'));
	if (!empty($storex_clerk)) {
		$user_info['clerk'] = 1;
	} else {
		$user_info['clerk'] = 0;
	}
	$card_info = card_setting_info();
	$user_info['mycard'] = pdo_get('storex_mc_card_members', array('uniacid' => intval($_W['uniacid']), 'uid' => $uid));
	if (!empty($user_info['mycard'])) {
		$user_info['mycard']['is_receive'] = 1;//是否领取,1已经领取，2没有领取
		$user_info['mycard']['fields'] = iunserializer($user_info['mycard']['fields']);
		$user_info['mycard']['group'] = array();
		$user_info['mycard']['group'] = card_group_id($uid);
	} else {
		$user_info['mycard']['is_receive'] = 2;
	}
	if (!empty($card_info)) {
		$show_fields = array('title', 'color', 'background', 'logo', 'description');
		foreach ($show_fields as $val) {
			if (!empty($card_info[$val])) {
				$user_info['mycard'][$val] = $card_info[$val];
			}
			if ($val == 'background') {
				if ($card_info[$val]['background'] == 'user') {
					$user_info['mycard'][$val]['image'] = $user_info['mycard'][$val]['image'];
				} else {
					$png = $user_info['mycard'][$val]['image'];
					$png = !empty($png) ? $png : '1';
					$user_info['mycard'][$val]['image'] = tomedia("addons/wn_storex/template/style/img/card/" . $png . ".png");
				}
			}
		}
		if (!empty($card_info['params']['cardBasic']['params'])) {
			$user_info['mycard']['card_level'] = $card_info['params']['cardBasic']['params']['card_level'];
			$user_info['mycard']['card_label'] = $card_info['params']['cardBasic']['params']['card_label'];
		}
		$user_info['mycard']['cardNums'] = array(
			'status' => 0,
		);
		if (!empty($card_info['params']['cardNums']) && $card_info['params']['cardNums']['params']['nums_status'] == 1) {
			$cardNums = $card_info['params']['cardNums']['params'];
			if (!empty($cardNums['nums'])) {
				$user_info['mycard']['cardNums']['status'] = $cardNums['nums_status'];
			}
			$user_info['mycard']['cardNums']['text'] = $cardNums['nums_text'];
			$user_info['mycard']['cardNums']['nums'] = $user_info['mycard']['nums'];
		}
		$user_info['mycard']['cardTimes'] = array(
			'status' => 0,
		);
		if (!empty($card_info['params']['cardTimes']) && $card_info['params']['cardTimes']['params']['times_status'] == 1) {
			$times_status = $card_info['params']['cardTimes']['params'];
			if (!empty($times_status['times'])) {
				$user_info['mycard']['cardTimes']['status'] = $times_status['times_status'];
			}
			$user_info['mycard']['cardTimes']['text'] = $times_status['times_text'];
			$user_info['mycard']['cardTimes']['endtime'] = $user_info['mycard']['endtime'];
		}
	}
	$member = pdo_get('storex_member', array('weid' => $_W['uniacid'], 'from_user' => $_W['openid']));
	$user_info['password'] = 0;
	if (!empty($member['credit_password']) && !empty($member['password_lock'])) {
		$user_info['password'] = 1;
	}
	wmessage(error(0, $user_info), '', 'ajax');
}
if ($op == 'personal_update') {
	if (!empty($_GPC['fields'])) {
		foreach ($_GPC['fields'] as $key=>$value) {
			if (empty($key) && $key != 'gender' && empty($value)) {
				wmessage(error(-1, '信息不完整'), '', 'ajax');
			}
		}
	}
	$result = mc_update($_W['openid'], $_GPC['fields']);
	if (!empty($result)) {
		wmessage(error(0, '修改成功'), '', 'ajax');
	} else {
		wmessage(error(-1, '修改失败'), '', 'ajax');
	}
}
if ($op == 'credits_record') {
	$credits = array();
	$credits_record = pdo_getall('mc_credits_record', array('uniacid' => $_W['uniacid'], 'credittype' => $_GPC['credittype'], 'uid' => $uid, 'module' => 'wn_storex'), array('num', 'createtime', 'module', 'id'), '', 'id DESC');
	if (!empty($credits_record)) {
		foreach ($credits_record as $data) {
			$data['createtime'] = date('Y-m-d H:i:s', $data['createtime']);
			$offset = $_GPC['credittype'] == 'credit2' ? '元' : '积分';
			if ($data['num'] > 0) {
				$data['remark'] = '充值' . $data['num'] . $offset;
				$credits['recharge'][] = $data;
			} else {
				$data['remark'] = '消费' . - $data['num'] . $offset;
				$credits['consume'][] = $data;
			}
		}
	}
	wmessage(error(0, $credits), '', 'ajax');
}
if ($op == 'address_lists') {
	$address_info = pdo_getall('mc_member_address', array('uid' => $uid, 'uniacid' => $_W['uniacid']), '', '', 'isdefault DESC');
	wmessage(error(0, $address_info), '', 'ajax');
}
if ($op == 'current_address') {
	$current_info = pdo_get('mc_member_address', array('id' => intval($_GPC['id']), 'uid' => $uid, 'uniacid' => $_W['uniacid']));
	wmessage(error(0, $current_info), '', 'ajax');
}
if ($op == 'address_post') {
	$address_info = $_GPC['fields'];
	if (empty($address_info['username']) || empty($address_info['zipcode']) || empty($address_info['province']) || empty($address_info['city'])  || empty($address_info['district']) || empty($address_info['address'])) {
		wmessage(error(-1, '请填写正确的信息'), '', 'ajax');
	}
	if (empty($address_info['mobile'])) {
		wmessage(error(-1, '手机号码不能为空'), '', 'ajax');
	}
	if (!preg_match(REGULAR_MOBILE, $address_info['mobile'])) {
		wmessage(error(-1, '手机号码格式不正确'), '', 'ajax');
	}
	unset($address_info['id']);
	if (!empty($_GPC['id'])) {
		$result = pdo_update('mc_member_address', $address_info, array('id' => intval($_GPC['id'])));
		wmessage(error(0, $result), '', 'ajax');
	} else {
		$address_info['uid'] = $uid;
		$address_info['uniacid'] = $_W['uniacid'];
		$address = pdo_get('mc_member_address', array('uniacid' => $_W['uniacid'], 'uid' => $uid));
		if (empty($address)) {
			$address_info['isdefault'] = 1;
		}
		$result = pdo_insert('mc_member_address', $address_info);
		wmessage(error(0, $result), '', 'ajax');
	}
}
if ($op == 'address_default') {
	$default_result = pdo_update('mc_member_address', array('isdefault' => '0'), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
	$result = pdo_update('mc_member_address', array('isdefault' => '1'), array('id' => intval($_GPC['id'])));
	wmessage(error(0, '设置成功'), '', 'ajax');

}
if ($op == 'address_delete') {
	$result = pdo_delete('mc_member_address', array('id' => intval($_GPC['id'])));
	wmessage(error(0, '删除成功'), '', 'ajax');
}

if ($op == 'credit_password') {
	if (empty($_GPC['password'])) {
		wmessage(error(-1, '余额支付密码不能为空'), '', 'ajax');
	}
	$member = pdo_get('storex_member', array('weid' => $_W['uniacid'], 'from_user' => $_W['openid']), array('id', 'credit_password', 'credit_salt'));
	if (empty($member['credit_password'])) {
		wmessage(error(1, '余额未设置支付密码'), '', 'ajax');
	}
	$password = hotel_member_hash(trim($_GPC['password']), $member['credit_salt']);
	if ($password != $member['credit_password']) {
		wmessage(error(-1, '余额支付密码错误'), '', 'ajax');
	} else {
		wmessage(error(0, '密码正确'), '', 'ajax');
	}
}

if ($op == 'check_password_lock') {
	$member = pdo_get('storex_member', array('weid' => $_W['uniacid'], 'from_user' => $_W['openid']), array('id', 'password_lock'));
	if ($member['password_lock'] != trim($_GPC['password_lock'])) {
		wmessage(error(-1, '更改密码依据输入错误'), '', 'ajax');
	} else {
		$str = "wn_storex_password_lock:{$_W['openid']}:{$member['password_lock']}";
		wmessage(error(0, md5($str)), '', 'ajax');
	}
}

if ($op == 'set_credit_password') {
	$member = pdo_get('storex_member', array('weid' => $_W['uniacid'], 'from_user' => $_W['openid']));
	if (!empty($member['password_lock'])) {
		$string = $_GPC['string'];
		$str = md5("wn_storex_password_lock:{$_W['openid']}:{$member['password_lock']}");
		if (empty($string) || $string != $str) {
			wmessage(error(-1, '验证不同过,请重新验证'), '', 'ajax');
		}
	}
	$password = trim($_GPC['password']);
	$password_lock = trim($_GPC['password_lock']);
	if (istrlen($password) < 6) {
		wmessage(error(-1, '密码长度至少6位'), '', 'ajax');
	}
	if (istrlen($password) > 16) {
		wmessage(error(-1, '密码长度最多16位'), '', 'ajax');
	}
	$update = array();
	$check_password_lock = false;
	if (empty($member['password_lock'])) {
		if (!empty($password_lock)) {
			$check_password_lock = true;
		} else {
			wmessage(error(-1, '改密依据不能为空'), '', 'ajax');
		}
	} else {
		if (!empty($password_lock)) {
			$check_password_lock = true;
		}
	}
	if (!empty($check_password_lock)) {
		if (istrlen($password_lock) > 10) {
			wmessage(error(-1, '改密依据不要太长'), '', 'ajax');
		}
		if (istrlen($password_lock) < 4) {
			wmessage(error(-1, '改密依据太短'), '', 'ajax');
		}
		$update['password_lock'] = $password_lock;
	}
	$salt = random(8);
	$password = hotel_member_hash($password, $salt);
	$update['credit_password'] = $password;
	$update['credit_salt'] = $salt;
	$result = pdo_update('storex_member', $update, array('weid' => $_W['uniacid'], 'from_user' => $_W['openid']));
	if (!empty($result)) {
		wmessage(error(0, '设置密码成功'), '', 'ajax');
	} else {
		wmessage(error(-1, '设置密码失败'), '', 'ajax');
	}
}

if ($op == 'credit_pay') {
	if (empty($_W['openid'])) {
		message('请先关注公众号！', '', 'error');
	}
	$type = $_GPC['type'];
	$money = $_GPC['money'];
	$pay_types = array('credit1' => '积分', 'credit2' => '余额');
	$clerk = pdo_get('storex_clerk', array('id' => intval($_GPC['clerkid'])), array('id', 'storeid'));
	if (empty($clerk)) {
		message('二维码错误', '', 'error');
	}
	$types = array_keys($pay_types);
	if (!in_array($type, $types)) {
		message('收款类型错误', '', 'error');
	}
	if ($money <= 0) {
		message('收款金额错误', '', 'error');
	}
	$money = sprintf('%.2f', $money);
	$uid = mc_openid2uid($_W['openid']);
	$credit = mc_credit_fetch($uid);
	if (empty($credit[$type]) || $credit[$type] < $money) {
		message($pay_types[$type] . '不足', '', 'error');
	}
	$log = '通过扫店员码扣除' . $pay_types[$type] . ':' . $money;
	mc_credit_update($uid, $type, -$money, $log);
	$data = array(
		'uniacid' => $_W['uniacid'],
		'clerkid' => $_GPC['clerkid'],
		'type' => $type,
		'money' => sprintf('%.2f', $money),
		'openid' => $_W['openid'],
		'time' => TIMESTAMP,
	);
	pdo_insert('storex_clerk_pay', $data);
	$url = murl('entry', array('id' => $clerk['storeid'], 'do' => 'display', 'm' => 'wn_storex'), true, true);
	$url .= '#/StoreIndex/' . $clerk['storeid'];
	message('支付成功！', $url, 'success');
}

if ($op == 'footer') {
	$storeid = intval($_GPC['storeid']);
	if (!check_wxapp()) {
		$is_wxapp = 2;
	} else {
		$is_wxapp = 1;
	}
	$footer = pdo_get('storex_homepage', array('storeid' => $storeid, 'type' => 'footer', 'is_wxapp' => $is_wxapp));
	if (!empty($footer['items'])) {
		$footer['items'] = !empty($footer['items']) ? iunserializer($footer['items']) : '';
		if (!empty($footer['items']['footer'])) {
			$footer['items'] = $footer['items']['footer'];
		}
	}
	wmessage(error(0, $footer), '', 'ajax');
}

if ($op == 'code_mode') {
	$set = get_storex_set();
	if (!empty($set['credit_pw']) && $set['credit_pw'] == 1) {
		$memberinfo = array();
		$memberinfo = get_member_mode();
		$credit_set['credit_pw'] = $set['credit_pw'];
		$credit_set['credit_pw_mode'] = $set['credit_pw_mode'];
	} else {
		$credit_set['credit_pw'] = 2;
	}
	wmessage(error(0, array('credit_set' => $credit_set, 'modes' => array('phone' => '手机号', 'email' => '邮箱'), 'member' => $memberinfo)), '', 'ajax');
}

if ($op == 'send_code') {
	$type = trim($_GPC['type']);
	$set = get_storex_set();
	$memberinfo = get_member_mode();
	if (empty($set['credit_pw_mode']) || empty($set['credit_pw_mode'][$type])) {
		wmessage(error(-1, '与之前验证方式不符'), '', 'ajax');
	}
	if (!empty($memberinfo) && !isset($memberinfo[$type])) {
		wmessage(error(-1, '验证方式错误'), '', 'ajax');
	}
	$send_codes = pdo_getall('storex_code', array('openid' => $_W['openid'], 'weid' => $_W['uniacid'], 'send_status' => 1), array(), '', 'createtime DESC', array(1,1));
	if (!empty($send_codes) && (TIMESTAMP - $send_codes['0']['createtime']) < 60 ) {
		wmessage(error(-1, '请勿重复发送'), '', 'ajax');
	}
	if (in_array($type, array('phone', 'email'))) {
		$number = trim($_GPC['number']);
		if ($type == 'phone') {
			if (!empty($member['phone']) && $member['phone'] != $number) {
				wmessage(error(-1, '手机号错误'), '', 'ajax');
			}
			if (!preg_match(REGULAR_MOBILE, $number)) {
				wmessage(error(-1, '手机号码格式不正确'), '', 'ajax');
			}
			$code_info = get_code_info();
			$code_info['mobile'] = trim($_GPC['number']);
			$body = "您的短信验证码为: {$code_info['code']} 您正在使用{$this->module['title']}相关功能, 需要你进行身份确认. ".random(3);
			load()->model('cloud');
			$result = cloud_sms_send($number, $body);
			$code_info['mobile'] = $number;
		}
		if ($type == 'email') {
			if (!empty($member['email']) && $member['email'] != $number) {
				wmessage(error(-1, '邮箱错误'), '', 'ajax');
			}
			if (!preg_match(REGULAR_EMAIL, $number)) {
				wmessage(error(-1, '邮箱格式不正确'), '', 'ajax');
			}
			$code_info = get_code_info();
			load()->func('communication');
			$content = "您的邮箱验证码为: {$code_info['code']} 您正在使用{$this->module['title']}相关功能, 需要你进行身份确认.";
			$result = ihttp_email($number, "{$this->module['title']}身份确认验证码", $content);
			$code_info['email'] = $number;
		}
		if (!empty($result) && !is_error($result)) {
			$code_info['send_status'] = 1;
			pdo_insert('storex_code', $code_info);
			wmessage(error(0, '发送成功'), '', 'ajax');
		} else {
			$code_info['send_status'] = 2;
			pdo_insert('storex_code', $code_info);
			wmessage(error(-1, '发送失败'), '', 'ajax');
		}
	} else {
		wmessage(error(-1, '验证类型错误'), '', 'ajax');
	}
}

if ($op == 'set_password') {
	$code = $_GPC['code'];
	$type = trim($_GPC['type']);
	$memberinfo = get_member_mode();
	if (!empty($memberinfo) && !isset($memberinfo[$type])) {
		wmessage(error(-1, '验证方式错误'), '', 'ajax');
	}
	$number = trim($_GPC['number']);
	$password = trim($_GPC['password']);
	$repeat_password = trim($_GPC['r_password']);
	$member = pdo_get('storex_member', array('weid' => intval($_W['uniacid']), 'from_user' => trim($_W['openid'])), array('weid', 'from_user', 'phone', 'email'));
	if (empty($member)) {
		wmessage(error(41009, '未登录！'), '', 'ajax');
	}
	if (in_array($type, array('phone', 'email'))) {
		if (!empty($member[$type]) && $member[$type] != $number) {
			wmessage(error(-1, '验证号错误'), '', 'ajax');
		}
		$condition = array(
			'openid' => trim($_W['openid']),
			'weid' => intval($_W['uniacid']),
			'send_status' => 1,
		);
		if ($type == 'phone') {
			$condition['mobile'] = $number;
		} else {
			$condition['email'] = $number;
		}
		$codes = pdo_getall('storex_code', $condition, array('id', 'openid', 'code', 'mobile', 'email', 'status', 'createtime'), '', 'createtime DESC');
		if (!empty($codes) && is_array($codes)) {
			$codeinfo = $codes[0];
			if ($codeinfo['status'] == 2) {
				wmessage(error(-1, '验证码已使用'), '', 'ajax');
			}
			if ((TIMESTAMP - $codeinfo['createtime']) > 600) {
				wmessage(error(-1, '验证码已过期'), '', 'ajax');
			}
			if ($codeinfo['code'] != $code) {
				wmessage(error(-1, '验证码错误'), '', 'ajax');
			}
			if ($password != $repeat_password) {
				wmessage(error(-1, '两次输入的密码不同'), '', 'ajax');
			}
			if (istrlen($password) < 6 || istrlen($password) > 16) {
				wmessage(error(-1, '密码长度6至16位'), '', 'ajax');
			}
			pdo_update('storex_code', array('status' => 2), array('id' => $codeinfo['id']));
			$salt = random(8);
			$update['credit_password'] = hotel_member_hash($password, $salt);
			$update['credit_salt'] = $salt;
			if ($type == 'phone') {
				$update[$type] = $codeinfo['mobile'];
			} else {
				$update[$type] = $codeinfo['email'];
			}
			$result = pdo_update('storex_member', $update, array('weid' => intval($_W['uniacid']), 'from_user' => trim($_W['openid'])));
			if (!empty($result)) {
				wmessage(error(0, '设置密码成功'), '', 'ajax');
			} else {
				wmessage(error(-1, '设置密码失败'), '', 'ajax');
			}
		} else {
			wmessage(error(-1, '验证码错误'), '', 'ajax');
		}
	} else {
		wmessage(error(-1, '验证类型错误'), '', 'ajax');
	}
}
