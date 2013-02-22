<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
$cacheid = "bank_bd";

$id = isset($id) && is_numeric($id) ? $id : 0;

if($action=='edit'){
	if(!$cfg_memeber_bank_edit){
		ShowMsg("您没有权限编辑银行卡!","-1");
		exit();
	}
	$query = "select * from ek_member_bank where id='$id' and uid='$cfg_cl->M_ID' ";
	$rowp = $dsql->GetOne($query);
	if(!is_array($rowp))
	{
		ShowMsg("读取银行卡基本信息出错!","-1");
		exit();
	}
	$t->assign($rowp);
	$t->assign('banktype',getBankTypeLists());
	$t->assign('id',$id);
	$t->display('member/bankadd.html',"$cacheid");
}elseif($action=='save'){
	if($id){
		if(!$cfg_memeber_bank_edit){
			ShowMsg("您没有权限编辑银行卡!","-1");
			exit();
		}
	}
	$bankid = isset($bankid) && is_numeric($bankid) ? $bankid : 0;
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
	if($cardnum!=$cardnum1){
		ShowMsg("两次输入银行卡号码不一致！","-1");
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
	if($idnumber<>''){
		if (!preg_match("/^(?:\d{15}|\d{17}([0-9]|X))$/i", $idnumber)){
			ShowMsg("身份证格式不正确！","-1");
			exit();
		}
	}

	if(!$id){
		//检查用户绑定银行个数
		if($cfg_cl->fields['bankmaxnum']){
			$bankmaxnum=$cfg_cl->fields['bankmaxnum'];
		}else{
			$bankmaxnum=$groupdb['bankmaxnum'];
		}
		if($bankmaxnum){
			$row = $dsql->GetOne("Select count(*) as dd From `ek_member_bank` where uid='$cfg_cl->M_ID'");
			if(is_array($row)){
				if($row['dd']>=$bankmaxnum){
					ShowMsg("绑定银行卡数量已满！","bank_bd.php");
					exit;
				}
			}
		}
		$row = $dsql->GetOne("Select id From `ek_member_bank` where cardnum='$cardnum'");
		if(is_array($row)){
			ShowMsg("您要绑定的银行卡已存在！","bank_bd.php");
			exit;
		}

		$insql="INSERT INTO `ek_member_bank` (uid,sf,city,bankid,zhihang,cardnum,realname,idnumber,addtime) VALUES ('$cfg_cl->M_ID','$sf','$city','$bankid','$zhihang','$cardnum','$realname','$idnumber','".time()."')";
	}else{
		$insql="update `ek_member_bank` set sf='$sf',city='$city',bankid='$bankid',zhihang='$zhihang',cardnum='$cardnum',realname='$realname',idnumber='$idnumber' where id='$id' and uid='$cfg_cl->M_ID'";
	}
	if($dsql->ExecuteNoneQuery($insql)){
		$dsql->ExecuteNoneQuery("INSERT INTO `ek_member_history_bank` (`uid`,`bankid`,`realname`,`cardnum`,`dateline`)VALUES ('$cfg_cl->M_ID','$bankid','$realname','$cardnum','".time()."')");
		ShowMsg('成功保存银行卡信息！','bank_bd.php',0,5000);
		exit();
	}
	ShowMsg('保存失败，请检查所填项目！','-1');
	exit();
}elseif($action=='add'){
	$t->assign('banktype',getBankTypeLists());
	$t->display('member/bankadd.html',"$cacheid");
	exit();
}elseif($action=='del'){
	if(!$cfg_memeber_bank_del){
		ShowMsg("您没有权限删除银行卡!","-1");
		exit();
	}
	$dsql->ExecuteNoneQuery("delete from ek_member_bank where id='$id' and uid='$cfg_cl->M_ID'");
	ShowMsg("银行卡删除成功","bank_bd.php");
	exit();
}

$numPerPage=5;
$page = isset($page) ? intval($page) : 1;

$whereorder="where b.uid='{$cfg_cl->M_ID}'";
$csqlStr="select count(*) as dd from `ek_member_bank` b $whereorder";
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

$sqlStr="select b.*,tp.tname from ek_member_bank b left join ek_bank_type tp on tp.tid=b.bankid $whereorder order by b.addtime desc limit $limitstart,$numPerPage";
$dsql->SetQuery($sqlStr);
$dsql->Execute('data_list');
$i=0;
$datas=array();
while($row=$dsql->GetArray('data_list'))
{
	$i++;
	$row['i']=$i;
	$datas[]=$row;
}

$t->assign('datas',$datas);
$t->assign('i',$i);
$t->assign('isedit',$cfg_memeber_bank_edit);
$t->assign('isdel',$cfg_memeber_bank_del);

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
$nextpage='?page='.$TotalPage;
$firstpage='?page=1';
$lastpage='?page='.$TotalPage;
$t->assign('perpage',$perpage);
$t->assign('nextpage',$nextpage);
$t->assign('firstpage',$firstpage);
$t->assign('lastpage',$lastpage);

$t->display('member/bank_bd.html',"$cacheid");