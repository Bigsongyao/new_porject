<?php
/**
 * 摇一摇抽奖模块定义
 *
 * @author logoove
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Yoby_gameyaoModule extends WeModule {
	public $m_name = "yoby_gameyao";
	public $m_title="摇一摇抽奖";//默认标题
	public $m_game_title="摇一摇抽奖";//游戏后标题
	public $m_desc="摇一摇抽奖，快来参与吧！";//封面和游戏描述
	public $m_game_desc="摇一摇抽奖，快来参与吧！";
	public $m_play_desc="点击进入摇一摇抽奖界面,摇动手机,每天都可以参与.";
	
	public function fieldsFormDisplay($rid = 0) {
			global $_W;
		load()->func('tpl');
			if(!empty($rid)){
			$reply = pdo_fetch("SELECT * FROM ".tablename($this->m_name."_reply")." WHERE rid = :rid", array(':rid' => $rid));
			$reply['g_res'] = unserialize($reply['g_res']);//游戏资源
			
		}else{
			$reply = array(
				'start_time' => TIMESTAMP,
				'end_time' => TIMESTAMP+3600*24*30,
				'fm_title'=>$this->m_title,
				'fm_desc'=>$this->m_desc,
				'fm_img'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/avg.jpg",
				
				'share_title'=>$this->m_title,
				'share_game_title'=>$this->m_game_title,
				'share_desc'=>$this->m_desc,
				'share_game_desc'=>$this->m_game_desc,
				'share_img'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/icon.jpg",
				'share_url'=>'',
				'share_game_num'=>1,
				'share_prize_num'=>1,
				'is_chou'=>1,
				'g_music'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/js/1.mp3",
				'g_index_img'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/avg.jpg",
				'g_rule_img'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/avg.jpg",
				'g_rule_desc'=>"".$this->m_play_desc."",
				'g_bg_color'=>'#FF4500',
				'g_copyright'=>'陕ICP备15015437号-1',
				'g_isreg'=>0,//不自动注册
				'g_title'=>$this->m_title,//游戏标题
				'g_time'=>30,
				'g_play_num'=>0,//虚假人数
				'g_address'=>1,
				'g_res'=>array(
					't1'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/title_1.png",//游戏开始图
					't2'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/title_2.png",
					't3'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/title_3.png",
					't4'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/title_4.png",
					't5'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/title_5.png",
					't6'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/1.png",
					't7'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/2.png",
					't8'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/3.png",
					't9'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/4.png",
					't10'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/5.png",
					't11'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/6.png",
					't12'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/7.png",
					't13'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/8.png",
						't14'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/9.png",
						't15'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/10.png",					
						't16'=>$_W['siteroot']."addons/".$this->m_name."/template/mobile/images/22.png",					
										
				),
				
				'is_prize'=>1,//开启抽奖
				'prize_fen'=>10,//抽奖最低积分
				'prize_password'=>'123456',//抽奖密码
				'prize_max_num'=>100,//最多次数
				'prize_day_num'=>3,//每天最大次数
				
				'isok'=>1,
				'max_num'=>100,
				'day_num'=>30,
				
			);
			
		}
		
		include $this->template('form');		
		
		
		
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
	global $_GPC, $_W;
	load()->func('file');
	$id = intval($_GPC['reply_id']);
	//extract($_GPC);

	$g_res  = array(
		't2'=>$_GPC['t2'],
		't1'=>$_GPC['t1'],
		't3'=>$_GPC['t3'],
		't4'=>$_GPC['t4'],
		't5'=>$_GPC['t5'],
		't6'=>$_GPC['t6'],
		't7'=>$_GPC['t7'],
		't8'=>$_GPC['t8'],
		't9'=>$_GPC['t9'],
				't10'=>$_GPC['t10'],
						't11'=>$_GPC['t11'],
								't12'=>$_GPC['t12'],
										't13'=>$_GPC['t13'],
												't14'=>$_GPC['t14'],
														't15'=>$_GPC['t15'],
																't16'=>$_GPC['t16'],








		
	);
			$insert = array(
			'rid' => $rid,
			'weid'=>$_W['uniacid'],
			'start_time'=>strtotime($_GPC['htime']['start']),
			'end_time'=>strtotime($_GPC['htime']['end']),
			
			'fm_img' => $_GPC['fm_img'],
			'fm_title' => $_GPC['fm_title'],
			'fm_desc' => $_GPC['fm_desc'],

			'share_img' => $_GPC['share_img'],
			'share_title' => $_GPC['share_title'],
						'share_game_title' =>$_GPC['share_game_title'],
						
			'share_desc' => $_GPC['share_desc'],	
					'share_game_desc' => $_GPC['share_game_desc'],	
			'share_url' =>$_GPC['share_url'],
'is_chou'=>$_GPC['is_chou'],
			'share_prize_num' =>intval($_GPC['share_prize_num']),
			'share_game_num' =>intval($_GPC['share_game_num']),

			'g_music' =>$_GPC['g_music'],		
      'g_index_img'=>$_GPC['g_index_img'],
			'g_rule_img'=>$_GPC['g_rule_img'],
			'g_rule_desc' => htmlspecialchars_decode($_GPC['g_rule_desc']),
			'g_bg_color'=>$_GPC['g_bg_color'],
			'g_isreg'=>intval($_GPC['g_isreg']),
			'g_time'=>intval($_GPC['g_time']),
			'g_copyright' =>$_GPC['g_copyright'],
			'g_title' =>$_GPC['g_title'],		
			'g_play_num'=>intval($_GPC['g_play_num']),
			'g_res'=>serialize($g_res),
			'g_address'=>$_GPC['g_address'],
			
				'isok' =>intval($_GPC['isok']),
			'is_prize'=>(int)$_GPC['is_prize'],
			'prize_fen'=>(int)$_GPC['prize_fen'],
			'prize_password'=>$_GPC['prize_password'],
			'prize_max_num'=>(int)$_GPC['prize_max_num'],
			'prize_day_num'=>(int)$_GPC['prize_day_num'],
						
			'max_num' => intval($_GPC['max_num']),
			'day_num' => intval($_GPC['day_num']),
		
			
		);

		

		if (empty($id)) {
			pdo_insert($this->m_name."_reply", $insert);
		} else {
			pdo_update($this->m_name."_reply", $insert, array('id' => $id));
		}
		
	}

	public function ruleDeleted($rid) {
			$row = pdo_fetchall("SELECT id  FROM ".tablename($this->m_name."_reply")." WHERE rid = '$rid'");
		$deleteid = array();
		if (!empty($row)) {
			foreach ($row as $k => $v) {
				$deleteid[] = $v['id'];
			}
		}
		pdo_delete($this->m_name."_reply", "id IN ('".implode("','", $deleteid)."')");
		pdo_delete($this->m_name.'_fans',array('rid'=>$rid));
		pdo_delete($this->m_name.'_dayrank',array('rid'=>$rid));
		pdo_delete($this->m_name.'_award',array('rid'=>$rid));
		pdo_delete($this->m_name.'_award2',array('rid'=>$rid));
	}


}