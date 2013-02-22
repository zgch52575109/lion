<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Group');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='用户组管理';

if($action=="save")
{
	$bankmaxnum = isset($bankmaxnum) && is_numeric($bankmaxnum) ? $bankmaxnum : 0;
	$cashhigher = isset($cashhigher) && is_numeric($cashhigher) ? $cashhigher : 0;
	$cashlower = isset($cashlower) && is_numeric($cashlower) ? $cashlower : 0;
	$creditshigher = isset($creditshigher) && is_numeric($creditshigher) ? $creditshigher : 0;
	$creditslower = isset($creditslower) && is_numeric($creditslower) ? $creditslower : 0;
	$fanshui = isset($fanshui) && is_numeric($fanshui) ? $fanshui : 0;
	if($cashlower<=$cashhigher){
		ShowMsg("存款金额区间上限要大于下限!","-1");
		exit();
	}
	if($creditslower<=$creditshigher){
		ShowMsg("投注金额区间上限要大于下限!","-1");
		exit();
	}
	if(!$id){
		$in_query = "insert into `ek_member_group`(grouptitle,bankmaxnum,dayoutcashnum,maxoutmoney,cashhigher,cashlower,creditshigher,creditslower,fanshui,maxfanshui,lastcashhigher,lastcreditshigher) Values('$grouptitle','$bankmaxnum','$dayoutcashnum','$maxoutmoney','$cashhigher','$cashlower','$creditshigher','$creditslower','$fanshui','$maxfanshui','$lastcashhigher','$lastcreditshigher')";
		if(!$dsql->ExecuteNoneQuery($in_query))
		{
			ShowMsg("添加用户组失败，请检查您的输入是否存在问题！","-1");
			exit();
		}
		write_group_cache();
		ShowMsg("成功创建一个用户组！","admin_member_group.php");
		exit();
	}else{
		$dsql->ExecuteNoneQuery("update ek_member_group set grouptitle='$grouptitle',bankmaxnum='$bankmaxnum',dayoutcashnum='$dayoutcashnum',maxoutmoney='$maxoutmoney',cashhigher='$cashhigher',cashlower='$cashlower',creditshigher='$creditshigher',creditslower='$creditslower',fanshui='$fanshui',maxfanshui='$maxfanshui' ,lastcashhigher='$lastcashhigher',lastcreditshigher='$lastcreditshigher' where groupid=".$id);
		write_group_cache();
		ShowMsg("更新成功！","admin_member_group.php");
		exit;
	}
}
elseif($action=="edit")
{
	$query = "select * from ek_member_group where groupid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取用户组基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_group.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	if($id==1){
		ShowMsg("注册用户组不可删除!","-1");
		exit();
	}
	$dsql->ExecuteNoneQuery("delete from ek_member_group where groupid='$id'");
	write_group_cache();
	ShowMsg("用户组删除成功","admin_member_group.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_group.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}