<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Payment');
if(empty($action))
{
	$action = '';
}
$back=$Ekrurl;
$id = isset($id) && is_numeric($id) ? $id : 0;
if($managesubmit){
	if($submitway=='creater'){
		$subject = $subject ? $subject : 'unNamed';
		$folder = $folder ? $folder : '';
		if ($folder){
			$fetch = $dsql->GetOne("SELECT id FROM ek_payment_config WHERE upid = '0' AND folder = '{$folder}'");
			if (!$fetch['id']){
				$dsql->ExecuteNoneQuery("INSERT INTO ek_payment_config (used,upid,folder,subject) VALUES ('0','0','$folder','$subject')");
			}
		}
	} elseif ($submitway == 'setused') {
		$ids = $commi = '';
		$qids = $commq = '';
		foreach ($selects as $id){ $ids .= $commi.$id; $commi = ','; }
		$used = $status ? 1 : 0;
		$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE id IN ('".str_replace(",","','",$ids)."') AND upid = '0'");
		$dsql->Execute('config_list');
		while($row=$dsql->GetArray('config_list')){
			if ($row['used'] != $used){
				$qids .= $commq.$row['id']; $commq = ',';
			}
		}
		if ($qids){
			$dsql->ExecuteNoneQuery("UPDATE ek_payment_config SET used = '$used' WHERE id IN ('".str_replace(",","','",$qids)."')");
		}
	} elseif ($submitway == 'deleter') {
		$ids = $commi = '';
		$qids = $commq = '';
		foreach ($selects as $id){ $ids .= $commi.$id; $commi = ','; }
		$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE id IN ('".str_replace(",","','",$ids)."') AND upid = '0'");
		$dsql->Execute('config_list');
		while($row=$dsql->GetArray('config_list')){
			$qids .= $commq.$row['id']; $commq = ',';
		}
		if ($qids){
			$dsql->ExecuteNoneQuery("DELETE FROM ek_payment_config WHERE id IN ('".str_replace(",","','",$qids)."')");
			$dsql->ExecuteNoneQuery("DELETE FROM ek_payment_config WHERE upid IN ('".str_replace(",","','",$qids)."')");
		}
	}
	ShowMsg("操作成功，返回!","admin_payment.php");
	exit();
}elseif ($configsubmit){
	$apiid = is_numeric($configid) && $configid > 0 ? intval($configid) : 0;
	if ($apiid){
		$fetch = $dsql->GetOne("SELECT * FROM ek_payment_config WHERE id = '$apiid' AND upid = '0'");
		if ($fetch['id']){
			$dsql->ExecuteNoneQuery("UPDATE ek_payment_config SET subject = '$subject', description = '$description', image = '$image' WHERE id = '$apiid'");
			$dids = $commd = '';
			$selects = is_array($selects) ? $selects : array();
			$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE upid = '$apiid'");
			$dsql->Execute('config_list');
			while($row=$dsql->GetArray('config_list')){
				if (in_array($row['id'],$selects)){
					$dids .= $commd.$row['id']; $commd = ',';
				} else {
					$description = $_POST['description'.$row['id']];
					$confkey = $_POST['confkey'.$row['id']];
					$confval = $_POST['confval'.$row['id']];
					$dsql->ExecuteNoneQuery("UPDATE ek_payment_config SET description = '$description', confkey = '$confkey', confval = '$confval' WHERE id = '$row[id]'");
				}
			}
			$dids && $dsql->ExecuteNoneQuery("DELETE FROM ek_payment_config WHERE id IN ('".str_replace(",","','",$dids)."')");
			$description = $descriptionn;
			$confkey = $confkeyn;
			$confval = $confvaln;
			if ($confkey){
				$dsql->ExecuteNoneQuery("INSERT INTO ek_payment_config (upid,description,confkey,confval) VALUES ('$apiid','$description','$confkey','$confval')");
			}
		}
		ShowMsg("配置更新成功，返回!","admin_payment.php");
		exit();
	}
}
if($action=='edit')
{
	if (is_numeric($id) && $id > 0){
		$loops=array();
		$fetch = $dsql->GetOne("SELECT * FROM ek_payment_config WHERE id = '{$id}' AND upid = '0'");
		if ($fetch['id']){
			$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE upid = '{$id}'");
			$dsql->Execute('config_list');
			while($row=$dsql->GetArray('config_list')){
				$loops[] = $row;
			}
		}
	}
	include(EK_ADMIN.'/templets/admin_top.html');
	include(EK_ADMIN.'/templets/admin_payment_edit.html');
	include(EK_ADMIN.'/templets/admin_foot.html');
	exit();
}
include(EK_ADMIN.'/templets/admin_top.html');
include(EK_ADMIN.'/templets/admin_payment.html');
include(EK_ADMIN.'/templets/admin_foot.html');
exit();
?>