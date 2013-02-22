<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "ranking_list";
$t->assign('noticear',get_notice_list('1'));

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('ranking_list.html',"$cacheid");