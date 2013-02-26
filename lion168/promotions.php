<?php
require_once(dirname(__FILE__)."/config.php");
$cacheid = "index";
$t->assign('page_name',$cacheid);
if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}
$t->display('index/promotions.html',"$cacheid"); 