<?php
/**
 * 摇一摇抽奖模块处理程序
 *
 * @author logoove
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Yoby_gameyaoModuleProcessor extends WeModuleProcessor {
public function respond() {
 		global $_W;
       	 $rid = $this->rule;
        	$sql = "SELECT *  FROM " . tablename('yoby_gameyao_reply') . " WHERE `rid`=:rid LIMIT 1";
        $row = pdo_fetch($sql, array(':rid' => $rid));
	$now = time();	
	if($row['isok']==0){
	return $this->respText("活动未开始或已经提前结束,活动开始时间是:".date('Y-m-d H:i:s',$row['start_time']));
	}elseif($row['isok']==1){
	if ($row['start_time'] > $now) {
            return $this->respText("活动未开始,开始时间是:".date('Y-m-d H:i:s',$row['start_time'])."请耐心等待!");
        }
	if($row['end_time'] < $now)	{
		  return $this->respNews(array(
                        'Title' =>'活动结束啦',
                        'Description' => "活动已结束,下次早点来,点击查看排名!",
                        'PicUrl' => tomedia($row['fm_img']),
                        'Url' =>$this->createMobileUrl('rank', array('rid' => $rid)),
            ));
	}else{
		return $this->respNews(array(
                        'Title' => $row['fm_title'],
                        'Description' => $row['fm_desc'],
                        'PicUrl' => tomedia($row['fm_img']),
                        'Url' => $this->createMobileUrl('index', array('rid' => $rid)),
            ));
	}
		
	}elseif($row['isok']==2){
		return $this->respText("活动暂停中,请等待开启.");
	}
		}
}