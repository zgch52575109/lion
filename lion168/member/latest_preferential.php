<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "news";

$numPerPage=6;
$page = isset($page) ? intval($page) : 1;

$csqlStr="select count(*) as dd from `ek_preferential` b where b.l_expaddtime>'".time()."'";
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

$sqlStr="select b.* from ek_preferential b where b.l_expaddtime>'".time()."' order by b.l_addtime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$row['l_addtime']=MyDate('Y-m-d',$row['l_addtime']);
	$datas[]=$row;
}

$t->assign('datas',$datas);

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
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);

$t->display('member/latest_preferential.html',"$cacheid");