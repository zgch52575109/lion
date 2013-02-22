<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_Laiyuan');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='网站来源管理';
if($action=="del"){
	$dsql->ExecuteNoneQuery("delete from ek_laiyuan where l_id='$id'");
	ShowMsg("银行删除成功","admin_laiyuan.php");
	exit();
}elseif($action=="delall")
{
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_laiyuan where l_id in(".$ids.")");
	ShowMsg("数据删除成功","admin_laiyuan.php");
	exit();
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_laiyuan.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}