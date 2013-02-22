<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_User');
if(empty($action))
{
	$action = '';
}

if($action=="add")
{
	if(ereg("[^0-9a-zA-Z_@!\.-]",$pwd) || ereg("[^0-9a-zA-Z_@!\.-]",$username) || ereg("[^0-9a-zA-Z_@!\.-]",$pwd2))
	{
		ShowMsg("密码或用户名不合法，<br />请使用[0-9a-zA-Z_@!.-]内的字符！","-1",0,3000);
		exit();
	}
	if($pwd!=$pwd2)
	{
		ShowMsg("密码和确认密码不一样，请返回修改！","-1",0,3000);
		exit();
	}
	$row = $dsql->GetOne("Select count(*) as dd from `ek_admin` where name like '$username' ");
	if($row['dd']>0)
	{
		ShowMsg('用户名已存在！','-1');
		exit();
	}
	$groupid = $groupid ? intval($groupid) : 1;
	$amount = $amount ? intval($amount) : 0;
	$mpwd = md5($pwd);
	$pwd = substr(md5($pwd),5,20);
	$inquery = "Insert Into `ek_admin`(password,name,groupid,singleamount,amount,state) values('$pwd','$username',$groupid,'$singleamount','$amount',1)";
	$dsql->ExecuteNoneQuery($inquery);
	ShowMsg('成功增加一个用户！','admin_webmaster.php');
	exit();
}
elseif($action=="save")
{
	$pwd = trim($pwd);
	$pwd2 = trim($pwd2);
	if(ereg("[^0-9a-zA-Z_@!\.-]",$pwd) || ereg("[^0-9a-zA-Z_@!\.-]",$username) || ereg("[^0-9a-zA-Z_@!\.-]",$pwd2))
	{
		ShowMsg("密码或用户名不合法，<br />请使用[0-9a-zA-Z_@!.-]内的字符！","-1",0,3000);
		exit();
	}
	if($pwd!=$pwd2)
	{
		ShowMsg("密码和确认密码不一样，请返回修改！","-1",0,3000);
		exit();
	}
	$pwdm = '';
	if($pwd!='')
	{
		$pwdm = ",pwd='".md5($pwd)."'";
		$pwd = ",password='".substr(md5($pwd),5,20)."'";
	}
	$groupid = $groupid ? intval($groupid) : 1;
	if($groupid>$cuserLogin->getgroupid()){
		ShowMsg("不能添加比自己权限高的用户！","-1",0,3000);
		exit();
	}
	$amount = $amount ? intval($amount) : 0;
	if($id!=1){
		$query = "Update `ek_admin` set name='$username',groupid='$groupid',singleamount='$singleamount',amount='$amount',state='$state' $pwd where id='$id'";
	}else{
		$query = "Update `ek_admin` set name='$username' $pwd where id='$id'";
	}
	
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功更改一个帐户！","admin_webmaster.php");
	exit();
}
elseif($action=="del")
{
	$rs = $dsql->ExecuteNoneQuery2("delete from `ek_admin` where id='$id' And id<>1 And id<>'".$cuserLogin->getUserID()."'");
	if($rs>0)
	{
		header("Location:admin_webmaster.php");
	}
	else
	{
		ShowMsg("不能删除id为1的创建人帐号，不能删除自己！","admin_webmaster.php",0,3000);
	}
	exit();
}
elseif($action=="delall")
{
	if(empty($e_id))
	{
		ShowMsg("请选择需要删除的链接","-1");
		exit();
	}
	$ids = implode(',',$e_id);
	$dsql->ExecuteNoneQuery("delete from `ek_admin` where id in ($ids) And id<>1 And id<>'".$cuserLogin->getUserID()."'");
	header("Location:admin_webmaster.php");
	exit();
}
elseif($action=="log"){
	$row = $dsql->GetOne("Select * From `ek_admin` where id='$id'");
	if(!is_array($row))
	{
		ShowMsg("读取用户错误","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_webmaster_log.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit;
}
else
{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_webmaster.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit;
}

function GetUserType($trank)
{
	global $adminRanks;
	if(isset($adminRanks[$trank]))
	{
		return $adminRanks[$trank];
	}
	else
	{
		return "错误类型";
	}
}

function getManagerState($s)
{
	if($s==1){
		return "激活";
	}else if($s==0){
		return "锁定";
	}else{
		return "未知";
	}
}
?>