<?php
defined('IN_IA') or exit('Access Denied');

/**
 * 格式化金额
 * @param $price
 * @return string
 */
function format_price($price){
    if($price == ''){
        $price = 0;
    }

    $price = number_format($price, 2, '.', '');

    return sprintf("￥%s", $price);
}


function get_cookie($key)
{
    global $_W;
    $key = $_W['config']['cookie']['pre'] . $key;
    return json_decode(base64_decode($_COOKIE[$key]), true);
}

function insert_cookie($key, $data, $expire = 0)
{
    global $_W;
    $session = base64_encode(json_encode($data));
    $expire = $expire != 0 ? (TIMESTAMP + $expire) : 0;
    setcookie($_W['config']['cookie']['pre'].$key, $session, $expire);
}

function get_region($region_id, $region_type){
    $list = pdo_fetchall("SELECT region_id, region_name FROM ".tablename('jkj_region')." WHERE parent_id = :parent_id AND region_type = :type", array(
        ':type' => $region_type,
        ':parent_id' => $region_id
    ));

    return $list ? $list : array();
}

function get_region_name($region_id){
    $region_name = pdo_fetchcolumn("SELECT region_name FROM ".tablename('jkj_region')." WHERE region_id = :region_id", array(':region_id' => $region_id,));

    return $region_name ? $region_name : '';
}

/**获取商店全地址
 * @param $shop_id
 * @param string $key 省市区间隔符号
 * @return string
 */
function get_shop_address($shop_id, $key=''){
    global $_W;

    $sql = "SELECT CONCAT(b.region_name,'{$key}',c.region_name,'{$key}',d.region_name,'{$key}',a.address) FROM ".tablename('jkj_shops')." as a ".
        "LEFT JOIN ".tablename('jkj_region'). " as b ON a.province=b.region_id " .
        "LEFT JOIN ".tablename('jkj_region'). " as c ON a.city=c.region_id " .
        "LEFT JOIN ".tablename('jkj_region'). " as d ON a.district=d.region_id " .
        "WHERE a.uniacid=:uniacid AND shop_id=:shop_id";
    $address = pdo_fetchcolumn($sql, array(':shop_id' => $shop_id, ':uniacid' => $_W['uniacid']));

    return $address;
}

/**
 * 错误提示
 * @param   array   $errno     错误代码
 * @param   array   $message   提示信息
 */
function in_error($errno, $message = '') {
    return empty($message) ?  array('status' => false) : array('status' => $errno, 'message' => $message );
}

/**
 * 成功提示
 * @param   array   $errno     成功代码
 * @param   array   $message   提示信息
 * @param   array   $content   反馈内容
 */
function in_success($ok, $content=array(), $message = '') {
    return empty($message)&&empty($content) ?  array('status' => true) : array( 'status' => $ok, 'message' => $message, 'content' => $content);
}


/**
 * 权限判定
 * @param   array   $role_str     判定权限 user,designer,shoper
 * @return bool
 */
function check_role($role_str = ''){
    $roles = empty($role_str) ? ['user'] : explode(',', $role_str);

    foreach($roles as $role){
        if($role == 'user' && empty($_SESSION['user_id'])){
            return false;
        }elseif($role == 'designer' && empty($_SESSION['is_designer'])){
            return false;
        }elseif($role == 'shoper' && empty($_SESSION['is_shoper'])){
            return false;
        }else{
            return false;
        }
    }

    return true;
}

/**
 * 数组是否包含另一个数组
 * @param $search_arr 被包含数组
 * @param $arr 包含数组
 * @return bool
 */
function arr_in_arr($search_arr, $arr){
	foreach($search_arr as $search){
		if(!in_array($search, $arr)){
			return false;
		}
	}
	
	return true;
}

/**
 * 清除缓存
 * @return bool
 */
function clear_cache(){
    global $_W;

    load()->func('file');
    return rmdirs(ATTACHMENT_ROOT . '/we7_jkj/cache/'.$_W['uniacid'].'/');
}



?>