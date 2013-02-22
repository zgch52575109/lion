<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_popularize');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='网站推广管理';

if($action=="save")
{
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	if(trim($pname)==''){
		ShowMsg("名称不能为空！","-1");
		exit();
	}
	if(trim($phttp)==''){
		ShowMsg("推广ID不能为空！","-1");
		exit();
	}
	if(trim($purl)==''){
		ShowMsg("推广ID不能为空！","-1");
		exit();
	}
	if($id){
		$insql="update `popularize` set pname='$pname',phttp='$phttp',purl='$purl'where id='$id'";
	}else{
		$insql="insert into `popularize`(pname,phttp,purl) values ('$pname','$phttp','$purl')";
	}
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存！','admin_popularize.php',0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}
elseif($action=="add")
{
	CheckPurview('admin_popularize');
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_popularize_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}
elseif($action=="edit")
{
	$query = "select * from popularize where id='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_popularize_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from popularize where id='$id'");
	ShowMsg("删除成功","admin_popularize.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from popularize where id in(".$ids.")");
	ShowMsg("数据删除成功","admin_popularize.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_popularize.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}