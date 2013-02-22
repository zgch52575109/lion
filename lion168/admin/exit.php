<?php
require_once(dirname(__FILE__).'/../include/common.php');
require_once(EK_INC.'/check.admin.php');
$cuserLogin = new userLogin();
$cuserLogin->exitUser();
if(empty($needclose))
{
	header('location:index.php');
}
else
{
	$msg = "<script language='javascript'>
	if(document.all) window.opener=true;
	window.close();
	</script>";
	echo $msg;
}
?>