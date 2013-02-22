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

if($action=="save")
{
	/*echo "<br />=account".$account;//用户名或者ID:
	echo "<br />bankid=".$bankid;	//手动会员优惠发放:
	echo "<br />cash=".$cash;	//优惠金额:
	echo "<br />sender=".$sender;	//优惠人姓名*/
	
	if(trim($account)==''){
		ShowMsg("用户名或者ID不能为空","-1");
		exit();
	}
	if(trim($cash)==''){
		ShowMsg("金额不能为空","-1");
		exit();
	}

	$wherestr="username='$account'";

	$row = $dsql->GetOne("select * from ek_member where $wherestr ");
	if(!is_array($row)){
		ShowMsg("用户名不存在","-1");
		exit();
	}
	$uid=$row['uid'];
	$M_name=$row['truename'];
	//$M_money=$row['money']+$cash;

	$sender= $row['truename'];
	//手动会员优惠发放选项
	$type = isset($type) && is_numeric($type) ? $type : 0;
	$row=$dsql->GetOne("SELECT * FROM `ek_member_promotions` where uid='$type' and states=1" );
	if(!is_array($row)){
		ShowMsg("请选择正确的优惠发放选项！","-1");
		exit();
	}
	$promotions_id=$row['id'];
	$check=in_array($check,array(0,1)) ? $check : 0;
	/*if($check){
		$state=2;
		$check=2;
	}else{
		$state=2;
		$check=2;
	}*/
	if($check){
		$state=4;
		$check=2;
	}else{
		$state=1;
		$check=0;
	}
	$itime=isCurrentDay(time());
	//$Sql_u_m="update ek_member set money='$M_money' where $wherestr ";
	$orderid=date('ymdHis').rand(1000,9999);
	$note="$adminname,$pagetitle 提交,$itime";	
	$insql="INSERT INTO `ek_member_incash` (orderid,uid,type,promotions_id,hongli,realname,state,`check`,addtime,note,bank) VALUES ('$orderid','$uid','$type','$type','$cash','$M_name','$state','$check','".time()."','$note','用户钱包')";
	if($dsql->ExecuteNoneQuery($insql))
	{
		ShowMsg('成功提交优惠发放信息！','admin_member_promotions.php',0,5000);
		exit();
	}
	$note="$adminname,$pagetitle 失败,$itime";
	$insql="INSERT INTO `ek_member_incash` (orderid,uid,type,promotions_id,hongli,realname,state,`check`,addtime,note,bank) VALUES ('$orderid','$uid','$type','$type','$cash','$M_name','$state','$check','".time()."','$note','用户钱包')";
	$dsql->ExecuteNoneQuery($insql);
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();



}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_promotions.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}