<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "feedback";

if($action=='save'){
	if(trim($msg)==''){
		ShowMsg('没有填写提交的问题内容！','-1');
		exit();
	}
	$dateline=time();
	$insql="INSERT INTO `ek_feedback` (`uid`,`msg`,dtime)VALUES ('$cfg_cl->M_ID','$msg','$dateline')";
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('您的问题已经提交，请等待客服的回答！','feedback.php');
		exit();
	}
}

$numPerPage=10;
$page = isset($page) ? intval($page) : 1;

$csqlStr="select count(*) as dd from `ek_feedback` b where uid='$cfg_cl->M_ID' and ischeck='1'";
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

$sqlStr="select b.*,a.name from ek_feedback b left join ek_admin a on a.id=b.mid where uid='$cfg_cl->M_ID' order by b.dtime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$row['dtime']=MyDate('Y-m-d H:i:s',$row['dtime']);
	$row['retime']=MyDate('Y-m-d H:i:s',$row['retime']);
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
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);

$t->display('member/feedback.html',"$cacheid");