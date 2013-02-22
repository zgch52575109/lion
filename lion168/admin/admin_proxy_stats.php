<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_proxy');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;

$pagetitle='代理推广统计';

$y = sadate('Y');
$lastyear = $y-1;


CheckPurview('admin_proxy');
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_proxy_stats.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>