<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "friends_recommendation";
$t->assign('noticear',get_notice_list('1'));
if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('friends_recommendation.html',"$cacheid");