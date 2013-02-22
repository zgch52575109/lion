<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('limit_operation');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='用户额度操作';

if($action=="save")
{
	if(trim($account)==''){
		ShowMsg("用户名或者ID不能为空","-1");
		exit();
}		
		$wherestr="username='$account'";
	$row = $dsql->GetOne("select * from ek_member where $wherestr ");
	if(!is_array($row)){
		ShowMsg("用户名或者ID不存在","-1");
		exit();
	}
	$uid=$row['uid'];
	$sender=$sender ? $sender : $row['truename'];
	$ctype='1';
	if(!is_numeric($amount)){
		ShowMsg("金额只能为大于0的数字！","-1");
		exit();
	}
	$zqcash=$row['money'];
	$tmount=getHGmoney($row['username'],$row['truename']);
		if($amount>$tmount){
			ShowMsg("转出金额不能大于可转额度！","-1");
			exit();
		}
		$status=zhuanchuHGmoeny($amount,$row['username'],$row['truename']);
		if($status=='0'){//成功
			//用户账户加钱
			$nowmount=getHGmoney($row['username'],$row['truename']);
			$upsql='';
			if($nowmount && $nowmount<>$row['touzhumoney']){
				$upsql=",touzhumoney='$nowmount'";
			}
			$dsql->ExecuteNoneQuery("update ek_member set `money`=money+$amount {$upsql} where uid=$uid");
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_game_log` (gameid,zhuanhuanly,zhuanhuanmb,uid,type,zqcash,zqedu,cash,state,note,addtime) VALUES ('1','游戏账户','本站账户','$uid','2','$zqcash','$tmount','$amount','1','成功','".time()."')");//转入转出记录
			$orderid=date('ymdHis').rand(1000,9999);
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$uid','8','$amount','".time()."')");//资金记录
			ShowMsg('转出额度成功！','admin_limit_operation.php',0,5000);
			exit();
		}
		ShowMsg('转出额度失败，错误代码：'.$status.'，您可以提供此代码给客服！','admin_limit_operation.php',0,5000);
		exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_limit_operation.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}