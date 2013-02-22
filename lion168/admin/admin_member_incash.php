<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Incash');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$type=in_array($type,array(1,2)) ? $type : 1;

$pagetitle='现金系统';
$rand=$cuserLogin->getUserRank();
$mid=$cuserLogin->getUserID();
$adminname=$cuserLogin->getUserName();
$timestr=time();

if($action=="check")
{
	if($rand<>1){
		ShowMsg("您不是审核员","-1");
		exit();
	}
	$row = $dsql->GetOne("select `check`,`state`,orderid,cash from ek_member_incash where id='$id'");
	if(is_array($row)){
		if($row['check']){
			ShowMsg("已经审核过",$back);
			exit();
		}
		if($row['state']>1){
			//if($row['state']!=2){
				ShowMsg("已经处理",$back);
				exit;
			//}
		}
		$cash=$row['cash'];
		$istoday=0;
		

		$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
		if($rowm['singleamount']<$cash){
			ShowMsg("单次操作额度超过限制",$back);
			exit;
		}
		if($rowm['last_operation_time']){
			$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
			if($last_operation_time<>MyDate('Y-m-d',$timestr)){
				$istoday=1;
			}else{
				if(($rowm['todayamount']+$cash)>$rowm['amount']){
					ShowMsg("今日操作额度已满",$back);
					exit;
				}
			}
		}
		$checknote=$adminname.',审核通过,'.MyDate('Y-m-d H:i:s',$timestr);

		if($dsql->ExecuteNoneQuery("update ek_member_incash set `check`='2',`note`='$checknote',state='4' where id='$id'")){
			$orderid=$row['orderid'];
			$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`addtime`) values ('$mid','$orderid','$type','2','$cash','','$timestr')";
			if($dsql->ExecuteNoneQuery($sql)){
				if($istoday){
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`='$cash',last_operation_time='$timestr' where id='$mid'");
				}else{
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$cash,last_operation_time='$timestr' where id='$mid'");
				}
				ShowMsg("处理成功",$back);
				exit();
			}
		}
	}
	ShowMsg("系统错误","-1");
	exit();
}
elseif($action=="operation")
{
	if($rand<>2){
		ShowMsg("您不是操作员","-1");
		exit();
	}
	$row = $dsql->GetOne("select `check`,`state`,orderid,cash,`operation`,uid,note,shouxufei,hongli,ctype from ek_member_incash where id='$id'");
	if(is_array($row)){
		if($row['operation']){
			ShowMsg("已经操作过",$back);
			exit();
		}
		if($row['state']>1){
			if($row['state']!='4'){
			ShowMsg("已经处理",$back);
			exit;
			}
		}
		if($row['check']==1){
			ShowMsg("只能拒绝",$back);
			exit;
		}
		$cash=$row['cash'];
		$uid=$row['uid'];
		$checknote=$row['note'];
		$shouxufei=$row['shouxufei'];
		$hongli=$row['hongli'];
		$ctype=$row['ctype'];
		$istoday=0;
		

		$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
		if($rowm['singleamount']<$cash){
			ShowMsg("单次操作额度超过限制",$back);
			exit;
		}
		if($rowm['last_operation_time']){
			$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
			if($last_operation_time<>MyDate('Y-m-d',$timestr)){
				$istoday=1;
			}else{
				if(($rowm['todayamount']+$cash)>$rowm['amount']){
					ShowMsg("今日操作额度已满",$back);
					exit;
				}
			}
		}
		$checknote=$checknote.'<br>'.$adminname.',操作通过,'.MyDate('Y-m-d H:i:s',$timestr);
		$upsql='';
		if($type==1){
			$upsql=",incash='$cash'";
		}elseif($type==2){
			$upsql=",outcash='$cash'";
		}
		if($dsql->ExecuteNoneQuery("update ek_member_incash set `operation`='2',`note`='$checknote' where id='$id'")){
			$orderid=$row['orderid'];
			$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`addtime`) values ('$mid','$orderid','$type','4','$cash','','$timestr')";
			if($dsql->ExecuteNoneQuery($sql)){
				$dsql->ExecuteNoneQuery("update ek_member_incash set `state`=2{$upsql} where id='$id'");
				if($type==1){
					$rowin = $dsql->GetOne("Select weekincash,lastincashtime From `ek_member` where uid='$uid' ");
					$weekincash=0;
					if(is_array($rowin)){
						$weekincash = (date('YW', $rowin['lastincashtime']) == date('YW', time())) ? ($rowin['weekincash'] + $cash) : $cash;
					}
					$upsql="";
					if($weekincash){
						$upsql=",weekincash='$weekincash',lastincashtime='".time()."'";
					}
					$dsql->ExecuteNoneQuery("update ek_member set `money`=money+$cash+$shouxufei+$hongli,`allmoney`=allmoney+$cash,allhongli=allhongli+$hongli,allshouxufei=allshouxufei+$shouxufei{$upsql} where uid='$uid'");
					$rowm = $dsql->GetOne("select `id` from ek_member_firsthongli where uid='$uid'");
					if(!$rowm['id']){
						$firsthongli=$cash*$cfg_memeber_first_hongli;
						if($firsthongli>$cfg_memeber_first_maxhongli) $firsthongli=$cfg_memeber_first_maxhongli;
						$dsql->ExecuteNoneQuery("insert into ek_member_firsthongli(`uid`,`orderid`,`cash`,hongli) values ('$uid','$orderid','$cash','$firsthongli')");
						$date_time=time();
						$dsql->ExecuteNoneQuery("update ek_member set `firstmoney`='$cash',`fmtime`='$date_time' where uid='$uid'");
					}
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$uid','$ctype','$cash','".time()."')");//资金记录
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$uid','6','$hongli','".time()."')");//资金记录-红利
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$uid','7','$shouxufei','".time()."')");//资金记录-手续费
				}elseif($type==2){
					//$dsql->ExecuteNoneQuery("update ek_member set `money`=money-$cash where uid='$uid'");
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$uid','10','$cash','".time()."')");//资金记录
				}
				
				if($istoday){
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=$cash,last_operation_time='$timestr' where id='$mid'");
				}else{
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$cash,last_operation_time='$timestr' where id='$mid'");
				}
				
				ShowMsg("操作成功",$back);
				exit();
			}
		}
	}
	//ShowMsg("系统错误","-1");
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
	include(EK_ADMIN.'/templets/admin_member_incash.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}