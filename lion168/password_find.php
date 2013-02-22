<?php
require_once(dirname(__FILE__)."/member/config.php");

$cacheid = "passwrod_find";
$t->assign('page_name','index');
$t->assign('noticear',get_notice_list('1'));
if($action=='find'){
    if(empty($username))
    {
        showmsg('对不起，请输入用户名', '-1');
        exit;
    }elseif(empty($safequestion) || empty($safeanswer)){
        ShowMsg("请输入密码问题和答案！","-1");
        exit();
    }elseif (Checkuid($username, '', false) != 'ok'){
        ShowMsg("你输入的用户名 {$username} 不合法！","-1");
        exit();
	}elseif(empty($ps)){
		ShowMsg("对不起，请输入密码！","-1");
		exit();
	}elseif(empty($ps1)){
		ShowMsg("对不起，请输入密码！","-1");
		exit();
	}elseif($ps1!=$ps){
		ShowMsg("对不起，两次输入的密码不同！","-1");
		exit();
	}
    $member = member($username);
	$uid=$member['uid'];
	if(!$member['secques'])
	{
		showmsg('对不起您尚未设置安全密码，请联想管理员重设密码', '/');
		exit;
	}
	$secques=$safequestion > 0 ? quescrypt($safequestion, $safeanswer) : '';
	if($secques==''){
        ShowMsg("请输入密码问题和答案！","-1");
        exit();
	}else{
		if($secques==$member['secques']){
		$pwd = trim($ps);
		$ps=md5($pwd);
		$dateline=time();
		$query1 = "UPDATE `ek_member` SET password='$ps' where uid='$uid' ";
	if($dsql->ExecuteNoneQuery($query1)){
		$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_password` (`uid`,`password`,dateline)VALUES ('$uid','$ps','$dateline')");
		ShowMsg('成功修改密码！','login.html',0,5000);
		exit();
	}
	ShowMsg('修改密码失败！','-1');
	exit();
		}else{
        ShowMsg("对不起您选择的问题或输入的答案错误，请重新输入！","-1");
        exit();
		}
	}
}

if(GetCookie('EKuid')!=''){
	$t->assign('loginname',GetCookie('EKUserName'));
	$t->assign('loginuid',GetCookie('EKuid'));
}

$t->display('index/password_find.html',"$cacheid");