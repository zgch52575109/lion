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
$vars = array(
'_input_charset'	=> $this->config['charset'],
'body'				=> _base_endecode_($apiid."\t".$payid."\t".$subject."\t".$price),
'notify_url'		=> $this->config['notify_url'],
'out_trade_no'		=> date('Ymd').'-'.$payid,
'partner'			=> $this->config['partner'],
'payment_type'		=> 1,
'return_url'		=> $this->config['return_url'],
'seller_email'		=> $this->config['email'],
'service'			=> 'create_direct_pay_by_user',
'subject'			=> $subject,
'total_fee'			=> $price,
);
$code = $this->config['authkey'];
$link = 'https://www.alipay.com/cooperate/gateway.do?';
$auth = $comma = '';
foreach ($vars as $key => $val){
$val = trim($val);
if ($val){
$link .= $key.'='.urlencode($val).'&';
$auth .= $comma.$key.'='.$val; $comma = '&';
}
}
return $link.'sign='.md5($auth.$code).'&sign_type=MD5';
}
function creater($apiid,$payid,$subject,$price){
$this->results['method_ispost'] = 0;
$this->results['paymentstring'] = $this->getvars($apiid,$payid,$subject,$price);
return $this->results;
}
}
?>