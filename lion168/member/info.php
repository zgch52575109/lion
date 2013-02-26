<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "index";







$rowu=$dsql->GetOne("SELECT * FROM `ek_member_firsthongli` where uid='$cfg_cl->M_ID'");
if(!is_array($rowu)){
		$weicun=1;
}
if($rowu['lingqutime']){
	$rowu['lingqutime']=MyDate('Y-m-d H:i:s',$rowu['lingqutime']);
	$hongli_Status = 1;
}else{
	$rowu['lingqutime']='还没有领取，请立即领取';
	$hongli_Status = 0;
}
$hongli=$rowu['hongli'];

if($action=='save'){
	if($weicun){
			ShowMsg("请在存款后再领取红利！","-1");
			exit();
	}
	if($rowu['state']==1){
		ShowMsg('您已经领取过红利了！','-1');
		exit();
	}
$row=$dsql->GetOne("SELECT state FROM `ek_member_incash` where uid='$cfg_cl->M_ID'and type=2 and state=2");
	if($row['state']==2){
		ShowMsg('您已经取过款，不能在领取首存红利！','-1');
		exit();
	}
	$orderid=date('ymdHis').rand(1000,9999);
	
	$dsql->ExecuteNoneQuery("update ek_member set money=money+$hongli,ifhongli='1' where uid='$cfg_cl->M_ID'");
	$dsql->ExecuteNoneQuery("update ek_member_firsthongli set `state`='1',`lingqutime`='".time()."' where uid='$cfg_cl->M_ID'");
	$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','5','$hongli','".time()."')");//资金记录
	$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,bank,hongli,state,addtime,`check`,operation) VALUES ('$orderid','0','$cfg_cl->M_ID','5','','$hongli','2','".time()."','2','2')");//资金记录
	ShowMsg('领取成功！','info.php');
	exit();
}

$t->assign($rowu);

$t->assign('hongli_Status',$hongli_Status);
$t->display('member/info.html',"$cacheid");