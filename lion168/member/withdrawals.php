<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "withwithdrawalss";

$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;

if($cfg_cl->fields['dayoutcashnum']>0){
	$dayoutcashnum=$cfg_cl->fields['dayoutcashnum'];
}else{
	$dayoutcashnum=$groupdb['dayoutcashnum'];
}
if($cfg_cl->fields['maxoutmoney']>0){
	$maxoutmoney=$cfg_cl->fields['maxoutmoney'];
}else{
	$maxoutmoney=$groupdb['maxoutmoney'];
}
if($cfg_cl->fields['checkoutmoney']>0){
	$checkoutmoney=$cfg_cl->fields['checkoutmoney'];
}else{
	$checkoutmoney=$groupdb['checkoutmoney'];
}

if($action=='save'){
	$rowc=$dsql->GetOne("SELECT id from ek_member_bank where uid='$cfg_cl->M_ID' and id='$bankid'");
	if(!$rowc['id']){
		ShowMsg("没有绑定银行卡！","-1");
		exit();
	}
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	if($cash<$cfg_memeber_incash_min_money){
		ShowMsg("最小提款金额为：$cfg_memeber_outcash_min_money元！","-1");
		exit();
	}
	if($cash>$maxoutmoney){
		ShowMsg("最大提款金额为：$maxoutmoney元！","-1");
		exit();
	}
	if($cash<=0){
		ShowMsg("输入金额不能小于0！","-1");
		exit();
	}
	//检查当日提款次数是否受限
	if($dayoutcashnum){
		$row = $dsql->GetOne("Select count(*) as dd From `ek_member_incash` where uid='$cfg_cl->M_ID' and type='2' and TO_DAYS(addtime)=TO_DAYS(NOW())");
		if(is_array($row)){
			if($row['dd']>=$dayoutcashnum){
				ShowMsg("今天提款次数已满，请联系客服升级权限！","withdrawals.php");
				exit;
			}
		}
	}

	if($cfg_cl->fields['ifhongli']){//申请红利
		$rowu=$dsql->GetOne("SELECT * FROM `ek_member_firsthongli` where uid='$cfg_cl->M_ID'");
		$firsthongli=$rowu['hongli'];
		$firstcash=$rowu['cash'];
		$rowa = $dsql->GetOne("Select SUM(cash) as dd From `ek_member_incash` where uid='$cfg_cl->M_ID' and state='2'");
		$row = $dsql->GetOne("Select SUM(cash) as dd From `ek_game_log` where uid='$cfg_cl->M_ID' and type='1' and state='1' and addtime>'$lastcashtime'");
		if(is_array($row)){
			if($row['dd']<(($firsthongli+$firstcash)*$cfg_memeber_outcash_x+($rowa['dd']-$firstcash)*$cfg_memeber_outcash_y)){
				ShowMsg($cfg_memeber_outcash_noallow_str2,"withdrawals.php");
				exit;
			}
		}else{
			ShowMsg("您还没有存款，请存款后再申请！","withdrawals.php");
			exit;
		}
	}else{
		//检查从上次提现时间到现在的投注额度
		$lastcashtime=$cfg_cl->fields['outcashtime'];
		$row = $dsql->GetOne("Select SUM(cash) as dd From `ek_game_log` where uid='$cfg_cl->M_ID' and type='1' and state='1' and addtime>'$lastcashtime'");
		if(is_array($row)){
			if($row['dd']<($cfg_cl->M_Money*$cfg_memeber_outcash_j)){
				ShowMsg($cfg_memeber_outcash_noallow_str,"withdrawals.php");
				exit;
			}
		}else{
			ShowMsg("您还没有投注过，请投注后再提款！","withdrawals.php");
			exit;
		}
	}
	$row = $dsql->GetOne("Select amountlock,money From `ek_member` where uid='$cfg_cl->M_ID'");
	if(is_array($row)){
		$amountlock=$row[amountlock];
		if($amountlock!=1){
			$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=1 where uid='$cfg_cl->M_ID'");
	$bank='';
	$orderid=date('ymdHis').rand(1000,9999);
	$moneys=$row[money];
	$moneys=$moneys-$cash;
	if($moneys>=0){
	$insql="INSERT INTO `ek_member_incash` (orderid,bankid,uid,type,bank,cash,state,addtime) VALUES ('$orderid','$bankid','$cfg_cl->M_ID','2','$bank','$cash','1','".time()."')";
	if($dsql->ExecuteNoneQuery($insql)){
		$dsql->ExecuteNoneQuery("update ek_member set `money`=money-$cash where uid='$cfg_cl->M_ID'");
		if($cash>=$checkoutmoney){
		$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=0 where uid='$cfg_cl->M_ID'");
			ShowMsg($cfg_memeber_outcash_checkout_str,'withdrawals.php',0,5000);
		}else{
			ShowMsg('成功提交提款信息，请等待管理员的审核！','withdrawals.php',0,5000);
		$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=0 where uid='$cfg_cl->M_ID'");
		}
		exit();
	}
		$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=0 where uid='$cfg_cl->M_ID'");
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
	}else{
		$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=0 where uid='$cfg_cl->M_ID'");
		ShowMsg('提交失败，请不要试图重复恶意提单！','-1');
	exit();
}
	}else{
		$dsql->ExecuteNoneQuery("update ek_member set `amountlock`=0 where uid='$cfg_cl->M_ID'");
		ShowMsg('提交失败，请不要试图重复恶意提单！','-1');
	exit();
}
}
}
$sqlStr="select b.*,tp.tname,tp.intro from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$cfg_cl->M_ID' order by b.addtime desc";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$datas[]=$row;
}

$t->assign('datas',$datas);
$t->assign('bankid',$bankid);

if($bankid){
	$rowc=$dsql->GetOne("SELECT b.*,tp.tname from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$cfg_cl->M_ID' and b.id='$bankid'");
}else{
	$rowc=$dsql->GetOne("SELECT b.*,tp.tname from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$cfg_cl->M_ID' order by b.addtime desc");
}
$t->assign('rowc',$rowc);

$t->assign('mincash',$cfg_memeber_incash_min_money);
$t->assign('maxcash',$maxoutmoney);
$t->assign('dayoutcashnum',$dayoutcashnum);

$t->display('member/withdrawals.html',"$cacheid");