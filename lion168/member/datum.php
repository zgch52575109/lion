<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "index";

$rowu=$dsql->GetOne("SELECT * FROM `ek_member` where uid='$cfg_cl->M_ID'");

if($action=='save'){
	if(trim($truename)==''){
		ShowMsg("真实姓名不能为空！","-1");
		exit();
	}
	if(trim($email)==''){
		ShowMsg("邮箱不能为空！","-1");
		exit();
	}
	if(trim($phone)==''){
		ShowMsg("联系电话不能为空！","-1");
		exit();
	}
	if(!eregi("^[0-9-]",$phone))
	{
		ShowMsg("联系电话格式不正确！","-1");
		exit();
	}
	if(!eregi("^[0-9a-z][a-z0-9\.-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$",$email))
	{
		ShowMsg("Email格式不正确！","-1");
		exit();
	}
	//检测邮箱是否存在
	$row = $dsql->GetOne("Select uid From `ek_member` where email like '$email' and uid<>'$cfg_cl->M_ID' ");
	$dateline=time();

	$query1 = "UPDATE `ek_member` SET email='$email',phone='$phone',qq='$qq' where uid='".$cfg_cl->M_ID."' ";
	if($dsql->ExecuteNoneQuery($query1)){
		if($email<>'' && $email<>$rowu['email']){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_email` (`uid`,email,dateline)VALUES ('$cfg_cl->M_ID','$email','$dateline')");
		}
		if($qq<>'' && $qq<>$rowu['qq']){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_qq` (`uid`,qq,dateline)VALUES ('$cfg_cl->M_ID','$qq','$dateline')");
		}
		if($phone<>'' && $phone<>$rowu['phone']){
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_phone` (`uid`,phone,dateline)VALUES ('$cfg_cl->M_ID','$phone','$dateline')");
		}
		ShowMsg('成功保存资料！','datum.php',0,5000);
		exit();
	}
	ShowMsg('保存资料失败！','-1');
	exit();
}

$t->assign($rowu);



$t->display('member/member.html',"$cacheid");