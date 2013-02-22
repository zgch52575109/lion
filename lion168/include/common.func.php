<?php
if(!defined('EK_INC'))
{
	exit("Request Error!");
}
require_once(EK_INC.'/charset.func.php');
//拼音的缓冲数组
$pinyins = Array();

//获得当前的脚本网址
function GetCurUrl()
{
	if(!empty($_SERVER["REQUEST_URI"]))
	{
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}
	else
	{
		$scriptName = $_SERVER["PHP_SELF"];
		if(empty($_SERVER["QUERY_STRING"]))
		{
			$nowurl = $scriptName;
		}
		else
		{
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
		}
	}
	return $nowurl;
}

//格式化时间
function sadate($format,$timestamp=''){
	global $cfg_cli_time;
	!$timestamp && $timestamp = time();
	return gmdate($format,$timestamp+$cfg_cli_time*3600);
}

//返回格林威治标准时间
function MyDate($format='Y-m-d H:i:s',$timest=0,$cli_time=0)
{
	global $cfg_cli_time;
	if(!$cli_time) $cli_time=$cfg_cli_time;
	$addtime = $cli_time * 3600;
	if(empty($format))
	{
		$format = 'Y-m-d H:i:s';
	}
	return gmdate ($format,$timest+$addtime);
}

function GetDateMk($mktime)
{
	return MyDate("Y-m-d",$mktime);
}


//中文截取2，单字节截取模式
//如果是request的内容，必须使用这个函数
function cn_substrR($str,$slen,$startdd=0)
{
	$str = cn_substr(stripslashes($str),$slen,$startdd);
	return addslashes($str);
}

//中文截取2，单字节截取模式
function cn_substr($str,$slen,$startdd=0)
{
	global $cfg_soft_lang;
	if($cfg_soft_lang=='utf-8')
	{
		return cn_substr_utf8($str,$slen,$startdd);
	}
	$restr = '';
	$c = '';
	$str_len = strlen($str);
	if($str_len < $startdd+1)
	{
		return '';
	}
	if($str_len < $startdd + $slen || $slen==0)
	{
		$slen = $str_len - $startdd;
	}
	$enddd = $startdd + $slen - 1;
	for($i=0;$i<$str_len;$i++)
	{
		if($startdd==0)
		{
			$restr .= $c;
		}
		else if($i > $startdd)
		{
			$restr .= $c;
		}

		if(ord($str[$i])>0x80)
		{
			if($str_len>$i+1)
			{
				$c = $str[$i].$str[$i+1];
			}
			$i++;
		}
		else
		{
			$c = $str[$i];
		}

		if($i >= $enddd)
		{
			if(strlen($restr)+strlen($c)>$slen)
			{
				break;
			}
			else
			{
				$restr .= $c;
				break;
			}
		}
	}
	return $restr;
}

//utf-8中文截取，单字节截取模式
function cn_substr_utf8($str, $length, $start=0)
{
	if(strlen($str) < $start+1)
	{
		return '';
	}
	preg_match_all("/./su", $str, $ar);
	$str = '';
	$tstr = '';

	//为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
	for($i=0; isset($ar[0][$i]); $i++)
	{
		if(strlen($tstr) < $start)
		{
			$tstr .= $ar[0][$i];
		}
		else
		{
			if(strlen($str) < $length + strlen($ar[0][$i]) )
			{
				$str .= $ar[0][$i];
			}
			else
			{
				break;
			}
		}
	}
	return $str;
}

function GetCkVdValue()
{
	@session_start();
	return isset($_SESSION['ek_ckstr']) ? $_SESSION['ek_ckstr'] : '';
}

//php某些版本有Bug，不能在同一作用域中同时读session并改注销它，因此调用后需执行本函数
function ResetVdValue()
{
	@session_start();
	$_SESSION['ek_ckstr'] = '';
	$_SESSION['ek_ckstr_last'] = '';
}

function ExecTime()
{
	$time = explode(" ", microtime());
	$usec = (double)$time[0];
	$sec = (double)$time[1];
	return $sec + $usec;
}

function getRunTime($t1)
{
	$t2=ExecTime() - $t1;
	return "页面执行时间: ".number_format($t2, 6)."秒";
}

function getPowerInfo()
{
	return "<p>Powered by <strong><a href=\"http://www.ek"."eke.net\" title=\"".$GLOBALS['cfg_softname']."\" target=\"_blank\">".$GLOBALS['cfg_soft_enname']."</a></strong> <em>".$GLOBALS['cfg_version']."</em></p>";
}


function dd2char($ddnum)
{
	$ddnum = strval($ddnum);
	$slen = strlen($ddnum);
	$okdd = '';
	$nn = '';
	for($i=0;$i<$slen;$i++)
	{
		if(isset($ddnum[$i+1]))
		{
			$n = $ddnum[$i].$ddnum[$i+1];
			if( ($n>96 && $n<123) || ($n>64 && $n<91) )
			{
				$okdd .= chr($n);
				$i++;
			}
			else
			{
				$okdd .= $ddnum[$i];
			}
		}
		else
		{
			$okdd .= $ddnum[$i];
		}
	}
	return $okdd;
}

function PutCookie($key,$value,$kptime=0,$pa="/")
{
	global $cfg_cookie_encode;
	setcookie($key,$value,time()+$kptime,$pa);
	setcookie($key.'__ckMd5',substr(md5($cfg_cookie_encode.$value),0,16),0,$pa);
}

function DropCookie($key)
{
	setcookie($key,'',time()-18000,"/");
	setcookie($key.'__ckMd5','',time()-18000,"/");
}

function GetCookie($key)
{
	global $cfg_cookie_encode;
	if( !isset($_COOKIE[$key]) || !isset($_COOKIE[$key.'__ckMd5']) )
	{
		return '';
	}
	else
	{
		if($_COOKIE[$key.'__ckMd5']!=substr(md5($cfg_cookie_encode.$_COOKIE[$key]),0,16))
		{
			return '';
		}
		else
		{
			return $_COOKIE[$key];
		}
	}
}

