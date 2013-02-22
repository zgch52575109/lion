<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "game_demo";
$t->assign('noticear',get_notice_list('1'));
if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('game_demo.html',"$cacheid");