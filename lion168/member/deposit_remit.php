<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "deposit_remit";

$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;

if($action=='save'){
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	if($cash<$cfg_memeber_incash_min_money){
		ShowMsg("最小充值金额为：$cfg_memeber_incash_min_money元！","-1");
		exit();
	}
	if($cash>$cfg_memeber_incash_max_money){
		ShowMsg("最大充值金额为：$cfg_memeber_incash_max_money元！","-1");
		exit();
	}
	$row=$dsql->GetOne("SELECT * FROM `ek_receive_bank` where used='1' and id='$bankid'");
	if(!is_array($row)){
		ShowMsg("请选择正确的银行卡！","-1");
		exit();
	}
	if($cfg_memeber_incash_edit_sender){
		if(trim($sender)==''){
			ShowMsg("请填写汇款人姓名姓名！","-1");
			exit();
		}
		if(strlen($sender)>45){
			ShowMsg("汇款人姓名姓名过长！","-1");
			exit();
		}
	}else{
		$sender=$cfg_cl->fields['username'];
	}
	$otherbank=in_array($otherbank,array(0,1)) ? $otherbank : 0;
	$bank=$row['subject'];
	$orderid=date('ymdHis').rand(1000,9999);
	$hongli=$cash*$cfg_memeber_incash_hongli;
	if($hongli>$cfg_memeber_incash_maxhongli) $hongli=$cfg_memeber_incash_maxhongli;
	$shouxufei=$cash*$cfg_memeber_incash_shouxufei;
	if($shouxufei>$cfg_memeber_incash_maxshouxufei) $shouxufei=$cfg_memeber_incash_maxshouxufei;
	if($cfg_memeber_incash_check==1){
		$state=1;
		$check=0;
	}else{
		$state=4;
		$check=2;
	}
	$firsthongli=0;
	if(!$cfg_cl->fields['money'] && !$cfg_cl->fields['firstmoney']){
		$row=$dsql->GetOne("SELECT id FROM `ek_member_incash` where type='1'");
		if(!$row['id']){
			$firsthongli=$cash*$cfg_memeber_first_hongli;
			if($firsthongli>$cfg_memeber_first_maxhongli) $firsthongli=$cfg_memeber_first_maxhongli;
		}
	}
	$insql="INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,ctype,bank,cardnum,realname,otherbank,cash,hongli,shouxufei,firsthongli,state,`check`,addtime) VALUES ('$orderid','0','$cfg_cl->M_ID','1','1','$bank','$cardnum','$sender','$otherbank','$cash','$hongli','$shouxufei','$firsthongli','$state','$check','".time()."')";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功提交汇款信息，请等待管理员的审核！','deposit_remit.php',0,5000);
		exit();
	}
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
}

if($bankid){
	$rowc=$dsql->GetOne("SELECT * FROM `ek_receive_bank` where groupid='{$cfg_cl->fields[groupid]}' and used='1' and id='$bankid'");
}else{
	$rowc=$dsql->GetOne("SELECT * FROM `ek_receive_bank` where groupid='{$cfg_cl->fields[groupid]}' and used='1' order by torder asc,id desc");
}
$t->assign('rowc',$rowc);

$bankid=$rowc['id'];

$t->assign('bankid',$bankid);

$sql="select * from ek_receive_bank where groupid='{$cfg_cl->fields[groupid]}' and used='1' order by torder asc";
$rbankar=array();
$dsql->SetQuery($sql);
$dsql->Execute('al');
while($rowr=$dsql->GetArray('al'))
{
	$rbankar[]=$rowr;
}
global $Mer_key,$Mer_code,$Sponsored_Connectivity,$Mer_Amount_cash;
$MID=$cfg_cl->M_ID;
$Mer_Amount_cash=authcode($Mer_Amount_cash, 'ENCODE', 'IpsPay');
$MID=authcode($MID, 'ENCODE', 'IpsPay');
$MUserName=$cfg_cl->M_UserName;
$orderid=$MUserName."_".date('ymdHis').rand(1000,9999);
$orderid=authcode($orderid, 'ENCODE', 'IpsPay');
$Mer_code=authcode($Mer_code, 'ENCODE', 'IpsPay');
$Mer_key=authcode($Mer_key, 'ENCODE', 'IpsPay');
$t->assign('Mer_Amount_cash',$Mer_Amount_cash);
$t->assign('userID',$MID);
$t->assign('Mer_key',$Mer_key);//商户证书 
$t->assign('Mer_code',$Mer_code);//商户号
$t->assign('BillNo',$orderid);//商户订单号
$t->assign('Sponsored_Connectivity',$Sponsored_Connectivity);//支付网址
$t->assign('rbankar',$rbankar);
//$t->assign('rbankar',getReceiveBankLists());
$t->assign('isedit',$cfg_memeber_incash_edit_sender);
$t->assign('mincash',$cfg_memeber_incash_min_money);
$t->assign('maxcash',$cfg_memeber_incash_max_money);
$t->display('member/deposit_remit.html',"$cacheid");