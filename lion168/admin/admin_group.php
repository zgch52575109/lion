<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Group');
if(empty($action))
{
	$action = '';
}

if($action=='add'){
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_group_add.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit;
}
elseif($action=='save'){
	switch (trim($acttype)) 
	{
		case "add":
			$row = $dsql->GetOne("Select * From ek_admintype where rank='".$rankid."'");
			if(is_array($row))
			{
				ShowMsg("你所创建的组别的级别值已存在，不允许重复!","-1");
				exit();
			}
			if($rankid > 10)
			{
				ShowMsg('组级别值不能大于10， 否则一切权限设置均无效!', '-1');
				exit();
			}
			$AllPurviews = '';
			if(is_array($purviews))
			{
				foreach($purviews as $pur)
				{
					$AllPurviews .= $pur.' ';
				}
				$AllPurviews = trim($AllPurviews);
			}
			$dsql->ExecuteNoneQuery("INSERT INTO ek_admintype(rank,typename,system,purviews) VALUES ('$rankid','$groupname', 0, '$AllPurviews');");
			ShowMsg("成功创建一个新的用户组!","admin_group.php");
			exit();
		break;
		case "edit":
			if($rank==10)
			{
				ShowMsg("超级管理员的权限不允许更改!","admin_group.php");
				exit();
			}
			$purview = "";
			if(is_array($purviews))
			{
				foreach($purviews as $p)
				{
					$purview .= "$p ";
				}
				$purview = trim($purview);
			}
			$dsql->ExecuteNoneQuery("Update `ek_admintype` set typename='$typename',purviews='$purview' where CONCAT(`rank`)='$rank'");
			ShowMsg("成功更改用户组的权限!","admin_group.php");
			exit();
		break;
	}
}
elseif($action=='edit'){
	$groupRanks = Array();
	$groupSet = $dsql->GetOne("Select * From `ek_admintype` where CONCAT(`rank`)='{$rank}' ");
	$groupRanks = explode(' ',$groupSet['purviews']);
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_group_edit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit;
}
elseif($action=='del'){
	$dsql->ExecuteNoneQuery("Delete From `ek_admintype` where CONCAT(`rank`)='$rank' And system='0';");
	ShowMsg("成功删除一个用户组!","admin_group.php");
	exit();
}
else
{
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_group.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit;
}

//检查是否已经有此权限
function CRank($n)
{
	global $groupRanks;
	return in_array($n,$groupRanks) ? ' checked' : '';
}
?>