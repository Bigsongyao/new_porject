<?php
/**
 * 摇一摇抽奖模块微站定义
 *
 * @author logoove
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Yoby_gameyaoModuleSite extends WeModuleSite {
	public function __construct(){
		global $_GPC, $_W;
		$this->m_name = "yoby_gameyao";
		$this->title = "摇一摇抽奖";
		$this->fans = $this->m_name."_fans";
		$this->award = $this->m_name."_award";
		$this->award2 = $this->m_name."_award2";
		$this->reply = $this->m_name."_reply";
		$this->dayrank = $this->m_name."_dayrank";
		$this->weid = $_W['uniacid'];
		$this->yobyurl =$_W['siteroot']."addons/".$this->m_name."/template/mobile/";
		$this->today = date('Y-m-d',time());
		load()->model('mc');
		$this->openid = $_W['openid'];
		 $rid= intval($_GPC['rid']);
		$isreg= pdo_fetchcolumn("select headimgurl from ".tablename($this->fans)."  where  rid=:rid and openid=:openid", array(':rid' =>$rid,':openid'=>$this->openid));
    
      if(empty($isreg) && !empty($this->openid)){
      	 $userinfo = mc_oauth_userinfo();
         	
				$nickname=addslashes($this->emojien($userinfo['nickname']));
	 			$headimgurl=$userinfo['avatar'];
	
	pdo_query("insert ignore into ".tablename($this->fans)."(rid,weid,openid,nickname,headimgurl) values($rid,".$this->weid.",'".$this->openid."','$nickname','$headimgurl')");
      }	
      if(!empty($this->openid)){
	  	  $is_share= pdo_fetch("select id from ".tablename($this->dayrank)."  where  rid=$rid and openid='".$this->openid."' and rectime='".$this->today."' ");//今天是否分享
         if(empty($is_share)){
		 	$data1 = array(
	'weid'=>$this->weid,
		'rid'=>$rid,
	'openid'=>$this->openid,
	'rectime'=>$this->today,
	);
	pdo_insert($this->dayrank,$data1);
	  }  
	  }
	$this->row = pdo_fetch("SELECT * FROM " . tablename($this->reply) . " WHERE rid = :rid", array(':rid' => $rid));//全局配置	
		}
   public function doMobileindex() {//游戏首页
        global $_GPC, $_W;
      
        $rid = intval($_GPC['rid']);
        
        $row = $this->row;
       $g_res = unserialize($row['g_res']);//游戏资源配置数组
       
      
      
		if (empty($rid)) {message('rid参数错误了！', '', 'error');}
    $this->isweixin();
    
    /*
     $lahei= pdo_fetch("select id from ".tablename($this->fans)."  where  rid=$rid and openid='".$this->openid."' and status=1 ");
   if(!empty($lahei)){//拉黑了
 die('<script type="text/javascript">alert("由于您活动作弊,现已禁止您参与,如有异议,请联系活动主办方!");document.addEventListener("WeixinJSBridgeReady", function onBridgeReady() {
WeixinJSBridge.call("closeWindow");
});</script>');
 }  
 */

        if($row['end_time'] < time())	{
		 die('<script type="text/javascript">alert("活动已结束!");location.href="'.$this->createMobileUrl('rank',array('rid'=>$rid)).'"
</script>');
	}
	  if($row['isok'] ==2)	{
		 die('<script type="text/javascript">alert("活动暂停中等待开启!");location.href="'.$this->createMobileUrl('rank',array('rid'=>$rid)).'"
</script>');
	}
     if($row['isok'] ==0)	{
		 die('<script type="text/javascript">alert("活动未开始或已经提前结束!");location.href="'.$this->createMobileUrl('rank',array('rid'=>$rid)).'"
</script>');
	}  	
     	 $day_num =  intval($row['prize_day_num']);//每天抽奖次数
     	 $max_num = intval($row['prize_max_num']);//总次数
     	 $share_prize_num = intval($row['share_prize_num']);//分享增加抽奖次数
     	    	 
      $today_prize_num = pdo_fetchcolumn("select day_prize_num from ".tablename($this->dayrank)."  where   openid='".$this->openid."'  and  rectime='".$this->today."'  and rid = '$rid' ");//查询当天抽奖次数
      
      $prize_num= pdo_fetchcolumn("select prize_num from ".tablename($this->fans)."  where  openid=:openid and rid=:rid ", array(':openid'=>$this->openid,':rid' => $rid));//记录已经抽奖次数
      
      if($prize_num<$max_num){//已抽奖小于总抽奖
      	
        if($today_prize_num<$day_num){
        	
        include $this->template('index');
        
        }else{
			 die('<script>alert("今天'.$day_num.'次抽奖机会已经用完了!");location.href="'.$this->createMobileUrl('rank',array('rid'=>$rid)).'"</script>');
		}
      
      }else{
      die('<script>alert("总'.$max_num.'次抽奖机会已经用完了,不能再参加本次活动了!");location.href="'.$this->createMobileUrl('rank',array('rid'=>$rid)).'"</script>');   
      }

   
       
        }

    public function doMobileshare() {//分享增加机会
  global $_GPC, $_W;
        $rid = intval($_GPC['rid']); 
        
           $row= $this->row;

         $num = (int)$row['share_prize_num'];//分享增加抽奖次数
         $isshare= pdo_fetch("select id,isshare from ".tablename($this->dayrank)."  where  rid=$rid and openid='".$this->openid."' and rectime='".$this->today."' ");//今天是否分享
         $isshare_share = (int)$is_share['isshare'];
		 	if($isshare_share==1){
				echo 0;
			}else{
				 pdo_query("UPDATE ".tablename($this->dayrank)." SET isshare=1,day_prize_num=day_prize_num-$num WHERE id=".$isshare['id']);//改分享状态
         echo 1;
			}
		 
         
 
 }        
        public function doMobilerank() {//排名
        global $_GPC, $_W;

        $rid = intval($_GPC['rid']);
		
        $row = $this->row;
        $g_res = unserialize($row['g_res']);
        $fans = pdo_fetch("SELECT * FROM ".tablename($this->fans)." WHERE rid = '".$rid."' and openid='".$this->openid."' ");
          $today_prize_num = pdo_fetchcolumn("select day_prize_num from ".tablename($this->dayrank)."  where   openid='".$this->openid."'  and  rectime='".$this->today."'  and rid = '$rid' ");
      	$today_prize_num = ($today_prize_num<0)?"0":$today_prize_num;
       
        $tp_sql="select * from (SELECT @rank:=@rank+1 as rank,openid,rid,id FROM " . tablename($this->fans) . " where  rid=$rid and  openid is not null ORDER BY max_fen DESC,id asc) as A where rid=$rid  and openid='".$this->openid."'";
         $s1="set @rank=0";
         pdo_query($s1);
         $rank = pdo_fetchcolumn($tp_sql);//自己排名
                 
        
        
        
        
         $s1="set @rank=0";
         pdo_query($s1);
      $list= pdo_fetchall("select *,@rank:=@rank+1 as rank from ".tablename($this->fans)."  where  rid=$rid  and  openid is not null order   by max_fen desc,id asc  limit 10");   
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->fans)."  where  rid=$rid  and  openid is not null");	
$n = ($row['g_play_num']==0)?$total:$row['g_play_num'];//虚假人数

$psize =10;
		$totalpage = ceil($total/$psize);//总页数
		
			$prize_num = (int)$row['is_daynum'];//每天最多抽奖次数
			$isnum = (int)$rs_share['isnum'];
			$prize_num = $prize_num-$isnum;//剩余抽奖次数
			$prize_num = ($prize_num<0)?0:$prize_num;
		
		
		
    include $this->template('rank');    
        }       	
	public function doMobileyao(){//摇奖
		global $_W,$_GPC;		
		$rid = (int)$_GPC['rid'];
	
	
	 	
	 	 $row = $this->row;
	 			$chou = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->award2)." WHERE rid = '".$rid."' and openid='".$this->openid."' ");//已中奖次数
	 			
	 	$chounum = pdo_fetch("SELECT prize_num FROM ".tablename($this->fans)." WHERE rid = '".$rid."' and openid='".$this->openid."' ");//已抽奖次数
	 		$chounum1 = (int)$chounum['prize_num'];//已抽奖次数
	 		
	 	$zongnum = (int)$row['prize_max_num'];//抽奖总次数
	 	$daynum = (int)$row['prize_day_num'];//每天抽奖次数
	 		$is_chou = (int)$row['is_chou'];//最多中奖次数
	 		
	 		
	 		$isnumrs = pdo_fetch("SELECT id,day_prize_num FROM ".tablename($this->dayrank)." WHERE rid = '".$rid."' and openid='".$this->openid."' and rectime='".$this->today."'");
			
		$isnum = (int)$isnumrs['day_prize_num'];//今天已经抽奖次数
		$ids = (int)$isnumrs['id'];
		$nn = $daynum-$isum;
	 	if($chounum1<$zongnum){
			if($isnum<$daynum){
		 pdo_query("UPDATE ".tablename($this->fans)." SET prize_num=prize_num+1 where  rid=$rid and openid='".$this->openid."'");//抽奖次数+1
		 
		 pdo_query("UPDATE ".tablename($this->dayrank)." SET day_prize_num=day_prize_num+1 WHERE id=".$ids);//使用摇奖一次机会
		 
		$list= pdo_fetchall("SELECT *  FROM ".tablename($this->award) ." where weid=".$this->weid." and rid=$rid");
		if(!empty($list)){
			$arr_prize = array();
			$gailv = 0;
			foreach($list as $v){
				if($v['num']>0){//奖品没有了就不参与			
				$arr_prize[] = array(
				'id'=>$v['id'],
				'prize'=>$v['title'],
				'rate'=>$v['gailv'],
				);
				}
				$gailv+=$v['gailv'];
			}
			$gailv = 1000-$gailv;
			$arr_prize[] = array(
			'id'=>0,
			'prize'=>'下次也许会中奖哦',
			'rate'=>$gailv,
			);
			foreach ($arr_prize as $index => $value) {
			$arr[$index] = $value['rate'];
		}
		unset($index);		
		$total = array_sum($arr);
		$index = $this->get_rand($arr);
		$data = $arr_prize[$index];
		$data['rate'] = $data['rate'] / $total;	
		
		if($data['id']!=0){
			if($is_chou==0){
			
			$zid = (int)$data['id'];//奖品id
			
			pdo_query("UPDATE ".tablename($this->award)." SET num=num-1,shownum=shownum-1 WHERE id=".$zid);//奖品数量减一
			
			$rs = pdo_fetch("SELECT *  FROM ".tablename($this->award) ." where id=$zid");
			$sn=$this->sn();
			$data = array(
				'weid'=>$this->weid,
				'rid'=>$rid,
				'createtime'=>time(),
				'title'=>$rs['title'],
				'dengji'=>$rs['dengji'],
				'img'=>$rs['img'],
				'isok'=>0,
				'sn'=>$sn,
				'openid'=>$this->openid,
			);
			pdo_insert($this->award2,$data);//插入中奖纪录
			
			$json = array(
			"done"=>"true",
			"jpimg"=>tomedia($rs['img']),
			'jpdengji'=>$rs['dengji'],
			'jpname'=>$rs['title'],
			'sncode'=>$sn,
			"cjjh"=>"今天有".$nn."次抽奖机会",
			);
			}else{//限制中奖次数
			
			
			if($chou<$is_chou){
			
			
					$zid = (int)$data['id'];//奖品id
			
			pdo_query("UPDATE ".tablename($this->award)." SET num=num-1,shownum=shownum-1 WHERE id=".$zid);//奖品数量减一
			
			$rs = pdo_fetch("SELECT *  FROM ".tablename($this->award) ." where id=$zid");
			$sn=$this->sn();
			$data = array(
				'weid'=>$this->weid,
				'rid'=>$rid,
				'createtime'=>time(),
				'title'=>$rs['title'],
				'dengji'=>$rs['dengji'],
				'img'=>$rs['img'],
				'isok'=>0,
				'sn'=>$sn,
				'openid'=>$this->openid,
			);
			pdo_insert($this->award2,$data);//插入中奖纪录
			
			$json = array(
			"done"=>"true",
			"jpimg"=>tomedia($rs['img']),
			'jpdengji'=>$rs['dengji'],
			'jpname'=>$rs['title'],
			'sncode'=>$sn,
			"cjjh"=>"今天有".$nn."次抽奖机会",
			);
			
			
			}else{
				$json = array(
			"done"=>"false",
			"jpimg"=>'',
			'jpdengji'=>'',
			'jpname'=>'',
			'sncode'=>'',
			'msg'=>'没有中奖哦,继续努力!',
			'flag'=>0,
			"cjjh"=>"今天有".$nn."次抽奖机会",
			);
			
			
			
			}
			
			}
			
			
			
			
		}else{
					$json = array(
			"done"=>"false",
			"jpimg"=>'',
			'jpdengji'=>'',
			'jpname'=>'',
			'sncode'=>'',
			'msg'=>'没有中奖哦,继续努力!',
			'flag'=>0,
			"cjjh"=>"今天有".$nn."次抽奖机会",
			);
		}
		}
		
		//判断抽奖		
			}else{
				$json = array(
				"msg"=>"今天".$daynum."次抽奖机会已用完!",
				);
			}
		}else{
			$json = array(
				"msg"=>"总".$zongnum."次抽奖机会已用完!",
				);
		}
		
		
		echo json_encode($json);
		
		}
		        public function doMobilesavename() {//注册会员
        global $_GPC, $_W;
        $rid = intval($_GPC['rid']);    

 $title = trim($_GPC['title']);
 $mobile = trim($_GPC['mobile']);
 $address = trim($_GPC['address']);
  $row = pdo_fetch("select id,mobile from ".tablename($this->fans)."  where  rid=:rid and openid=:openid", array(':rid' => $rid,':openid'=>$this->openid)); 
    	if (empty($row['mobile'])) {
		$data = array(
	'title'=>$title,
	'mobile'=>$mobile,
	'address'=>$address,
	);
	pdo_update($this->fans,$data,array('id'=>$row['id']));
	echo json_encode(array(
		'done'=>'true'
		));
		}else{
		
		echo json_encode(array(
		'msg'=>'领奖信息已经存在啦'
		));	
		}
        } 
				public function doMobilePrizesn(){//兑奖
		global $_W,$_GPC;
		
		$rid = (int)$_GPC['rid'];
		$id = (int)$_GPC['wid'];//兑奖id
		$password = $_GPC['password'];//密码
		$ispassword = pdo_fetchcolumn("SELECT prize_password FROM " . tablename($this->reply) . " WHERE rid = :rid", array(':rid' => $rid));
		if($password==$ispassword){
			$item = pdo_fetch("SELECT * FROM ".tablename($this->award2)." where id=$id and  openid='".$this->openid."'");
		if(!empty($item)){
		pdo_query("UPDATE ".tablename($this->award2)." SET isok=1 WHERE id=".$id);	
		}
		$json = array(
		"done"=>"true",
		);
		}else{
			$json = array(
			"msg"=>"密码为空或不正确!",
			);
		}
		
		
		echo json_encode($json);
		
		}		
	public function doWebGl() {//管理
				global $_GPC, $_W;
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM ".tablename($this->reply)." WHERE weid = ".$this->weid." ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->reply) . " WHERE weid = ".$this->weid);
		$pager = pagination($total, $pindex, $psize);
		include $this->template('gl');
	

	}
