<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "preferential";
$t->assign('page_name',$cacheid);
$t->assign('noticear',get_notice_list('1'));

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
$i=0;
while($row=$dsql->GetArray('data_list'))
{
	$i++;
	$row['i']=$i;
	$row['l_addtime']=MyDate('Y-m-d',$row['l_addtime']);
	$datas[]=$row;
}

$t->assign('datas',$datas);

$t->assign('TotalResult',$TotalResult);
$t->assign('numPerPage',$numPerPage);
$t->assign('page',$page);
$t->assign('TotalPage',$TotalPage);
$perpage='?page='.($page-1);
$nextpage='?page='.($page+1);
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/preferential.html',"$cacheid");