function GetIP()
{
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
	{
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
	{
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	else if(!empty($_SERVER["REMOTE_ADDR"]))
	{
		$cip = $_SERVER["REMOTE_ADDR"];
	}
	else
	{
		$cip = '';
	}
	preg_match("/[\d\.]{7,15}/", $cip, $cips);
	$cip = isset($cips[0]) ? $cips[0] : 'unknown';
	unset($cips);
	return $cip;
}

function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0)
{
	if(empty($GLOBALS['cfg_phpurl']))
	{
		$GLOBALS['cfg_phpurl'] = '..';
	}
	$htmlhead  = "<html>\r\n<head>\r\n<title>金狮国际 提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0'style='background-color:#000;padding-top:100px;'>\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

	if($limittime==0)
	{
		$litime = 1000;
	}
	else
	{
		$litime = $limittime;
	}

	if($gourl=="-1")
	{
		if($limittime==0)
		{
			$litime = 5000;
		}
		$gourl = "javascript:history.back(-1);";
	}

	if($gourl==''||$onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}
	else
	{
		$func = "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
		$rmsg = $func;
        $rmsg .= "document.write(\"<br /><div  style='padding:0px;width:745px; height:413px;background-image:url({$GLOBALS['cfg_phpurl']}images/messagebox_03.gif)'>";
        $rmsg .= "<div style='padding:6px;font-size:13px;text-align:center; margin-top:110px; color:#666';'><b>金狮国际 提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div  style='height:130px;font-size:10pt; margin-top:50px; text-align:center'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";
		if($onlymsg==0)
		{
			if($gourl!="javascript:;" && $gourl!="")
			{
				$rmsg .= "<br /><a href='{$gourl}' style='color:#666'>如果你的浏览器没反应，请点击这里...</a>";
			}
			$rmsg .= "<br/></div>\");\r\n";
			if($gourl!="javascript:;" && $gourl!='')
			{
				$rmsg .= "setTimeout('JumpUrl()',$litime);";
			}
		}
		else
		{
			$rmsg .= "<br/><br/></div>\");\r\n";
		}
		$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}

function alertMsg($str,$url)
{
	if(!empty($url)) $urlstr="location.href='".$url."';";
	if(!empty($str)) $str ="alert('".$str."');";
	echo("<script>".$str.$urlstr."</script>");
}

function selectMsg($str,$url1,$url2)
{
	echo("<script>if(confirm('$str')){location.href='$url1'}else{location.href='$url2'}</script>");
}

function AjaxHead()
{
	@header("Pragma:no-cache\r\n");
	@header("Cache-Control:no-cache\r\n");
	@header("Expires:0\r\n");
}

function HtmlReplace($str,$rptype=0)
{
	$str = stripslashes($str);
	if($rptype==0)
	{
		$str = htmlspecialchars($str);
	}
	else if($rptype==1)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",' ',$str);
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
	}
	else if($rptype==2)
	{
		$str = htmlspecialchars($str);
		$str = str_replace("　",'',$str);
		$str = ereg_replace("[\r\n\t ]",'',$str);
	}
	else
	{
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
		$str = eregi_replace('script','ｓｃｒｉｐｔ',$str);
		$str = eregi_replace("<[/]{0,1}(link|meta|ifr|fra)[^>]*>",'',$str);
	}
	return addslashes($str);
}

//邮箱格式检查
function CheckEmail($email)
{
	return eregi("^[0-9a-z][a-z0-9\._-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$", $email);
}

function quescrypt($questionid, $answer) {
	return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
}

function dstripslashes($string) {
	if(empty($string)) return $string;
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function MkdirAll($truepath,$mmode)
{
	global $cfg_dir_purview;
	if(!file_exists($truepath))
	{
		mkdir($truepath,$cfg_dir_purview);
		chmod($truepath,$cfg_dir_purview);
		return true;
	}
	else
	{
		return true;
	}
}

function writefile($filename, $data, $method = 'wb', $chmod = 1) {
	$return = false;
	if (strpos($filename, '..') !== false) {
		 exit('Write file failed');
	}
	if($fp = @fopen($filename, $method )) {
		@flock($fp, LOCK_EX);
		$return = fwrite($fp, $data);
		fclose($fp);
		$chmod && @chmod($filename,0777);
	}
	return $return;
}

// 写入缓存文件
function writetocache($cachename, $cachedata = '') {
	//if(in_array($cachename, array('archives','categories','links','newarticles','hotarticles','rodomarticles'))) {
		$cachedir = EK_ROOT.'/data/cache/';
		$cachefile = $cachedir.'cache_'.$cachename.'.php';
		if(!is_dir($cachedir)) {
			@mkdir($cachedir, 0777);
		}
		$cachedata = "<?php\r\n//EKEKE cache file\r\n//Created on ".MyDate('Y-m-d H:i:s',time())."\r\n\r\nif(!defined('EK_ROOT')) exit('Access Denied');\r\n\r\n".$cachedata."\r\n\r\n?>";
		if (!writefile($cachefile, $cachedata)) {
			exit('Can not write to '.$cachename.' cache files, please check directory ./data/cache/ .');
		}
	//}
}

function getBankTypeLists()
{
	$cachefile = EK_ROOT.'/data/cache/cache_bank_type.php';
	if(!file_exists($cachefile)){
		bank_type_recache();
	}
	@include($cachefile);
	return $bank_type_cache;
}

function bank_type_recache(){
	global $dsql;
	$sql="select * from ek_bank_type order by torder asc";
	$rows=array();
	$dsql->SetQuery($sql);
	$dsql->Execute('al');
	while($rowr=$dsql->GetArray('al'))
	{
		$rows[]=$rowr;
	}
	$contents = "\$bank_type_cache = unserialize('".addcslashes(serialize($rows), '\\\'')."');";
	writetocache('bank_type',$contents);
}

function getReceiveBankLists()
{
	$cachefile = EK_ROOT.'/data/cache/cache_receive_bank.php';
	if(!file_exists($cachefile)){
		receive_bank_recache();
	}
	@include($cachefile);
	return $receive_bank_cache;
}

function receive_bank_recache(){
	global $dsql;
	$sql="select * from ek_receive_bank where used='1' order by torder asc";
	$rows=array();
	$dsql->SetQuery($sql);
	$dsql->Execute('al');
	while($rowr=$dsql->GetArray('al'))
	{
		$rows[]=$rowr;
	}
	$contents = "\$receive_bank_cache = unserialize('".addcslashes(serialize($rows), '\\\'')."');";
	writetocache('receive_bank',$contents);
}

function isCurrentDay($timeStr,$ctime='0'){
	if(empty($timeStr)) return "";
	if(GetDateMk($timeStr)==GetDateMk(time())){
		return "<FONT COLOR=\"#FF0000\">".($ctime ? MyDate('Y-m-d H:i:s',$timeStr,'+8') : MyDate('Y-m-d H:i:s',$timeStr))."</FONT>";
	}else{
		return $ctime ? MyDate('Y-m-d H:i:s',$timeStr,'+8') : MyDate('Y-m-d H:i:s',$timeStr);
	}
}

function _base_endecode_($string,$decode = 0){
	global $cfg_webhashid;
	$return = '';
	$string = $decode ? base64_decode($string) : $string;
	$hashid = trim($cfg_webhashid);
	$hashid = $hashid ? $hashid : '~!@#$%^&';
	$hashlen = strlen($hashid);
	for ($i = 0; $i < strlen($string); $i += $hashlen){
	$return .= substr($string, $i, $hashlen) ^ $hashid;
	}
	return $decode ? $return : str_replace("=","",base64_encode($return));
}

function write_group_cache(){
	global $dsql;
	$sql="select * from ek_member_group";
	$rows=array();
	$dsql->SetQuery($sql);
	$dsql->Execute('al');
	while($rowr=$dsql->GetArray('al'))
	{
		$cache='';
		foreach($rowr as $key=>$value){
			$cache.="\r\n\$groupdb['$key']=\"$value\";";
		}
		$rowp = $dsql->GetOne("select * from ek_member_group where groupid>'$rowr[groupid]' order by groupid asc");
		if(is_array($rowp)){
			$cache.="\r\n\$groupdb['nextcashhigher']=\"$rowp[cashhigher]\";";
			$cache.="\r\n\$groupdb['nextcreditshigher']=\"$rowp[creditshigher]\";";
			$cache.="\r\n\$groupdb['nextgroupid']=\"$rowp[groupid]\";";
		}
		writetocache('group_'.$rowr['groupid'],$cache);
	}
}

function get_notice_list($num='5',$cut='50'){
	global $dsql;
	$sql="select * from ek_notice order by l_addtime desc limit 0,$num";
	$dsql->SetQuery($sql);
	$dsql->Execute('data_list');
	while($rowr=$dsql->GetArray('data_list')){
		$row['l_addtime']=MyDate('Y-m-d',$row['l_addtime']);
		if($cut){
			$row['l_body']=cn_substr(trim(strip_tags($row['l_body'])),$cut);
		}
		$rows[]=$rowr;
	}
	return $rows;
}

function get_news_list($num='5',$cut='50'){
	global $dsql;
	$sql="select * from ek_news order by l_addtime desc limit 0,$num";
	$dsql->SetQuery($sql);
	$dsql->Execute('data_list');
	while($rowr=$dsql->GetArray('data_list')){
		$row['l_addtime']=MyDate('Y-m-d',$row['l_addtime']);
		if($cut){
			$row['l_body']=cn_substr(trim(strip_tags($row['l_body'])),$cut);
		}
		$rows[]=$rowr;
	}
	return $rows;
}


function postUrl($url, $postvar)
{
    $ch = curl_init();
    $headers = array(
        "Content-type: text/xml; charset=\"utf-8\"",
        "Accept: text/xml",
        "Content-length: ".strlen($postvar)
    );
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvar);
    $res = curl_exec ($ch);
    curl_close ($ch);
    return $res;
}

function cut($cont,$startstr,$endstr)
{
	$strarr = explode($startstr,$cont);
	$strarr = explode($endstr,$strarr[1]);
	return $strarr[0];
}

function regHGuser($username,$truename,$type='1'){
	global $cfg_apiurl,$cfg_currencyid,$cfg_agentid;
	$firstname=substr($truename,0,3);
	$lastname=substr($truename,3);
	$poststr='<?xml version="1.0"?><request action="registration"><element><properties name="username">'.$username.'</properties><properties name="mode">'.$type.'</properties><properties name="firstname">'.$username.'</properties><properties name="lastname">'.$username.'</properties><properties name="currencyid">'.$cfg_currencyid.'</properties><properties name="agentid">'.$cfg_agentid.'</properties><properties name="affiliateid"></properties><properties name="testusr"></properties></element></request>';
	$str=postUrl($cfg_apiurl,$poststr);
	if(strpos($str,'<properties name="status">0</properties>')){
		$ticketid=cut($str,'<properties name="ticket">','</properties>');
		return $ticketid;
	}else{
		return false;
	}
}

function getHGmoney($username,$truename,$type='1'){
	global $cfg_apiurl;
	$poststr='<?xml version="1.0"?><request action="accountbalance"><element><properties name="username">'.$username.'</properties><properties name="mode">'.$type.'</properties></element></request>';
	$str=postUrl($cfg_apiurl,$poststr);
	if(strpos($str,'<properties name="status">608</properties>')){
		regHGuser($username,$truename);
		$str=postUrl($cfg_apiurl,$poststr);
	}
	$HGmoney=0;
	if(strpos($str,'<properties name="status">0</properties>')){
		$HGmoney=cut($str,'<properties name="balance">','</properties>');
	}
	return $HGmoney;
}

function zhuanruHGmoeny($amount,$username,$truename,$type='1'){
	global $cfg_apiurl,$cfg_currencyid,$cfg_refno,$cfg_promoid,$cfg_agentid;
	$cfg_refno=substr(md5(date('ymdHis').rand(1000,9999)), 8, 16);
	$poststr='<?xml version="1.0"?><request action="deposit"><element><properties name="username">'.$username.'</properties><properties name="mode">'.$type.'</properties><properties name="currencyid">'.$cfg_currencyid.'</properties><properties name="amount">'.$amount.'</properties>'.($cfg_refno ? '<properties name="refno">'.$cfg_refno.'</properties>' : '').($cfg_promoid ? '<properties name="promoid">'.$cfg_promoid.'</properties>' : '').($cfg_agentid ? '<properties name="agentid">'.$cfg_agentid.'</properties>' : '').'</element></request>';
	$str=postUrl($cfg_apiurl,$poststr);
	if(strpos($str,'<properties name="status">116</properties>')){
		regHGuser($username,$truename);
		$str=postUrl($cfg_apiurl,$poststr);
	}
	if(strpos($str,'<properties name="status">')){
		$status=cut($str,'<properties name="status">','</properties>');
		if($status=='0'){
			$paymentid=cut($str,'<properties name="paymentid">','</properties>');
			$poststr='<?xml version="1.0"?><request action="deposit-confirm"><element><properties name="status">'.$status.'</properties><properties name="paymentid">'.$paymentid.'</properties><properties name="errdesc"></properties></element></request>';
			$str=postUrl($cfg_apiurl,$poststr);
			if(strpos($str,'<properties name="status">')){
				$status=cut($str,'<properties name="status">','</properties>');
			}else{
				$status=9999;
			}
		}
	}else{
		$status=9999;
	}
	return $status;
}

function zhuanchuHGmoeny($amount,$username,$truename,$type='1'){
	global $cfg_apiurl,$cfg_currencyid,$cfg_refno,$cfg_promoid,$cfg_agentid;
	$cfg_refno=substr(md5(date('ymdHis').rand(1000,9999)), 8, 16);
	$poststr='<?xml version="1.0"?><request action="withdrawal"><element><properties name="username">'.$username.'</properties><properties name="mode">'.$type.'</properties><properties name="currencyid">'.$cfg_currencyid.'</properties><properties name="amount">'.$amount.'</properties>'.($cfg_refno ? '<properties name="refno">'.$cfg_refno.'</properties>' : '').($cfg_promoid ? '<properties name="promoid">'.$cfg_promoid.'</properties>' : '').($cfg_agentid ? '<properties name="agentid">'.$cfg_agentid.'</properties>' : '').'</element></request>';
	$str=postUrl($cfg_apiurl,$poststr);
	if(strpos($str,'<properties name="status">116</properties>')){
		regHGuser($username,$truename);
		$str=postUrl($cfg_apiurl,$poststr);
	}
	if(strpos($str,'<properties name="status">')){
		$status=cut($str,'<properties name="status">','</properties>');
		if($status=='0'){
			$paymentid=cut($str,'<properties name="paymentid">','</properties>');
			$poststr='<?xml version="1.0"?><request action="withdrawal-confirm"><element><properties name="status">'.$status.'</properties><properties name="paymentid">'.$paymentid.'</properties><properties name="errdesc"></properties></element></request>';
			$str=postUrl($cfg_apiurl,$poststr);
			if(strpos($str,'<properties name="status">')){
				$status=cut($str,'<properties name="status">','</properties>');
			}else{
				$status=9999;
			}
		}
	}else{
		$status=9999;
	}
	return $status;
}

function update_come_from(){
	global $dsql,$cfg_basehost;
	$refurl=$_SERVER['HTTP_REFERER'];
	if($refurl){
		if(strpos($refurl,$cfg_basehost)===false){
			$ip=GetIP();
			$timestr=time();
			$l_url=GetCurUrl();
			$dsql->ExecuteNoneQuery("INSERT INTO `ek_laiyuan` (l_url,l_fromurl,l_fromip,l_addtime) VALUES ('$l_url','$refurl','$ip','$timestr')");
		}
	}
}

function insert_views(){
	global $dsql;
	$ip=GetIP();
	$timestr=time();
	$today_start = mktime(0,0,0,date('m'),date('d'),date('Y'));
	$today_end = mktime(0,0,0,date('m'),date('d')+1,date('Y'));
	$rowd = $dsql->GetOne("select l_id from `ek_views` where l_fromip='$ip' and l_addtime BETWEEN '{$today_start}' AND '{$today_end}'");
	if(!is_array($rowd)){
		$refurl=$_SERVER['HTTP_REFERER'];
		$l_url=GetCurUrl();
		$dsql->ExecuteNoneQuery("INSERT INTO `ek_views` (l_url,l_fromurl,l_fromip,l_addtime) VALUES ('$l_url','$refurl','$ip','$timestr')");
	}

}

function ipaccess($ip, $accesslist) {
	return preg_match("/^(".str_replace(array("\r\n", ' '), array('|', ''), preg_quote($accesslist, '/')).")/", $ip);
}

function ipbanned() {
	global $cfg_ipaccess,$cfg_banip;
	$onlineip=GetIP();

	if($cfg_ipaccess && !ipaccess($onlineip, $cfg_ipaccess)) {
		return TRUE;
	}

	if(empty($cfg_banip)) {
		return FALSE;
	} else {
		if(ipaccess($onlineip, $cfg_banip)) {
			return TRUE;
		}
	}
	return FALSE;
}

function adminipbanned() {
	global $cfg_admin_ipaccess,$cfg_admin_banip;
	$onlineip=GetIP();

	if($cfg_admin_ipaccess && !ipaccess($onlineip, $cfg_admin_ipaccess)) {
		return TRUE;
	}

	if(empty($cfg_admin_banip)) {
		return FALSE;
	} else {
		if(ipaccess($onlineip, $cfg_admin_banip)) {
			return TRUE;
		}
	}
	return FALSE;
}

function getmembercount($begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+24*3600;
	$rowd = $dsql->GetOne("select count(*) as dd from `ek_member` where jointime>='$begin_date' and jointime<'$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getmemberfirstcount($begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+24*3600;
	$rowd = $dsql->GetOne("select count(*) as dd from `ek_member` where firstmoney <>'0' and fmtime>='$begin_date' and fmtime<'$end_date'");
	
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getproxytgcount($begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+24*3600;
	$rowd = $dsql->GetOne("select count(*) as dd from `ek_proxy_member` where dateline>='$begin_date' and dateline<'$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}
function getinpopularizecountfirstmoney($type,$pname){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `record_sign`,`ek_member` where record_sign.uid=ek_member.uid and allmoney>0 and pname='$pname'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}
function getinproxycountfirstmoney($type,$uid){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `ek_member` where firstmoney>0 and proxyid='$uid'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}
function getinpopularizecount($type,$pname){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `record_sign`,`ek_member` where record_sign.uid=ek_member.uid and pname='$pname'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getinproxycount($type,$uid){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `ek_proxy_member` where touid='$uid'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getinproxycountday($type,$uid,$begin_date){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `ek_proxy_member` where touid='$uid' and dateline>=$begin_date");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getinproxycountdayfirstmoney($type,$uid,$begin_date){
	global $dsql;
	$rowd = $dsql->GetOne("select count(*)as dd from `ek_member` where allmoney>0 and proxyid='$uid' and jointime>=$begin_date");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}
function pularizecountdayfirstmoney($type,$pname,$begin_date){
	global $dsql;
	$lastdate=date("Y-m")."-31";
	$rowd = $dsql->GetOne("select count(*)as dd from `record_sign`,`ek_member` where record_sign.uid=ek_member.uid and ek_member.allmoney>0 and record_sign.pname='$pname' and record_sign.signtime>='".$begin_date."' and record_sign.signtime<='".$lastdate."'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function pularizecountday($type,$pname,$begin_date){
	global $dsql;
	$lastdate=date("Y-m")."-31";
	$rowd = $dsql->GetOne("select count(*)as dd from `record_sign`,`ek_member` where record_sign.uid=ek_member.uid and record_sign.pname='".$pname."' and record_sign.signtime>='".$begin_date."' and record_sign.signtime<='".$lastdate."'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getmembertgcount($begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+24*3600;
	$rowd = $dsql->GetOne("select count(*) as dd from `ek_member_tuiguang` where dateline>='$begin_date' and dateline<'$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getincashcount($type,$begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+24*3600;
	$rowd = $dsql->GetOne("select sum(cash) as dd from `ek_member_incash` where type='$type' and state='2' and addtime>='$begin_date' and addtime<'$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getincashhourcount($type,$i){
	global $dsql;
	$m=Date('m');
	$y=Date('Y');
	$begin_date=strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,$i,$y)));
	$end_date=strtotime(date('Y-m-d H:i:s',mktime(23,59,59,$m,$i,$y)));
	$rowd = $dsql->GetOne("select sum(cash) as dd from `ek_member_incash` where type='$type' and state='2' and addtime>='$begin_date' and addtime<='$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getviewscount($begin_date,$end_date){
	global $dsql;
	$begin_date=strtotime($begin_date);
	$end_date=strtotime($end_date)+3600;
	$rowd = $dsql->GetOne("select count(*) as dd from `ek_views` where l_addtime>='$begin_date' and l_addtime<'$end_date'");
	if(is_array($rowd)){
	$TotalResult = $rowd['dd'];
	}else{
	$TotalResult = 0;
	}
	return $TotalResult;
}

function getPlayerdetails($uid=0){
	global $cfg_CasinoId,$cfg_api_username,$cfg_api_password,$cfg_apigeturl,$dsql;
	$processname ='get_Playerdetails';
	ek_process::unlock($processname);
	if(ek_process::islocked($processname, 600)) {
		return false;
	}
	@set_time_limit(1000);
	@ignore_user_abort(TRUE);
	$startdate=MyDate('Y-m-d',time()-3600*24);
	$enddate=$startdate;
	$poststr='<?xml version="1.0"?><GetPlayerdetails><Username>'.$cfg_api_username.'</Username><Password>'.$cfg_api_password.'</Password><CasinoId>'.$cfg_CasinoId.'</CasinoId>'.($uid ? '<AccountID>'.$uid.'</AccountID>' : '').'<StartDate>'.$startdate.'</StartDate><Enddate>'.$enddate.'</Enddate></GetPlayerdetails>';
	$str=postUrl($cfg_apigeturl,$poststr);
	$str=htmlspecialchars_decode($str);
	if(strpos($str,'<PlayerDetails>')!==false){
		preg_match_all( "/<PlayerDetails>(.*)<\/PlayerDetails>/isU", $str, $mar );
		if(is_array($mar[1])){
			foreach($mar[1] as $v){
				$PlayerName=cut($v,'<PlayerName>','</PlayerName>');
				$Bet_Amount=cut($v,'<Bet_Amount>','</Bet_Amount>');
				$Bet_Payoff=cut($v,'<Bet_Payoff>','</Bet_Payoff>');
				$TotalWin=cut($v,'<TotalWin>','</TotalWin>');
				$DeductAmount=cut($v,'<DeductAmount>','</DeductAmount>');
				$EvenAmount=cut($v,'<EvenAmount>','</EvenAmount>');
				$TotalAmount=cut($v,'<TotalAmount>','</TotalAmount>');
				if(trim($PlayerName)!=''){
					$row = $dsql->GetOne("Select uid,alltouzhumoney,weektouzhumoney,monthtouzhumoney,seasontouzhumoney,yeartouzhumoney,lastuptime From `ek_member` where username like '$PlayerName' ");
					if($row['uid']){
						$uid=$row['uid'];
						$alltouzhumoney = $row['alltouzhumoney'] + $TotalAmount;
						$weektouzhumoney = (date('YW', $row['lastuptime']) == date('YW', time()-3600*24)) ? ($row['weektouzhumoney'] + $TotalAmount) : $TotalAmount;
						$monthtouzhumoney = (date('Ym', $row['lastuptime']) == date('Ym', time()-3600*24)) ? ($row['monthtouzhumoney'] + $TotalAmount) : $TotalAmount;
						$seasontouzhumoney = (date('Y', $row['lastuptime']) == date('Y', time()-3600*24) && ceil(date('n', $row['lastuptime'])/3)==ceil(date('n', time()-3600*24)/3)) ? ($row['seasontouzhumoney'] + $TotalAmount) : $TotalAmount;
						$yeartouzhumoney = (date('Y', $row['lastuptime']) == date('Y', time()-3600*24)) ? ($row['yeartouzhumoney'] + $TotalAmount) : $TotalAmount;
						$dateline=strtotime($startdate);
						$rowb = $dsql->GetOne("Select id,TotalAmount From `ek_game_bet` where uid='$uid' and addtime='$dateline'");
						$isupmember=0;
						if(is_array($rowb)){
							$oldTotalAmount=$rowb['TotalAmount'];
							if($oldTotalAmount!=$TotalAmount){//如果存在记录并且记录不同，更新记录
								if($dsql->ExecuteNoneQuery("update `ek_game_bet` set `Bet_Amount`='$Bet_Amount',Bet_Payoff='$Bet_Payoff',TotalWin='$TotalWin',DeductAmount='$DeductAmount',EvenAmount='$EvenAmount',TotalAmount='$TotalAmount' where id='".$rowb['id']."';")){
									$addamount=$TotalAmount-$oldTotalAmount;
									if($addamount<>0){
										$alltouzhumoney = $row['alltouzhumoney'] + $addamount;
										$weektouzhumoney = (date('YW', $row['lastuptime']) == date('YW', time()-3600*24)) ? ($row['weektouzhumoney'] + $addamount) : $addamount;
										$monthtouzhumoney = (date('Ym', $row['lastuptime']) == date('Ym', time()-3600*24)) ? ($row['monthtouzhumoney'] + $addamount) : $addamount;
										$seasontouzhumoney = (date('Y', $row['lastuptime']) == date('Y', time()-3600*24) && ceil(date('n', $row['lastuptime'])/3)==ceil(date('n', time()-3600*24))/3) ? ($row['seasontouzhumoney'] + $addamount) : $addamount;
										$yeartouzhumoney = (date('Y', $row['lastuptime']) == date('Y', time()-3600*24)) ? ($row['yeartouzhumoney'] + $addamount) : $addamount;
										$lastliveuptime=time()-3600*24;
										$dsql->ExecuteNoneQuery("update ek_member set alltouzhumoney=$alltouzhumoney,weektouzhumoney=$weektouzhumoney,monthtouzhumoney=$monthtouzhumoney,seasontouzhumoney=$seasontouzhumoney,yeartouzhumoney=$yeartouzhumoney,lastuptime=$lastliveuptime where uid='$uid'");
									}
								}
							}
						}else{
							if($dsql->ExecuteNoneQuery("INSERT INTO `ek_game_bet` (`uid`,`Bet_Amount`,Bet_Payoff,TotalWin,DeductAmount,EvenAmount,TotalAmount ,`addtime`)VALUES ('$uid','$Bet_Amount','$Bet_Payoff','$TotalWin','$DeductAmount','$EvenAmount','$TotalAmount','$dateline');")){
							$lastliveuptime=time()-3600*24;
								$dsql->ExecuteNoneQuery("update ek_member set alltouzhumoney=$alltouzhumoney,weektouzhumoney=$weektouzhumoney,monthtouzhumoney=$monthtouzhumoney,seasontouzhumoney=$seasontouzhumoney,yeartouzhumoney=$yeartouzhumoney,lastuptime=$lastliveuptime where uid='$uid'");
							}
						}
					}
				}
			}
		}
	}
	getlivePlayerdetails(0);
	getYestodayGetBetdetails();
	writetocache('nextrun',"\$cfg_cronnextrun = '".strtotime(MyDate('Y-m-d',time()+24*3600))."';");
	ek_process::unlock($processname);
	return true;
}

function getlivePlayerdetails($uid=0){
	global $cfg_CasinoId,$cfg_api_username,$cfg_api_password,$cfg_livegame_apigeturl,$dsql;
	$startdate=MyDate('Y/m/d',time()-3600*24);
	$poststr='<?xml version="1.0" encoding="utf-8" ?><GameResultInfo><Username>'.$cfg_api_username.'</Username><Password>'.$cfg_api_password.'</Password><CasinoId>'.$cfg_CasinoId.'</CasinoId>'.($uid ? '<UserId>'.$uid.'</UserId>' : '').'<DateVal>'.$startdate.'</DateVal></GameResultInfo>';
	$str=postUrl($cfg_livegame_apigeturl,$poststr);
	$str=htmlspecialchars_decode($str);
	if(strpos($str,'<PlayerBetDetails>')!==false){
		preg_match_all( "/<PlayerBetDetails>(.*)<\/PlayerBetDetails>/isU", $str, $mar );
		if(is_array($mar[1])){
			foreach($mar[1] as $v){
				$PlayerName=cut($v,'<AccountID>','</AccountID>');
				$StakedAmount=cut($v,'<StakedAmount>','</StakedAmount>');
				$LiveGameTotalAmount=cut($v,'<LiveGameTotalAmount>','</LiveGameTotalAmount>');
				$TotalAmount=cut($v,'<LiveGameExcludeEvenandTieAmount>','</LiveGameExcludeEvenandTieAmount>');
				if(trim($PlayerName)!=''){
					$row = $dsql->GetOne("Select uid,alllivetouzhumoney,weeklivetouzhumoney,monthlivetouzhumoney,seasonlivetouzhumoney,yearlivetouzhumoney,lastliveuptime From `ek_member` where username like '$PlayerName' ");
					if($row['uid']){
						$uid=$row['uid'];
						$alltouzhumoney = $row['alllivetouzhumoney'] + $TotalAmount;
						$weektouzhumoney = (date('YW', $row['lastliveuptime']) == date('YW', time()-3600*24)) ? ($row['weeklivetouzhumoney'] + $TotalAmount) : $TotalAmount;
						$monthtouzhumoney = (date('Ym', $row['lastliveuptime']) == date('Ym', time()-3600*24)) ? ($row['monthlivetouzhumoney'] + $TotalAmount) : $TotalAmount;
						$seasontouzhumoney = (date('Y', $row['lastliveuptime']) == date('Y', time()-3600*24) && ceil(date('n', $row['lastliveuptime'])/3)==ceil(date('n', time())/3)) ? ($row['seasonlivetouzhumoney'] + $TotalAmount) : $TotalAmount;
						$yeartouzhumoney = (date('Y', $row['lastliveuptime']) == date('Y', time()-3600*24)) ? ($row['yearlivetouzhumoney'] + $TotalAmount) : $TotalAmount;
						$dateline=strtotime($startdate);
						$rowb = $dsql->GetOne("Select id,LiveGameExcludeEvenandTieAmount From `ek_live_game_bet` where uid='$uid' and addtime='$dateline'");
						$isupmember=0;
						if(is_array($rowb)){
							$oldTotalAmount=$rowb['LiveGameExcludeEvenandTieAmount'];
							if($oldTotalAmount!=$TotalAmount){//如果存在记录并且记录不同，更新记录
								if($dsql->ExecuteNoneQuery("update `ek_live_game_bet` set `StakedAmount`='$StakedAmount',LiveGameTotalAmount='$LiveGameTotalAmount',LiveGameExcludeEvenandTieAmount='$TotalAmount' where id='".$rowb['id']."';")){
									$addamount=$TotalAmount-$oldTotalAmount;
									if($addamount<>0){
										$alltouzhumoney = $row['alllivetouzhumoney'] + $addamount;
										$weektouzhumoney = (date('YW', $row['lastliveuptime']) == date('YW', time()-3600*24)) ? ($row['weeklivetouzhumoney'] + $addamount) : $addamount;
										$monthtouzhumoney = (date('Ym', $row['lastliveuptime']) == date('Ym', time()-3600*24)) ? ($row['monthlivetouzhumoney'] + $addamount) : $addamount;
										$seasontouzhumoney = (date('Y', $row['lastliveuptime']) == date('Y', time()-3600*24) && ceil(date('n', $row['lastliveuptime'])/3)==ceil(date('n', time()-3600*24))/3) ? ($row['seasonlivetouzhumoney'] + $addamount) : $addamount;
										$yeartouzhumoney = (date('Y', $row['lastliveuptime']) == date('Y', time()-3600*24)) ? ($row['yearlivetouzhumoney'] + $addamount) : $addamount;
										$lastliveuptime=time()-3600*24;
										$dsql->ExecuteNoneQuery("update ek_member set alllivetouzhumoney=$alltouzhumoney,weeklivetouzhumoney=$weektouzhumoney,monthlivetouzhumoney=$monthtouzhumoney,seasonlivetouzhumoney=$seasontouzhumoney,yearlivetouzhumoney=$yeartouzhumoney,lastliveuptime=$lastliveuptime where uid='$uid'");
									}
								}
							}
						}else{
						$lastliveuptime=time()-3600*24;
							if($dsql->ExecuteNoneQuery("INSERT INTO `ek_live_game_bet` (`uid`,`StakedAmount`,LiveGameTotalAmount,LiveGameExcludeEvenandTieAmount ,`addtime`)VALUES ('$uid','$StakedAmount','$LiveGameTotalAmount','$TotalAmount','$dateline');")){
								$dsql->ExecuteNoneQuery("update ek_member set alllivetouzhumoney=$alltouzhumoney,weeklivetouzhumoney=$weektouzhumoney,monthlivetouzhumoney=$monthtouzhumoney,seasonlivetouzhumoney=$seasontouzhumoney,yearlivetouzhumoney=$yeartouzhumoney,lastliveuptime=$lastliveuptime where uid='$uid'");
							}
						}
					}
				}
			}
		}
	}
}

//实时更新用户有效投注额
function getnowlivePlayerdetails($uid=0){
//echo "<br />uid=".$uid;
	global $cfg_CasinoId,$cfg_api_username,$cfg_api_password,$cfg_livegame_apigeturl,$dsql;
	$startdate=MyDate('Y/m/d',time());
	$dateline=strtotime($startdate);
	$dsql->ExecuteNoneQuery("update `ek_now_live_game_bet` set todayStakeAmount='0',todayLiveGameTotalAmount='0',todayLiveGameExcludeEvenandTieAmount='0' where addtime < '$dateline';");
	$poststr='<?xml version="1.0" encoding="utf-8" ?><GameResultInfo><Username>'.$cfg_api_username.'</Username><Password>'.$cfg_api_password.'</Password><CasinoId>'.$cfg_CasinoId.'</CasinoId>'.($uid ? '<UserId>'.$uid.'</UserId>' : '').'<DateVal>'.$startdate.'</DateVal></GameResultInfo>';
	$str=postUrl($cfg_livegame_apigeturl,$poststr);
	$str=htmlspecialchars_decode($str);
	if(strpos($str,'<PlayerBetDetails>')!==false){

		preg_match_all( "/<PlayerBetDetails>(.*)<\/PlayerBetDetails>/isU", $str, $mar );
		if(is_array($mar[1])){
		
			foreach($mar[1] as $v){
			
				$PlayerName=cut($v,'<AccountID>','</AccountID>');
				$todayStakedAmount=cut($v,'<StakedAmount>','</StakedAmount>');
				$todayLiveGameTotalAmount=cut($v,'<LiveGameTotalAmount>','</LiveGameTotalAmount>');
				$todayTotalAmount=cut($v,'<LiveGameExcludeEvenandTieAmount>','</LiveGameExcludeEvenandTieAmount>');
				
				if(trim($PlayerName)!=''){
				$row = $dsql->GetOne("Select * From `ek_member` where username = '$PlayerName'");
					if($row['uid']){
						$uid=$row['uid'];
						$addtime=strtotime($startdate);
							$dsql->ExecuteNoneQuery("replace into `ek_now_live_game_bet` (`uid`,`todayStakeAmount`,`todayLiveGameTotalAmount`,`todayLiveGameExcludeEvenandTieAmount`,`addtime`)VALUES ('$uid','$todayStakedAmount','$todayLiveGameTotalAmount','$todayTotalAmount','$addtime');");
							
						}
					}
				}
				
			}
		}
	}
	//将用户完整的信息（投注额，UID）写入ek_now_live_game_bet
function getPlayerdetailall($uid=0){
	global $dsql;
			$sqlStr="select uid,username from ek_member";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
			if($row['uid']){
			$uid=$row['uid'];
						$rowd = $dsql->GetOne("select sum(LiveGameExcludeEvenandTieAmount) as dd from `ek_live_game_bet` where uid='$uid'");
						$lgeeta=$rowd[dd];
						$alllgeeta=$rowd[dd]+$todayTotalAmount;
						$rowd = $dsql->GetOne("select sum(LiveGameTotalAmount) as dd from `ek_live_game_bet` where uid='$uid'");
						$lgta=$rowd[dd];
						$alllgta=$rowd[dd]+$todayLiveGameTotalAmount;
						$rowd = $dsql->GetOne("select sum(StakedAmount) as dd from `ek_live_game_bet` where uid='$uid'");
						$sa=$rowd[dd];
						$allsa=$rowd[dd]+$todayStakedAmount;
						$rowd = $dsql->GetOne("select weeklivetouzhumoney as dd from `ek_member` where uid='$uid'");
						$week=$rowd[dd];
						$allweek=$rowd[dd]+$todayTotalAmount;
						$todayTotalAmount=0;
						$todayLiveGameTotalAmount=0;
						$todayStakedAmount=0;
						$dateline=strtotime(date('Y/m/d',time()));
						$dsql->ExecuteNoneQuery("replace into `ek_now_live_game_bet` (`uid`,`todayStakeAmount`,todayLiveGameTotalAmount,todayLiveGameExcludeEvenandTieAmount ,`sumStakedAmount`,sumLiveGameTotalAmount,sumLiveGameExcludeEvenandTieAmount,`allStakedAmount`,allLiveGameTotalAmount,allLiveGameExcludeEvenandTieAmount,weeklivetouzhumoney,allweeklivetouzhumoney ,`addtime`)VALUES ('$uid','$todayStakedAmount','$todayLiveGameTotalAmount','$todayTotalAmount','$sa','$lgta','$lgeeta','$allsa','$alllgta','$alllgeeta','$week','$allweek','$dateline');");
					}
		}

}

//实时昨天更新游戏记录
function getYestodayGetBetdetails($uid=0){
	global $cfg_CasinoId,$cfg_api_username,$cfg_api_password,$dsql,$cfg_gamehistory_apigeturl;
	$startdate=MyDate('Y/m/d',time()-3600*24);
	$poststr='<?xml version="1.0"?><GetBetdetails><Username>'.$cfg_api_username.'</Username><Password>'.$cfg_api_password.'</Password><CasinoId>'.$cfg_CasinoId.'</CasinoId>'.($uid ? '<UserId>'.$uid.'</UserId>' : '').'<DateVal>'.$startdate.'</DateVal></GetBetdetails>';
	$str=postUrl($cfg_gamehistory_apigeturl,$poststr);
	$str=htmlspecialchars_decode($str);
	if(strpos($str,'<Betinfo>')!==false){
		preg_match_all( "/<Betinfo>(.*)<\/Betinfo>/isU", $str, $mar );
		if(is_array($mar[1])){
			foreach($mar[1] as $v){
				$BetStartDate=cut($v,'<BetStartDate>','</BetStartDate>');
				$BetEndDate=cut($v,'<BetEndDate>','</BetEndDate>');
				$UserName=cut($v,'<AccountId>','</AccountId>');
				$BetId=cut($v,'<BetId>','</BetId>');
				$GameId=cut($v,'<GameId>','</GameId>');
				$BetAmount=cut($v,'<BetAmount>','</BetAmount>');
				$Payout=cut($v,'<Payout>','</Payout>');
				$Currency=cut($v,'<Currency>','</Currency>');
				$GameType=cut($v,'<GameType>','</GameType>');
				$BetSpot=cut($v,'<BetSpot>','</BetSpot>');
				$BetNo=cut($v,'<BetNo>','</BetNo>');
				$BetStartDate=strtotime($BetStartDate);
				$BetEndDate=strtotime($BetEndDate);
				$dsql->ExecuteNoneQuery("replace into gamehistory.gamehistory_all_excltoday (`BetStartDate`,`BetEndDate` ,`UserName`,`BetId`,`GameId`,`BetAmount`,`Payout`,`Currency`,`GameType`,`BetSpot`,`BetNo`)VALUES ('$BetStartDate','$BetEndDate','$UserName','$BetId','$GameId','$BetAmount','$Payout','$Currency','$GameType','$BetSpot','$BetNo');");

			}
		}
	}
}

//实时更新今日游戏记录
function getTodayGetBetdetails($uid=0){
	global $cfg_CasinoId,$cfg_api_username,$cfg_api_password,$dsql,$cfg_gamehistory_apigeturl;
	$startdate=MyDate('Y/m/d',time());
	$poststr='<?xml version="1.0"?><GetBetdetails><Username>'.$cfg_api_username.'</Username><Password>'.$cfg_api_password.'</Password><CasinoId>'.$cfg_CasinoId.'</CasinoId>'.($uid ? '<UserId>'.$uid.'</UserId>' : '').'<DateVal>'.$startdate.'</DateVal></GetBetdetails>';
	$str=postUrl($cfg_gamehistory_apigeturl,$poststr);
	$str=htmlspecialchars_decode($str);
	$startdate=strtotime($startdate);
	$dsql->ExecuteNoneQuery("delete from gamehistory.gamehistory_today where BetStartDate<$startdate;");
	if(strpos($str,'<Betinfo>')!==false){
		preg_match_all( "/<Betinfo>(.*)<\/Betinfo>/isU", $str, $mar );
		if(is_array($mar[1])){
			foreach($mar[1] as $v){
				$BetStartDate=cut($v,'<BetStartDate>','</BetStartDate>');
				$BetEndDate=cut($v,'<BetEndDate>','</BetEndDate>');
				$UserName=cut($v,'<AccountId>','</AccountId>');
				$BetId=cut($v,'<BetId>','</BetId>');
				$GameId=cut($v,'<GameId>','</GameId>');
				$BetAmount=cut($v,'<BetAmount>','</BetAmount>');
				$Payout=cut($v,'<Payout>','</Payout>');
				$Currency=cut($v,'<Currency>','</Currency>');
				$GameType=cut($v,'<GameType>','</GameType>');
				$BetSpot=cut($v,'<BetSpot>','</BetSpot>');
				$BetNo=cut($v,'<BetNo>','</BetNo>');
				$BetStartDate=strtotime($BetStartDate);
				$BetEndDate=strtotime($BetEndDate);
				$dsql->ExecuteNoneQuery("replace into gamehistory.gamehistory_today (`BetStartDate`,`BetEndDate` ,`UserName`,`BetId`,`GameId`,`BetAmount`,`Payout`,`Currency`,`GameType`,`BetSpot`,`BetNo`)VALUES ('$BetStartDate','$BetEndDate','$UserName','$BetId','$GameId','$BetAmount','$Payout','$Currency','$GameType','$BetSpot','$BetNo');");

			}
		}
	}
}

//更新上周现金码
function WeeklyRegularChips($uid=0){
		global $dsql;
		$time=date('YW',strtotime(date('Y-m-d H:m:s')));
		$rowd = $dsql->GetOne("select time from weekly_regularchips_plan where id='8'");
	if($rowd['time']!=$time){
		$BetEndDate = strtotime("last Sunday+1days");
		$BetStartDate = strtotime("last Sunday-6days");
		$dsql->ExecuteNoneQuery("update `regularchips_weekly` set WeeklyRegularChips=0,WeeklyBetAmount=0 where Addtime<$time");
			$sqlStr="select UserName from gamehistory.gamehistory_all_excltoday where BetEndDate<=$BetEndDate and BetEndDate>=$BetStartDate  group by UserName";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
			if($row['UserName']){
					$username=$row['UserName'];
					$rowd = $dsql->GetOne("select uid from ek_member where username='$username'");	
					$uid=$rowd['uid'];
					$rowd = $dsql->GetOne("select sum(b.Payout) as SumPayout from gamehistory.GameHistory_All_ExclToday as b where Payout>0 and b.BetEndDate>=$BetStartDate and b.BetEndDate<=$BetEndDate and b.UserName='$username'");	
					$WeeklyRegularChips=$rowd['SumPayout'];
					$rowd = $dsql->GetOne("select sum(b.BetAmount) as SumBetAmount from gamehistory.gamehistory_all_excltoday as b where b.BetEndDate>=$BetStartDate and b.BetEndDate<=$BetEndDate and b.UserName='$username'");	
					$WeeklyBetAmount=$rowd['SumBetAmount'];
					$Addtime=date('YW',strtotime(date('Y-m-d H:i:s')));
					$dsql->ExecuteNoneQuery("replace INTO `regularchips_weekly` (`WeeklyRegularChips`,`WeeklyBetAmount`,`Addtime` ,`uid`)VALUES ('$WeeklyRegularChips','$WeeklyBetAmount','$Addtime','$uid');");
				}
			$i++;
			}
		$dsql->ExecuteNoneQuery("update `weekly_regularchips_plan` set time=$time where id='8'");
	}

}

//更新本周现金码
function ThisWeekRegularChips($uid=0){
		global $dsql;
		$dsql->ExecuteNoneQuery("update regularchips_thisweek set WeeklyRegularChips='0',ThisWeekBetAmount='0'");
			$BetStartDate=strtotime("last Sunday +1days");  
			$BetEndDate=strtotime(date("Y/m/d H:i:s",mktime(0,0,0,date("m"),date("d"),date("Y"))));
			$sqlStr="select UserName from gamehistory.gamehistory_all_excltoday where BetEndDate<$BetEndDate and BetEndDate>=$BetStartDate group by UserName";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
					$username=$row['UserName'];
			$rowd = $dsql->GetOne("select uid from ek_member where username='$username'");	
			$uid=$rowd['uid'];
					$rowd = $dsql->GetOne("select sum(b.Payout) as SumPayout from gamehistory.gamehistory_all_excltoday as b where Payout>0 and b.BetEndDate>=$BetStartDate and b.UserName='$username' and BetEndDate<$BetEndDate");	
					$ThisWeekRegularChips=$rowd['SumPayout'];
					$rowd = $dsql->GetOne("select sum(b.BetAmount) as SumBetAmount from gamehistory.gamehistory_all_excltoday as b where b.BetEndDate>=$BetStartDate and b.UserName='$username' and BetEndDate<$BetEndDate");	
					$ThisWeekBetAmount=$rowd['SumBetAmount'];
					$Addtime=date('YW',strtotime(date('Y-m-d H:i:s')));
					$dsql->ExecuteNoneQuery("replace INTO `regularchips_thisweek` (`WeeklyRegularChips`,`ThisWeekBetAmount`,`Addtime` ,`uid`)VALUES ('$ThisWeekRegularChips','$ThisWeekBetAmount','$Addtime','$uid');");
			$i++;
			}
}
//昨天以前现金码
function AllRegularChips($uid=0){
		global $dsql;
			$BetEndDate=strtotime(date("Y/m/d H:i:s",mktime(0,0,0,date("m")-1,date("d"),date("Y"))));
	$dsql->ExecuteNoneQuery("update regularchips_all set AllRegularChips='0',AllBetAmount='0'");
			$sqlStr="select UserName from gamehistory.gamehistory_all_excltoday where BetEndDate<$BetEndDate  group by UserName";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
			if($row['UserName']){
					$username=$row['UserName'];
			$rowd = $dsql->GetOne("select uid from ek_member where username='$username'");	
			$uid=$rowd['uid'];
					$rowa = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where Payout>0 and UserName='$username' and BetEndDate<$BetEndDate");	
					$AllRegularChips=$rowa['SumPayout'];
					$rowd = $dsql->GetOne("select sum(BetAmount) as SumBetAmount from gamehistory.gamehistory_all_excltoday where UserName='$username' and BetEndDate<$BetEndDate");	
					$AllBetAmount=$rowd['SumBetAmount'];
					$Addtime=strtotime(date('Y-m-d H:i:s'));
					$dsql->ExecuteNoneQuery("replace INTO `regularchips_all` (`AllRegularChips`,`AllBetAmount`,`Addtime` ,`uid`)VALUES ('$AllRegularChips','$AllBetAmount','$Addtime','$uid');");
				}
			$i++;
			}
}

//更新今天现金码
function todayRegularChips($uid=0){
	global $dsql;
	$dsql->ExecuteNoneQuery("update regularchips_today set TodayRegularChips='0',TodayBetAmount='0'");
	$BetStartDate=strtotime(date('Y-m-d'));
	$sqlStr="select distinct(UserName) from gamehistory.gamehistory_today where BetEndDate>=$BetStartDate";
	$dsql->SetQuery($sqlStr);
	$dsql->Execute('class_list');
	$i=1;
	while($row=$dsql->GetArray('class_list'))
	{
		$username=$row['UserName'];
		$rowd = $dsql->GetOne("select uid from ek_member where username='$username'");	
		$uid=$rowd['uid'];
		$rowd = $dsql->GetOne("select sum(b.Payout) as SumPayout from gamehistory.gamehistory_today as b where b.Payout>0 and b.UserName='$username' and b.BetEndDate>=$BetStartDate ");	
		$TodayRegularChips=$rowd['SumPayout'];
		$rowd = $dsql->GetOne("select sum(b.BetAmount) as SumBetAmount from gamehistory.gamehistory_today as b where b.UserName='$username' and b.BetEndDate>=$BetStartDate ");	
		$TodayBetAmount=$rowd['SumBetAmount'];
		$Addtime=strtotime(date('Y-m-d H:i:s'));
		$dsql->ExecuteNoneQuery("replace INTO `regularchips_today` (`TodayRegularChips`,`TodayBetAmount`,`Addtime`,`uid`)VALUES ('$TodayRegularChips','$TodayBetAmount','$Addtime','$uid');");
	$i++;
	}
}

//本月实时更新活跃用户
function updatememberactive($uid=0){
		global $dsql;
		$dsql->ExecuteNoneQuery("update ek_member set active='0'");
		$y=date('Y');
		$m=date('m');
		$BetStartDate = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,01,$y)));
		$sqlStr="select distinct(UserName) from gamehistory.gamehistory_all_excltoday where BetEndDate>=$BetStartDate";
		$dsql->SetQuery($sqlStr);
		$dsql->Execute('class_list');
		$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
			if($row['UserName']){
					$username=$row['UserName'];
					$rowd = $dsql->GetOne("select uid,active from ek_member where username='$username'");	
					$uid=$rowd['uid'];
					$actives=$rowd['active'];
					$rowd = $dsql->GetOne("select count(*) as active from gamehistory.gamehistory_all_excltoday as b where b.BetEndDate>=$BetStartDate and b.UserName='$username'");	
					$active=$rowd['active'];
					$rowd = $dsql->GetOne("select count(*) as active from gamehistory.gamehistory_today as b where b.BetEndDate>=$BetStartDate and b.UserName='$username'");	
					$active=$rowd['active']+$active;
					if($active!=$actives){
					$dsql->ExecuteNoneQuery("update `ek_member` set active='$active' where uid='$uid';");
					}
			$i++;
			}
		}
}
//代理上月活跃用户更新
function updateproxymemberactive($proxyuid){
		global $dsql;
		$y=date('Y');
		$m=date('m')-1;
		if($m==0){$m=12;}
		$BetStartDate = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,01,$y)));
		$BetEndDate = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,m,01,$y)));		
			$sqlStr="select uid,username from ek_proxy_member where touid=$proxyuid";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$i=1;
		while($row=$dsql->GetArray('class_list'))
			{
			if($row['username']){
					$username=$row['username'];
					$uid=$row['uid'];
					$rowd = $dsql->GetOne("select count(*) as active from gamehistory.gamehistory_all_excltoday as b where b.BetEndDate>=$BetStartDate and b.BetEndDate<=$BetEndDate and b.UserName='$username'");	
					$active=$rowd['active'];
					$dsql->ExecuteNoneQuery("update `ek_proxy_member` set active='$active' where uid='$uid';");
			$i++;
			}
		}
}

