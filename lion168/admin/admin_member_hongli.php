<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Incash');

	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_member_hongli.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();