<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "news";

$numPerPage=10;
$page = isset($page) ? intval($page) : 1;

$csqlStr="select count(*) as dd from `proxy_cash` b where proxyuid='$cfg_cl->M_ID' and outcash > 0";
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

$sqlStr="SELECT pc.proxyuid,pc.cashmoney,pc.addtime,pc.remark,pc.outcash FROM proxy_cash pc  where pc.proxyuid='$cfg_cl->M_ID'  and and outcash > 0 order by pc.addtime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list_w');
$datas_w=array();
while($row_w=$dsql->GetArray('data_list_w'))
{
	//$row['addtime']=MyDate('Y-m-d',$row['addtime']);
	$datas_w[]=$row_w;
}

$t->assign('datas',$datas_w);

$t->assign('TotalResult',$TotalResult);
$t->assign('numPerPage',$numPerPage);
$t->assign('page',$page);
$t->assign('TotalPage',$TotalPage);
if($page>1)
$perpage='?page='.($page-1);
else
$perpage='?page=1';

if($page<$TotalPage)
$nextpage='?page='.($page+1);
else
$nextpage='?page='.$TotalPage;
$firstpage='?page=1';
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);



$t->display('proxy/profit.html',"$cacheid");