<?php
require_once(dirname(__FILE__)."/config.php");


CheckRank(0,0);
CheckNotAllow();
$cacheid = "newsJoinIn";

$numPerPage=12;
$page = isset($page) ? intval($page) : 1;


$proxyuid="{$cfg_cl->M_ID}";


/*if($action=="edit"){  
		//echo //更新
		$y=date('Y');
		$m=date('m');
		if($m==0){$m=12;}
		$BetStartDate = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,01,$y)));
		$BetEndDate = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,$m,31,$y)));
		$csqlStr_one="SELECT count(*) as dd ,b.proxyuid,b.addtime from ek_proxy_member_thismonth b where  proxyuid='$cfg_cl->M_ID'";
		$row = $dsql->GetOne($csqlStr_one);
		if(is_array($row)){$TotalResult = $row['dd'];}else{$TotalResult = 0;}	
		$addtime=strtotime(MyDate('Y-m-d',$row['addtime']));
		if($BetStartDate!=$addtime){
			$rowea = $dsql->GetOne("SELECT active FROM ek_active where id =1");//获得用户活跃值	

		$sql_class="m.uid,m.username,m.jointime,m.truename,m.`status`,m.proxyid,m.active,mg.grouptitle,mg.groupid,mg.groupid,ra.AllRegularChips,p.fencheng,nlg.allStakedAmount";
		$sql_tab="ek_member  m,ek_proxy p,ek_member_group mg,regularchips_all ra ,ek_now_live_game_bet nlg";
		$whereStr="m.proxyid=p.uid  and m.groupid=mg.groupid and m.uid=ra.uid and p.uid=$proxyuid and m.uid=nlg.uid";		 
		$sql_order="order by m.jointime $get_select2 ";
		$date_i=0;
		$sqlStr_st="SELECT  $sql_class  FROM  $sql_tab  WHERE  $whereStr   $sql_order";
		
		$rowe_a=$rowea['active'];//系统活跃值
		$userActive=0;
		
		
		$dsql->SetQuery($sqlStr_st);	
		$dsql->Execute('data_lien');
		while($roww_st=$dsql->GetArray('data_lien'))
		{		
			$fencheng=$roww_st['fencheng'];			
			$username=$roww_st['username'];	
			$rowe_b=$roww_st['active'];//用户活跃值		
			$uid=$roww_st['uid'];
			$rowd = $dsql->GetOne("SELECT sum(hongli) as dd ,sum(shouxufei) as shouxufei FROM ek_member_incash where uid=$uid and addtime>$BetStartDate and addtime<$BetEndDate");
			$rowg = $dsql->GetOne("SELECT sum(hongli) as dd FROM ek_member_firsthongli where uid=$uid and lingqutime>$BetStartDate and lingqutime<$BetEndDate");
			$rowb = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where UserName='$username'and BetEndDate>$BetStartDate and BetEndDate<$BetEndDate");	
			$SumPayout=$rowb['SumPayout']; 
			if($SumPayout >0){$SumPayout=0;}
			
			$hongli=$rowb['dd'];
			$shouxufei=$rowd['shouxufei'];
			
			$firsthongli=$rowg['dd'];
				if($rowe_b >= $rowe_a){
					$userActive=1;
					if($SumPayout<0){
						$SumPayout=0-$SumPayout;
						$SumPayout=$SumPayout-$hongli-$firsthongli-$shouxufei;
						$fcmoney_new=$SumPayout*$fencheng;
					}else{
						$fcmoney_new=0;
					}
				}
				
			
			
			$fcmoney=round($fcmoney_new,2);
			if($SumPayout < 0){$SumPayout=0;}
			
			$userUid=$roww_st['uid'];//用户ID
			$userNumber=$roww_st['username'];//用户帐号
			$userJointime =$roww_st['jointime'];//用户注册时间			
			$truename=$roww_st['truename'];//用户名
			$userStatus=$roww_st['status'];//用户状态
			$proxyid= $roww_st['proxyid'] ;//代理ID
			//echo "<br /> 活跃度=".$userActive=$roww_st['active'];//活跃度
			$userGrouptitle=$roww_st['grouptitle'];//用户级别名称
			$userAllRegularChips=$roww_st['AllRegularChips'];//现金码
			$userGroupid=$roww_st['groupid'];//用户级别ID
			$userDividend=$rowd['dd'] + $rowg['dd'];//红利-->反水/优惠
			$userPoundage=$rowd['shouxufei'];//手序费
			$komisyon=$fcmoney;//提成
			$netoKita=$SumPayout;//利润（元）
			$userAllStakedAmount=$roww_st['allStakedAmount'];//总投注额
			$insql_insert="replace INTO ek_proxy_member_thismonth (userUid,proxyuid,userNumber,userName,userGroupid,userGrouptitle,userJointime,userAllRegularChips,fencheng,netoKita,userStatus,userActive,userDividend,userPoundage,komisyon,userAllStakedAmount,addtime
		 ) VALUES ('$userUid','$proxyid','$userNumber','$truename','$userGroupid','$userGrouptitle','$userJointime','$userAllRegularChips','$fencheng','$netoKita','$userStatus','$userActive','$userDividend','$userPoundage','$komisyon','$userAllStakedAmount'
		,'".time()."');";
			$dsql->ExecuteNoneQuery($insql_insert);	

		}
		}
		
	}*/




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







$csqlStr="select count(*) as dd from `ek_proxy_member_excltmonth`  $whereStr";
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
if($get_begin_date!=""){$is_form.= " and userJointime > $get_begin_date ";}
if($get_end_date!=""){$is_form.= " and userJointime < $get_end_date ";}
if($get_select3!=""){$is_form.= " and userGroupid= '$get_select3'" ;}
if($get_textfield!=""){$is_form.= "and userNumber LIKE '%$get_textfield%'";}
if($get_select4!=""){$is_form.= "and userStatus='$get_select4' ";}

if($get_select2==""){$get_select2="DESC";}
$whereStr="where $is_form and  proxyuid='{$cfg_cl->M_ID}'";

$sqlStr_sql="select * from ek_proxy_member_excltmonth  $whereStr order by netoKita  $get_select2 limit $limitstart,$numPerPage";
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
$t->display('agent/join_inMonth.html',"$cacheid");