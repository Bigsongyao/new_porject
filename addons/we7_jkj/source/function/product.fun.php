<?php
defined('IN_IA') or exit('Access Denied');

/*
 * 获取商品列表
 * @param $type 商品类型 0：定制，1：预约
 * @param $filter_item 筛选条件 筛选条件，多个用.隔开，0或空为不限制
 * @param int $page 当前页码
 * @param int $size 一页显示数量
 */
function get_product_list($type, $filter_item = '', $page = 1, $size = 15){
    global $_W;

    $type = empty($type) ? 0 : 1;
    $par = array(
        ':type' => $type,
        ':uniacid' => $_W['uniacid'],
    );

    $ext_item = array();
    if (!empty($filter_item))
    {
        foreach ($filter_item AS $v)
        {
            if (is_numeric($v) && $v !=0)
            {
                $ext_item[] = $v;
            }
        }
    }

	if(count($ext_item)>0){
        arsort($ext_item);
        $ext_item_str = implode(',',$ext_item);

        load()->func('file');
        $cache = 'we7_jkj/cache/'.$_W['uniacid'].'/'.base64_encode($ext_item_str).'.php';
        $where = file_read($cache);
        if($where === false){
            $sql = "SELECT product_id,item_id FROM ".tablename('jkj_product_cat')." WHERE uniacid=:uniacid AND item_id IN (".$ext_item_str.")";
            $product_item = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

            foreach($product_item as $item){
                $products[$item['product_id']][] = $item['item_id'];
            }

            foreach($products as $product_id => $items){
                if(arr_in_arr($ext_item, $items)){
                    $ext_product[] = $product_id;
                }
            }

            $where = count($ext_product)>0 ? ' AND product_id IN ('.implode(',',$ext_product).')' : ' AND 1=0';
            file_write($cache, $where);
        }
	}else{
        $where = '';
    }
    $sql = "SELECT product_id, product_name, product_thumb, price FROM ".
            tablename('jkj_products').
            "WHERE product_type=:type AND uniacid=:uniacid " . $where .
			' ORDER BY sort_by ASC, product_id DESC'.' LIMIT '.$size*($page-1).','.$size;

    $result['list'] = pdo_fetchall($sql, $par);
    foreach($result['list'] as $key => $val){
        $sql = "SELECT AVG(star) as star, COUNT(comment_id) as total FROM ".tablename('jkj_comments')." WHERE product_id=:product_id AND uniacid=:uniacid";
        $commont = pdo_fetch($sql, array(':product_id'=>$val['product_id'], ':uniacid'=>$_W['uniacid']));

        $result['list'][$key]['product_thumb'] = tomedia($val['product_thumb']);
        $result['list'][$key]['format_price'] = format_price($val['price']);
        $result['list'][$key]['comment']['total'] = $commont['total'] ? $commont['total'] : 0;
        $result['list'][$key]['comment']['star'] = $commont['star'] ? round($commont['star'], 1) : 0;
        //用户已登录商品是否已收藏
        $result['list'][$key]['is_collect'] = !empty($_SESSION['user_id']) ? is_collect($val['product_id'], $_SESSION['user_id']) : 0;
    }

    $sql = "SELECT COUNT(product_id) FROM ".
            tablename('jkj_products').
            "WHERE product_type=:type AND uniacid=:uniacid " . $where;
    $total = pdo_fetchcolumn($sql, $par);
    $result['max_page'] = ceil($total/$size);
    $result['now_page'] = $page;

    return $result;
}

/*获取商品详情
 * */
