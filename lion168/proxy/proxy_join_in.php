<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "newsJoinIn";
$numPerPage=10;
$page = isset($page) ? intval($page) : 1;
$proxyuid="{$cfg_cl->M_ID}";
$get_begin_date =$begin_date;	//开始时间	begin_date
$get_end_date =$end_date;		//结束时间	end_date
$get_textfield = $textfield;		//账户	textfield
$get_select2 = $select2;			//排序	select2
$get_select3 = $select3;			//会员等级	select3
$get_select4 = $select4;			//状态	select4  
if ($page>$TotalPage) $page=$TotalPage;
$limitstart = ($page-1) * $numPerPage;
if($limitstart<0) $limitstart=0;
$rowtr = $dsql->GetOne("select * from ek_proxy where uid='{$cfg_cl->M_ID}'");
$xiajifencheng=$rowtr['xjfencheng'];

$whereStr="where topuid='{$cfg_cl->M_ID}'";
if($get_begin_date){$whereStr.= " and jointime>= '$get_begin_date'" ;}
if($get_end_date){$whereStr.= " and jointime<= '$get_end_date'" ;}
if($get_select4){$whereStr.= " and status= '$get_select4'" ;}
if($get_textfield){$whereStr.= " and username like '$get_textfield'" ;}
$csqlStr="select count(*) as dd from `ek_proxy`  $whereStr";
$row = $dsql->GetOne($csqlStr);
if(is_array($row)){
$TotalResult = $row['dd'];
}else{
$TotalResult = 0;
}
$lastmonth_start = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
$lastmonth_end = date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y")));
$TotalPage = ceil($TotalResult/$numPerPage);
$sqlStr_sql="select jointime,uid,username,truename,tjnum from ek_proxy  $whereStr order by jointime  limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr_sql);
$dsql->Execute('data_li');
$datas_f=array();
$in_i=1;
while($roww=$dsql->GetArray('data_li'))
{
	$uid=$roww['uid'];
	$roww['userJointime']=MyDate('Y-m-d',$roww['jointime']);
	$roww['xjfencheng']=$xiajifencheng;
	$roww['xjdlfencheng']=$xiajifencheng*100;
	$rowdr = $dsql->GetOne("select sum(cashmoney) as dd from proxy_cash where addtime>='$lastmonth_start' and addtime<'$lastmonth_end' and proxyuid=$uid and xjdl is null");
//echo $csqlStrhd="select sum(cashmoney) as dd from proxy_cash where addtime>='$lastmonth_start' and addtime<'$lastmonth_end' and proxyuid=$uid and xjdl is null";
//$rowdy = $dsql->GetOne($csqlStrhd);
	$roww['lastmonthmoney']=$rowdr['dd'];
	$roww['lastmonthfencheng']=$roww['lastmonthmoney']*$roww['xjfencheng'];
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
$t->display('proxy/proxy_join_in.html',"$cacheid");