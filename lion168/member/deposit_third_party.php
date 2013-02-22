<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "deposit_third_party";

if($action=='save'){
	$bank_id = isset($bank_id) && is_numeric($bank_id) ? $bank_id : 0;
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	if($cash<$cfg_memeber_incash_min_money){
		ShowMsg("最小充值金额为：$cfg_memeber_incash_min_money元！","-1");
		exit();
	}
	if($cash>$cfg_memeber_incash_max_money){
		ShowMsg("最大充值金额为：$cfg_memeber_incash_max_money元！","-1");
		exit();
	}
	$orderid=date('ymdHis').rand(1000,9999);
	$apier=$dsql->GetOne("SELECT * FROM ek_payment_config WHERE id = '$bank_id' AND used = '1' AND upid = '0'");
	if ($apier['id'] && file_exists(EK_ROOT.'/include/payment/'.$apier['folder'].'.php')){
		$apiidisplay = 0;
		$loops['api'] = $apier;
		$loops['conf'] = array();
		$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE upid = '$bank_id'");
		$dsql->Execute('config_list');
		while($row=$dsql->GetArray('config_list')){
			$loops['conf'][$row['confkey']] = $row['confval'];
		}
		require_once EK_ROOT.'/include/payment/'.$apier['folder'].'.php';
		$payment = new _wespace_apis_payment_($loops['conf']);
		$loops['apied'] = $payment->creater($apier['id'],$orderid,'存款在线充值',$cash);
		unset($payment);
	}
	$bank=$loops['api']['subject'];
	if($cfg_memeber_incash_check==1){
		$state=1;
		$check=0;
	}else{
		$state=4;
		$check=2;
	}
	
	$insql="INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,ctype,bank,cash,state,`check`,addtime) VALUES ('$orderid','$bank_id','$cfg_cl->M_ID','1','2','$bank','$cash','$state','$check','".time()."')";
	if($dsql->ExecuteNoneQuery($insql)){
		if ($loops['apied']['method_ispost']){
			echo '					<form name="wanepaymentid" action="'.$loops['apied']['paymentaction'].'" method="post">';
			echo $loops['apied']['paymentstring'];
			echo '						<input id="payment_payer_apied" name="payment_payer_apied" type="submit" value="立即付款" />';
			echo '					</form>';
			echo '<script>payment_payer_apied.submit();</script>正在转向支付页面，请稍候。。。';
		}else{
			header('Location:'.$loops['apied']['paymentstring']);
		}
		exit();
	}
	ShowMsg('提交失败，请检查联系管理员！','-1');
	exit();
}

$sqlStr="SELECT * FROM ek_payment_config WHERE used = '1' AND upid = '0'";
$dsql->SetQuery($sqlStr);
$dsql->Execute('config_list');
while($row=$dsql->GetArray('config_list'))
{
	$datas[]=$row;
}
$t->assign('datas',$datas);
unset($datas);

$t->assign('isedit',$cfg_memeber_incash_edit_sender);
$t->assign('mincash',$cfg_memeber_incash_min_money);
$t->assign('maxcash',$cfg_memeber_incash_max_money);
$t->display('member/deposit_third_party.html',"$cacheid");