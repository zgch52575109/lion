<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_member_popularize');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='推广统计';

CheckPurview('admin_member_popularize');

if($action=='view'){
	$query = "select * from record_sign where pname='$pname' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取推广渠道基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_popularize_view.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}


include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member_popularize.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>