public function doWebAward() {//添加奖品
			global $_GPC, $_W;

		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$rid = intval($_GPC['rid']);
			
		if('post' == $op){
			$id = intval($_GPC['id']);
			if(!empty($id)){
			$item = pdo_fetch("SELECT * FROM ".tablename($this->award)." where id=$id ");
			empty($item)?message('亲,数据不存在！', '', 'error'):"";	
			}
			
			
			if(checksubmit('submit')){
				empty ($_GPC['title'])?message('奖品名称不能为空'):$title =$_GPC['title'];
				empty ($_GPC['dengji'])?message('奖品不能为空'):$dengji =$_GPC['dengji'];
				$num =$_GPC['num'];
				$shownum =$_GPC['shownum'];
				empty ($_GPC['img'])?message('奖品图片不能为空'):$img =$_GPC['img'];
				$gailv =$_GPC['gailv'];
				$data = array(
				'weid'=>$this->weid,
				'rid'=>$rid,
				'title'=>$title,
				'dengji'=>$dengji,
				'num'=>$num,
				'shownum'=>$shownum,
				'img'=>$img,
				'gailv'=>$gailv,
				);
				
				if(empty($id)){
						pdo_insert($this->award,$data);
						message('添加成功！', $this->createWebUrl('award', array('op' => 'display','rid'=>$rid)), 'success');
				}else{
					unset($data['weid']);
						pdo_update($this->award, $data, array('id' => $id));
						message('更新成功！', $this->createWebUrl('award', array('op' => 'display','rid'=>$rid)), 'success');
				}
				
				
				
			}else{
				include $this->template('award');
			}
			
		}else if('del' == $op){//删除
		
		
			if(isset($_GPC['delete'])){
				$ids = implode(",",$_GPC['delete']);
				$sqls = "delete from  ".tablename($this->award)."  where id in(".$ids.")"; 
				pdo_query($sqls);
				message('删除成功！', referer(), 'success');
			}
			$id = intval($_GPC['id']);
			pdo_delete($this->award, array('id' => $id));
			message('删除成功！', referer(), 'success');
			
		}else if('display' == $op){//显示
			$pindex = max(1, intval($_GPC['page']));
			$psize =20;//每页显示
			
			$list = pdo_fetchall("SELECT *  FROM ".tablename($this->award) ." where weid=".$this->weid." and rid=$rid  ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize);//分页
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->award)." where weid=".$this->weid."  and rid=$rid " );
			$pager = pagination($total, $pindex, $psize);
			include $this->template('award');
		}

	
			
			}

