<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('withdrawals_Cash');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='手工提交取款单';

if($action=="save")
{
	if(trim($account)==''){
		ShowMsg("用户名或者ID不能为空","-1");
		exit();
	}
	if(is_numeric($account)){
		$wherestr="uid='$account'";
	}else{
		$wherestr="username='$account'";
	}
	$row = $dsql->GetOne("select * from ek_member where $wherestr ");
	if(!is_array($row)){
		ShowMsg("用户名或者ID不存在","-1");
		exit();
	}
	$uid=$row['uid'];
	$mcash=$row['money'];
	if($mcash<$cash){
		ShowMsg("提款金额不能大于{$mcash}元！","-1");
		exit();
	}
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	$bank='';
	$orderid=date('ymdHis').rand(1000,9999);
	$check=in_array($check,array(0,1)) ? $check : 0;
	if($check){
		$state=4;
		$check=2;
	}else{
		$state=1;
		$check=0;
	}
	$insql="INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,bank,cash,state,`check`,addtime) VALUES ('$orderid','$bankid','$uid','2','$bank','$cash','$state','$check','".time()."')";
	if($dsql->ExecuteNoneQuery($insql)){
				$dsql->ExecuteNoneQuery("update ek_member set `money`=money-$cash where uid='$uid'");

		ShowMsg('成功提交提款信息！','admin_withdrawals.php',0,5000);
		exit();
	}
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_withdrawals.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}