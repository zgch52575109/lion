<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('bank_Type');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='银行卡类型管理';

if($action=="save")
{
	if(empty($torder)) 
	{
		$trow = $dsql->GetOne("select max(torder)+1 as dd from ek_bank_type");
		$torder = $trow['dd'];
	}
	if (!is_numeric($torder)) $torder=1;
	if(!$id){
		$in_query = "insert into `ek_bank_type`(tname,intro,torder) Values('$tname','$intro','$torder')";
		if(!$dsql->ExecuteNoneQuery($in_query))
		{
			ShowMsg("添加银行失败，请检查您的输入是否存在问题！","-1");
			exit();
		}
		bank_type_recache();
		ShowMsg("成功创建一个银行！","admin_bank_type.php");
		exit();
	}else{
		$dsql->ExecuteNoneQuery("update ek_bank_type set tname='$tname',intro='$intro',torder='$torder' where tid=".$id);
		ShowMsg("更新成功！","admin_bank_type.php");
		exit;
	}
}
elseif($action=="edit")
{
	$query = "select * from ek_bank_type where tid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取银行基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_bank_type.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_bank_type where tid='$id'");
	bank_type_recache();
	ShowMsg("银行删除成功","admin_bank_type.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_bank_type.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}