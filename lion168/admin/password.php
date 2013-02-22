<?php
require_once(dirname(__FILE__)."/config.php");
$pagetitle='密码修改';

if($action=="save")
{
	if($pwd!=$pwd2)
	{
		ShowMsg("密码和确认密码不一样，请返回修改！","-1",0,3000);
		exit();
	}
	if($pwd!='')
	{
		$pwdm = ",pwd='".md5($pwd)."'";
		$pwd = "password='".substr(md5($pwd),5,20)."'";
	}

	if($id){
		$sql = "Update `ek_admin` set $pwd where id='$id'";
		$query=mysql_query($sql) or die(mysql_error());
if($query){
		ShowMsg('修改密码成功！','index.php',0,5000);
		exit();
		}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
	}
}
if($_GET[id]){
	$id=$_GET[id];
	$sql = "select * from ek_admin where id=$id";
	$query=mysql_query($sql) or die(mysql_error());
    $rs=mysql_fetch_array($query);
	if(!is_array($rs))
	{
		ShowMsg("读取基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/password.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
	}