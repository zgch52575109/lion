<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
	$ticketid=regHGuser($cfg_cl->fields['username'],$cfg_cl->fields['truename'],1);
	if($ticketid){
		header("Location:".$cfg_apiloginurl.$ticketid."&lang=ch");
		exit();
	}else{
		ShowMsg("系统出现错误，请联系客服人员！","-1");
		exit();
	}
?>

 
