<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "limit_operation";
$id = isset($id) && is_numeric($id) ? $id : 0;
$page = isset($page) && is_numeric($page) ? $page : 1;
$pagesize = isset($pagesize) && is_numeric($pagesize) ? $pagesize : $cfg_memeber_limit_list_pagesize;
if($action=='save'){
	if(!is_numeric($amount)){
		ShowMsg("金额只能为数字！","-1");
		exit();
	}
	if($cash_out == '' ||  $cash_in == ''){
			ShowMsg("请填写转出转入账户","-1");
			exit();
	}
	if ($cash_out == 1 )
	{
		$truntype = 1;
    }
	else
	{ 
	   $truntype = 2;
    } 
 
	$zqcash=$cfg_cl->fields['money'];
	$tmount=getHGmoney($cfg_cl->fields['username'],$cfg_cl->fields['truename']);
	if($truntype==2){
		if($amount>$tmount){
			ShowMsg("转出金额不能大于可转额度！","-1");
			exit();
		}
		$status=zhuanchuHGmoeny($amount,$cfg_cl->fields['username'],$cfg_cl->fields['truename']);
		if($status=='0'){//成功
			//用户账户加钱
			$nowmount=getHGmoney($cfg_cl->fields['username'],$cfg_cl->fields['truename']);
			$upsql='';
			if($nowmount && $nowmount<>$cfg_cl->fields['touzhumoney']){
				$upsql=",touzhumoney='$nowmount'";
			}
			$dsql->ExecuteNoneQuery("update ek_member set `money`=money+$amount {$upsql} where uid='$cfg_cl->M_ID'");
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_game_log` (gameid,zhuanhuanly,zhuanhuanmb,uid,type,zqcash,zqedu,cash,state,note,addtime) VALUES ('1','游戏账户','本站账户','$cfg_cl->M_ID','2','$zqcash','$tmount','$amount','1','成功','".time()."')");//转入转出记录
			$orderid=date('ymdHis').rand(1000,9999);
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','8','$amount','".time()."')");//资金记录
			ShowMsg('转出额度成功！','limit_operation.php',0,5000);
			exit();
		}
		ShowMsg('转出额度失败，错误代码：'.$status.'，您可以提供此代码给客服！','limit_operation.php',0,5000);
		exit();
	}else{
		if($amount>$cfg_cl->fields['money']){
			ShowMsg("转入金额不能大于可转资金！","-1");
			exit();
		}
		$status=zhuanruHGmoeny($amount,$cfg_cl->fields['username'],$cfg_cl->fields['truename']);
		if($status=='0'){//成功
			//用户账户扣钱
			$nowmount=getHGmoney($cfg_cl->fields['username'],$cfg_cl->fields['truename']);
			$upsql='';
			if($nowmount && $nowmount<>$cfg_cl->fields['touzhumoney']){
				$upsql=",touzhumoney='$nowmount'";
			}
			$dsql->ExecuteNoneQuery("update ek_member set `money`=money-$amount {$upsql} where uid='$cfg_cl->M_ID'");
			$orderid=date('ymdHis').rand(1000,9999);
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_game_log` (gameid,zhuanhuanly,zhuanhuanmb,uid,type,zqcash,zqedu,cash,state,note,addtime) VALUES ('1','本站账户','游戏账户','$cfg_cl->M_ID','1','$zqcash','$tmount','$amount','1','成功','".time()."')");//转入转出记录
			$amount=0-$amount;
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','9','$amount','".time()."')");//资金记录

			ShowMsg('转入额度成功！','limit_operation.php',0,5000);
			exit();
		}
		ShowMsg('转入额度失败，错误代码：'.$status.'，您可以提供此代码给客服！','limit_operation.php',0,5000);
		exit();
	}
}


$searchstr=$_SERVER['QUERY_STRING'];
	$numPerPage=$pagesize;

	$whereorder="where o.uid='{$cfg_cl->M_ID}'";
	if ($begin_date){
		$begindate=strtotime($begin_date);
		$whereorder.=" and o.addtime >='$begindate'";
	}
	if ($end_date){
		$enddate=strtotime($end_date);
		$whereorder.=" and o.addtime <='$enddate'";
	}
	$csqlStr="select count(*) as dd from `ek_game_log` o $whereorder";
	$row = $dsql->GetOne($csqlStr);
	if(is_array($row)){
	$TotalResult = $row['dd'];
	}else{
	$TotalResult = 0;
	}
	$TotalPage = ceil($TotalResult/$numPerPage);
	if ($page>$TotalPage) $page=$TotalPage;
	$limitstart = ($page-1) * $numPerPage;
	if($limitstart<0) $limitstart=0;
	$sqlStr="select o.* from ek_game_log o ".$whereorder." order by o.addtime desc limit $limitstart,$numPerPage";
	$dsql->SetQuery($sqlStr);
	$dsql->Execute('data_list');
	while($row=$dsql->GetArray('data_list'))
	{
		if($ctime=='1'){
			$row['addtime']=MyDate('Y-m-d H:i:s',$row['addtime'],'-4');
		}else{
			$row['addtime']=MyDate('Y-m-d H:i:s',$row['addtime']);
		}
		$datas[]=$row;
	}
	$t->assign('datas',$datas);
	unset($datas);
	
	$perpage='?'.($searchstr ? $searchstr.'&' : '').'page='.($page-1);
	$nextpage='?'.($searchstr ? $searchstr.'&' : '').'page='.($page+1);
	$firstpage='?'.($searchstr ? $searchstr.'&' : '').'page=1';
	$lastpage='?'.($searchstr ? $searchstr.'&' : '').'page='.$TotalPage;
if($page>1)
$perpage='?page='.($page-1);
else
$perpage='?page=1';

if($page<$TotalPage)
$nextpage='?page='.($page+1);
else
$nextpage='?page='.$TotalPage;
	$t->assign('firstpage',$firstpage);
	$t->assign('lastpage',$lastpage);
$t->assign('TotalResult',$TotalResult);
$t->assign('numPerPage',$numPerPage);
$t->assign('page',$page);
$t->assign('TotalPage',$TotalPage);


$t->assign('ctime',$ctime);
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);

$tmount=getHGmoney($cfg_cl->fields['username'],$cfg_cl->fields['truename']);
$tmount = number_format($tmount,2); 
$t->assign('tmount',$tmount);
$t->assign("balance",number_format($tmount+$t->get_vars("money"),2));
$t->assign('tmount',$tmount);
$t->display('member/limit_operation.html',"$cacheid");