//更新现金码（全部）
function lastRegularChips($uid=0){
		global $dsql;
		$lastday=strtotime(date("Y/m/d H:i:s",mktime(0,0,0,date("m"),date("d")-1,date("Y"))));
		$tday=strtotime(date("Y/m/d"));
		$sqlStr="select UserName from gamehistory.gamehistory_all_excltoday where BetEndDate>=$lastday group by UserName";
		$dsql->SetQuery($sqlStr);
		$dsql->Execute('excltoday');
		$i=1;
		while($row=$dsql->GetArray('excltoday'))
		{
			$username=$row['UserName'];
			$rowd = $dsql->GetOne("select uid from ek_member where username='$username'");	
			$uid=$rowd['uid'];
			$rowr = $dsql->GetOne("select id from regularchips_all where uid='$uid'");	
			$rowd = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where Payout>0 and UserName='$username' and BetEndDate>=$lastday and BetEndDate<$tday");	
			$RegularChips=$rowd['SumPayout'];
			$rowd = $dsql->GetOne("select sum(BetAmount) as SumBetAmount from gamehistory.gamehistory_all_excltoday where UserName='$username' and BetEndDate>=$lastday and BetEndDate<$tday");	
			$BetAmount=$rowd['SumBetAmount'];
			$Addtime=strtotime(date('Y-m-d H:i:s'));
			if($rowr['id']){
			$id=$rowr['id'];
			$dsql->ExecuteNoneQuery("update `regularchips_all` set AllRegularChips=AllRegularChips+$RegularChips,AllBetAmount=AllBetAmount+$BetAmount,Addtime=$Addtime where id=$id");
			}else{
			$dsql->ExecuteNoneQuery("replace INTO `regularchips_all` (`AllRegularChips`,`AllBetAmount`,`Addtime` ,`uid`)VALUES ('$RegularChips',$BetAmount,'$Addtime','$uid');");
			}
		$i++;
		}
}
//代理月自动更新
function getproxymoney($uid=0){
global $dsql;
$sqlStr="select * from ek_proxy";
$dsql->SetQuery($sqlStr);
$dsql->Execute('ek_proxy_list');
$i=1;
	while($row=$dsql->GetArray('ek_proxy_list'))
	{
		$pactive=$row['active'];
		$updatetime=$row['updatetime'];
		$time=date('Ym');
		$fencheng=$row['fencheng'];
		$proxyuid=$row['uid'];
		if($updatetime!=$time){
			$sqlStr="select username,truename,uid from ek_member where proxyid=$proxyuid";
			$dsql->SetQuery($sqlStr);
			$dsql->Execute('class_list');
			$a=0;
			while($row=$dsql->GetArray('class_list'))
			{
				$y=date('Y');
				$m=date('m')-1;
				if($m==0){$m=12;}
				$username=$row['username'];
				$uid=$row['uid'];
				$BetStartDate = strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))));
				$BetEndDate = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))));
				$rowq = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=2 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
				$rowm = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=1 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
				$rowd = $dsql->GetOne("SELECT sum(hongli) as dd,sum(shouxufei) as d FROM ek_member_incash where uid=$uid and addtime>$BetStartDate and addtime<$BetEndDate");
				$rowb = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where UserName='$username' and BetEndDate>$BetStartDate and BetEndDate<$BetEndDate");	
				$SumPayout=$rowb['SumPayout'];
				$hongli=$rowb['dd'];
				$shouxufei=$rowd['d'];
				if($rowq[uid]||$rowm[uid]||$SumPayout<0){
				$a++;
						$SumPayout=0-$SumPayout;
						$SumPayout=$SumPayout-$hongli-$shouxufei;
						if($SumPayout <0){$SumPayout=0;}
						$fcmoney=$SumPayout+$fcmoney;
				}else{
					$SumPayouts=0-$SumPayout;
					$SumPayouts_now=$SumPayouts-$hongli-$shouxufei;
					$SumPayoutmony=$SumPayoutmony+$SumPayouts_now;
				}
			}
			$fcmoney_new=round($fcmoney*$fencheng,2);
			$allSumPayoutmony=round($SumPayoutmony+$fcmoney,2);
			$now=date('Y-m-d H:i:s');
			if($fcmoney_new>0){
				if($a>=$pactive){
				$dsql->ExecuteNoneQuery("replace INTO `proxy_cash` (`proxyuid`,`cashmoney` ,`addtime`)VALUES ('$proxyuid','$fcmoney_new','$now');");
				$now=date('Ym');
				$dsql->ExecuteNoneQuery("update `ek_proxy` set money=money+$fcmoney_new,allSumPayout='$allSumPayoutmony',updatetime='$now'where uid='$proxyuid';");
				}else{
				$dsql->ExecuteNoneQuery("replace INTO `proxy_cash` (`proxyuid`,`cashmoney` ,`addtime`,`outcash`,`remark`)VALUES ('$proxyuid','$fcmoney_new','$now','2','活跃会员数未达到（--".$pactive."人--）');");
				$now=date('Ym');
				$dsql->ExecuteNoneQuery("update `ek_proxy` set updatetime='$now'where uid='$proxyuid';");
				}
			}
			$fcmoney=0;
			$SumPayoutmony=0;
		getproxyusermoney($proxyuid);
		}
	}
				$now=date('Ym');
				$dsql->ExecuteNoneQuery("update `ek_proxy` set updatetime='$now';");
}

