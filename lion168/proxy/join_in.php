<?php
require_once(dirname(__FILE__)."/config.php");


CheckRank(0,0);
CheckNotAllow();
$cacheid = "newsJoinIn";
 ///代理佣金
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
 $t->assign('cashmoney',$rs['sumcash']);








$numPerPage=10;
$page = isset($page) ? intval($page) : 1;

 
$whereStr="where   proxyuid= $cfg_cl->M_ID ";
$csqlStr="select count(*) as dd from ek_member $whereStr";
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
 


$sqlStr_sql="select uid,username,FROM_UNIXTIME(jointime,'%Y-%m-%d %H:%i:%s') as jointime,FROM_UNIXTIME(logintime,'%Y-%m-%d %H:%i:%s') as logintime,logincount from ek_member  $whereStr limit $limitstart,$numPerPage";
 
$dsql->SetQuery($sqlStr_sql);
$dsql->Execute('data_li');
$datas_f=array();
$in_i=1;
while($roww=$dsql->GetArray('data_li'))
{
	//print_r($roww);
	$roww['i']=$in_i++;
  
	$roww['fencheng']=$roww['fencheng']*100;
	$datas_f[]=$roww;
}

$t->assign('datas_mg',$datas_mg);
$t->assign('datas_f',$datas_f);
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
$nextpage='?page='.$TotalPage.($get_begin_date ? '&get_begin_date='.$get_begin_date : '').($get_end_date ? '&get_end_date='.$get_end_date : '').($get_textfield ? '&get_textfield='.$get_textfield : '').($get_select3 ? '&get_select3='.$get_select3 : '').($get_select4 ? '&get_select4='.$get_select4 : '');
$firstpage='?page=1';
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);
$t->display('agent/join_in.html',"$cacheid");