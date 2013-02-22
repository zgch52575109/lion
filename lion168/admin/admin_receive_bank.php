<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('receive_Bank');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='收款银行卡管理';

if($action=="save")
{
	if(trim($subject)==''){
		ShowMsg("请填写名称！","-1");
		exit();
	}
	if(trim($image)==''){
		ShowMsg("请填写图片地址！","-1");
		exit();
	}
	if(trim($bank)==''){
		ShowMsg("请填写开户网点！","-1");
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
	$groupid = isset($groupid) && is_numeric($groupid) ? $groupid : 0;
	if(!$groupid){
		ShowMsg("请选择用户组！","-1");
		exit();
	}
	$used=in_array($used,array(0,1)) ? $used : 0;
	if(empty($torder)) 
	{
		$trow = $dsql->GetOne("select max(torder)+1 as dd from ek_receive_bank");
		$torder = $trow['dd'];
	}
	if (!is_numeric($torder)) $torder=1;
	if(!$id){
		$in_query = "insert into `ek_receive_bank`(groupid,subject,image,bank,cardnum,realname,used,torder) Values('$groupid','$subject','$image','$bank','$cardnum','$realname','$used','$torder')";
		if(!$dsql->ExecuteNoneQuery($in_query))
		{
			ShowMsg("添加银行卡失败，请检查您的输入是否存在问题！","-1");
			exit();
		}
		receive_bank_recache();
		ShowMsg("成功创建一个银行卡！","admin_receive_bank.php");
		exit();
	}else{
		$dsql->ExecuteNoneQuery("update ek_receive_bank set groupid='$groupid',subject='$subject',image='$image',bank='$bank',cardnum='$cardnum',realname='$realname',used='$used',torder='$torder' where id=".$id);
		receive_bank_recache();
		ShowMsg("更新成功！","admin_receive_bank.php");
		exit;
	}
}
elseif($action=="edit")
{
	$query = "select b.* from ek_receive_bank b where b.id='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取银行卡基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_receive_bank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_receive_bank where id='$id'");
	receive_bank_recache();
	ShowMsg("银行卡删除成功","admin_receive_bank.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_receive_bank where id in(".$ids.")");
	receive_bank_recache();
	ShowMsg("数据删除成功","admin_receive_bank.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_receive_bank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}