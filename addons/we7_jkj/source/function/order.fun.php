<?php
defined('IN_IA') or exit('Access Denied');

/** 订单记录
 * @param $order_id
 * @param $order_status 订单状态
 * @param string $record 记录内容
 * @param bool $send_remind 是否发送订单提醒
 * @return bool
 */
function order_record($order_id, $order_status, $send_remind = false){
    global $_W;

    include INC_ROOT.'order_remind.php';
    $order_info = pdo_fetch('SELECT * FROM '.tablename('jkj_order').' WHERE order_id=:order_id AND uniacid=:uniacid', array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));

    $record['content'] = '';
    $add_time = TIMESTAMP;
    switch($order_status){
        case ADD:
            break;
        case DELIVER:
            include_once INC_FUN.'product.php';

            break;
        case ASSIGN:
            include_once INC_FUN.'user.php';
            $user_info = user_info($order_info['designer_id']);
            $record['content'] = sprintf('分配订单给 设计师%s', $user_info['realname'] ? $user_info['realname'] : $user_info['username']);
            break;
        case MEASUE:
            $add_time = $order_info['measue_time'];
            break;
        case DISCUSS:
            break;
        case SIGN:
            $record['contract_sn'] = $order_info['contract_sn'];
            $record['contract_price'] = format_price($order_info['contract_price']);
            $record['pay_type'] = $order_info['pay_type'];
            $record['order_time'] = date('Y-m-d', $order_info['order_time']);
            $record['contract_images'] = unserialize($order_info['contract_images']);
            $record['invoice_images'] = unserialize($order_info['invoice_images']);
            break;
        case PRODUCTION:
            $record['production_sn'] = $order_info['production_sn'];
            $record['production_day'] = $order_info['production_day'];
            break;
        case SHIPPING:
            $record['build_time'] = date('Y-m-d', $order_info['build_time']);
            $record['acceptance_images'] = unserialize($order_info['acceptance_images']);
            $record['real_images'] = unserialize($order_info['real_images']);
            break;
        case COMMENT:
            $sql = "SELECT * FROM ".tablename('jkj_comments')." WHERE comment_type=1 AND uniacid=:uniacid AND order_id=:order_id";
            $commont = pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'], ':order_id' => $order_info['order_id']));

            $record['star'] = $commont['star'];
            $record['content'] = $commont['content'];
            $record['tag'] = unserialize($commont['tag']);

            break;
        case CANCEL:
            include_once INC_FUN.'user.php';
            $user_info = user_info($order_info['designer_id']);
            $record['content'] = sprintf('设计师%s取消了订单', $user_info['realname'] ? $user_info['realname'] : $user_info['username']);
            break;
        case REFUND:
            break;
        case RESTART:
            break;
        default:
            return false;
    }

    $data = array(
        'order_id' => $order_id,
        'order_status' => $order_status,
        'order_record' => serialize($record),
        'add_time' => $add_time,
        'action_user_id' => $_SESSION['user_id'],
        'uniacid' => $_W['uniacid']
    );
    pdo_insert('jkj_order_record', $data);

    if($send_remind){
        order_remind($order_id, $order_status, 1);
    }

    return true;
}

/**发送订单提醒
 * @param $order_id
 * @param $order_type 订单类型 0:reserOrder,1:order
 * @param $order_status 订单状态 order:0：待分配，1：客服已派单，2：负责人已派单，3:已量尺。4：已沟通：5已签约，6：已下单，7：已配送，8：已评价/已完成，9：取消
 *                              reserOrder:0：未联系，1：已联系，2：已体验，3：已取消
 */
