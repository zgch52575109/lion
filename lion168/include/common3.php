<?php
//error_reporting(E_ALL);
//error_reporting(E_ALL || ~E_NOTICE);
define('EK_INC', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ) );
define('EK_ROOT', ereg_replace("[/\\]{1,}",'/',substr(EK_INC,0,-8) ) );
define('EK_DATA', EK_ROOT.'/data');

if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}

//检查和注册外部提交的变量
function CheckRequest(&$val) {
	if (is_array($val)) {
		foreach ($val as $_k=>$_v) {
			CheckRequest($_k); 
			CheckRequest($val[$_k]);
		}
	} else
	{
		if( strlen($val)>0 && preg_match('#^(cfg_|GLOBALS)#',$val) )
		{
			exit('Request var not allow!');
		}
	}
}
CheckRequest($_REQUEST);

function _RunMagicQuotes(&$svar)
{
	if(!get_magic_quotes_gpc())
	{
		if( is_array($svar) )
		{
			foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
		}
		else
		{
			$svar = addslashes($svar);
		}
	}
	return $svar;
}

foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}

//系统相关变量检测
if(!isset($needFilter))
{
	$needFilter = false;
}
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isSafeMode = @ini_get("safe_mode");
if( eregi('windows', @getenv('OS')) )
{
	$isSafeMode = false;
}


//Session保存路径
$sessSavePath = EK_DATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
	session_save_path($sessSavePath);
}

$timestamp = time();

//数据库配置文件
require_once(EK_DATA.'/common.inc.php');

//系统配置参数
require_once(EK_DATA."/config.cache.inc.php");

//php5.1版本以上时区设置
//由于这个函数对于是php5.1以下版本并无意义，因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
	$time51 = $cfg_cli_time * -1;
	@date_default_timezone_set('Etc/GMT'.$time51);
}
$cfg_isUrlOpen = @ini_get("allow_url_fopen");

//站点根目录
$cfg_basedir = eregi_replace('include$','',EK_INC);

//模板的存放目录
$cfg_templets_dir = 'templets';

//会员目录
$cfg_member_dir = '/'.$cfg_cmspath.'member';
$cfg_memberurl = $cfg_basehost.$cfg_member_dir;

$cfg_phpurl = '/'.$cfg_cmspath;

//附件目录
$cfg_medias_dir = '/'.$cfg_cmspath.$cfg_upload_dir;

//上传的普通图片的路径,建议按默认
$cfg_image_dir = $cfg_medias_dir.'/allimg';

$cfg_user_dir = $cfg_medias_dir.'/userup';

//系统摘要信息，****请不要删除本项**** 否则系统无法正确接收系统漏洞或升级信息
$cfg_version = 'V1.0.0_gbk';
$cfg_soft_lang = 'utf-8';
$cfg_softname = '金狮国际';
$cfg_soft_enname = '金狮国际';
$cfg_soft_devteam = '金狮国际';

//新建目录的权限，如果你使用别的属性，本程不保证程序能顺利在Linux或Unix系统运行
$cfg_dir_purview = 0755;
/*
if($cfg_gzipcompress && function_exists('ob_gzhandler') && !in_array(CURSCRIPT, array('attachment', 'wap'))) {
	ob_start('ob_gzhandler');
} else {
	$cfg_gzipcompress = 0;
	ob_start();
}
*/

if(!isset($cfg_NotPrintHead)) {
	header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

//引入数据库类
require_once(EK_INC.'/libs/sql.class.php');
//require_once(EK_INC.'/libs/sql.class_db.php');

//全局常用函数
require_once(EK_INC.'/common.func.php');

//加载模板库类
require_once(EK_INC.'/libs/smarty-lite/class.template.php');

!$currentid && $currentid='index';
//template
$t = new template;
$t->template_dir	= EK_ROOT . "/".$cfg_templets_dir."/".$cfg_df_style."/".$cfg_df_html."/";
$t->compile_dir		= EK_DATA . "/templates_c/";
$t->config_dir		= EK_DATA . "/configs/";
$t->cache_dir		= EK_DATA . "/smcache/";
$t->left_tag = '<!--{';
$t->right_tag = '}-->';
$t->cache = $cfg_iscache;
$t->cache_lifetime = $cfg_cachetime;
$t->assign('webname',$cfg_webname);
$t->assign('cfg_keywords',$cfg_keywords);
$t->assign('cfg_description',$cfg_description);
$t->assign('basehost',$cfg_basehost);
$t->assign('cmspath',$cfg_cmspath);
$t->assign('cfg_stats',stripslashes($cfg_stats));
$t->assign('cfg_foot',stripslashes($cfg_foot));
$t->assign('cfg_qq',stripslashes($cfg_qq));

@include EK_DATA.'/cache/cache_nextrun.php';
//引入进程类
require_once(EK_INC.'/libs/ek.process.php');
		   echo '开始更新今日游戏记录。。。'.date('m/d H-i-s'); 
		    //getTodayGetBetdetails();
		   echo '今日游戏记录更新结束。。。'.date('m/d H-i-s'); 
			//lastRegularChips();
		    // AllRegularChips();
		   //ThisWeekRegularChips();
		  
