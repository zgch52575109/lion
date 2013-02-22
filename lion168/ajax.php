<?php
require_once(dirname(__FILE__)."/config.php");
AjaxHead();
if(empty($action))
{
	$action = '';
}
$id = empty($id) ? 0 : intval($id);

if($action=="checkusername"){
	$row = $dsql->GetOne("Select * From `ek_member` where username='$username'");
	if(is_array($row)) exit('<font color=#FF0000>该用户名已被注册，请重新输入！</font>'); else exit('<font color="#009900">该用户名可以注册！</font>');
}