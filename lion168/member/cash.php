<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "cash";
 
 
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
$t->display('member/cash.html',"$cacheid");