function get_product_info($product_id){
    global $_W;

    $result = pdo_fetch("SELECT * FROM ".tablename('jkj_products')." WHERE product_id=:product_id AND uniacid=:uniacid", array(
        ':product_id' => $product_id,
        ':uniacid' => $_W['uniacid']
    ));

    if(!$result){
        return false;
    }

    $product['product_id'] = $result['product_id'];
    $product['product_name'] = $result['product_name'];
    $product['product_thumb'] = tomedia($result['product_thumb']);
    $product['product_details'] = htmlspecialchars_decode($result['product_details']);
    $product['description'] = $result['description'];
    $product['product_type'] = $result['product_type'];
    $product['status'] = $result['status'];
    $product['is_collect'] = !empty($_SESSION['user_id']) ? is_collect($result['product_id'], $_SESSION['user_id']) : 0;

    if($result['product_type'] == 0){
        $product_imgs = unserialize($result['product_img']);
        $product['product_image'] = array_map("tomedia", $product_imgs);
        $product['product_shipping'] = htmlspecialchars_decode($result['product_shipping']);
        $product['product_suite'] = htmlspecialchars_decode($result['product_suite']);
        $product['attr'] = get_product_attr($product_id);
        $product['attr'] = get_product_attr($product_id);
        $product['product_cat'] = get_product_cat($product_id);
        $product['price'] = $result['price'];
        $product['product_link'] = get_link_product($product_id);
    }else{
        $product['product_img'] =  tomedia($result['product_img']);
        //$product['shop_id'] =  $result['shop_id'];
        $product['shop'] = get_shop_info($result['shop_id']);
    }

    return $product;
}

/*获取商品属性
 * */
function get_product_attr($product_id){
    global $_W;

    $sql = "SELECT pa.product_attr_id, pa.attr_id, pa.attr_value, a.attr_name, a.is_suite FROM ".
        tablename('jkj_product_attr')." AS pa, ". tablename('jkj_attribute')." AS a ".
        "WHERE pa.attr_id=a.attr_id AND pa.product_id=:product_id AND pa.uniacid=:uniacid ORDER BY attr_sort ASC";

    $attr_info = pdo_fetchall($sql, array(
        ':product_id' => $product_id,
        ':uniacid' => $_W['uniacid']
    ));

    return $attr_info ? $attr_info : array();
}

/*获取商品关联
 * */
function get_link_product($product_id){
    global $_W;

    $data = array();
    $sql = "SELECT product_id, link_product_id FROM ".tablename('jkj_link_product'). " WHERE (product_id=:product_id OR link_product_id=:product_id) AND product_id>0 AND uniacid=:uniacid";
    $par = array(
        ':product_id' => $product_id,
        ':uniacid' => $_W['uniacid'],
    );
    $list = pdo_fetchall($sql, $par);

    foreach($list as $k => $v){
        $link_id = $v['product_id'] == $product_id ? $v['link_product_id'] : $v['product_id'];

        $sql = "SELECT product_id, product_name, product_thumb, price FROM ".tablename('jkj_products'). " WHERE product_id=:product_id AND uniacid=:uniacid";
        $data[$k] = pdo_fetch($sql, array(
            ':product_id' => $link_id,
            ':uniacid' => $_W['uniacid'],
        ));
    }

    return $data;
}

function get_product_cat($product_id){
    global $_W;

    $sql = "SELECT id, cat_id, item_id FROM ".tablename('jkj_product_cat'). " WHERE product_id=:product_id AND uniacid=:uniacid";
    $par = array(
        ':product_id' => $product_id,
        ':uniacid' => $_W['uniacid'],
    );
    return pdo_fetchall($sql, $par);
}

/*处理商品关联
 * */
function link_product($id, $link_id, $checked){
    global $_W;

    if($id == $link_id){
        return false;
    }

    if($id>0){
        $where = " WHERE product_id IN (:id, :link_id) AND link_product_id IN (:id, :link_id) AND uniacid=:uniacid ";
    }else{
        $where = " WHERE product_id IN (:id, :link_id) AND link_product_id IN (:id, :link_id) AND uniacid=:uniacid AND uid={$_W['uid']}";
    }
    $sql = "SELECT count(*) FROM ".tablename('jkj_link_product').$where;
    $par = array(
        ':id' => $id,
        ':link_id' => $link_id,
        ':uniacid' => $_W['uniacid'],
    );
    $is_link = pdo_fetchcolumn($sql, $par);
    if($checked){
        if($is_link){
            return false;
        }

        $insert = array(
            'product_id' => $id,
            'link_product_id' => $link_id,
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['uid'],
        );

        return pdo_insert('jkj_link_product', $insert);
    }else{
        if(!$is_link){
            return false;
        }

        return pdo_query("DELETE FROM ".tablename('jkj_link_product') . $where, $par);
    }
}

/*获取分类列表
 * */
