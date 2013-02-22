<?php
require_once(dirname(__FILE__)."/config.php");

$cacheid = "ranking_list_year";
$t->assign('noticear',get_notice_list('1'));
 

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}
$timestr=time();
$sqlStr="select m.username,m.yearlivetouzhumoney as yeartouzhumoney,g.grouptitle from ek_member m left join ek_member_group g on g.groupid=m.groupid where yearlivetouzhumoney>0 order by m.yearlivetouzhumoney desc limit 14";
$dsql->SetQuery($sqlStr);
$dsql->Execute('class_list');
$i=1;
$datas=array();
while($row=$dsql->GetArray('class_list'))
{
	$row['i']=$i;
	$strlen=strlen($row['username'])-3;
	$xstr='';
	if($strlen>0){
		for($j=0;$j<$strlen;$j++){
			$xstr.='*';
		}
	}
	$row['username']=substr($row['username'],0,3).$xstr;
	$datas[]=$row;
	$i++;
}
$t->assign('datas',$datas);

$t->display('ranking_list_year.html',"$cacheid");