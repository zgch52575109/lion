<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "preferential";
$t->assign('page_name',$cacheid);
$t->assign('noticear',get_notice_list('1'));

 
if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/preferential_fs.html',"$cacheid");