function getproxyusermoney($uid){
		global $dsql;
		$y=date('Y');
		$m=date('m');
	$now= strtotime(date('Y-m-d H:i:s',mktime(0,0,0,$m,01,$y)));
	$rowd = $dsql->GetOne("SELECT addtime as d FROM ek_proxy_member_excltmonth where addtime>=$now");
if(!$rowd['addtime']){
		$y=date('Y');
		$m=date('m')-1;
		if($m==0){$m=12;}
		$BetStartDate = strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))));
		$BetEndDate = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))));
		$csqlStr_one="SELECT count(*) as dd ,b.proxyuid,b.addtime from ek_proxy_member_excltmonth b where  proxyuid='$uid'";
		$row = $dsql->GetOne($csqlStr_one);
		if(is_array($row)){$TotalResult = $row['dd'];}else{$TotalResult = 0;}	
		$addtime=strtotime(MyDate('Y-m-d',$row['addtime']));
		if($BetStartDate!=$addtime){
		/*$sql_class="m.uid,m.username,m.jointime,m.truename,m.`status`,m.proxyid,m.active,mg.grouptitle,mg.groupid,mg.groupid,ra.AllRegularChips,p.fencheng,nlg.allStakedAmount";
			$sql_tab="ek_member  m,ek_proxy p,ek_member_group mg,regularchips_all ra ,ek_now_live_game_bet nlg";
			$whereStr="m.proxyid=p.uid  and m.groupid=mg.groupid and m.uid=ra.uid and p.uid=$proxyuid and m.uid=nlg.uid";		*/
			$sql_class="m.uid,m.username,m.jointime,m.truename,m.`status`,m.proxyid,mg.grouptitle,mg.groupid,mg.groupid,p.fencheng";
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
			$uid=$roww_st['uid'];
			$row_ra = $dsql->GetOne("SELECT  ra.AllRegularChips FROM regularchips_all ra where ra.uid=$uid addtime>$BetStartDate and addtime<$BetEndDate");
			$row_nlg = $dsql->GetOne("SELECT sum(nlg.StakedAmount) as StakedAmount  FROM ek_live_game_bet nlg  where nlg.uid=$uid and addtime>$BetStartDate and addtime<$BetEndDate");
			$rowq = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=2 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
			$rowm = $dsql->GetOne("SELECT uid FROM ek_member_incash where uid=$uid and type=1 and operation=2 and addtime>$BetStartDate and addtime<$BetEndDate");
			$rowd = $dsql->GetOne("SELECT sum(hongli) as dd ,sum(shouxufei) as shouxufei FROM ek_member_incash where uid=$uid and addtime>$BetStartDate and addtime<$BetEndDate");
			//$rowg = $dsql->GetOne("SELECT sum(hongli) as dd FROM ek_member_firsthongli where uid=$uid and lingqutime>$BetStartDate and lingqutime<$BetEndDate");
			$rowb = $dsql->GetOne("select sum(Payout) as SumPayout from gamehistory.gamehistory_all_excltoday where UserName='$username'and BetEndDate>$BetStartDate and BetEndDate<$BetEndDate");
			$SumPayout=$rowb['SumPayout'];
			if($SumPayout >0){$SumPayout=0;}
			$hongli=$rowb['dd'];
			$shouxufei=$rowd['shouxufei'];
			//$firsthongli=$rowg['dd'];
			$userActive=0;
				if($rowq[uid]||$rowm[uid]){
					$userActive=1;
					$SumPayout=0-$SumPayout;
					$SumPayout=$SumPayout-$hongli-$shouxufei;
					$fcmoney_new=$SumPayout*$fencheng;
				}
			$fcmoney=round($fcmoney_new,2);
			if($SumPayout < 0){$SumPayout=0;}
			$userUid=$roww_st['uid'];//用户ID
			$userNumber=$roww_st['username'];//用户帐号
			$userJointime =$roww_st['jointime'];//用户注册时间			
			$truename=$roww_st['truename'];//用户名
			$userStatus=$roww_st['status'];//用户状态
			$proxyid= $roww_st['proxyid'] ;//代理ID
			$userGrouptitle=$roww_st['grouptitle'];//用户级别名称
			$userAllRegularChips=$row_ra['AllRegularChips'];//现金码
			$userGroupid=$roww_st['groupid'];//用户级别ID
			$userDividend=$rowd['dd'] + $rowg['dd'];//红利-->反水/优惠
			$userPoundage=$rowd['shouxufei'];//手序费
			$komisyon=$fcmoney;//提成
			$netoKita=$SumPayout;//利润（元）
			$userAllStakedAmount=$row_nlg['StakedAmount'];//总投注额
			$insql_insert="INSERT INTO ek_proxy_member_excltmonth (userUid,proxyuid,userNumber,userName,userGroupid,userGrouptitle,userJointime,userAllRegularChips,fencheng,netoKita,userStatus,userActive,userDividend,userPoundage,komisyon,userAllStakedAmount,addtime) VALUES ('$userUid','$proxyid','$userNumber','$truename','$userGroupid','$userGrouptitle','$userJointime','$userAllRegularChips','$fencheng','$netoKita','$userStatus','$userActive','$userDividend','$userPoundage','$komisyon','$userAllStakedAmount','".time()."');";
			$dsql->ExecuteNoneQuery($insql_insert);	

			}
		}
	}
}
//二级代理分成计算
function getproxyxjmoney($uid){
global $dsql;
$Date = date('Y-m-d H:i:s',mktime(0,0,0,m,01,Y));
$sqlStr="select * from ek_proxy where xjnum>0";
$dsql->SetQuery($sqlStr);
$dsql->Execute('ek_proxy_list');
$i=1;
	while($row=$dsql->GetArray('ek_proxy_list'))
	{
	$uid=$row['uid'];
	$fencheng=$row['xjfencheng'];
	$rowd = $dsql->GetOne("select sum(c.cashmoney) as dd from ek_proxy p left join proxy_cash c on c.proxyuid=p.uid where p.topuid=$uid and c.addtime>=$Date and c.xjdl!=1");
	$fcmoney_new=$rowd['dd'] * $fencheng;
	$now = date('Y-m-d H:i:s');
	$dsql->ExecuteNoneQuery("replace INTO `proxy_cash` (`proxyuid`,`cashmoney` ,`addtime`,`xjdl`)VALUES ('$uid','$fcmoney_new','$now','1');");
	$i++;
	}

}


//第三方加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600) 
{
	$ckey_length = 4;   
	// 随机密钥长度 取值 0-32;
	// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : EABAX::getAppInf('KEY'));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) 
	{
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) 
	{
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) 
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') 
	{
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) 
		{
			return substr($result, 26);
		} 
		else 
		{
			return '';
		}
	} 
	else 
	{
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
