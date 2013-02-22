<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('deposit_Cash');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='手动会员优惠发放';

$adminname=$cuserLogin->getUserName();


if($action=="add")
{

	if($number2==""){ShowMsg("请输入优惠类型编号","-1");		exit();}
	if($cash2==""){$cash2=0;}
	$row = $dsql->GetOne("select * from ek_member_promotions where uid='$number2' ");
	if(is_array($row)){ShowMsg("本类型编号以存在，请重新输入！！","-1");		exit();	}	
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	if(trim($account2)==''){
		ShowMsg("名称不能为空！","-1");
		exit();
	}
	
	

	
	$insql="INSERT INTO ek_member_promotions (uid,name,money,addtime) VALUES ('$number2','$account2',$cash2,'".time()."')";	
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存！','admin_member_promotions_add.php',0,5000);
		exit();
	}
	
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();




}elseif($action=="edit")
{
	$query = "select * from ek_member_promotions where id='$pid' ";
	$roww = $dsql->GetOne($query);
	if(!is_array($roww))
	{
		ShowMsg("读取基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_promotions_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="delet"){
	$insql="update `ek_member_promotions` set states='0' where id='$pid'";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功删除！','admin_member_promotions_add.php',0,5000);
		exit();
	}	
	ShowMsg('删除失败，请检查所填项目！','-1');
	exit();
}elseif($action=="addadd"){
	$insql="update `ek_member_promotions` set name='$account2',money='$cash2' where uid='$number2'";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功修改！','admin_member_promotions_add.php',0,5000);
		exit();
	}	
	ShowMsg('修改失败，请检查所填项目！','-1');
	exit();
}elseif($action=="dele"){
	$insql="update `ek_member_promotions` set states='1' where id='$pid'";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功恢复！','admin_member_promotions_add.php',0,5000);
		exit();
	}	
	ShowMsg('恢复失败，请检查所填项目！','-1');
	exit();}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_promotions_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}