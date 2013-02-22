<?php 
session_start();
$ip=$_SESSION['USER_ip'];
if($ip==''){
$ip= $_SERVER["REMOTE_ADDR"];
$http= 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; 
$U_RL=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$time=date("y-m-d H-i-s");
$sql="insert into record (`ip`,`http`,`ontime`) values ('$ip','$http','$time')";
	mysql_query($sql);
	if($_GET["from"] || $_GET["proxy"]){
	if($_GET["from"])
	{
		$i_from=$_GET["from"];
		$sql="select * from popularize where phttp='$i_from'";
		$query=mysql_query($sql) or die(mysql_error());
		$rs=mysql_fetch_array($query);
		$pname=$rs['pname'];
		}
	elseif($_GET["proxy"])
	{
		$i_from=$_GET["proxy"];
		$sql="select * from ek_proxy where domainid='$i_from'";
		$query=mysql_query($sql) or die(mysql_error());
		$rs=mysql_fetch_array($query);
		$proxyuid=$rs['uid'];
		$pname=$http;
		}
	}/*elseif($U_RL)
	{
		$i_from=$U_RL;
		$sql="select * from ek_proxy where domain='$i_from'";
		$query=mysql_query($sql);
		$rs=mysql_fetch_array($query);
		if($rs['uid']){
		$proxyuid=$rs['uid'];
		}else{
		$i_from=$U_RL;
		$pname=$U_RL;
		}
		}*/
	session_start();
  	$_SESSION['USER_ip'] = $ip;
   	$_SESSION['W_http'] = $i_from;
    $_SESSION['ON_time'] = $time; 
	$_SESSION['proxyuid'] = $proxyuid;
	$_SESSION['pname'] = $pname;
 
}
?>