function get_category_list($type = 0){
    global $_W;

    $cat_list = array();
    $type = empty($type) ? 0 : 1;

    $sql = "SELECT cat_id, cat_name FROM ".tablename('jkj_category') ." WHERE uniacid=:uniacid AND type=:type AND is_show=1 ORDER BY sort_by ASC, cat_id DESC";
    $result = pdo_fetchall($sql, array(
        ':uniacid' => $_W['uniacid'],
        ':type' => $type,
    ));

    foreach($result as $key => $val){
        $cat_item = array();

        $item = pdo_fetchall("SELECT item_id, title FROM ".tablename('jkj_product_cat_item') ." WHERE uniacid=:uniacid AND cat_id=:cat_id ORDER BY item_id ASC", array(
            ':uniacid' => $_W['uniacid'],
            ':cat_id' => $val['cat_id'],
        ));
        foreach($item as $v){
            $cat_item[$v['item_id']] = $v['title'];
        }

        $val['item'] = $cat_item;
        $cat_list[] = $val;
    }

    return $cat_list;
}

/*商品是否已收藏
 * */
function is_collect($product_id, $user_id = 0){
    global $_W;

    $user_id = empty($user_id) ? $_SESSION['user_id'] : $user_id;

    if(empty($user_id)){
        return false;
    }

    return pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jkj_collect')." WHERE user_id=:user_id AND product_id=:product_id AND uniacid=:uniacid", array(
        ':user_id' => $user_id,
        ':product_id' => $product_id,
        ':uniacid' => $_W['uniacid'],
    ));
}

function get_commont_list($product_id, $page = 1, $size = 15){
    global $_W;

    $par = array(
        ':uniacid' => $_W['uniacid'],
        ':product_id' => $product_id,
    );

    $sql = "SELECT a.commont_id, a.content, a.star, a.add_time, b.headimg, b.username FROM ".
        tablename('jkj_commonts'). " AS a " .
        "LEFT JOIN " .
        tablename('jkj_user'). " AS b " .
        "ON a.user_id=b.user_id AND a.uniacid=b.uniacid " .
        "WHERE a.uniacid=:uniacid AND a.product_id=:product_id " .
        "ORDER BY add_time ASC LIMIT ".$size*($page-1).','.$size;
    $result['list'] = pdo_fetchall($sql, $par);

    foreach($result['list'] as $k => $v){
        $result['list'][$k]['add_time'] = date('Y年m月d日', $v['add_time']);
    }

    $sql = "SELECT COUNT(*) FROM ". tablename('jkj_commonts'). " WHERE a.uniacid=:uniacid AND a.product_id=:product_id";
    $total = pdo_fetchcolumn($sql, $par);
    $result['max_page'] = ceil($total/$size);
    $result['now_page'] = $page;

    return $result;
}

function get_shop_info($shop_id){
    global $_W;

    $sql = "SELECT shop_id,shoper_id,shop_name,province,city,district,address,lng,lat,content FROM ". tablename('jkj_shops'). " WHERE uniacid=:uniacid AND shop_id=:shop_id";
    $result = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':shop_id' => $shop_id));

    if(!$result){
        return false;
    }

    $result['shoper_img'] = tomedia($result['shoper_img']);
    $result['add_address'] = get_shop_address($result['shop_id']);
    $result['content'] = htmlspecialchars_decode($result['content'], ENT_QUOTES);
    $result['shoper'] = pdo_fetch("SELECT user_id,username,realname,headimg FROM ". tablename('jkj_user'). " WHERE uniacid=:uniacid AND user_id=:user_id", array(':uniacid' => $_W['uniacid'], ':user_id' => $result['shoper_id']));
    $result['designer'] = '';
    $designer = get_shop_designer($shop_id);
    foreach($designer as $val){
        $result['designer'] .= $val['user_id'].',';
    }
    $result['designer'] = substr($result['designer'],0,strlen($result['designer'])-1);

    return $result;
}

function get_shop_designer($shop_id){
    global $_W;

    if($shop_id == 0){
        return array();
    }

    $sql = "SELECT b.user_id,b.username FROM ".
            tablename('jkj_designer')." AS a ".
            "LEFT JOIN ".
            tablename('jkj_user')." AS b ".
            "ON a.user_id=b.user_id AND a.uniacid=b.uniacid ".
            "WHERE a.shop_id=:shop_id AND a.uniacid=:uniacid AND b.is_designer=1";
    $list = pdo_fetchall($sql, array(':shop_id' => $shop_id, ':uniacid' => $_W['uniacid']));

    return $list;
}

?>