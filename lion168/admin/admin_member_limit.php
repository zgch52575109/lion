<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Limit');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='手工额度处理';

if($action=="edit")
{
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_limit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}