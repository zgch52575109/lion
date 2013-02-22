<?php
require_once(dirname(__FILE__)."/config.php");
require_once(EK_INC.'/check.member.php');
$keeptime = isset($keeptime) && is_numeric($keeptime) ? $keeptime : -1;
$cfg_cl = new MemberLogin($keeptime);
$cacheid = "login";

$username = $_REQUEST['UserName'];
$password = $_REQUEST['userpassword'];
$action = $_REQUEST['action'];
 
if($action=='login')
{
	$svali = GetCkVdValue();
/*	if(strtolower($ValidateCode)!=$svali || $svali=='')
	{
		ResetVdValue();
		echo "<script language=javascript>alert('验证码输入错误！');document.location.reload();</script>";
		exit;
	}	*/
	
   // $rs = $cfg_cl->CheckUser($username,$password);
	
	//if ($rs > 0 )
	//{
		echo "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td height=\"50\" align=\"center\" width=\"100%\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		echo "<tr><td height=24  align=\"center\">欢迎:$username 登陆!<a href=\"#\" onClick=\"JavaScript:window.open('','new','toolbar=no,menubar=no,titlebar=no,resizable=yes,location=no,status=no');\"><img src=\"images/jinru2.jpg\" width=\"92\" height=\"20\" border=\"0\" /></a><a href= target=\"_blank\"><img src=\"images/jinru3.jpg\" width=\"92\" height=\"20\" style=\"margin-left:10px;\" /></a>&nbsp;<a href=\"Logout.html\"  onclick=\"return //confirm('您确实要重新登陆吗？')\" ><font color=\"red\"><b>重新登陆</b></font></a>";
		
		echo " </td></tr></table></td></tr></table>";
		exit();
/*    }
   else
    {
	   echo "<script language=javascript>alert('用户名密码错误！');document.location.reload();</script>";
	   exit;
	}	*/
	

}

 if($action=='check_login')
 {
   if(GetCookie('EKuid')!='')
   {      $login_name = GetCookie('EKUserName');
	   	echo "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td height=\"50\" align=\"center\" width=\"100%\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		echo "<tr><td height=24  align=\"center\">欢迎: $login_name登陆!<a href=\"#\" onClick=\"JavaScript:window.open('','new','toolbar=no,menubar=no,titlebar=no,resizable=yes,location=no,status=no');\"><img src=\"images/jinru2.jpg\" width=\"92\" height=\"20\" border=\"0\" /></a><a href= target=\"_blank\"><img src=\"images/jinru3.jpg\" width=\"92\" height=\"20\" style=\"margin-left:10px;\" /></a>&nbsp;<a href=\"Logout.html\"  onclick=\"return //confirm('您确实要重新登陆吗？')\" ><font color=\"red\"><b>重新登陆</b></font></a>";
		
		echo " </td></tr></table></td></tr></table>";
		exit(); 
	}
 
 }
 ?>