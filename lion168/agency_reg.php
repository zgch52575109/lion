<?php
require_once(dirname(__FILE__)."/config.php");
require_once(EK_INC.'/check.member.php');
$keeptime = isset($keeptime) && is_numeric($keeptime) ? $keeptime : -1;
$cfg_cl = new MemberLogin($keeptime);

$cacheid = "agency_reg";
$t->assign('page_name','agency');
$t->assign('noticear',get_notice_list('1'));
if($cfg_consumermb_allowreg=='0')
{
	ShowMsg('系统关闭了新用户注册！', 'index.php');
	exit();
}
if($cfg_cl->IsLogin())
{
	ShowMsg('你已经登陆系统，无需重新注册！', 'index.php');
	exit();
}
if(!isset($action))
{
	$action = '';
}








if($action=='check_username'){
	 //检测用户名是否存在
    $username = trim($UserName);
	if($username)
	{
	$row = $dsql->GetOne("Select uid From `ek_proxy` where username = '$username' ");
	if(is_array($row))
	   {
		echo "你指定的用户名 {$username} 已存在，请使用别的用户名！";
	   }
	else
	  {
		echo "你指定的用户名 {$username} 可以使用";
	  }
	}
 exit();
}
if($action=='check_email'){
    $email = trim($email);
 	if($email)
	{
	   $row = $dsql->GetOne("Select uid From `ek_proxy` where email = '$email' ");
	   if(is_array($row))
	     {
		   echo "你指定的邮箱地址$email 已存在，请使用别邮箱地址！";
	     }
	   else
	    {
		   echo "你指定的邮箱地址{$email} 可以使用";
	    }
	}
 
 exit();
}





if($action=='save'){
	$svali = GetCkVdValue();
	if(strtolower($ValidateCode)!=$svali || $svali=='')
	{
		ResetVdValue();
		ShowMsg("验证码错误！","-1");
		exit();
	}
	$username = trim($UserName);
	$tel = trim($tel);
	$pwd = trim($Password);
	$pwdc = trim($rePassword);

	if(trim($username)==''){
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
	$gender= in_array($gender,array(0,1)) ? $gender : 0;
	if(!eregi("^[0-9-]",$userTel))
	{
		ShowMsg("联系电话格式不正确！","-1");
		exit();
	}

	$rs = Checkuid($username,'用户名');
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
	elseif(strlen($username) < $cfg_mb_idmin || strlen($pwd) < $cfg_mb_pwdmin)
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
	$row = $dsql->GetOne("Select uid From `ek_proxy` where username = '$username' ");
	if(is_array($row))
	{
		ShowMsg("你指定的用户名 {$username} 已存在，请使用别的用户名！","-1");
		exit();
	}
	//检测邮箱是否存在
	$row = $dsql->GetOne("Select uid From `ek_proxy` where email = '$email' ");
	if(is_array($row))
	{
		ShowMsg("你指定的邮箱 {$email} 已存在，请使用别的邮箱！","-1");
		exit();
	} 
 
 
	$jointime = time();
	$logintime = time();
	$joinip = GetIP();
	$loginip = GetIP();
	$pwd = md5($Password);
	$dateline=time();
	
 

	$inQuery = "INSERT INTO `ek_proxy` (`username` ,`password` ,`truename`,`email`,`phone`,`qq`,`jointime` ,`joinip`,domainid) VALUES ('$username','$pwd','$TrueName','$email','$userTel','$qq','$jointime','$joinip','$username'); ";
 
	if($dsql->ExecuteNoneQuery($inQuery))
	{
     ShowMsg("注册成功，但是系统需要审核您的帐号信息，请等待管理的审核。","index.php",0,2000);
	 exit();
 
	}
	else 
	{
		ShowMsg("注册失败，请检查资料是否有误或与管理员联系！","-1");
		exit();
	}
}
 

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKusername'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/agency_reg.html',"$cacheid");
