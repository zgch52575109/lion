<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Bank');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='银行卡类型管理';

if($action=="save")
{
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
	if(trim($sf)==''){
		ShowMsg("请选择省份！","-1");
		exit();
	}
	if(trim($city)==''){
		ShowMsg("请选择城市！","-1");
		exit();
	}
	if(!$bankid){
		ShowMsg("请选择开户行！","-1");
		exit();
	}
	if(trim($zhihang)==''){
		ShowMsg("请填写支行名称！","-1");
		exit();
	}
	if(strlen($cardnum)<15){
		ShowMsg("银行卡号码格式不对！","-1");
		exit();
	}
	if(trim($realname)==''){
		ShowMsg("请填写持卡人姓名！","-1");
		exit();
	}
	if(strlen($realname)>16){
		ShowMsg("持卡人姓名过长！","-1");
		exit();
	}
	//if (!preg_match("/^(?:\d{15}|\d{17}([0-9]|X))$/i", $idnumber)){
		//ShowMsg("身份证格式不正确！","-1");
		//exit();
	//}
	$dsql->ExecuteNoneQuery("update `ek_member_bank` set sf='$sf',city='$city',bankid='$bankid',zhihang='$zhihang',cardnum='$cardnum',realname='$realname',idnumber='$idnumber' where id='$id'");
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存银行卡信息！','admin_member_bank.php',0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}
elseif($action=="edit")
{
	$query = "select b.*,m.username from ek_member_bank b left join ek_member m on m.uid=b.uid where b.id='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取银行基本信息出错!","-1");
		exit();
	}
	$btype=getBankTypeLists();
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_bank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_member_bank where id='$id'");
	ShowMsg("银行删除成功","admin_member_bank.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_member_bank where id in(".$ids.")");
	ShowMsg("数据删除成功","admin_member_bank.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_bank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}