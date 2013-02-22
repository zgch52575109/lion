<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_member_popularize');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='代理级别管理';

if($action=="save")
{
	$bankmaxnum = isset($bankmaxnum) && is_numeric($bankmaxnum) ? $bankmaxnum : 0;
	if(!$id){
		$in_query = "insert into `ek_proxy_group`(grouptitle,fencheng) Values('$grouptitle','$fencheng')";
		if(!$dsql->ExecuteNoneQuery($in_query))
		{
			ShowMsg("添加代理级别失败，请检查您的输入是否存在问题！","-1");
			exit();
		}
		write_group_cache();
		ShowMsg("成功创建一个代理级别！","admin_proxy_group.php");
		exit();
	}else{
		$dsql->ExecuteNoneQuery("update ek_proxy_group set grouptitle='$grouptitle',fencheng='$fencheng' where groupid=".$id);
		write_group_cache();
		ShowMsg("更新成功！","admin_proxy_group.php");
		exit;
	}
}
elseif($action=="edit")
{
	$query = "select * from ek_proxy_group where groupid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取代理级别基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_group.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_proxy_group where groupid='$id'");
	write_group_cache();
	ShowMsg("代理级别删除成功","admin_proxy_group.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_group.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}