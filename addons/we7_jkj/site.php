<?php
/**
 * 极客家网上预约系统模块微站定义
 *
 * @author О⒈㈢
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

define(INC_ROOT, IA_ROOT.'/addons/we7_jkj/source/');
define(FUN_ROOT, INC_ROOT.'function/');
define(CLASS_ROOT, INC_ROOT.'class/');
define(APP_ROOT, INC_ROOT.'app/');
define(WEB_ROOT, INC_ROOT.'web/');

include(FUN_ROOT.'global.fun.php');

class We7_jkjModuleSite extends WeModuleSite {

    public function doWebSet(){
        global $_W, $_GPC;

        include $this->template('setting');
    }

    public function doWebProducts(){
        include(FUN_ROOT.'product.fun.php');

        global $_W, $_GPC;

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $product_id = isset($_GPC['product_id']) ? intval($_GPC['product_id']) : 0;

        if($fun == 'post'){
            if (checksubmit('submit')) {
                $product_type = empty($_GPC['product_type']) ? 0 : 1;

                $data['product_type'] = $product_type;
                $data['product_name'] = trim($_GPC['product_name']);
                $data['status'] = $_GPC['status'] == 'on' ? 1 : 0;
                $data['description'] = trim($_GPC['description']);
                $data['sort_by'] = intval($_GPC['sort_by']);
                $data['product_thumb'] = trim($_GPC['product_thumb']);
                $data['linkurl'] = trim($_GPC['linkurl']);
                $data['product_details'] = htmlspecialchars($_GPC['product_details'], ENT_QUOTES );
                $data['uniacid'] = $_W['uniacid'];

                if($product_type == 0){
                    $data['price'] = trim($_GPC['price']);
                    $data['product_img'] = is_array($_GPC['product_img']) ? serialize($_GPC['product_img']) : serialize(array());
                    $data['product_shipping'] = htmlspecialchars($_GPC['product_shipping'], ENT_QUOTES);
                    $data['product_suite'] = htmlspecialchars($_GPC['product_suite'], ENT_QUOTES);
                }elseif($product_type == 1){
                    $data['shop_id'] = intval($_GPC['shop_id']);
                    $data['product_img'] =  trim($_GPC['product_img']);
                }

                if($product_id){
                    pdo_update('jkj_products', $data, array('product_id' => $product_id, 'product_type' => $product_type));
                }else{
                    pdo_insert('jkj_products', $data);
                    $product_id = pdo_insertid();
                }

                //处理商品分类
                $cat_ids = isset($_GPC['cat_id'])&&is_array($_GPC['cat_id']) ? $_GPC['cat_id'] : array();
                $item_ids = isset($_GPC['item_id'])&&is_array($_GPC['item_id']) ? $_GPC['item_id'] : array();
                $ids = isset($_GPC['id'])&&is_array($_GPC['id']) ? $_GPC['id'] : array();
                $exist_id = array();

                foreach($cat_ids as $key => $cat_id){
                    if(!empty($cat_id) && !empty($item_ids[$key]) && isset($ids[$key])){
                        $cat_data = array(
                            'product_id' => $product_id,
                            'item_id' => $item_ids[$key],
                            'cat_id' => $cat_id,
                            'uniacid' => $_W['uniacid']
                        );

                        if($ids[$key]){
                            pdo_update('jkj_product_cat', $cat_data, array('id' => $ids[$key]));
                            $exist_id[] = $ids[$key];
                        }else{
                            pdo_insert('jkj_product_cat', $cat_data);
                            $exist_id[] = pdo_insertid();
                        }
                    }
                }

                if(count($exist_id)>0){
                    pdo_query("DELETE FROM ".tablename('jkj_product_cat')." WHERE uniacid=:uniacid AND id NOT IN (".implode(',', $exist_id).") AND product_id=:product_id", array(
                        ':uniacid' => $_W['uniacid'],
                        ':product_id' => $product_id,
                    ));
                }else{
                    pdo_delete('jkj_product_cat', array('uniacid' => $_W['uniacid'], 'product_id' => $product_id));
                }

                //处理商品属性
                $attr_value = isset($_GPC['attr_value'])&&is_array($_GPC['attr_value']) ? $_GPC['attr_value'] : array();
                $attr_id = isset($_GPC['attr_id'])&&is_array($_GPC['attr_id']) ? $_GPC['attr_id'] : array();
                $product_attr_id = isset($_GPC['product_attr_id'])&&is_array($_GPC['product_attr_id']) ? $_GPC['product_attr_id'] : array();
                $exist_product_attr_id = array();

                foreach($attr_value as $key => $attr){
                    if(!empty($attr) && !empty($attr_id[$key]) && isset($product_attr_id[$key])){
                        $attr_data = array(
                            'product_id' => $product_id,
                            'attr_id' => $attr_id[$key],
                            'attr_value' => $attr,
                            'uniacid' => $_W['uniacid']
                        );

                        if($product_attr_id[$key]){
                            pdo_update('jkj_product_attr', $attr_data, array('product_attr_id' => $product_attr_id[$key]));
                            $exist_product_attr_id[] = $product_attr_id[$key];
                        }else{
                            pdo_insert('jkj_product_attr', $attr_data);
                            $exist_product_attr_id[] = pdo_insertid();
                        }
                    }
                }

                if(count($exist_product_attr_id)>0){
                    pdo_query("DELETE FROM ".tablename('jkj_product_attr')." WHERE uniacid=:uniacid AND product_attr_id NOT IN (".implode(',', $exist_product_attr_id).") AND product_id=:product_id", array(
                        ':uniacid' => $_W['uniacid'],
                        ':product_id' => $product_id,
                    ));
                }else{
                    pdo_delete('jkj_product_attr', array('uniacid' => $_W['uniacid'], 'product_id' => $product_id));
                }

                //处理商品关联
                pdo_update('jkj_link_product', array('product_id' => $product_id), array('product_id' => 0, 'uniacid' => $_W['uniacid'], 'uid' => $_W['uid']));
                clear_cache();
                message('添加成功', $this->createWebUrl("products",array("fun"=>"display")));
            }
            //删除为保存的商品关联
            pdo_delete('jkj_link_product', array('product_id'=> 0, 'uniacid' => $_W['uniacid'], 'uid' => $_W['uid']));

            $category_list = pdo_fetchall("SELECT * FROM ".tablename('jkj_category')." WHERE uniacid = :uniacid ORDER BY sort_by ASC, cat_id DESC", array(':uniacid' => $_W['uniacid']));
            foreach($category_list as $value){
                $value['item'] = pdo_fetchall("SELECT item_id, title FROM ".tablename('jkj_product_cat_item')." WHERE uniacid=:uniacid AND cat_id=:cat_id", array(':uniacid' => $_W['uniacid'], ':cat_id' => $value['cat_id']));
                $cate_list[$value['type']][$value['cat_id']] = $value;
            }

            $attr_list = pdo_fetchall("SELECT * FROM ".tablename('jkj_attribute')." WHERE uniacid = :uniacid ORDER BY attr_sort ASC, attr_id DESC", array(':uniacid' => $_W['uniacid']));
            $shop_list = pdo_fetchall("SELECT shop_id,shop_name FROM ".tablename('jkj_shops')." WHERE uniacid = :uniacid ORDER BY shop_id DESC", array(':uniacid' => $_W['uniacid']));
            $item = get_product_info($product_id);
            if(!$item){
                $item['product_type'] = empty($_GPC['product_type']) ? 0 : 1;
            }

        }elseif($fun == 'ajax'){
            $op = $_GPC['op'];

            switch($op){
                case 'search':
                    $key = $_GPC['key'];

                    $sql = 'SELECT product_id, product_name FROM '.tablename('jkj_products'). 'WHERE uniacid=:uniacid AND product_name LIKE :product_name AND product_id<>:product_id ORDER BY sort_by ASC, product_id DESC';
                    $par[':uniacid'] = $_W['uniacid'];
                    $par[':product_id'] = $product_id;
                    $par[':product_name'] = "%{$key}%";
                    $result = pdo_fetchall($sql, $par);

                    break;
                case 'status':
                    $status = $_GPC['status'] ? 1 : 0;

                    $res = pdo_fetchcolumn("SELECT product_id FROM ".tablename('jkj_products')." WHERE product_id=:product_id AND uniacid = :uniacid", array(
                        ':product_id' => $product_id,
                        ':uniacid' => $_W['uniacid']
                    ));

                    if($res){
                        pdo_update('jkj_products', array('status' => $status), array('product_id' => $product_id));
                        $result = '1';
                    }else{
                        $result = '0';
                    }
                case 'link':
                    $link_product_id = intval($_GPC['link_product_id']);
                    $checked = empty($_GPC['checked']) ? 0 : 1;
                    $result = link_product($product_id, $link_product_id, $checked) ? '1' : '0';

                    break;
                default:
                    break;
            }

            is_array($result) ? die(json_encode($result)) : die($result);

        }else{
            $product_name = isset($_GPC['product_name']) ? trim($_GPC['product_name']) : '';
            $page = max(1, intval($_GPC['page']));

            $result = $this->get_product_list($product_name, $page);

            $list = $result['list'];
            $pager = $result['pager'];
        }

        include $this->template('cmsProduct');
    }

    public function doWebCategory(){
        global $_W, $_GPC;

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $cat_id = isset($_GPC['cat_id']) ? intval($_GPC['cat_id']) : 0;
        $type = $_GPC['type'] ? 1 : 0;

        if($fun == 'post'){
            if (checksubmit('submit')) {
                $cat_name = $_GPC['cat_name'];
                $sort_by = $_GPC['sort_by'];
                $is_show = $_GPC['is_show'] ? 1 : 0;

                $data = array(
                    'cat_name'  =>  $cat_name,
                    'sort_by'   =>  $sort_by,
                    'is_show'   =>  $is_show,
                    'type'      =>  $type,
                    'uniacid'   => $_W['uniacid']
                );

                if($cat_id){
                    pdo_update('jkj_category', $data, array('cat_id' => $cat_id));
                }else{
                    pdo_insert('jkj_category', $data);
                }

                message('添加成功', $this->createWebUrl("category",array("fun"=>"display", 'cat_id' => $cat_id)));
            }


            if($cat_id){
                $category = pdo_fetch("SELECT * FROM ".tablename('jkj_category')." WHERE cat_id=:cat_id AND uniacid = :uniacid", array(':cat_id' => $cat_id, ':uniacid' => $_W['uniacid']));
            }
            $list = pdo_fetchall("SELECT * FROM ".tablename('jkj_category')." WHERE uniacid = :uniacid AND type = :type AND cat_id <> :cat_id", array(
                ':uniacid' => $_W['uniacid'],
                ':type' => $type,
                ':cat_id' => $cat_id
            ));
        }elseif($fun == 'delete'){
            $result = pdo_fetchcolumn("SELECT cat_id FROM ".tablename('jkj_category')." WHERE cat_id=:cat_id AND uniacid = :uniacid", array(
                ':cat_id' => $cat_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_delete('jkj_product_cat_item', array('cat_id' => $cat_id, 'uniacid' => $_W['uniacid']));
                pdo_delete('jkj_category', array('cat_id' => $cat_id, 'uniacid' => $_W['uniacid']));
                die('1');
            }else{
                die('0');
            }
        }elseif($fun == 'isShow'){
            $isShow = $_GPC['isShow'] ? 1 : 0;

            $result = pdo_fetchcolumn("SELECT cat_id FROM ".tablename('jkj_category')." WHERE cat_id=:cat_id AND uniacid = :uniacid", array(
                ':cat_id' => $cat_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_update('jkj_category', array('is_show' => $isShow), array('cat_id' => $cat_id));
                die('1');
            }else{
                die('0');
            }
        }elseif($fun == 'sortBy'){
            $issort = $_GPC['issort'] ? intval($_GPC['issort']) : 0;

            $result = pdo_fetchcolumn("SELECT cat_id FROM ".tablename('jkj_category')." WHERE cat_id=:cat_id AND uniacid IN (0, :uniacid)", array(
                ':cat_id' => $cat_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_update('jkj_category', array('sort_by' => $issort), array('cat_id' => $cat_id));
                die('1');
            }else{
                die('0');
            }
        }else{
            $list = pdo_fetchall("SELECT * FROM ".tablename('jkj_category')." WHERE uniacid = :uniacid ORDER BY sort_by ASC, cat_id DESC", array(':uniacid' => $_W['uniacid']));
        }

        include $this->template('cmsCategory');
    }

    public function doWebProductCat(){
        global $_W, $_GPC;
        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $cat_id = isset($_GPC['cat_id']) ? intval($_GPC['cat_id']) : 0;
        $item_id = isset($_GPC['item_id']) ? intval($_GPC['item_id']) : 0;

        $info = pdo_fetch("SELECT * FROM ".tablename('jkj_category')." WHERE cat_id=:cat_id AND uniacid IN (0, :uniacid)", array(':cat_id' => $cat_id, ':uniacid' => $_W['uniacid']));

        if(empty($info)){
            message('分类不存在或已删除', 'referer ', 'error');
        }

        if($fun == 'post'){
            if (checksubmit('submit')) {
                $cat_name = $_GPC['cat_name'];

                foreach($cat_name as $row){
                    if(!empty($row)){
                        $insert = array(
                            'cat_id' => $cat_id,
                            'title' => $row,
                            'uniacid' => $_W['uniacid']
                        );

                        pdo_insert('jkj_product_cat_item', $insert);
                    }
                }

                clear_cache();
                message('添加成功', $this->createWebUrl("productCat",array("fun"=>"display", 'cat_id' => $cat_id)));
            }
            $list = pdo_fetchall("SELECT * FROM ".tablename('jkj_category')." WHERE uniacid IN (0, :uniacid)", array(':uniacid' => $_W['uniacid']));
        }elseif($fun == 'delete'){
            pdo_delete('jkj_product_cat_item', array('item_id' => $item_id, 'uniacid' => $_W['uniacid']));
            die(json_encode(array(
                'type' => 'success'
            )));
        }else{
            $list = pdo_fetchall("SELECT * FROM ".tablename('jkj_product_cat_item')." WHERE uniacid= :uniacid AND cat_id=:cat_id", array(':uniacid' => $_W['uniacid'], ':cat_id' => $cat_id));
        }

        include $this->template('cmsProductCat');
    }

    public function doWebAttribute(){
        global $_W, $_GPC;

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $attr_id = isset($_GPC['attr_id']) ? intval($_GPC['attr_id']) : 0;
        $product_attr_id = isset($_GPC['product_attr_id']) ? intval($_GPC['product_attr_id']) : 0;

        if($fun == 'post'){
            if (checksubmit('submit')) {
                $attr_name = $_GPC['attr_name'];

                foreach($attr_name as $row){
                    if(!empty($row)){
                        $insert = array(
                            'is_suite' => 0,
                            'attr_name' => $row,
                            'attr_sort' => 0,
                            'uniacid' => $_W['uniacid']
                        );

                        pdo_insert('jkj_attribute', $insert);
                    }
                }

                message('添加成功', $this->createWebUrl("attribute",array("fun"=>"display")));
            }
        }elseif($fun == 'delete'){
            $result = pdo_fetchcolumn("SELECT attr_id FROM ".tablename('jkj_attribute')." WHERE attr_id=:attr_id AND uniacid = :uniacid", array(
                ':attr_id' => $attr_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_delete('jkj_product_attr', array('attr_id' => $attr_id, 'uniacid' => $_W['uniacid']));
                pdo_delete('jkj_attribute', array('attr_id' => $attr_id, 'uniacid' => $_W['uniacid']));
                die('1');
            }else{
                die('0');
            }
        }elseif($fun == 'sortBy'){
            $issort = $_GPC['issort'] ? intval($_GPC['issort']) : 0;

            $result = pdo_fetchcolumn("SELECT attr_id FROM ".tablename('jkj_attribute')." WHERE attr_id=:attr_id AND uniacid = :uniacid", array(
                ':attr_id' => $attr_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_update('jkj_attribute', array('sort_by' => $issort), array('attr_id' => $attr_id));
                die('1');
            }else{
                die('0');
            }
        }elseif($fun == 'isSuite'){
            $result = pdo_fetchcolumn("SELECT attr_id FROM ".tablename('jkj_attribute')." WHERE attr_id=:attr_id AND uniacid = :uniacid", array(
                ':attr_id' => $attr_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                pdo_update('jkj_attribute', array('is_suite' => 0), array('uniacid' => $_W['uniacid']));
                pdo_update('jkj_attribute', array('is_suite' => 1), array('attr_id' => $attr_id, 'uniacid' => $_W['uniacid']));
                die('1');
            }else{
                die('0');
            }
        }else{
            $list = pdo_fetchall("SELECT * FROM ".tablename('jkj_attribute')." WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
        }

        include $this->template('cmsAttribute');
    }

    public function doWebShops(){
        include(FUN_ROOT.'product.fun.php');

        global $_W, $_GPC;

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $shop_id = isset($_GPC['shop_id']) ? intval($_GPC['shop_id']) : 0;

        if($fun == 'display'){
            $page = max(1, intval($_GPC['page']));
            $size = 15;

            $sql = "SELECT * FROM ".tablename('jkj_shops')." WHERE uniacid=:uniacid ORDER BY shop_id DESC "." LIMIT ".$size*($page-1).",".$size;
            $list = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

            foreach($list as $k => $v){
                $list[$k]['all_address'] = get_shop_address($v['shop_id'], '·');
                $list[$k]['shoper'] = pdo_fetch("SELECT username,mobile FROM ". tablename('jkj_user'). " WHERE uniacid=:uniacid AND user_id=:user_id", array(':uniacid' => $_W['uniacid'], ':user_id' => $v['shoper_id']));
            }
        }elseif($fun == 'delete'){
            $result = pdo_fetch("SELECT shop_id,shoper_id FROM ".tablename('jkj_shops')." WHERE shop_id=:shop_id AND uniacid = :uniacid", array(
                ':shop_id' => $shop_id,
                ':uniacid' => $_W['uniacid']
            ));

            if($result){
                $designer = get_shop_designer($shop_id);
                foreach($designer as $v){
                    pdo_delete('jkj_designer', array('shop_id' => $shop_id, 'user_id' => $v['user_id'], 'uniacid' => $_W['uniacid']));
                    pdo_update('jkj_user', array('is_designer' => 0), array('user_id' => $v['user_id'], 'uniacid' => $_W['uniacid']));
                }
                pdo_update('jkj_user', array('is_shoper' => 0), array('user_id' => $result['shoper_id'], 'uniacid' => $_W['uniacid']));
                pdo_delete('jkj_shops', array('shop_id' => $shop_id, 'uniacid' => $_W['uniacid']));
            }

            message('删除成功', $this->createWebUrl("shops",array("fun"=>"display")));
        }elseif($fun == 'search_user'){
            $keyword = $_GPC['keyword'];
            $type = $_GPC['type'];
            $where = '';
            $par[':uniacid'] = $_W['uniacid'];
            if(!empty($keyword)){
                $where = " AND username LIKE :keyword";
                $par[':keyword'] = "'%{$keyword}%'";
            }

            if($type == 'set_shoper'){
                $list = pdo_fetchall("SELECT user_id,username FROM ". tablename('jkj_user'). " WHERE uniacid=:uniacid AND is_shoper=0".$where, $par);
            }else{
                $list = pdo_fetchall("SELECT user_id,username FROM ". tablename('jkj_user'). " WHERE uniacid=:uniacid AND is_designer=0".$where, $par);
            }

            die(json_encode($list));
        }elseif($fun == 'set'){
            $type = $_GPC['type'];

            $data = get_shop_info($shop_id);

            if($type == 'setDesigner'){
                $list = get_shop_designer($shop_id);
            }

            ob_start();
            include $this->template($type);
            $code = ob_get_contents();
            ob_clean();

            die($code);
        }else{
            if (checksubmit('submit')) {
                $data['shop_name'] = $_GPC['shop_name'];
                $data['province'] = $_GPC['province'];
                $data['city'] = $_GPC['city'];
                $data['district'] = $_GPC['district'];
                $data['address'] = $_GPC['address'];
                $data['content'] = htmlspecialchars($_GPC['content']);
                $data['lng'] = $_GPC['lng'];
                $data['lat'] = $_GPC['lat'];
                $data['uniacid'] = $_W['uniacid'];

                if($shop_id){
                    pdo_update('jkj_shops', $data, array('shop_id' => $shop_id, 'uniacid' => $_W['uniacid']));
                }else{
                    $data['add_time'] = TIMESTAMP;
                    pdo_insert('jkj_shops', $data);
                    $shop_id = pdo_insertid();
                }

                /*处理设计师*/
                $designer_str = $_GPC['designer'];
                $designer_str = preg_match('/^[\d\,]+$/',$designer_str) ? $designer_str : '';
                $designer_arr = explode(',', $designer_str);

                $old_designer = get_shop_designer($shop_id);
                $old_designer_ids = array();
                foreach($old_designer as $k => $v){
                    $old_designer_ids[$v['user_id']] = $v['user_id'];
                }
                foreach($designer_arr as $k => $v){
                    if(!in_array($v, $old_designer_ids) && !empty($v)){
                        pdo_insert('jkj_designer', array(
                            'shop_id' => $shop_id,
                            'user_id' => $v,
                            'uniacid' => $_W['uniacid']
                        ));

                        pdo_update('jkj_user', array('is_designer' => 1), array('user_id' => $v, 'uniacid' => $_W['uniacid']));
                    }else{
                        unset($old_designer_ids[$v]);
                    }
                }

                foreach($old_designer_ids as $v){
                    pdo_delete('jkj_designer', array('shop_id' => $shop_id, 'user_id' => $v, 'uniacid' => $_W['uniacid']));
                    pdo_update('jkj_user', array('is_designer' => 0), array('user_id' => $v, 'uniacid' => $_W['uniacid']));
                }

                /*处理店长*/
                $shoper_id = intval($_GPC['shoper_id']);
                $old_shoper_id = pdo_fetchcolumn("SELECT shoper_id FROM ".tablename('jkj_shops'). " WHERE shop_id=:shop_id AND uniacid=:uniacid", array(
                    ':shop_id' => $shop_id,
                    ':uniacid' => $_W['uniacid'],
                ));

                if($old_shoper_id != $shoper_id){
                    pdo_update('jkj_user', array('is_shoper' => 0), array('user_id' => $old_shoper_id, 'uniacid' => $_W['uniacid']));
                    pdo_update('jkj_user', array('is_shoper' => 1), array('user_id' => $shoper_id, 'uniacid' => $_W['uniacid']));
                    pdo_update('jkj_shops', array('shoper_id' => $shoper_id), array('shop_id' => $shop_id, 'uniacid' => $_W['uniacid']));
                }

                message('编辑成功', $this->createWebUrl("shops",array("fun"=>"display")));
            }

            $item = get_shop_info($shop_id);
            if(!$item){
                $item = array(
                    'shop_id' => 0,
                    'lng' => '116.404',
                    'lat' => '39.915',
                    'province' => 0,
                    'city' => 0,
                    'district' => 0,
                );
            }

            $province = get_region(1, 1);
            $city = get_region($item['province'], 2);
            $district = get_region($item['city'], 3);
        }

        include $this->template('cmsShop');
    }

    public function doWebRoles(){
        include(FUN_ROOT.'user.fun.php');

        global $_W,$_GPC;

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';
        $user_id = isset($_GPC['user_id']) ? intval($_GPC['user_id']) : 0;

        if($fun == 'display'){
            $role = isset($_GPC['role']) ? $_GPC['role'] : 'all';
            $keyword = isset($_GPC['keyword']) ? $_GPC['keyword'] : '';
            $page = max(1, intval($_GPC['page']));

            $result = get_user_list($role, $keyword, $page);
            $list = $result['list'];
            $pager = $result['pager'];
        }elseif($fun == 'post'){
            if (checksubmit('submit')) {
                if(!empty($_GPC['pwd'])||!empty($_GPC['cpwd'])){
                    if(!preg_match('/^[\s\S]{6,}$/', $_GPC['pwd']) || !preg_match('/^[\s\S]{6,}$/', $_GPC['cpwd'])){
                        message('密码长度不能小于6位', 'referer', 'error');
                    }
                    if($_GPC['pwd'] != $_GPC['cpwd']){
                        message('密码和确认密码不一致', 'referer', 'error');
                    }
                }

                $update['user_id'] = $user_id;
                $update['nickname'] = $_GPC['nickname'];
                $update['realname'] = $_GPC['realname'];
                $update['sex'] = $_GPC['sex'];
                $update['birth_year'] = $_GPC['birth_year'];
                $update['birth_month'] = $_GPC['birth_month'];
                $update['birth_day'] = $_GPC['birth_day'];
                $update['province'] = $_GPC['province'];
                $update['city'] = $_GPC['city'];
                $update['district'] = $_GPC['district'];
                $update['home_phone'] = $_GPC['home_phone'];
                $update['address'] = $_GPC['address'];
                $update['status'] = $_GPC['status'];
                $update['password'] = $_GPC['pwd'];

                include(CLASS_ROOT.'user.class.php');

                $user = new User();
                if($user->updateUserInfo($update)){
                    message('编辑成功', $this->createWebUrl("roles",array("fun"=>"display")));
                }else{
                    message($user->getErr(), $this->createWebUrl("roles",array("fun"=>"display")));
                }
            }

            $item = user_info($user_id);
            if(!$item){
                message('用户不存在', 'referer', 'error');
            }
            $province = get_region(1,1);
            $city = get_region($item['province'],2);
            $district = get_region($city['province'],3);
        }

        include $this->template('cmsRole');
    }

    public function doWebOrder(){
        global $_GPC, $_W;

        include(FUN_ROOT.'product.fun.php');
        include(FUN_ROOT.'user.fun.php');

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';

        if($fun == 'display'){
            $size = 15;
            $page = max(1, intval($_GPC['page']));
            $order_status = isset($_GPC['order_status']) ? $_GPC['order_status'] : 'all';

            $sql = "SELECT * FROM".tablename('jkj_order')." WHERE uniacid=:uniacid ORDER BY add_time DESC LIMIT ".$size*($page-1).",".$size;
            $list = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

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

                $shop[$val['shop_id']] = isset($shop[$val['shop_id']]) ? $shop[$val['shop_id']] : get_shop_info($val['shop_id']);
                $designer[$val['designer_id']] = isset($designer[$val['designer_id']]) ? $designer[$val['designer_id']] : user_info($val['designer_id']);

                $list[$key]['shoper'] = $shop[$val['shop_id']]['shoper'];
                $list[$key]['designer'] = $designer[$val['designer_id']]['username'];
                $list[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
                $list[$key]['province'] = get_region_name($val['province']);
                $list[$key]['city'] = get_region_name($val['city']);
                $list[$key]['pay_money'] = $val['pay_status'] == 1 ? format_price($val['pay_money']) : format_price(0);
            }

            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('jkj_order'). 'WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
            $pager = pagination($total, $page, $size);
        }

        include $this->template('cmsOrder');
    }

    public function doWebReserOrder(){
        global $_GPC, $_W;

        include(FUN_ROOT.'product.fun.php');

        $fun = isset($_GPC['fun']) ? $_GPC['fun'] : 'display';

        if($fun == 'display'){
            $size = 15;
            $page = max(1, intval($_GPC['page']));
            $order_status = isset($_GPC['order_status']) ? $_GPC['order_status'] : 'all';

            $sql = "SELECT * FROM".tablename('jkj_reser_order')." WHERE uniacid=:uniacid ORDER BY add_time DESC LIMIT ".$size*($page-1).",".$size;
            $list = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

            foreach($list as $key => $val){
                if($val['product_id']){
                    $product[$val['product_id']] = isset($product[$val['product_id']]) ? $product[$val['product_id']] : get_product_info($val['product_id']);

                    $list[$key]['source_name'] = $product[$val['product_id']]['product_name'];
                    $list[$key]['source_thumb'] = $product[$val['product_id']]['product_thumb'];
                }else{
                    $list[$key]['source_name'] = '快速预约体验';
                    $list[$key]['source_thumb'] = '';
                }
                $shop[$val['shop_id']] = isset($shop[$val['shop_id']]) ? $shop[$val['shop_id']] : get_shop_info($val['shop_id']);

                $list[$key]['shop_name'] = $shop[$val['shop_id']]['shop_name'];
                $list[$key]['order_time'] = date('Y-m-d H:i:s', $val['order_time']);
                $list[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
            }

            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('jkj_reser_order'). 'WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
            $pager = pagination($total, $page, $size);
        }

        include $this->template('cmsOrder');
    }

    public function doWebRegion(){
        global $_GPC;

        $type = $_GPC['type'];
        $region_id = $_GPC['region_id'];

        $list = get_region($region_id, $type);

        die(json_encode($list));
    }

    public function doMobileRegion(){
        global $_GPC;

        $type = $_GPC['type'];
        $region_id = $_GPC['region_id'];

        $list = get_region($region_id, $type);

        die(json_encode($list));
    }

    public function doMobileIndex(){
        global $_W, $_GPC;

        if(empty($_SESSION['user_id'])){
            $_user = get_cookie('user');
            if($_user){
                $_SESSION['user_id'] = $_user['user_id'];
                $_SESSION['username'] = $_user['username'];
                $_SESSION['headimg'] = $_user['headimg'];
                $_SESSION['is_designer'] = $_user['is_designer'];
                $_SESSION['is_shoper'] = $_user['is_shoper'];
            }
        }

        include $this->template('index');
    }

    public function doMobileAjax(){
        global $_W, $_GPC;

        $op = $_GPC['op'] ? trim($_GPC['op']) : 'index';
        $fun = $_GPC['fun'] ? trim($_GPC['fun']) : 'index';

        if(empty($_SESSION['user_id'])){
            $_user = get_cookie('user');
            if($_user){
                $_SESSION['user_id'] = $_user['user_id'];
                $_SESSION['username'] = $_user['username'];
                $_SESSION['headimg'] = $_user['headimg'];
                $_SESSION['is_designer'] = $_user['is_designer'];
                $_SESSION['is_shoper'] = $_user['is_shoper'];
            }
        }

        $file = APP_ROOT."{$op}/{$fun}.php";

        if(file_exists($file)){
            include $file;
        }else{
            die(json_encode(in_error(1, '接口不存在')));
        }
    }

    public function doWebAjax(){
        global $_W, $_GPC;

        $op = $_GPC['op'] ? trim($_GPC['op']) : 'index';
        $fun = $_GPC['fun'] ? trim($_GPC['fun']) : 'index';

        $file = WEB_ROOT."{$op}/{$fun}.php";

        if(file_exists($file)){
            include $file;
        }else{
            die(json_encode(in_error(1)));
        }
    }

    public function get_product_list($product_name = '', $page = 1, $size = 15){
        global $_W, $GPC;

        $where = 'WHERE uniacid=:uniacid ';
        $par[':uniacid'] = $_W['uniacid'];

        if($product_name){
            $where .= ' AND product_name LIKE :product_name';
            $par[':product_name'] = "%{$product_name}%";
        }

        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('jkj_products'). $where, $par);

        $sql = 'SELECT * FROM '.tablename('jkj_products'). $where . ' ORDER BY sort_by ASC, product_id DESC'.' LIMIT '.$size*($page-1).','.$size;
        $res['list'] = pdo_fetchall($sql, $par);

        $res['pager'] = pagination($total, $page, $size);

        return $res;
    }
}