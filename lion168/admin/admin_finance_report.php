<?php
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;

$pagetitle='财务管理';

if($action=='save'){
}else{
	CheckPurview('member_Incash');
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_finance_report.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}