public function doWebAward2() {//中奖数据
			global $_GPC, $_W;

		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$rid = intval($_GPC['rid']);
			
		if('post' == $op){
			$id = intval($_GPC['id']);
			if(!empty($id)){
			$item = pdo_fetch("SELECT * FROM ".tablename($this->award2)." where id=$id ");
			empty($item)?message('亲,数据不存在！', '', 'error'):"";	
			}
			
			
			if(checksubmit('submit')){
				empty ($_GPC['title'])?message('奖品名称不能为空'):$title =$_GPC['title'];
				empty ($_GPC['dengji'])?message('奖品不能为空'):$dengji =$_GPC['dengji'];
				$sn =$_GPC['sn'];
				$img = $_GPC['img'];
				$sn = (empty($sn))?sn():$sn;
				$openid =$_GPC['openid'];
				$isok = $_GPC['isok'];
				$data = array(
				'weid'=>$this->weid,
				'rid'=>$rid,
				'title'=>$title,
				'dengji'=>$dengji,
				'sn'=>$sn,
				'openid'=>$openid,
				'img'=>$img,
				'createtime'=>time(),
				'isok'=>$isok,
				);
				
				if(empty($id)){
						pdo_insert($this->award2,$data);
						message('添加成功！', $this->createWebUrl('award2', array('op' => 'display','rid'=>$rid)), 'success');
				}else{
					unset($data['weid'],$data['createtime']);
						pdo_update($this->award2, $data, array('id' => $id));
						message('更新成功！', $this->createWebUrl('award2', array('op' => 'display','rid'=>$rid)), 'success');
				}
				
				
				
			}else{
				include $this->template('award2');
			}
			
		}else if('del' == $op){//删除
		
		
			if(isset($_GPC['delete'])){
				$ids = implode(",",$_GPC['delete']);
				$sqls = "delete from  ".tablename($this->award2)."  where id in(".$ids.")"; 
				pdo_query($sqls);
				message('删除成功！', referer(), 'success');
			}
			$id = intval($_GPC['id']);
			pdo_delete($this->award2, array('id' => $id));
			message('删除成功！', referer(), 'success');
			
		}else if('display' == $op){//显示
			$pindex = max(1, intval($_GPC['page']));
			$psize =20;//每页显示
			$condition = '';
		if (!empty($_GPC['keyword'])) {
				$condition .= " AND  sn  LIKE '%".$_GPC['keyword']."%'  ";
			}
			$sql = "select A.id,A.createtime,A.title,A.dengji,A.isok,A.sn,B.title as xm,B.mobile,B.address from ".tablename($this->award2) ." as A,".tablename($this->fans) ." as B where  A.openid=B.openid and A.rid=$rid and A.weid=".$this->weid."  $condition ORDER BY A.id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
			$list = pdo_fetchall($sql);//分页
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM  '.tablename($this->award2) .' as A,'.tablename($this->fans) ." as B where  A.openid=B.openid and A.rid=$rid   and A.weid=".$this->weid.$condition);
			$pager = pagination($total, $pindex, $psize);
			include $this->template('award2');
		}

	
			
			}			
