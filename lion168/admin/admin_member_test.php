<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_member_popularize');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='试玩统计';

CheckPurview('admin_member_popularize');

include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member_test.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>