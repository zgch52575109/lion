<?php
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='用户管理';

CheckPurview('member_gamemoney');
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member_gamemoney.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>