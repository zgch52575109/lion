<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "agency";
$t->assign('page_name','agency');
$t->assign('noticear',get_notice_list('1'));

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/agency.html',"$cacheid");