function order_remind($order_id, $order_status, $order_type = 0){
    global $_W;

    include INC_ROOT.'order_remind.php';

    if($order_type == 0){
        $order_info = pdo_fetch('SELECT * FROM '.tablename('jkj_reser_order').' WHERE oid=:oid AND uniacid=:uniacid', array(':oid' => $order_id, ':uniacid' => $_W['uniacid']));
    }else{
        $order_info = pdo_fetch('SELECT * FROM '.tablename('jkj_order').' WHERE order_id=:order_id AND uniacid=:uniacid', array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));
    }

    if(!$order_info){
        return false;
    }

    if(isset($remind[$order_type]['user'][$order_status])){
        pdo_insert('jkj_order_remind', array(
            'user_id' => $order_info['user_id'],
            'content' => sprintf($remind[$order_type]['user'][$order_status], $order_info['order_sn']),
            'role' => 0,
            'status' => 0,
            'type' => 0,
            'add_time' => TIMESTAMP,
            'uniacid' => $_W['uniacid']
        ));
    }
    if(isset($remind[$order_type]['designer'][$order_status])){
        pdo_insert('jkj_order_remind', array(
            'user_id' => $order_info['designer_id'],
            'content' => sprintf($remind[$order_type]['user'][$order_status], $order_info['order_sn']),
            'role' => 1,
            'status' => 0,
            'type' => 0,
            'add_time' => TIMESTAMP,
            'uniacid' => $_W['uniacid']
        ));
    }
    if(isset($remind[$order_type]['shoper'][$order_status])){
        $shoper_id = pdo_fetch("SELECT shoper_id FROM ". tablename('jkj_shops'). " WHERE uniacid=:uniacid AND shop_id=:shop_id", array(':uniacid' => $_W['uniacid'], ':shop_id' => $order_info['shop_id']));
        pdo_insert('jkj_order_remind', array(
            'user_id' => $order_info['user_id'],
            'content' => sprintf($remind[$order_type]['user'][$order_status], $order_info['order_sn']),
            'role' => 2,
            'status' => 0,
            'type' => 0,
            'add_time' => TIMESTAMP,
            'uniacid' => $_W['uniacid']
        ));
    }

    return true;
}

/** 生成新的订单号
 *
 */
function order_sn($city){
    global $_W;
    include CLASS_ROOT.'cutf8_py.class.php';

    $cutf8_py = new CUtf8_PY();
    $city_name = get_region_name($city);
    $city_py = $cutf8_py->encode($city_name);
    $city_py = substr($city_py,0,strlen($city_py)-1);   //去掉市的首字母
    $city_py = strtoupper($city_py);                    //转大写

    $prefix_order_sn = $city_py.date('Ym');
    $sql = 'SELECT COUNT(*) FROM '.tablename('jkj_order')." WHERE order_sn LIKE :order_sn AND uniacid=:uniacid";
    $order_num = pdo_fetchcolumn($sql, array(':order_sn' => '%'.$prefix_order_sn.'%', ':uniacid' => $_W['uniacid']));

    do{
        $order_num++;
        $new_order_sn = $prefix_order_sn.str_pad($order_num,4,"0",STR_PAD_LEFT);

        $sql = 'SELECT COUNT(*) FROM '.tablename('jkj_order')." WHERE order_sn LIKE :order_sn AND uniacid=:uniacid";
        $is_repeat = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('jkj_order')." WHERE order_sn LIKE :order_sn AND uniacid=:uniacid", array(
            ':order_sn' => $new_order_sn,
            ':uniacid' => $_W['uniacid']));
    }while($is_repeat);

    return $new_order_sn;
}

/** 获取体验订单列表
 *
 */
