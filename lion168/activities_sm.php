<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "activities";
 
$t->assign('page_name','preferential');
$t->assign('noticear',get_notice_list('1'));

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/activities_sm.html',"$cacheid");