<?php
define('EK_ADMIN', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ) );
require_once(EK_ADMIN."/../include/common.php");
require_once(EK_INC."/check.admin.php");
header("Cache-Control:private");
$dsql->safeCheck = false;
$dsql->SetLongLink();

if(adminipbanned()){
	ShowMsg("您的IP不在本站访问列表里，不能访问本站", "javascript:;");
	exit;
}

//获得当前脚本名称，如果你的系统被禁用了$_SERVER变量，请自行更改这个选项
$EkNowurl = $s_scriptName = '';
$isUrlOpen = @ini_get("allow_url_fopen");
$EkNowurl = GetCurUrl();
$EkNowurls = explode('?',$EkNowurl);
$s_scriptName = $EkNowurls[0];
$Ekrurl=getreferer();
if(empty($Ekrurl)) $Ekrurl=$EkNowurl;

//检验用户登录状态
$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	//header("location:login.php");
	header("location:login.php?gotopage=".urlencode($EkNowurl));
	exit();
}


function getreferer()
{
	$refurl=$_SERVER['HTTP_REFERER'];
	if(!empty($refurl)){
		$refurlar=explode('/',$refurl);
		$i=count($refurlar)-1;
		$url=$refurlar[$i];
	}
	return $url;
}

// 分页函数
function multi($num, $perpage, $curpage, $mpurl, $maxpages = 1000) {
	$multipage = '';
	$realpages = 1;
	if($num > $perpage) {
		$page = 8;
		$offset = 4;
		$realpages = @ceil($num / $perpage);
		$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}

		$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<li class="text"><a href="'.$mpurl.'page=1">&laquo; First</a></li>' : '').($curpage > 1 ? '<li class="text"><a href="'.$mpurl.'page='.($curpage - 1).'">&#8249; Previous</a></li>' : '<li class="text">&#8249; Previous</li>');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<li class="page"><a href="'.$mpurl.'page='.$i.'">'.$i.'</a></li>' : '<li><a href="'.$mpurl.'page='.$i.'">'.$i.'</a></li>';
		}
		$multipage .= ($curpage < $pages ? '<li class="text"><a href="'.$mpurl.'page='.($curpage + 1).'">Next &#8250;</a></li>' : '<li class="text">Next &#8250;</li>').($to < $pages ? '<li class="text"><a href="'.$mpurl.'page='.$pages.'">Last &raquo;</a></li>' : '');

		$multipage = $multipage ? $multipage : '';
	}
	return $multipage;
}

/*++++++++++++++++++++++++++++++++++++
程序名称：IP解析程序
程序功能：基于QQ的二进制数据库QQWry.Dat
程序作者：strongc
使用方法：

请将文件 QQWry.Dat 置于当前目录中
或者可以用修改
define('__QQWRY__' , dirname(__FILE__).".\QQWry.Dat");
语句自定义QQWry.Dat路径

#实例+++++++++++++++++++++++++++++++
$ip="202.201.48.1";
$QQWry=new QQWry;
$ifErr=$QQWry->QQWry($ip);
echo "$QQWry->Country$QQWry->Local";
+++++++++++++++++++++++++++++++++++++*/

define('__QQWRY__' , dirname(__FILE__).".\qqwry.dat");
class QQWry
{
	var $StartIP = 0;
	var $EndIP = 0;
	var $Country = '';
	var $Local = '';

	var $CountryFlag = 0; // 标识 Country位置
        // 0x01,随后3字节为Country偏移,没有Local
        // 0x02,随后3字节为Country偏移,接着是Local
        // 其他,Country,Local,Local有类似的压缩。可能多重引用。

	var $fp;

	var $FirstStartIp = 0;
	var $LastStartIp = 0;
	var $EndIpOff = 0;

