<?php
require_once(dirname(__FILE__)."/proxy/config.php");

$cacheid = "agent_on";
$t->assign('noticear',get_notice_list('1'));
if($cfg_proxy_allowreg=='0')
{
	ShowMsg('系统关闭了新用户注册！', 'index.html');
	exit();
}
if($cfg_cl->IsLogin())
{
	ShowMsg('你已经登陆系统，无需重新注册！', 'index.html');
	exit();
}
if(!isset($action))
{
	$action = '';
}

if($action=='save'){
	$svali = GetCkVdValue();
	if(strtolower($ValidateCode)!=$svali || $svali=='')
	{
		ResetVdValue();
		ShowMsg("验证码错误！","-1");
		exit();
	}
	$UserName = trim($UserName);
	$tel = trim($tel);
	$pwd = trim($Password);
	$pwdc = trim($cfPassWord);

	if(trim($UserName)==''){
		ShowMsg("用户名不能为空！","-1");
		exit();
	}
	if(trim($TrueName)==''){
		ShowMsg("真实姓名不能为空！","-1");
		exit();
	}
	if(trim($email)==''){
		ShowMsg("邮箱不能为空！","-1");
		exit();
	}
	if(trim($userTel)==''){
		ShowMsg("联系电话不能为空！","-1");
		exit();
	}
	if(!eregi("^[0-9-]",$userTel))
	{
		ShowMsg("联系电话格式不正确！","-1");
		exit();
	}

	$rs = Checkuid($UserName,'用户名');
	if($rs != 'ok')
	{
		ShowMsg($rs,"-1");
		exit();
	}
	elseif(strlen($email) > 50)
	{
		ShowMsg('ERROR：你的邮箱过长，不允许注册！','-1');
		exit();
	}
	elseif(strlen($UserName) < $cfg_mb_idmin || strlen($pwd) < $cfg_mb_pwdmin)
	{
		ShowMsg('ERROR：你的用户名或密码过短，不允许注册！','-1');
		exit();
	}
	elseif($pwdc != $pwd)
	{
		ShowMsg('ERROR：你两次输入的密码不一致，不允许注册！','-1');
		exit();
	}

	if(!eregi("^[0-9a-z][a-z0-9\.-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$",$email))
	{
		ShowMsg("Email格式不正确！","-1");
		exit();
	}
	if(strlen($TrueName)<3){
		ShowMsg("用户名长度不正确！","-1");
		exit();
	}
	//检测用户名是否存在
	$row = $dsql->GetOne("Select uid From `ek_proxy` where username like '$UserName' ");
	if(is_array($row))
	{
		ShowMsg("你指定的用户名 {$UserName} 已存在，请使用别的用户名！","-1");
		exit();
	}
	//检测邮箱是否存在
	$row = $dsql->GetOne("Select uid From `ek_proxy` where email like '$email' ");
	if(is_array($row))
	{
		ShowMsg("你指定的邮箱 {$email} 已存在，请使用别的邮箱！","-1");
		exit();
	}
	$fromid=0;
	$groupid=1;
	$formuser = addslashes(trim(dstripslashes($formuser)));
	if($formuser) {
		$row = $dsql->GetOne("Select uid,groupid From `ek_proxy` where username='$formuser'");
		if(is_array($row)){
			$fromid=$row['uid'];
			$groupid=$row['groupid']+1;
			$rowg = $dsql->GetOne("Select groupid From `ek_proxy_group` where groupid='$groupid'");
			if(!is_array($rowg)){
				$groupid=$row['groupid'];
			}
		}
	}
	$jointime = time();
	$logintime = time();
	$joinip = GetIP();
	$loginip = GetIP();
	$pwd = md5($Password);
	$dateline=time();
	//$groupid=1;
	$inQuery = "INSERT INTO `ek_proxy` (`username` ,`password` ,`truename` ,`email`,`phone`,`qq`,`groupid` ,
	 `topuid`,`jointime` ,`joinip` ,`logintime` ,`loginip`,`status`,`diqu`,`intro` )
   VALUES ('$UserName','$pwd','$TrueName','$email','$userTel','$qq','$groupid',
   '$fromid','$jointime','$joinip','$logintime','$loginip','1','$diqu','$intro'); ";
   if($dsql->ExecuteNoneQuery($inQuery)){
		$uid = $dsql->GetLastID();
		if($fromid){
			$insql="INSERT INTO `ek_proxy_tuiguang` (`uid` ,`touid`,dateline) VALUES ('$uid','$fromid','$dateline')";
			$dsql->ExecuteNoneQuery($insql);
			$dsql->ExecuteNoneQuery("update ek_proxy set xjnum=xjnum+1 where uid='$fromid'");
		}
		$ml = new MemberLogin(7*3600);
		$rs = $ml->CheckUser($UserName,$Password);
		ShowMsg("注册成功，3秒钟后转向系统主页...","proxy/index.php",0,2000);
		exit();
   }else{
		ShowMsg("注册失败，请检查资料是否有误或与管理员联系！","-1");
		exit();
   }
}

$t->display('agent_on.html',"$cacheid");
