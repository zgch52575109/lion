<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('deposit_Cash');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='手工提交存款单';

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
	$sender=$sender ? $sender : $row['truename'];
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	$row=$dsql->GetOne("SELECT * FROM `ek_receive_bank` where used='1' and id='$bankid'");
	if(!is_array($row)){
		ShowMsg("请选择正确的银行卡！","-1");
		exit();
	}
	$check=in_array($check,array(0,1)) ? $check : 0;
	if($check){
		$state=4;
		$check=2;
	}else{
		$state=1;
		$check=0;
	}
	$otherbank=in_array($otherbank,array(0,1)) ? $otherbank : 0;
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	$bank=$row['subject'];
	$orderid=date('ymdHis').rand(1000,9999);
	$hongli=$cash*$cfg_memeber_incash_hongli;
	if($hongli>$cfg_memeber_incash_maxhongli) $hongli=$cfg_memeber_incash_maxhongli;
	$shouxufei=$cash*$cfg_memeber_incash_shouxufei;
	if($shouxufei>$cfg_memeber_incash_maxshouxufei) $shouxufei=$cfg_memeber_incash_maxshouxufei;
	$insql="INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,ctype,bank,cardnum,realname,otherbank,cash,hongli,shouxufei,state,`check`,addtime) VALUES ('$orderid','$bankid','$uid','1','1','$bank','$cardnum','$sender','$otherbank','$cash','$hongli','$shouxufei','$state','$check','".time()."')";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功提交汇款信息！','admin_member_incash.php',0,5000);
		exit();
	}
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_deposit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}