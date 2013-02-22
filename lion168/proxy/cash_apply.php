<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "proxy_informtion";
$t->assign('noticear',get_notice_list('1'));
 
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
 $sumcash = $rs['sumcash'];
 $t->assign('cashmoney',$rs['sumcash']);


if($action=="save")
{
	if(trim($account)==''){
		ShowMsg("用户名不能为空","-1");
		exit();
}		
	$wherestr="username='$account'";
	$row = $dsql->GetOne("select * from ek_proxy where $wherestr ");
	if(!is_array($row)){
		ShowMsg("用户名不存在","-1");
		exit();
	}
	$uid=$row['uid'];
	$cash = isset($cash) && is_numeric($cash) ? $cash : 0;
	if ($cash > $sumcash)
	{
		 ShowMsg("可提取佣金不足","-1");
		exit();
	}
	
	$now=date('Y-m-d h:i:s');
	$row = $dsql->GetOne("select * from ek_proxy where $wherestr ");
	$insql="INSERT INTO `proxy_cash` (cashmoney,proxyuid,addtime) VALUES ('$cash','$uid','$now')";//资金记录
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功提交取款申请！','cash_apply.php',0,5000);
		exit();
	}
	ShowMsg('提交失败，请检查所填项目！','-1');
	exit();
} 
 
 
 
$t->display('agent/cash_apply.html',"$cacheid");