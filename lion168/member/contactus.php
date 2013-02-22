<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "contactus";
 

$t->display('member/contactus.html',"$cacheid");