	function getStartIp($RecNo)
	{
		$offset = $this->FirstStartIp + $RecNo * 7;
		@fseek($this->fp, $offset, SEEK_SET);
		$buf = fread($this->fp, 7);
		$this->EndIpOff = ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256);
		$this->StartIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		return $this->StartIp;
	}

	function getEndIp()
	{
		@fseek($this->fp, $this->EndIpOff, SEEK_SET);
		$buf = fread($this->fp, 5);
		$this->EndIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		$this->CountryFlag = ord($buf[4]);
		return $this->EndIp;
	}

	function getCountry()
	{
		switch($this->CountryFlag)
		{
			case 1: 
			case 2: 
				$this->Country = $this->getFlagStr($this->EndIpOff + 4); 
				$this->Local = (1 == $this->CountryFlag) ? '' : $this->getFlagStr($this->EndIpOff + 8); 
				break ; 
			default: 
				$this->Country = $this->getFlagStr($this->EndIpOff + 4); 
				$this->Local = $this->getFlagStr(ftell($this->fp)); 
		}
	}

	function getFlagStr($offset)
	{
		$flag = 0;
		
		while(1)
		{
			@fseek($this->fp, $offset, SEEK_SET);
			$flag = ord(fgetc($this->fp));
			
			if($flag == 1 || $flag == 2)
			{
				$buf = fread($this->fp, 3);
				
				if($flag == 2)
				{
					$this->CountryFlag = 2;
					$this->EndIpOff = $offset - 4;
				}
				
				$offset = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256);
			}
			else
				break;
		}
		
		if($offset < 12) return '';
		
		@fseek($this->fp, $offset, SEEK_SET);

		return $this->getStr();
	}

	function getStr()
	{
		$str = '';
		
		while(1)
		{
			$c = fgetc($this->fp);

			if(ord($c[0]) == 0) break;
			
			$str .= $c;
		}
		
		return $str;
	}

	function QQwry($dotip = '')
	{
		if(!$dotip) return;
		
		if(ereg("^(127)", $dotip))
		{
			$this->Country = '本地网络';
			return;
		}
		else if(ereg("^(192)", $dotip))
		{
			$this->Country = '局域网';
			return;
		}

		$nRet;
		$ip = $this->IpToInt($dotip);
		$this->fp = fopen(__QQWRY__, "rb");
		
		if($this->fp == NULL)
		{
			$szLocal = "OpenFileError";
			return 1;
		}
		
		@fseek($this->fp, 0, SEEK_SET);
		$buf = fread($this->fp, 8);
		$this->FirstStartIp = ord($buf[0]) + (ord($buf[1]) * 256) + (ord($buf[2]) * 256 * 256) + (ord($buf[3]) * 256 * 256 * 256);
		$this->LastStartIp = ord($buf[4]) + (ord($buf[5]) * 256) + (ord($buf[6]) * 256 * 256) + (ord($buf[7]) * 256 * 256 * 256);

		$RecordCount = floor(($this->LastStartIp - $this->FirstStartIp) / 7);
		
		if($RecordCount <= 1)
		{
			$this->Country = "FileDataError";
			fclose($this->fp) ;
			return 2 ;
		}

		$RangB = 0;
		$RangE = $RecordCount;
		
		// Match ...
		while($RangB < $RangE - 1)
		{
			$RecNo = floor(($RangB + $RangE) / 2);
			$this->getStartIp($RecNo) ;

			if($ip == $this->StartIp)
			{
				$RangB = $RecNo;
				break;
			}
			
			if($ip > $this->StartIp) $RangB = $RecNo;
			else $RangE = $RecNo;
		}
		
		$this->getStartIp($RangB);
		$this->getEndIp();

		if(($this->StartIp <= $ip) && ($this->EndIp >= $ip))
		{
			$this->getCountry();
		}
		else
		{
			$this->Country = '未知';
			$this->Local = '';
		}
		
		fclose($this->fp);
	}

	function IpToInt($Ip)
	{
		$array = explode('.', $Ip);
		$Int = ($array[0] * 256 * 256 * 256) + ($array[1] * 256 * 256) + ($array[2] * 256) + $array[3];

		return $Int;
	}
}