public function doWebDaodata2(){//中奖数据
		global $_W,$_GPC;
		
		$rid = intval($_GPC['rid']);
	$sql = "select A.id,A.createtime,A.title,A.dengji,A.isok,A.sn,B.title as xm,B.mobile,B.address from ".tablename($this->award2) ." as A,".tablename($this->fans) ." as B where  A.openid=B.openid and A.rid=$rid and A.weid=".$this->weid."   ORDER BY A.id DESC LIMIT 0,1000";
	$list = pdo_fetchall($sql);
$export_str="姓名,手机,地址,奖品,等级,状态,SN,时间\n";
    foreach($list as $v){
				 
				  $xm = $v['xm'];
				  $address = $v['address'];
				  $mobile = $v['mobile'];
				  $title = $v['title'];
				  $dengji= $v['dengji'];
				  $isok = ($v['isok']==1)?"已领取":"未领取";
				  $sn = $v['sn'];
				  $createtime =date('Y-m-d h:i:s',$v['createtime']);
     $export_str.="$xm,=\"$mobile\",$address,$title,$dengji,$isok,=\"$sn\",=\"$createtime\""."\n";
      }
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$this->title."中奖名单.csv");

 
   //$export_str= mb_convert_encoding($export_str, "gb2312",'auto');
  echo  "\xEF\xBB\xBF".$export_str;
	}	

private function isweixin(){
	if(!$this->is_weixin() ){die('<script type="text/javascript">alert("调皮,怎么在电脑上打开呢!");</script>');}
}
private function hidetel($phone){
    $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i',$phone); 
    if($IsWhat == 1){
        return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i','$1****$2',$phone);
    }else{
        return  preg_replace('/(1[3587]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
    }
}
private function sn(){
	return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}
private function is_weixin() {
	$agent = $_SERVER ['HTTP_USER_AGENT'];
	if (! strpos ( $agent, "icroMessenger" )) {
		return false;
	}
	return true;
}
 private function emojien($str){
    if(!is_string($str))return $str;
    if(!$str || $str=='undefined')return '';

    $text = json_encode($str);
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); 
    return json_decode($text);
}
//显示解码
private function emojide($str){
    $text = json_encode($str);
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text);
    return json_decode($text);
}
/**
* 
* @param 数组 $proArr
* 
* @return 概率
*/
private function get_rand($proArr) { 
    $result = '';  
    $proSum = array_sum($proArr);   
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 		
    } 
    unset ($proArr);  
    return $result; 
}
}