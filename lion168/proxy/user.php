<?php
require_once(dirname(__FILE__)."/config.php");


CheckRank(0,0);
CheckNotAllow();
$cacheid = "newsJoinIn";

 ///代理佣金
 $rs=$dsql->GetOne("select sum(cashmoney) as sumcash  from `proxy_cash` where proxyuid = $cfg_cl->M_ID and outcash = 0 ");
 $t->assign('cashmoney',$rs['sumcash']);




$numPerPage=10;
$page = isset($page) ? intval($page) : 1;

 
$proxyuid="{$cfg_cl->M_ID}";

		$y=date('Y');
		$m=date('m');
		if($m==0){$m=12;}
		$BetStartDate = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,01,$y)));
		$BetEndDate = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,$m,31,$y)));
		$csqlStr_one="SELECT count(*) as dd ,b.proxyuid,b.addtime from ek_proxy_member_thismonth b where  proxyuid='$cfg_cl->M_ID'";
		$row = $dsql->GetOne($csqlStr_one);
		if(is_array($row)){$TotalResult = $row['dd'];}else{$TotalResult = 0;}	
		$addtime=strtotime(MyDate('Y-m-d',$row['addtime']));
		if($BetStartDate!=$addtime)
		{
			$sql_class="m.uid,m.username,m.jointime,m.truename,m.`status`,m.proxyid,m.active,mg.grouptitle,mg.groupid,mg.groupid,p.fencheng";
			$sql_tab="ek_member  m,ek_proxy p,ek_member_group mg ";
			$whereStr="m.proxyid=p.uid  and m.groupid=mg.groupid   and p.uid=$proxyuid ";	 
			$sql_order="order by m.jointime $get_select2 ";
			$date_i=0;
			$sqlStr_st="SELECT  $sql_class  FROM  $sql_tab  WHERE  $whereStr   $sql_order";
			$dsql->SetQuery($sqlStr_st);	
			$dsql->Execute('data_lien');
			while($roww_st=$dsql->GetArray('data_lien'))
			{		
				$fencheng=$roww_st['fencheng'];			
				$username=$roww_st['username'];	
				$rowe_b=$roww_st['active'];//用户活跃值		
				$uid=$roww_st['uid'];
				//$row_ra = $dsql->GetOne("SELECT  ra.AllRegularChips FROM regularchips_all ra where ra.uid=$uid");
				$rowq = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=2 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
				$rowm = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=1 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
				$row_nlg = $dsql->GetOne("SELECT sum(StakedAmount) as StakedAmount  FROM ek_live_game_bet where uid=$uid and addtime>=$BetStartDate and addtime<$BetEndDate");
				$rowd = $dsql->GetOne("SELECT sum(hongli) as dd ,sum(shouxufei) as shouxufei FROM ek_member_incash where uid=$uid and addtime>$BetStartDate and addtime<$BetEndDate");
				$rowb = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where UserName='$username'and BetEndDate>$BetStartDate and BetEndDate<$BetEndDate");	
				$SumPayout=$rowb['SumPayout']; 
				//if($SumPayout >0){$SumPayout=0;}
				$hongli=$rowb['dd'];
				$shouxufei=$rowd['shouxufei'];
				$fcmoney_new=0;
				if($rowq[uid]||$rowm[uid]){$userActive = 1;}else{$userActive = 0;}
				$SumPayout=0-$SumPayout;
				$SumPayout=$SumPayout-$hongli-$shouxufei;
				if($SumPayout < 0){$SumPayout = 0;}
				$fcmoney_new=$SumPayout*$fencheng;
				$fcmoney=round($fcmoney_new,2);
				$userUid=$roww_st['uid'];//用户ID
				$userNumber=$roww_st['username'];//用户帐号
				$userJointime =$roww_st['jointime'];//用户注册时间			
				$truename=$roww_st['truename'];//用户名
				$userStatus=$roww_st['status'];//用户状态
				$proxyid= $roww_st['proxyid'] ;//代理ID
				//echo "<br /> 活跃度=".$userActive=$roww_st['active'];//活跃度
				$userGrouptitle=$roww_st['grouptitle'];//用户级别名称
				//$userAllRegularChips=$row_ra['AllRegularChips'];//现金码
				$userGroupid=$roww_st['groupid'];//用户级别ID
				$userDividend=$rowd['dd'] + $rowg['dd'];//红利-->反水/优惠
				$userPoundage=$rowd['shouxufei'];//手序费
				$komisyon=$fcmoney;//提成
				$netoKita=$SumPayout;//利润（元）
				$userAllStakedAmount=$row_nlg['StakedAmount'];//总投注额
				$insql_insert="replace INTO ek_proxy_member_thismonth (userUid,proxyuid,userNumber,userName,userGroupid,userGrouptitle,userJointime,fencheng,netoKita,userStatus,userActive,userDividend,userPoundage,komisyon,userAllStakedAmount,addtime
			 ) VALUES ('$userUid','$proxyid','$userNumber','$truename','$userGroupid','$userGrouptitle','$userJointime','$fencheng','$netoKita','$userStatus','$userActive','$userDividend','$userPoundage','$komisyon','$userAllStakedAmount'
			,'".time()."');";
				$dsql->ExecuteNoneQuery($insql_insert);	
			}
		}
		
		
		




