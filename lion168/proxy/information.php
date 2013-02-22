<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "proxy_informtion";
$t->assign('noticear',get_notice_list('1'));
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
 $t->assign('cashmoney',$rs['sumcash']);







$id = isset($id) && is_numeric($id) ? $id : 0;

$rowu=$dsql->GetOne("SELECT * FROM `ek_proxy` where uid='$cfg_cl->M_ID'");

$numPerPage=30;
$page = isset($page) ? intval($page) : 1;

$whereorder="where b.uid='{$cfg_cl->M_ID}'";
$csqlStr="select count(*) as dd from `ek_proxy_bank` b $whereorder";
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

$sqlStr="select b.*,tp.tname from ek_proxy_bank b left join ek_bank_type tp on tp.tid=b.bankid $whereorder order by b.addtime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$i=0;
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$i++;
	$row['i']=$i;
	$datas[]=$row;
}


//代理用户信息
$get_Email = trim($textfield2);		//电子邮箱	textfield2
$get_QQ = trim($textfield3);		//QQ号码		textfield3
$get_Ponow = trim($textfield4);	//手机号码	textfield4

$sql_Email = "INSERT INTO `ek_proxy_history_email` (uid,email,dateline) VALUES ('$cfg_cl->M_ID','$get_Email','".time()."')";	//电子邮箱	textfield2
$sql_QQ = "INSERT INTO `ek_proxy_history_qq` (uid,qq,dateline) VALUES ('$cfg_cl->M_ID','$get_QQ','".time()."')";				//QQ号码		textfield3
$sql_Ponow = "INSERT INTO `ek_proxy_history_phone` (uid,email,dateline) VALUES ('$cfg_cl->M_ID','$get_Ponow','".time()."')";	//手机号码	textfild4

if($action=='save'){

$get_Email = trim($textfield2);		//电子邮箱	textfield2
$get_QQ = trim($textfield3);		//QQ号码		textfield3
$get_Ponow = trim($textfield4);		//手机号码	textfield4
$dateline=time();
	
	if($get_Email!=$rowu['email'] || $get_QQ!=$rowu['qq'] || $get_Ponow!=$rowu['phone'])
	{
		$query1 = "update `ek_proxy` SET email='$get_Email',qq='$get_QQ',phone='$get_Ponow' where uid='$cfg_cl->M_ID'";
		if($dsql->ExecuteNoneQuery($query1))
		{		
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_proxy_history_email` (uid,email,dateline) VALUES ('$cfg_cl->M_ID','$get_Email','".time()."')");
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_proxy_history_qq` (uid,qq,dateline) VALUES ('$cfg_cl->M_ID','$get_QQ','".time()."')");
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_proxy_history_phone` (uid,email,dateline) VALUES ('$cfg_cl->M_ID','$get_Ponow','".time()."')");
			ShowMsg('成功修改！','information.php',0,5000);
			exit();
		}
		ShowMsg('修改失败！','-1');
		exit();
	}

}

$url_dl="";
if($rowu['domain']!=""){$url_dl=$rowu['domain'];}
if($rowu['domainid']!=""){$url_dl=$rowu['domain']."?proxy=".$rowu['domainid'];}



$t->assign('datas',$datas);
$t->assign('email_dl',$rowu['email']);
$t->assign('phone_dl',$rowu['phone']);
$t->assign('url_dl',$url_dl);
$t->assign('qq_dl',$rowu['qq']);
$t->assign('money',$rowu['money']);

$t->assign('i',$i);
$t->assign('isedit',$cfg_memeber_bank_edit);
$t->assign('isdel',$cfg_memeber_bank_del);
$t->assign('realname',$datas[realname]);

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

$t->assign('groupname',$groupdb['grouptitle']);

$t->display('agent/information.htm',"$cacheid");