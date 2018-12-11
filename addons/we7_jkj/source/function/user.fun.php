<?php
defined('IN_IA') or exit('Access Denied');

function get_user_list($role, $keyword, $page = 1, $size = 15, $is_ajax = false){
    global $_W;

    $where = '';
    $par[':uniacid'] = $_W['uniacid'];

    if($role == '1'){
        $where .= " AND is_designer=1";
    }elseif($role == '2'){
        $where .= " AND is_shoper=1";
    }

    if(!empty($keyword)){
        $where .= " AND (username LIKE :keyword OR mobile LIKE :keyword OR nickname LIKE :keyword)";
        $par[':keyword'] = "'%{$keyword}%'";
    }

    $sql = "SELECT user_id,username,headimg,mobile,status,is_shoper,is_designer,addtime FROM ".tablename('jkj_user')." WHERE uniacid=:uniacid ".$where." ORDER BY user_id DESC LIMIT ".$size*($page-1).",".$size;
    $result['list'] = pdo_fetchall($sql, $par);

    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jkj_user')." WHERE uniacid=:uniacid ".$where, $par);

    $res['pager'] = pagination($total, $page, $size);
    if($is_ajax){
        $result['now_page'] = $page;
        $result['max_page'] = ceil($total/$size);
    }else{
        $result['pager'] = pagination($total, $page, $size);
    }

    return $result;
}

function user_info($user_id){
    global $_W;

    $sql = "SELECT user_id,username,headimg,nickname,realname,sex,birth_year,birth_month,birth_day,".
            "province,city,district,mobile,home_phone,email,address,is_designer,is_shoper,status ".
            "FROM ".tablename('jkj_user')." WHERE uniacid=:uniacid AND user_id=:user_id";
    $user = pdo_fetch($sql, array(
        ':uniacid' => $_W['uniacid'],
        ':user_id' => $user_id,
    ));

    if(!$user){
        return false;
    }

    return $user;
}

?>