//会员等级
$sqlStr_mg="SELECT  groupid,grouptitle  FROM  ek_member_group  order by groupid asc";
$dsql->SetQuery($sqlStr_mg);
$dsql->Execute('data_list_mg');
$datas_mg=array();

while($row_mg=$dsql->GetArray('data_list_mg'))
{
	$datas_mg[]=$row_mg;
}

$get_begin_date =$begin_date;	//开始时间	begin_date
$get_end_date =$end_date;		//结束时间	end_date
$get_textfield = trim($textfield);		//账户	textfield
$get_select2 = trim($select2);			//排序	select2
$get_select3 = trim($select3);			//会员等级	select3
$get_select4 = trim($select4);			//状态	select4  

$csqlStr="select count(*) as dd from `ek_proxy_member_thismonth`  $whereStr";
$row = $dsql->GetOne($csqlStr);
if(is_array($row)){
$TotalResult = $row['dd'];
}else{
$TotalResult = 0;
}
$TotalPage = ceil($TotalResult/$numPerPage);
if ($page>$TotalPage) $page=$TotalPage;
$limitstart = ($page-1) * $numPerPage;
if($limitstart<0) $limitstart=0;

$is_form.=" 1=1 ";
if($get_select3!=""){$is_form.= " and userGroupid= '$get_select3'" ;}
if($get_textfield!=""){$is_form.= "and userNumber LIKE '%$get_textfield%'";}
if($get_select4!=""){$is_form.= "and userStatus='$get_select4' ";}

if($get_select2==""){$get_select2="DESC";}
$whereStr="where $is_form and  proxyuid='{$cfg_cl->M_ID}'";

$sqlStr_sql="select * from ek_proxy_member_thismonth  $whereStr order by netoKita  $get_select2 limit $limitstart,$numPerPage";
 
$dsql->SetQuery($sqlStr_sql);
$dsql->Execute('data_li');
$datas_f=array();
$in_i=1;
while($roww=$dsql->GetArray('data_li'))
{
	//print_r($roww);
	$roww['i']=$in_i++;
	$roww['userJointime']=MyDate('Y-m-d',$roww['userJointime']);
	$roww['fencheng']=$roww['fencheng']*100;
	$datas_f[]=$roww;
}

$t->assign('datas_mg',$datas_mg);
$t->assign('datas_f',$datas_f);
$t->assign('TotalResult',$TotalResult);
$t->assign('numPerPage',$numPerPage);
$t->assign('page',$page);
$t->assign('TotalPage',$TotalPage);
if($page>1)
$perpage='?page='.($page-1);
else
$perpage='?page=1';

if($page<$TotalPage)
$nextpage='?page='.($page+1);
else
$nextpage='?page='.$TotalPage.($get_begin_date ? '&get_begin_date='.$get_begin_date : '').($get_end_date ? '&get_end_date='.$get_end_date : '').($get_textfield ? '&get_textfield='.$get_textfield : '').($get_select3 ? '&get_select3='.$get_select3 : '').($get_select4 ? '&get_select4='.$get_select4 : '');
$firstpage='?page=1';
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);
$t->display('agent/user.html',"$cacheid");