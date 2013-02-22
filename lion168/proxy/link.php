<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "proxy_informtion";


$t->assign('noticear',get_notice_list('1'));
$rowu=$dsql->GetOne("SELECT * FROM `ek_proxy` where uid='$cfg_cl->M_ID'");
 
 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
  
 

//代理用户信息
 
$url_dl="";
if($rowu['domain']!=""){$url_dl=$rowu['domain'];}
if($rowu['domainid']!=""){$url_dl=$rowu['domain']."?proxy=".$rowu['domainid'];}




$t->assign('url_dl',$url_dl);


$t->assign('groupname',$groupdb['grouptitle']);
$t->assign('cashmoney',$rs['sumcash']);

$t->display('agent/link.html',"$cacheid");