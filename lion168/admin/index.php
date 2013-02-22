<?php
require_once(dirname(__FILE__)."/config.php");

$y = sadate('Y');
$allnum=getviewscount(sadate('Y-m-d').' 0:0:0',sadate('Y-m-d').' 23:0:0');
$wnum=getviewscount(sadate('Y-m-d').' 01:0:0',sadate('Y-m-d').' 08:0:0');
$wunum=getviewscount(sadate('Y-m-d').' 15:0:0',sadate('Y-m-d').' 24:0:0');
$znum=getviewscount(sadate('Y-m-d').' 09:0:0',sadate('Y-m-d').' 14:0:0');


$wbili=ceil(($wnum/$allnum)*100);
$wubili=ceil(($wunum/$allnum)*100);
$zbili=ceil(($znum/$allnum)*100);

include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/index.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>