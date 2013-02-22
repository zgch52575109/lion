<?php
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='用户管理';

if($action=='save'){
	CheckPurview('member_Edit');
	$pwd = trim($password);
	$pwdc = trim($password2);
	if($pwd!=''){
		if(strlen($pwd) < $cfg_mb_pwdmin)
		{
			ShowMsg("你的密码过短，不允许使用！","-1");
			exit();
		}
		if($pwdc != $pwd)
		{
			ShowMsg('你两次输入的密码不一致！', '-1');
			exit();
		}
		$pwd = md5($password);
		$pwdsql=",password='$pwd'";
	}
	$groupid = isset($groupid) && is_numeric($groupid) ? $groupid : 1;
	$birthyear = isset($birthyear) && is_numeric($birthyear) ? $birthyear : 0;
	$birthmonth = isset($birthmonth) && is_numeric($birthmonth) ? $birthmonth : 0;
	$birthday = isset($birthday) && is_numeric($birthday) ? $birthday : 0;
	$bankmaxnum = isset($bankmaxnum) && is_numeric($bankmaxnum) ? $bankmaxnum : 0;
	$dayoutcashnum = isset($dayoutcashnum) && is_numeric($dayoutcashnum) ? $dayoutcashnum : 0;
	$maxoutmoney = isset($maxoutmoney) && is_numeric($maxoutmoney) ? $maxoutmoney : 0;
	$checkoutmoney = isset($checkoutmoney) && is_numeric($checkoutmoney) ? $checkoutmoney : 0;
	$updateSql = "groupid = '$groupid',truename = '$truename',phone = '$phone',email = '$email',qq = '$qq',gender = '$gender',birthyear = '$birthyear',birthmonth = '$birthmonth',birthday = '$birthday',bankmaxnum = '$bankmaxnum',dayoutcashnum = '$dayoutcashnum',maxoutmoney = '$maxoutmoney',checkoutmoney = '$checkoutmoney'";
	$updateSql = "update ek_member set ".$updateSql.$pwdsql." where uid=".$id;
	if(!$dsql->ExecuteNoneQuery($updateSql))
	{
		ShowMsg('更新用户信息出错，请检查',-1);
		exit();
	}else{
		ShowMsg('更新用户信息成功，返回',$back);
		exit();
	}
}elseif($action=='edit'){
	CheckPurview('member_Edit');
	$query = "select * from ek_member where uid='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取用户基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_edit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=='view'){
	CheckPurview('member_List');
	$query = "select m.*, mb.*,bt.tname,p.username as pusm,n.todayLiveGameExcludeEvenandTieAmount,n.todayStakeAmount,g.grouptitle,g.bankmaxnum as gbankmaxnum,g.dayoutcashnum as gdayoutcashnum,g.maxoutmoney as gmaxoutmoney,g.checkoutmoney as gcheckoutmoney from ek_member m left join ek_member_group g on g.groupid=m.groupid left join ek_proxy p on m.proxyid=p.uid left join ek_now_live_game_bet n on n.uid=m.uid left join ek_member_bank mb on mb.uid=m.uid left join ek_bank_type bt on bt.tid=mb.bankid where m.uid='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取用户基本信息出错!","-1");
		exit();
	}
	$rowl = $dsql->GetOne("Select sum(LiveGameExcludeEvenandTieAmount) as LiveGameExcludeEvenandTieAmount,sum(StakedAmount) as StakedAmount From `ek_live_game_bet` where uid='$id'");
	$StakedAmount=$rowl['StakedAmount']+$row['todayStakeAmount'];
	$LiveGameExcludeEvenandTieAmount=$rowl['LiveGameExcludeEvenandTieAmount']+$rowl['todayLiveGameExcludeEvenandTieAmount'];
$row['bankinfo']=$row['sf'].$row['city'].$row['tname'].$row['zhihang'].','.$row['cardnum'].','.$row['realname'];
	$row['gamemoney']=getHGmoney($row['username'],$row['truename']);
	if($row['bankmaxnum']==0) $row['bankmaxnum']=$row['gbankmaxnum'];
	if($row['dayoutcashnum']==0) $row['dayoutcashnum']=$row['gdayoutcashnum'];
	if($row['maxoutmoney']==0) $row['maxoutmoney']=$row['gmaxoutmoney'];
	if($row['checkoutmoney']==0) $row['checkoutmoney']=$row['gcheckoutmoney'];
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_view.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=='check'){
	CheckPurview('member_Check');
	$dsql->ExecuteNoneQuery("update ek_member set status='$status' where uid='$id'");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='delall'){
	CheckPurview('member_Del');
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_member where uid in(".$ids.")");
	$dsql->ExecuteNoneQuery("delete from ek_member_bank where uid in(".$ids.")");
	$dsql->ExecuteNoneQuery("delete from ek_member_incash where uid in(".$ids.")");
	$dsql->ExecuteNoneQuery("delete from ek_member_firsthongli where uid in(".$ids.")");
	$dsql->ExecuteNoneQuery("delete from ek_member_cash_log where uid in(".$ids.")");
	$dsql->ExecuteNoneQuery("delete from ek_game_log where uid in(".$ids.")");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='checkall'){
	CheckPurview('member_Check');
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("update ek_member set status='$status' where uid in(".$ids.")");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='czhengfuall'){
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
}elseif($action=='rank'){
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_rank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
		exit();
}

CheckPurview('member_List');
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>