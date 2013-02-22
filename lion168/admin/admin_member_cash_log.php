<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('cash_Log');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;

$pagetitle='资金记录';

if($action=="edit")
{
}else{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_cash_log.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}

function getcashtype($type){
	if($type=='1') return '银行汇款';
	if($type=='2') return '在线充值';
	if($type=='3') return '订单冲正';
	if($type=='4') return '订单冲负';
	if($type=='5') return '首存红利';
	if($type=='6') return '存款红利';
	if($type=='7') return '存款手续费';
	if($type=='8') return '转出额度';
	if($type=='9') return '转入额度';
	if($type=='10') return '取款';
	if($type=='11') return '反水奖励';
	if($type=='12') return '推广奖励';
	if($type=='13') return '后台会员冲正';
	if($type=='14') return '后台会员冲负';
	if($type=='15') return '其他奖励';
}