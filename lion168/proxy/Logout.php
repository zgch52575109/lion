<?php
require_once(dirname(__FILE__)."/config.php");
$cfg_cl->ExitCookie();
ShowMsg("成功退出登录！","../index.php",0,2000);
exit();
?>