<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('preferential_List');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='网站优惠管理';

if($action=="save")
{
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	if(trim($l_title)==''){
		ShowMsg("标题不能为空！","-1");
		exit();
	}
	if(trim($l_body)==''){
		ShowMsg("内容不能为空！","-1");
		exit();
	}
	$mid=$cuserLogin->getUserID();
	if($l_expaddtime==''){
		$l_expaddtime=time+3600*24*30;
	}else{
		$l_expaddtime=strtotime($l_expaddtime);
	}
	if($id){
		$insql="update `ek_preferential` set l_title='$l_title',l_pic='$l_pic',l_expaddtime='$l_expaddtime',l_body='$l_body' where l_id='$id'";
	}else{
		$insql="insert into `ek_preferential`(l_title,l_pic,l_expaddtime,mid,l_body,l_addtime) values ('$l_title','$l_pic','$l_expaddtime','$mid','$l_body','".time()."')";
	}
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存优惠！','admin_preferential.php',0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}
elseif($action=="add")
{
	CheckPurview('preferential_Add');
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_preferential_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}
elseif($action=="edit")
{
	$query = "select * from ek_preferential where l_id='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取优惠基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_preferential_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_preferential where l_id='$id'");
	ShowMsg("银行删除成功","admin_preferential.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_preferential where l_id in(".$ids.")");
	ShowMsg("数据删除成功","admin_preferential.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_preferential.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}