<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "cash_out";
 

$t->display('member/cash_out.html',"$cacheid");