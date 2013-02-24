<?php
require_once(dirname(__FILE__)."/config.php");
AjaxHead();
if(empty($action))
{
	$action = '';
}
$id = empty($id) ? 0 : intval($id);

if($action=="checkusername"){
	$row = $dsql->GetOne("Select * From `ek_member` where username='$param'");
	if(is_array($row)) {
		//已经存在
		$info = array("info"=>"该用户已经存在,请重新输入","status"=>"n");
		echo json_encode($info);
	}else{
		//可以注册
		$info = array("info"=>"该用户可以注册","status"=>"y");
		echo json_encode($info);
	}
}