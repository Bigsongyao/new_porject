<?php
/**
 * 极客家网上预约系统模块定义
 *
 * @author О⒈㈢
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class We7_jkjModule extends WeModule {

    public function welcomeDisplay($menus = array()) {
        //这里来展示DIY管理界面
        include $this->template('welcome');
    }

}