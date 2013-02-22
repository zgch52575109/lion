<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('proxy_deposit');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$pagetitle='手工添加代理取款单';
if($action=="save")
{
	if(trim($account)==''){
		ShowMsg("用户名不能为空","-1");
		exit();
}		
	$wherestr="username='$account'";
	$row = $dsql->GetOne("select * from ek_proxy where $wherestr ");
	if(!is_array($row)){
		ShowMsg("用户名不存在","-1");
		exit();
	}
	$uid=$row['uid'];
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	$now=date('Y-m-d h:i:s');
	$row = $dsql->GetOne("select * from ek_proxy where $wherestr ");
	$insql="INSERT INTO `proxy_cash` (cashmoney,proxyuid,addtime) VALUES ('$cash','$uid','$now')";//资金记录
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功提交汇款信息！','admin_proxy_deposit.php',0,5000);
		exit();
	}
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_deposit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}
