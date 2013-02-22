<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('incash_Stats');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;

$pagetitle='现金流动统计';

$y = sadate('Y');
$lastyear = $y-1;


CheckPurview('member_List');
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_memeber_incash_stats.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>