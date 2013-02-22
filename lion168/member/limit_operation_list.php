<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "limit_operation_list";

$id = isset($id) && is_numeric($id) ? $id : 0;
$page = isset($page) && is_numeric($page) ? $page : 1;
$pagesize = isset($pagesize) && is_numeric($pagesize) ? $pagesize : $cfg_memeber_limit_list_pagesize;



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
	//echo $sqlStr;
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

$t->display('member/limit_operation_list.html',"$cacheid");