<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "proxy_informtion";
$t->assign('noticear',get_notice_list('1'));
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");

 
 $rs1=$dsql->GetOne("select komisyon from `ek_proxy_member_thismonth` where proxyuid = $cfg_cl->M_ID");
 

$yongjin = $rs1['komisyon'] - $rs['sumcash'] ;
 $t->assign('yongjin',$yongjin);





 
if($cfg_consumermb_allowreg=='0')
{
	ShowMsg('系统关闭了新用户注册！', 'open.php');
	exit();
}

if(!isset($action))
{
	$action = '';
}

if($action=='save'){
 
	$UserName = trim($UserName);
	$tel = trim($tel);
	$pwd = trim($Password);
	$pwdc = trim($rePassword);

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
	$gender= in_array($gender,array(0,1)) ? $gender : 0;
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
	//if(Checkuid($TrueName,'')!='ok')
	//{
	//	ShowMsg("用户昵称或公司名称含有非法字符！","-1");
	//	exit();
	//}
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
	$row = $dsql->GetOne("Select uid From `ek_member` where username like '$UserName' ");
	if(is_array($row))
	{
		ShowMsg("你指定的用户名 {$UserName} 已存在，请使用别的用户名！","-1");
		exit();
	}
	//检测邮箱是否存在
	$row = $dsql->GetOne("Select uid From `ek_member` where email like '$email' ");
	if(is_array($row))
	{
		ShowMsg("你指定的邮箱 {$email} 已存在，请使用别的邮箱！","-1");
		exit();
	} 
 

 

	$formuser = addslashes(trim(dstripslashes($formuser)));
	if($formuser){
		$row = $dsql->GetOne("Select uid From `ek_proxy` where username='$formuser'");
		if(is_array($row)){
			$proxyuid=$row['uid'];
		}else{
			$proxyuid=0;
		}
	}

	$groupid = $cfg_newusergroupid;
	$status=$cfg_memeber_default_status;

	$jointime = time();
	$logintime = time();
	$joinip = GetIP();
	$loginip = GetIP();
	$pwd = md5($Password);
	$dateline=time();
	$secques=$safequestion > 0 ? quescrypt($safequestion, $safeanswer) : '';
	$inQuery = "INSERT INTO `ek_member` (`username` ,`password` ,`truename` ,`email`,`phone`,`qq`,`gender` ,`groupid` ,`birthyear`,`birthmonth` ,`birthday` ,
	 `topuid`,`proxyuid`,`secques` ,`jointime` ,`joinip` ,`logintime` ,`loginip`,`status` )
   VALUES ('$UserName','$pwd','$TrueName','$email','$userTel','$qq','$gender','$groupid','$Year','$Month','$Day',
   '$fromid','$proxyuid','$secques','$jointime','$joinip','$logintime','$loginip','$status'); ";
	if($dsql->ExecuteNoneQuery($inQuery))
	{
	$uid = $dsql->GetLastID();
	$sig_time=date("y-m-d h-i-s");
	session_start(); 
	$USER_ip=$_SESSION['USER_ip'];
	$W_http=$_SESSION['W_http'];
	$ON_time=$_SESSION['ON_time'];
	$pname=$_SESSION['pname'];
	 
    
     $W_http = $W_http."/?proxy=".$formuser;
	 
 
	$sql="insert into record_sign (`uid`,`uname`,`ip`,`signtime`,`http`,`ontime`,`pname`) values ('$uid','$UserName','$USER_ip','$sig_time','$W_http','$ON_time','$W_http')"; 
$dsql->ExecuteNoneQuery($sql);
 
		if($fromid){
			$insql="INSERT INTO `ek_member_tuiguang` (`uid` ,`touid`,dateline) VALUES ('$uid','$fromid','$dateline')";
			$dsql->ExecuteNoneQuery($insql);
			$dsql->ExecuteNoneQuery("update ek_member set tjnum=tjnum+1 where uid='$fromid'");
		}
		if($proxyuid!=''){
			$insql="INSERT INTO `ek_proxy_member` (`uid` ,`touid`,dateline,username) VALUES ('$uid','$proxyuid','$dateline','$UserName')";
			$dsql->ExecuteNoneQuery($insql);
			$dsql->ExecuteNoneQuery("update ek_proxy set tjnum=tjnum+1 where uid='$proxyuid'");
			$dsql->ExecuteNoneQuery("update ek_member set proxyid='$proxyuid' where uid='$uid'");
		}
		$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_password` (`uid`,`password`,dateline)VALUES ('$uid','$pwd','$dateline')");
		if($email<>''){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_email` (`uid`,email,dateline)VALUES ('$uid','$email','$dateline')");
		}
		if($qq<>''){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_qq` (`uid`,qq,dateline)VALUES ('$uid','$qq','$dateline')");
		}
		if($phone<>''){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_phone` (`uid`,phone,dateline)VALUES ('$uid','$phone','$dateline')");
		}
		if($truename<>''){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_truename` (`uid`,truename,dateline)VALUES ('$uid','$truename','$dateline')");
		}
 
			ShowMsg("开户成功...","open.php",0,2000);
			exit();
 
	}
	else 
	{
		ShowMsg("开户失败，请检查资料是否有误或与管理员联系！","-1");
		exit();
	}
}

$t->assign('groupname',$groupdb['grouptitle']);

$t->display('agent/open.html',"$cacheid");