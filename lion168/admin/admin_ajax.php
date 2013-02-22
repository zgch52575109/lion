<?php
require_once(dirname(__FILE__)."/config.php");
AjaxHead();
if(empty($action))
{
	$action = '';
}
$id = empty($id) ? 0 : intval($id);
$type=in_array($type,array(1,2,3,4)) ? $type : 1;

$rand=$cuserLogin->getUserRank();
$mid=$cuserLogin->getUserID();
$adminname=$cuserLogin->getUserName();
$timestr=time();

if($action=="submitincashcheck")
{
	if($rand<>1){
		echo("您不是审核员");
		exit();
	}
	$row = $dsql->GetOne("select `check`,`state`,`orderid`,`cash`,addtime from ek_member_incash where id='$id'");
	if(is_array($row)){
		if($row['check']){
			echo '已审核过';
			exit;
		}
		if($row['state']>1){
			echo '已操作过';
			exit;
		}
		if(time()-$row['addtime']<$cfg_memeber_uncheck_time*60){
			echo '30分钟内不能拒绝';
			exit;
		}
		$cash=$row['cash'];
		$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
		if($rowm['singleamount']<$cash){
			echo '单次操作额度超过限制';
			exit;
		}
		if($rowm['last_operation_time']){
			$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
			if($last_operation_time<>MyDate('Y-m-d',$timestr)){
				$istoday=1;
			}else{
				if(($rowm['todayamount']+$cash)>$rowm['amount']){
					echo '额度已满';
					exit;
				}
			}
		}
		$checknote=$adminname.',审核拒绝,'.MyDate('Y-m-d H:i:s',$timestr).','.$xuanxiang;
		if($dsql->ExecuteNoneQuery("update ek_member_incash set `check`='1',`note`='$checknote',checkxuanxiang='$xuanxiang',state='4' where id='$id'")){
			$orderid=$row['orderid'];
			$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`checkxuanxiang`,`addtime`) values ('$mid','$orderid','$type','1','$cash','$note','$xuanxiang','$timestr')";
			if($dsql->ExecuteNoneQuery($sql)){
				if($istoday){
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`='$cash',last_operation_time='$timestr' where id='$mid'");
				}else{
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$cash,last_operation_time='$timestr' where id='$mid'");
				}
				echo '拒绝成功';
				exit;
			}else{
				$dsql->ExecuteNoneQuery("update ek_member_incash set `check`='0',`note`='',checkxuanxiang='',state='0' where id='$id'");
				echo '系统错误1';
				exit;
			}
		}else{
			echo '系统错误2';
			exit;
		}
	}
	echo '系统错误4';
	exit;
}elseif($action=="submitincashoperation"){
	if($rand<>2){
		echo("您不是操作员");
		exit();
	}
	//if($type==1){
		$row = $dsql->GetOne("select `check`,`state`,`orderid`,`cash`,`operation`,uid,note from ek_member_incash where id='$id'");
		if(is_array($row)){
			if($row['operation']){
				echo '已操作过';
				exit;
			}
			if($row['state']>1){
				if($row['state']!=4){
				echo '已操作过';
				exit;
				}
			}
			$cash=$row['cash'];
			$uid=$row['uid'];
			$checknote=$row['note'];
			$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
			if($rowm['singleamount']<$cash){
				echo '单次操作额度超过限制';
				exit;
			}
			if($rowm['last_operation_time']){
				$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
				if($last_operation_time<>MyDate('Y-m-d',$timestr)){
					$istoday=1;
				}else{
					if(($rowm['todayamount']+$cash)>$rowm['amount']){
						echo '额度已满';
						exit;
					}
				}
			}
			$checknote=$checknote.'<br>'.$adminname.',操作拒绝,'.MyDate('Y-m-d H:i:s',$timestr).','.$xuanxiang;
			if($dsql->ExecuteNoneQuery("update ek_member_incash set `operation`='1',`note`='$checknote',`operationxuanxiang`='$xuanxiang' where id='$id'")){
				$orderid=$row['orderid'];
				$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`checkxuanxiang`,`addtime`) values ('$mid','$orderid','$type','3','$cash','$note','$xuanxiang','$timestr')";
				if($dsql->ExecuteNoneQuery($sql)){
					if($istoday){
						$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=$cash,last_operation_time='$timestr' where id='$mid'");
					}else{
						$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$cash,last_operation_time='$timestr' where id='$mid'");
					}
					$dsql->ExecuteNoneQuery("update ek_member_incash set `state`=3 where id='$id'");
					if($type==2){
						$dsql->ExecuteNoneQuery("update ek_member set `money`=money+$cash where uid='$uid'");
					}
					echo '操作成功';
					exit;
				}else{
					$dsql->ExecuteNoneQuery("update ek_member_incash set `check`='0' where id='$id'");
					echo '系统错误1';
					exit;
				}
			}else{
				echo '系统错误2';
				exit;
			}
		}
	//}
	echo '系统错误4';
	exit;
}elseif($action=="submitInCashdecline"){

			$checknote=$xuanxiang.'<br>'.$adminname.',操作拒绝,'.Date('Y-m-d H:i:s');
			$now=date('Y-m-d H:i:s');
			if($dsql->ExecuteNoneQuery("update proxy_cash set `outcash`='2',`remark`='$checknote',`addtime`='$now' where id='$id'")){
				echo("已操作");
				exit();
				}
}elseif($action=="submitincashczhengfu"){
	if($rand<>2){
		echo("您不是操作员");
		exit();
	}
	$jine = empty($jine) ? 0 : intval($jine);
	if($jine==0){
		echo("请输入金额");
		exit();
	}
	$row = $dsql->GetOne("select `czhengfu`,`state`,`orderid`,`cash`,uid,note from ek_member_incash where id='$id'");
	if(is_array($row)){
		if($row['state']<2){
			echo '订单未处理';
			exit;
		}
		$cash=$row['cash'];
		$uid=$row['uid'];
		$checknote=$row['note'];
		$oldczhengfu=$row['czhengfu'];
		$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
		if($rowm['singleamount']<$jine){
			echo '单次操作额度超过限制';
			exit;
		}
		if($rowm['last_operation_time']){
			$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
			if($last_operation_time<>MyDate('Y-m-d',$timestr)){
				$istoday=1;
			}else{
				if(($rowm['todayamount']+$jine)>$rowm['amount']){
					echo '额度已满';
					exit;
				}
			}
		}
		if($jine>0) $czf='冲正'.$jine; else $czf='冲负'.abs($jine);
		$checknote=$checknote.'<br>'.$adminname.','.$czf.','.MyDate('Y-m-d H:i:s',$timestr);
		if($dsql->ExecuteNoneQuery("update ek_member_incash set `czhengfu`='$jine',`note`='$checknote' where id='$id'")){
			$orderid=$row['orderid'];
			if($jine>0) $ctype=3; else $ctype=4;
			$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`addtime`) values ('$mid','$orderid','3','$ctype','$jine','$note','$timestr')";
			if($dsql->ExecuteNoneQuery($sql)){
				$dsql->ExecuteNoneQuery("update ek_member set `money`=money+$jine,allmoney=allmoney+$jine where uid='$uid'");
				if($istoday){
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=$jine,last_operation_time='$timestr' where id='$mid'");
				}else{
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$jine,last_operation_time='$timestr' where id='$mid'");
				}
				
				$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,note,addtime) VALUES ('$orderid','$uid','$ctype','$jine','$note','".time()."')");//资金记录
				echo '操作成功';
				exit;
			}else{
				$dsql->ExecuteNoneQuery("update ek_member_incash set `czhengfu`='$oldczhengfu' where id='$id'");
				echo '系统错误1';
				exit;
			}
		}else{
			echo '系统错误2';
			exit;
		}
	}
}elseif($action=="submitmemberczhengfu"){
	if($rand<>2){
		echo("您不是操作员");
		exit();
	}
	$jine = empty($jine) ? 0 : intval($jine);
	if($jine==0){
		echo("请输入金额");
		exit();
	}
	$row = $dsql->GetOne("select `money` from ek_member where uid='$id'");
	if(is_array($row)){
		$oldmoney=$row['money'];
		$rowm = $dsql->GetOne("select singleamount,amount,todayamount,last_operation_time from ek_admin where id='$mid'");
		if($rowm['singleamount']<$jine){
			echo '单次操作额度超过限制';
			exit;
		}
		if($rowm['last_operation_time']){
			$last_operation_time=MyDate('Y-m-d',$rowm['last_operation_time']);
			if($last_operation_time<>MyDate('Y-m-d',$timestr)){
				$istoday=1;
			}else{
				if(($rowm['todayamount']+$jine)>$rowm['amount']){
					echo '额度已满';
					exit;
				}
			}
		}
		if($jine>0) $czf='冲正'.$jine; else $czf='冲负'.abs($jine);
		$checknote=$adminname.','.$czf.','.MyDate('Y-m-d H:i:s',$timestr);
		if($dsql->ExecuteNoneQuery("update ek_member set `money`=money+$jine,allmoney=allmoney+$jine where uid='$id'")){
			$orderid=date('ymdHis').rand(1000,9999);;
			if($jine>0) $ctype=13; else $ctype=14;
			$sql="insert into ek_admincheck_log(`mid`,`orderid`,`type`,`checktype`,`cash`,`checknote`,`addtime`) values ('$mid','$orderid','4','$ctype','$jine','$note','$timestr')";
			if($dsql->ExecuteNoneQuery($sql)){
				if($istoday){
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=$jine,last_operation_time='$timestr' where id='$mid'");
				}else{
					$dsql->ExecuteNoneQuery("update ek_admin set `todayamount`=todayamount+$jine,last_operation_time='$timestr' where id='$mid'");
				}
				
				$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,note,addtime) VALUES ('$orderid','$id','$ctype','$jine','$note','".time()."')");//资金记录
				echo '操作成功';
				exit;
			}else{
				$dsql->ExecuteNoneQuery("update ek_member set `czhengfu`='$oldmoney' where uid='$id'");
				echo '系统错误1';
				exit;
			}
		}else{
			echo '系统错误2';
			exit;
		}
	}else{
			echo '系统错误2';
			exit;
	}
}elseif($action=="submitMemberCdailicash"){
	$rowm = $dsql->GetOne("select cashmoney,proxyuid from proxy_cash where id='$id'");
	$cashmoney=$rowm['cashmoney']-$jine;
	if($cashmoney<0){
		echo '金额大于发放金额';
		exit;
		}
	if($cashmoney>0){
	$proxyuid=$rowm['proxyuid'];
	$now=date('Y-m-d H:m:s');
	$dsql->ExecuteNoneQuery("INSERT INTO `proxy_cash` (cashmoney,proxyuid,addtime) VALUES ('$cashmoney','$proxyuid','$now')");//资金记录
	}
	$checknote=$adminname.',操作,'.Date('Y-m-d H:i:s');
	$dsql->ExecuteNoneQuery("update proxy_cash set `remark`='$note',`remark`='$checknote',`cashmoney`='$jine',`outcash`='1' where id='$id'");
	$dsql->ExecuteNoneQuery("update ek_proxy set `money`=money-$cashmoney where uid='$proxyuid'");
	echo '操作成功';
}elseif($action=="getbanklist"){
	if(trim($account)==''){
		echo '用户名或者ID不能为空';
		exit;
	}
	
	if(is_numeric($account)){
		$wherestr="uid='$account'";
	}else{
		$wherestr="username='$account'";
	}
	$row = $dsql->GetOne("select * from ek_member where $wherestr ");
	if(!is_array($row)){
		echo "用户名或者ID不存在";
		exit();
	}
	$uid=$row['uid'];
	$sqlStr="select b.*,tp.tname,tp.intro from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$uid' order by b.addtime desc";
	$dsql->SetQuery($sqlStr);
	$dsql->Execute('data_list');
	$str='<select name="bankid" onchange="getbankinfo(this.options[this.selectedIndex].value);">';
	while($row=$dsql->GetArray('data_list'))
	{
		$str.='<option value="'.$row['id'].'">'.$row['tname'].'（'.$row['intro'].'）'.'</option>';
	}
	$str.='</select><div id="bankinfo"></div><input type="hidden" name="uid" value="'.$uid.'">';
	echo $str;
	exit;
}elseif($action=="getbankinfo"){
	if(!$uid) exit('');
	if($id){
		$rowc=$dsql->GetOne("SELECT b.*,tp.tname from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$uid' and b.id='$id'");
	}else{
		$rowc=$dsql->GetOne("SELECT b.*,tp.tname from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid where b.uid='$uid' order by b.addtime desc");
	}
	echo '<br>持卡人：'.$rowc['realname'].'<br>省份：'.$rowc['sf'].'<br>城市：'.$rowc['city'].'<br>开户行：'.$rowc['tname'].' '.$rowc['zhihang'].'<br>银行卡号：'.$rowc['cardnum'].'';
	exit;
}