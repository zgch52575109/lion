<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Promotion');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='用户管理';

CheckPurview('member_List');

if($action=='view'){
	$query = "select * from ek_member where uid='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取推广用户基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_promotion_view.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}


include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member_promotion.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>