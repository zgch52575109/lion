<?php
require_once ("../../../member/config.php");
CheckRank(0,0);
class _wespace_apis_payment_return_{
	function loader(){
		global $dsql,$cfg_ml,$cfg_basehost;
		$result = 0;
		$vars = array(
		'body'			=> $_GET['body'],
		'buyer_email'	=> $_GET['buyer_email'],
		'buyer_id'		=> $_GET['buyer_id'],
		'exterface'		=> $_GET['exterface'],
		'is_success'	=> $_GET['is_success'],
		'notify_id'		=> $_GET['notify_id'],
		'notify_time'	=> $_GET['notify_time'],
		'notify_type'	=> $_GET['notify_type'],
		'out_trade_no'	=> $_GET['out_trade_no'],
		'payment_type'	=> $_GET['payment_type'],
		'seller_email'	=> $_GET['seller_email'],
		'seller_id'		=> $_GET['seller_id'],
		'subject'		=> $_GET['subject'],
		'total_fee'		=> $_GET['total_fee'],
		'trade_no'		=> $_GET['trade_no'],
		'trade_status'	=> $_GET['trade_status']
		);
		$config = array();
		$decodes = explode("\t",_base_endecode_($vars['body'],1));
		//$director = $this->_base_tpl_linker_('member','payment','index');
		$decodes['0'] = is_numeric($decodes['0']) && $decodes['0'] > 0 ? intval($decodes['0']) : 0; // id.payment.api
		$decodes['1'] = is_numeric($decodes['1']) && $decodes['1'] > 0 ? intval($decodes['1']) : 0; // id.payment.record
		$decodes['3'] = is_numeric($decodes['3']) && $decodes['3'] > 0 ? sprintf('%.02f',$decodes['3']) : 0.00; // price
		if ($decodes['0']){
			$fetch = $dsql->GetOne("SELECT * FROM ek_payment_config WHERE id = '{$decodes[0]}' AND used = '1' AND upid = '0'");
			if ($fetch['id']){
				$config['api'] = &$fetch;
				$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE upid = '{$decodes[0]}'");
				$dsql->Execute('config_list');
				while ($apier = $dsql->GetArray('config_list')){
					$config['conf'][$apier['confkey']] = $apier['confval'];
				}
			}
		}
		$code = $conf['authkey'];
		$auth = $comma = '';
		foreach ($vars as $key => $val) {
			$val = trim($val);
			if ($val) {
				$auth .= $comma.$key.'='.$val;
				$comma = '&';
			}
		}
		$auth = md5($auth.$config['conf']['authkey']);
		if ($auth == $_GET['sign']){
			$result = 1;
		}
		if ($result){
			$mtime=time();
			$dsql->ExecuteNoneQuery("update `ek_member` set money='$vars[total_fee]' where uid='{$cfg_cl->M_ID}'");
			$dsql->ExecuteNoneQuery("update `ek_member_incash` set state='2' where orderid='{$decodes[1]}'");
			//$dsql->ExecuteNoneQuery("INSERT INTO `ek_pay_log`(`orderid` ,`userid` ,`act` ,`state`,`money`,`mtime`)VALUES ('{$decodes[1]}','{$cfg_cl->M_ID}','¹ºÂò²úÆ·".$vars['subject']."','7','{$vars[total_fee]}','$mtime')");
		}
		$result=$result ? 'success' : 'fail';
		$rtnUrl=$cfg_basehost."/member/";
		header("Location:$rtnUrl");
	}
}
$wespace = new _wespace_apis_payment_return_();
$wespace->loader();
?>