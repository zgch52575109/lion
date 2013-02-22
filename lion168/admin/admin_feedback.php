<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('feedback_List');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='网站问题留言管理';

if($action=="save")
{
	if(trim($msg)==''){
		ShowMsg("留言内容不能为空！","-1");
		exit();
	}
	$mid=$cuserLogin->getUserID();
	if($remsg!=''){
		$upsql=",remsg='$remsg',ischeck='1',mid='$mid',retime='".time()."'";
	}
	$insql="update `ek_feedback` set msg='$msg' $upsql where id='$id'";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存问题留言！','admin_feedback.php',0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}
elseif($action=="edit")
{
	$query = "select * from ek_feedback where id='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取问题留言基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_feedback_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_feedback where id='$id'");
	ShowMsg("银行删除成功","admin_feedback.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_feedback where id in(".$ids.")");
	ShowMsg("数据删除成功","admin_feedback.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_feedback.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}