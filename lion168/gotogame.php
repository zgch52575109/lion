<?php
require_once(dirname(__FILE__)."/config.php");
	$mobile = $_POST[mobile];
	$time = time();
	$ip= $_SERVER["REMOTE_ADDR"];
	session_start();
	if($_SERVER['SERVER_NAME']==$_SESSION['W_http']){
	$http= 'http://'.$_SERVER['SERVER_NAME'];
	}else{
	$http= 'http://'.$_SERVER['SERVER_NAME'].'?from='.$_SESSION['W_http'];
	}
	$begin_date=date("Y-m-d");
	$begin_date=date("Y-m-d");
	$begin_date=strtotime($begin_date);
	$rowp = $dsql->GetOne("select COUNT(*) as cuntip from ek_game_testuser where time>=$begin_date and ip = '$ip'");	
	$cuntip=$rowp['cuntip'];
	if($cuntip>=3){
	if($ip=='222.127.206.144'){
	$row = $dsql->GetOne("select max(id) as id from ek_game_testuser");	
	$id=$row['id']+1;
	$id=10000+$id;
	$username = "JS_".$id;
	$sql="insert into ek_game_testuser (`ip`,`time`,`username`,`http`,`mobile`) values ('$ip','$time','$username','$http','$mobile')"; 
	$dsql->ExecuteNoneQuery($sql);
	$ticketid=regHGuser($username,$username,0);

   
	if($ticketid){
		header("Location:".$cfg_apiloginurl.$ticketid."&lang=ch");
		exit();
	}else{
		ShowMsg("系统出现错误，请联系客服人员！","-1");
		exit();
	}
	}
	?>
	<script language=javascript>alert('您是已经试玩游戏3次，请您申请真钱账号进行游戏！\r\n 祝您游戏愉快！');opener=null;window.close();</script>
	<?php
	exit;
	}
	$row = $dsql->GetOne("select max(id) as id from ek_game_testuser");	
	$id=$row['id']+1;
	$id=10000+$id;
	$username = "JS_".$id;
	$sql="insert into ek_game_testuser (`ip`,`time`,`username`,`http`) values ('$ip','$time','$username','$http')"; 
	$dsql->ExecuteNoneQuery($sql);
	$ticketid=regHGuser($username,$username,0);
	if($ticketid){
		header("Location:".$cfg_apiloginurl.$ticketid."&lang=ch");
		exit();
	}else{
		ShowMsg("系统出现错误，请联系客服人员！","-1");
		exit();
	}
?>
