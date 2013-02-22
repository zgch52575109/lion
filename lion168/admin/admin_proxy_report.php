<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('proxy_report');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$type=in_array($type,array(1,2)) ? $type : 1;

$pagetitle='现金系统';
$rand=$cuserLogin->getUserRank();
$mid=$cuserLogin->getUserID();
$adminname=$cuserLogin->getUserName();
$timestr=time();

if($action=="check")
{
	if($id){};
}else{
	CheckPurview('proxy_report');
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_peroxy_report.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}