<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "cash_system";

$id = isset($id) && is_numeric($id) ? $id : 0;
$page = isset($page) && is_numeric($page) ? $page : 1;
$state=is_array($state) ? $state : array();
$searchstr=$_SERVER['QUERY_STRING'];
	$numPerPage=10;
	$page = isset($page) ? intval($page) : 1;


	$whereorder="where o.proxyuid='{$cfg_cl->M_ID}'";
	if ($begin_date){
		$begindate=strtotime($begin_date);
		$whereorder.=" and o.addtime >='$begindate'";
	}
	if ($end_date){
		$enddate=strtotime($end_date);
		$whereorder.=" and o.addtime <='$enddate'";
	}
	if(is_array($state)){
		$statesql=implode(' or state=',$state);
	}
	if($statesql!=''){
		$whereorder.=" and (state=$statesql)";
	}
	$csqlStr="select count(*) as dd from `proxy_cash` o $whereorder";
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
	$sqlStr="select o.* from proxy_cash o ".$whereorder." order by o.addtime desc limit $limitstart,$numPerPage";
	$dsql->SetQuery($sqlStr);
	$dsql->Execute('data_list');
	$int_i=0;
	while($row=$dsql->GetArray('data_list'))
	{
		$i++;
		$row['i']=$i;;
		//$row['addtime']=MyDate('Y-m-d H:i:s',$row['addtime']);
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

$t->assign('state',$state);
$t->assign('begin_date',$begin_date);
$t->assign('end_date',$end_date);

$t->display('proxy/cash_system.html',"$cacheid");