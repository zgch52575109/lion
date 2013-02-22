<?php
require_once(dirname(__FILE__)."/config.php");
$check = trim(strtolower($_GET['check']));
if($check=='us'){
$username = trim(strtolower($_POST['username']));
$username = mysql_escape_string($username);

if ($username) { 
	//email通过检查
	$query = "SELECT username FROM ek_member WHERE username = '$username' LIMIT 1";
	$result = mysql_query( $query );
	$num = mysql_num_rows($result);
	echo $num;
} 
else{
echo "1";//不能注册
}
}
if($check=='pw'){
$username = trim(strtolower($_POST['username']));
$username = mysql_escape_string($username);

if ($username) { 
	//email通过检查
	$query = "SELECT username FROM ek_member WHERE username = '$username' LIMIT 1";
	$result = mysql_query( $query );
	$num = mysql_num_rows($result);
	echo $num;
} 
else{
echo "1";//不能注册
}
}
?>