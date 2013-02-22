<?php
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$pagetitle='用户管理';

if($action=='save'){
	CheckPurview('member_Edit');
	if($active==''){
	ShowMsg("活跃度不能为空","-1");
	exit();
	}
	echo "update ek_active set active = '$active' where id=1";
	if(!$dsql->ExecuteNoneQuery("update ek_active set active = '$active' where id=1"))
	{
		ShowMsg('更新活跃度出错，请检查',-1);
		exit();
	}else{
		ShowMsg('更新活跃度成功，返回',$back);
		exit();
	}
}
CheckPurview('member_List');
$row = $dsql->GetOne("SELECT * FROM ek_active where id=1");
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_member_active.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>