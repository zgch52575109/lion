<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Config');
if(empty($dopost))
{
	$dopost = "";
}
$configfile = EK_DATA.'/config.cache.inc.php';

//保存配置的改动
if($dopost=="save")
{
	foreach($_POST as $k=>$v)
	{
		if(ereg("^edit___",$k))
		{
			$v = cn_substrR(${$k},900);
		}
		else
		{
			continue;
		}
		$k = ereg_replace("^edit___","",$k);
		$configstr .="\${$k} = '$v';\r\n";
	}
	if(!isset($edit___cfg_memeber_limit_list_pagesize) || !isset($edit___cfg_stats) || !isset($edit___cfg_admin_banip)){
		ShowMsg("配置信息不能完整提交，请关闭浏览器重新保存，本次保存失败。","admin_config.php");
		exit();
	}
	if(trim($configstr)!=''){
		if(!is_writeable($configfile))
		{
			echo "配置文件'{$configfile}'不支持写入，无法修改系统配置参数！";
			exit();
		}
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		fwrite($fp,$configstr);
		fwrite($fp,"?".">");
		fclose($fp);
	}
	ShowMsg("成功更改站点配置！","admin_config.php");
	exit();
}
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_config.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>