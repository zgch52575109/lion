<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "recommend";

if($errFriends!=''){
	if($errFriends=='1'){

		$rowm = $dsql->GetOne("Select * From `ek_member` where username='$busername' ");
		if(is_array($rowm)){
			if($busername==$cfg_cl->fields['username']){
				ShowMsg('不能添加自己！','-1');
				exit();
			}
			if($rowm['topuid']>0){
				ShowMsg('推荐人已经被推荐过！','-1');
				exit();
			}
			if($cfg_cl->fields['groupid']<2){
				//ShowMsg('请先升级为星级会员！','-1');
				//exit();
			}
			if($rowm['firstmoney']<=0){
				ShowMsg('推荐人已经被推荐过！','-1');
				exit();
			}
			$tjmoney=$cfg_memeber_tuijian_fencheng*$rowm['firstmoney'];
			$insql="INSERT INTO `ek_member_tuiguang` (`uid` ,`touid`) VALUES ('$rowm[uid]','$cfg_cl->M_ID')";
			$dsql->ExecuteNoneQuery($insql);
			$dsql->ExecuteNoneQuery("update ek_member set tjmoney=tjmoney+$tjmoney,tjnum=tjnum+1 where uid='$cfg_cl->M_ID'");
			$orderid=date('ymdHis').rand(1000,9999);
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','12','$tjmoney','".time()."')");//资金记录
			$dsql->SetQuery("Select cash,czhengfu from ek_member_incash where uid='$rowm[uid]' and state='2' order by addtime desc limit 3");
			$dsql->Execute('data_list');
			$datas=array();
			while($row=$dsql->GetArray('data_list'))
			{
				$datas[]=$row;
			}
			if(is_array($datas)){
				if(isset($datas[1])){
					$tjmoney=$cfg_memeber_tuijian_fencheng2*($datas[1]['cash']+$datas[1]['czhengfu']);
					$dsql->ExecuteNoneQuery("update ek_member set tjmoney=tjmoney+$tjmoney where uid='$cfg_cl->M_ID'");
					$orderid=date('ymdHis').rand(1000,9999);
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','12','$tjmoney','".time()."')");//资金记录
				}
				if(isset($datas[2])){
					$tjmoney=$cfg_memeber_tuijian_fencheng3*($datas[2]['cash']+$datas[2]['czhengfu']);
					$dsql->ExecuteNoneQuery("update ek_member set tjmoney=tjmoney+$tjmoney where uid='$cfg_cl->M_ID'");
					$orderid=date('ymdHis').rand(1000,9999);
					$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_cash_log` (orderid,uid,type,cash,addtime) VALUES ('$orderid','$cfg_cl->M_ID','12','$tjmoney','".time()."')");//资金记录
				}
			}
			ShowMsg('添加成功！','recommend.php');
			exit();
		}else{
			ShowMsg('用户不存在！','-1');
			exit();
		}
	}else{
		if($busername<>''){
			$rowm = $dsql->GetOne("Select * From `ek_member` where username='$busername' ");
			if(is_array($rowm)){
				$rowm['jointime']=MyDate('d/m/y',$rowm['jointime']);
				if($rowm['status']){
					$rowm['status']='正常';
				}else{
					$rowm['status']='冻结';
				}
				$errFriends='';
				if($busername==$cfg_cl->fields['username']){
					$errFriends='不能添加自己！';
				}else{
					if($cfg_cl->fields['groupid']<2){
						//$errFriends='请先升级为星级会员！';
					}
					if($rowm['firstmoney']<=0){
						$errFriends.='推荐人还未开户！';
					}
				}
				if($rowm['topuid']>0){
					$errFriends.='推荐人已经被推荐过！';
				}
			}else{
				$rowm['truename']='该用户不存在！';
				$errFriends='请查询到再添加！';
			}
			$t->assign('rowm',$rowm);
		}
	}
}
$t->assign('errFriends',$errFriends);
$t->assign('busername',$busername);
$t->assign('firstmoney',$cfg_cl->fields['firstmoney']);
$t->assign('jointime',MyDate('d/m/y',$cfg_cl->fields['jointime']));

$numPerPage=30;
$page = isset($page) ? intval($page) : 1;

$whereorder="where b.touid='{$cfg_cl->M_ID}'";
$csqlStr="select count(*) as dd from `ek_member_tuiguang` b $whereorder";
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

$sqlStr="select m.username,m.truename,m.groupid,m.jointime,m.firstmoney,m.status from ek_member_tuiguang b left join ek_member m on m.uid=b.uid $whereorder order by m.jointime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$row['jointime']=MyDate('Y-m-d H:i:s',$row['jointime']);
	$datas[]=$row;
}

$t->assign('datas',$datas);

$t->assign('TotalResult',$TotalResult);
$t->assign('numPerPage',$numPerPage);
$t->assign('page',$page);
$t->assign('TotalPage',$TotalPage);
$perpage='?page='.($page-1);
$nextpage='?page='.($page+1);
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);

$t->display('member/recommend.html',"$cacheid");