function get_reser_order_list($role, $order_status, $page = 1, $size = 15,  $is_ajax = false){
    global $_W;

    $user_id = $_SESSION['user_id'];
    $is_shoper = $_SESSION['is_shoper'];
    $where = '';

    if($role == 'user' && $user_id){
        $field = 'user_id';
        $value = $user_id;
    }elseif($role == 'shoper' && $is_shoper){
        $field = 'shop_id';
        $value = pdo_fetchcolumn("SELECT shop_id FROM ".tablename('jkj_shops')." WHERE shoper_id=:user_id AND uniacid=:uniacid", array(':user_id' => $user_id, ':uniacid' => $_W['uniacid']));
    }else{
        return false;
    }
    if($order_status != 'all'){
        $where = ' AND status=:status';
        $par[':status'] = $order_status;
    }

    $par[':uniacid'] = $_W['uniacid'];
    $par[':field'] = $value;

    $fields = 'oid,product_id,order_sn,shop_id,name,mobile,order_time,order_status,add_time,order_id';

    $sql = "SELECT {$fields} FROM ".tablename('jkj_reser_order')." WHERE uniacid=:uniacid AND {$field}=:field {$where} ORDER BY add_time DESC LIMIT ".$size*($page-1).",".$size;
    $list = pdo_fetchall($sql, $par);

    foreach($list as $key => $val){
        if($val['product_id']){
            $product[$val['product_id']] = isset($product[$val['product_id']]) ? $product[$val['product_id']] : get_product_info($val['product_id']);

            $list[$key]['source_name'] = $product[$val['product_id']]['product_name'];
            $list[$key]['source_thumb'] = $product[$val['product_id']]['product_thumb'];
        }else{
            $list[$key]['source_name'] = '快速预约体验';
            $list[$key]['source_thumb'] = '';
        }

        $list[$key]['order_time'] = date('Y-m-d H:i:s', $val['order_time']);
        $list[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
    }
    $result['list'] = $list;

    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jkj_reser_order')." WHERE uniacid=:uniacid AND {$field}=:field {$where}", $par);
    if($is_ajax){
        $result['now_page'] = $page;
        $result['max_page'] = ceil($total/$size);
    }else{
        $result['pager'] = pagination($total, $page, $size);
    }

    return $result;
}

/** 获取体验订单列表
 *
 */
function get_order_list($role, $order_status, $page = 1, $size = 15,  $is_ajax = false){
    global $_W;

    $user_id = $_SESSION['user_id'];
    $is_designer = $_SESSION['is_designer'];
    $is_shoper = $_SESSION['is_shoper'];
    $where = '';

    if($role == 'user' && $user_id){
        $field = 'user_id';
        $value = $user_id;
    }elseif($role == 'designer' && $is_designer){
        $field = 'designer_id';
        $value = $user_id;
    }elseif($role == 'shoper' && $is_shoper){
        $field = 'shop_id';
        $value = pdo_fetchcolumn("SELECT shop_id FROM ".tablename('jkj_shops')." WHERE shoper_id=:user_id AND uniacid=:uniacid", array(':user_id' => $user_id, ':uniacid' => $_W['uniacid']));
    }else{
        return false;
    }
    if($order_status != 'all'){
        $where = ' AND status=:status';
        $par[':status'] = $order_status;
    }

    $par[':uniacid'] = $_W['uniacid'];
    $par[':field'] = $value;

    $fields = 'order_id,order_sn,source_id,source_type,remark,name,mobile,province,city,order_status,is_cancel,pay_money,pay_status,add_time';

    $sql = "SELECT {$fields} FROM ".tablename('jkj_order')." WHERE uniacid=:uniacid AND {$field}=:field {$where} ORDER BY add_time DESC LIMIT ".$size*($page-1).",".$size;
    $list = pdo_fetchall($sql, $par);

    foreach($list as $key => $val){
        switch($val['source_type']){
            case 'product':
                $product[$val['source_id']] = isset($product[$val['source_id']]) ? $product[$val['source_id']] : get_product_info($val['source_id']);

                $list[$key]['source_name'] = $product[$val['source_id']]['product_name'];
                $list[$key]['source_thumb'] = $product[$val['source_id']]['product_thumb'];
                break;
            case 'quickOrder':
                $list[$key]['source_name'] = '快速预约量尺';
                $list[$key]['source_thumb'] = '';
                break;
            case 'reserOrder':
                $shop[$val['source_id']] = isset($shop[$val['source_id']]) ? $shop[$val['source_id']] : get_shop_info($val['source_id']);

                $list[$key]['source_name'] = $shop[$val['source_id']]['shop_name'];
                $list[$key]['source_thumb'] = '';
                break;
        }

        $list[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
        $list[$key]['province'] = get_region_name($val['province']);
        $list[$key]['city'] = get_region_name($val['city']);
        $list[$key]['pay_money'] = $val['pay_status'] == 1 ? format_price($val['pay_money']) : format_price(0);
    }
    $result['list'] = $list;

    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jkj_order')." WHERE uniacid=:uniacid AND {$field}=:field {$where}", $par);
    if($is_ajax){
        $result['now_page'] = $page;
        $result['max_page'] = ceil($total/$size);
    }else{
        $result['pager'] = pagination($total, $page, $size);
    }

    return $result;
}


?>