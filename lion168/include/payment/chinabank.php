<?php
if(!defined('EK_INC'))
{
	exit("Request Error!");
}
class _wespace_apis_payment_{
var $config = array();
var $results = array();
function _wespace_apis_payment_($conf){
$this->config = &$conf;
}
function getvars($apiid,$payid,$subject,$price){
$authkey = $this->config['authkey'];
$results = array('action' => 'https://pay3.chinabank.com.cn/PayGate', 'string' => '');
$variable = array();
$variable['v_mid']			= $this->config['v_mid'];
$variable['v_oid']			= date('ymdHis').'-'.$this->config['v_mid'].'-'.mt_rand(1001,9999);
$variable['v_amount']		= sprintf('%.02f',$price);
$variable['v_moneytype']	= 'CNY';
$variable['v_url']			= $this->config['v_url'];
$variable['v_md5info']		= strtoupper(md5($variable['v_amount'].$variable['v_moneytype'].$variable['v_oid'].$variable['v_mid'].$variable['v_url'].$authkey));
$variable['remark1']		= _base_endecode_($apiid."\t".$payid."\t".$subject."\t".$price);
$variable['remark2']		= '';
foreach ($variable as $key=>$val){
$results['string'] .= '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
}
return $results;
}
function creater($apiid,$payid,$subject,$price){
$results = $this->getvars($apiid,$payid,$subject,$price);
$this->results['method_ispost'] = 1;
$this->results['paymentaction'] = $results['action'];
$this->results['paymentstring'] = $results['string'];
return $this->results;
}
}
?>