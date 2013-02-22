<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('admin_member_popularize');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
$pagetitle='代理管理';
if($action=='save'){
	CheckPurview('admin_member_popularize');
	$pwd = trim($password);
	$pwdc = trim($password2);
	if($pwd!=''){
		if(strlen($pwd) < $cfg_mb_pwdmin)
		{
			ShowMsg("你的密码过短，不允许使用！","-1");
			exit();
		}
		if($pwdc != $pwd)
		{
			ShowMsg('你两次输入的密码不一致！', '-1');
			exit();
		}
		$pwd = md5($password);
		$pwdsql=",password='$pwd'";
	}
	$fencheng = isset($fencheng) && is_numeric($fencheng) ? $fencheng : 0;
	$xjfencheng = isset($xjfencheng) && is_numeric($xjfencheng) ? $xjfencheng : 0;
	if($domainid!=''){
	$query = "select * from ek_proxy where domainid=$domainid and  uid!=$id";
	$rowp = $dsql->GetOne($query);
	if(is_array($rowp))
	{
		ShowMsg("请检查代理后缀!","-1");
		exit();
	}
	}
	if($id){
$updateSql = "username = '$username',groupid = '$groupid',truename = '$truename',phone = '$phone',email = '$email',qq = '$qq',domain = '$domain',domainid = '$domainid',qianzhui = '$qianzhui',fencheng = '$fencheng',active = '$active',bankmaxnum = '$bankmaxnum',xjfencheng = '$xjfencheng'";
if($sjdl!=0){$updateSql.=",topuid = '$sjdl'";}
	$Sql = "update ek_proxy set ".$updateSql.$pwdsql." where uid=".$id;
	if(!$dsql->ExecuteNoneQuery($Sql))
	{
		ShowMsg('更新代理信息出错，请检查',-1);
		exit();
	}else{
		ShowMsg('更新代理信息成功，返回',$back);
		exit();
	}
	}else{
$now=date('Ym');
$insertSql="insert into `ek_proxy` (username,groupid,password,truename,phone,qq,email,domain,domainid,qianzhui,fencheng,active,jointime,bankmaxnum,updatetime,topuid,xjfencheng) values ('$username','$groupid','$pwd','$truename','$phone','$qq','$email','$domain','$domainid','$qianzhui','$fencheng','$active','".time()."','$bankmaxnum','$now','$sjdl','$xjfencheng')";
	if(!$dsql->ExecuteNoneQuery($insertSql))
	{
		ShowMsg('新建代理信息出错，请检查',-1);
		exit();
	}else{
	if($sjdl!=0){
		$dsql->ExecuteNoneQuery("update ek_proxy set xjnum=xjnum+1 where uid='$sjdl'");
		}
		ShowMsg('新建代理信息成功，返回',$back);
		exit();
	}
		}
}elseif($action=="add")
{
	CheckPurview('admin_member_popularize');
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_edit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}
elseif($action=='edit'){
	CheckPurview('admin_member_popularize');
	$query = "select * from ek_proxy where uid='$id' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取代理基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_edit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=='bank'){
	CheckPurview('admin_member_popularize');
	$query = "select * from ek_proxy where uid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取代理基本信息出错!","-1");
		exit();
	}
	$query = "select * from ek_proxy_bank where uid='$id' ";
	$row = $dsql->GetOne($query);
	$btype=getBankTypeLists();
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_bank.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=='check'){
	CheckPurview('admin_member_popularize');
	$dsql->ExecuteNoneQuery("update ek_proxy set status='$status' where uid='$id'");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='delall'){
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("delete from ek_proxy where uid in(".$ids.")");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='bankdel'){
	if(empty($id))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$dsql->ExecuteNoneQuery("delete from ek_proxy_bank where id=$id");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='checkall'){
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
	$dsql->ExecuteNoneQuery("update ek_proxy set status='$status' where uid in(".$ids.")");
	ShowMsg("操作成功",$back);
	exit();
}elseif($action=='czhengfuall'){
	if(empty($checkall))
	{
		ShowMsg("请选择需要删除的数据","-1");
		exit();
	}
	$ids = implode(',',$checkall);
}elseif($action=="viewfencheng"){
	CheckPurview('admin_member_popularize');
	$query = "select * from ek_proxy where uid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取代理基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy_tuiguang.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="xxdl"){
	CheckPurview('admin_member_popularize');
	$query = "select * from ek_proxy where uid='$id' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取代理基本信息出错!","-1");
		exit();
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_proxy.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}elseif($action=="savebank")
{
	$bankid = isset($bankid) && $bankid ? $bankid : 0;
	$bid = isset($bid) && is_numeric($bid) ? $bid : 0;
	if(trim($sf)==''){
		ShowMsg("请选择省份！","-1");
		exit();
	}
	if(trim($city)==''){
		ShowMsg("请选择城市！","-1");
		exit();
	}
	if(!$bankid){
		ShowMsg("请选择开户行！","-1");
		exit();
	}
	if(trim($zhihang)==''){
		ShowMsg("请填写支行名称！","-1");
		exit();
	}
	if(strlen($cardnum)<15){
		ShowMsg("银行卡号码格式不对！","-1");
		exit();
	}
	if(trim($realname)==''){
		ShowMsg("请填写持卡人姓名！","-1");
		exit();
	}
	if(strlen($realname)>16){
		ShowMsg("持卡人姓名过长！","-1");
		exit();
	}
	if (!preg_match("/^(?:\d{15}|\d{17}([0-9]|X))$/i", $idnumber)){
		ShowMsg("身份证格式不正确！","-1");
		exit();
	}
	if($bid){
		$insql="update `ek_proxy_bank` set sf='$sf',city='$city',bankid='$bankid',zhihang='$zhihang',cardnum='$cardnum',realname='$realname',idnumber='$idnumber' where id='$bid'";
	}else{
		$insql="INSERT INTO `ek_proxy_bank` (uid,sf,city,bankid,zhihang,cardnum,realname,idnumber,addtime) VALUES ('$id','$sf','$city','$bankid','$zhihang','$cardnum','$realname','$idnumber','".time()."')";
	}
	if($dsql->ExecuteNoneQuery($insql)){
		ShowMsg('成功保存银行卡信息！',$back,0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}

CheckPurview('admin_member_popularize');
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_proxy.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>