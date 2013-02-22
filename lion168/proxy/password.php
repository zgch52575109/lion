<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "password";

$rowu=$dsql->GetOne("SELECT * FROM `ek_proxy` where uid='$cfg_cl->M_ID'");
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
 $t->assign('cashmoney',$rs['sumcash']);

if($action=='save'){
	$oldpwd = trim($password3);
	$pwd = trim($password2);
	$pwdc = trim($password1);
	if(!is_array($rowu) || $rowu['password'] != md5($oldpwd))
	{
		ShowMsg('你输入的旧密码错误或没填写，不允许修改！','-1');
		exit();
	}
	if(strlen($pwd) < $cfg_mb_pwdmin)
	{
		ShowMsg('ERROR：你的新密码过短！','-1');
		exit();
	}
	elseif($pwdc != $pwd)
	{
		ShowMsg('ERROR：你两次输入的密码不一致！','-1');
		exit();
	}
	$upwd = md5($password2);
	$dateline=time();

	

	$query1 = "UPDATE `ek_proxy` SET password='$upwd' where uid='".$cfg_cl->M_ID."' ";
	if($dsql->ExecuteNoneQuery($query1)){
		$dsql->ExecuteNoneQuery("INSERT INTO `ek_proxy_history_password` (`uid`,`password`,dateline)VALUES ('$cfg_cl->M_ID','$upwd','$dateline')");
		ShowMsg('成功修改密码！','password.php',0,5000);
		exit();
	}
	ShowMsg('修改密码失败！','-1');
	exit();
}

$t->assign($rowu);

$t->display('agent/password.html',"$cacheid");