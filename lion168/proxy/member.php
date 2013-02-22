<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "member";

if($uid){

	$query = "select m.jointime,m.username,todayLiveGameExcludeEvenandTieAmount,g.grouptitle from ek_member m left join ek_member_group g on g.groupid=m.groupid left join ek_now_live_game_bet n on n.uid=m.uid left join ek_live_game_bet e on e.uid=m.uid where m.uid='$uid' ";
	$row = $dsql->GetOne($query);
	if(!is_array($row))
	{
		ShowMsg("读取用户基本信息出错!","-1");
		exit();
	}
	$rowl = $dsql->GetOne("Select sum(LiveGameExcludeEvenandTieAmount) as LiveGameExcludeEvenandTieAmount From `ek_live_game_bet` where uid='$uid'");
	$LiveGameExcludeEvenandTieAmount=$rowl['LiveGameExcludeEvenandTieAmount']+$row['todayLiveGameExcludeEvenandTieAmount'];
	$rowd = $dsql->GetOne("SELECT sum(cash) as cash FROM ek_member_incash where state = 2 and type ='1' and uid = $uid");//存款
	$cash = $rowd['cash'];
	$rowd = $dsql->GetOne("SELECT sum(cash) as outcash FROM ek_member_incash where state = 2 and type ='2' and uid = $uid");//取款
	$outcash = $rowd['outcash'];
	$jointime = MyDate('Y-m-d',$row['jointime']);
	
$t->assign('cash',$cash);
$t->assign('outcash',$outcash);
$t->assign('jointime',$jointime);
$t->assign('LiveGameExcludeEvenandTieAmount',$LiveGameExcludeEvenandTieAmount);
$t->assign('username',$row['username']);
$t->assign('todayLiveGameExcludeEvenandTieAmount',$row['todayLiveGameExcludeEvenandTieAmount']);
$t->assign('grouptitle',$row['grouptitle']);
$t->display('agent/member.html',"$cacheid");
}