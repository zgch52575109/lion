<?php
require_once(dirname(__FILE__).'/include/common.php');
require_once(EK_INC.'/front.func.php');
require_once("record.php");
$tmount=getHGmoney($_SESSION['userInfo']['username'],$_SESSION['userInfo']['truename']);
$tmount = number_format($tmount,2); 
$t->assign('tmount',$tmount);
$t->assign("balance",number_format($tmount+$_SESSION['userInfo']['money'],2));