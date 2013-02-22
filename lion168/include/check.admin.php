<?php
if(!defined('EK_INC'))
{
	exit("Request Error!");
}
session_start();

//检查用户名的合法性
function CheckUserID($uid, $msgtitle='用户名', $ckhas=true)
{
	global $cfg_mb_notallow,$cfg_mb_idmin,$cfg_soft_lang,$dsql;
	if($cfg_mb_notallow != '')
	{
		$nas = explode(',',$cfg_mb_notallow);
		if(in_array($uid,$nas))
		{
			return $msgtitle.'为系统禁止的标识！';
		}
	}

	$ck_uid = $uid;

	for($i=0;isset($ck_uid[$i]);$i++)
	{
			if(ord($ck_uid[$i]) > 0x80)
			{
				if(isset($ck_uid[$i+1]) && ord($ck_uid[$i+1])>0x40)
				{
					$i++;
				}
				else
				{
					return $msgtitle.'可能含有乱码，建议你改用英文字母和数字组合！';
				}
			}
			else
			{
				if(eregi("[^0-9a-z@\.-]",$ck_uid[$i]))
				{
					return $msgtitle.'不能含有 [@]、[.]、[-]以外的特殊符号！';
				}
			}
	}
	if($ckhas)
	{
		$row = $dsql->GetOne("Select * From `ek_admin` where name like '$uid' ");
		if(is_array($row)) return $msgtitle."已经存在！";
	}
	return 'ok';
}

//检验用户是否有权使用某功能
function TestPurview($n)
{
	$rs = false;
	$purview = $GLOBALS['cuserLogin']->getPurview();
	if(eregi('admin_AllowAll',$purview))
	{
		return true;
	}
	if($n=='')
	{
		return true;
	}
	if(!isset($GLOBALS['groupRanks']))
	{
		$GLOBALS['groupRanks'] = explode(' ',$purview);
	}
	$ns = explode(',',$n);
	foreach($ns as $n)
	{
		//只要找到一个匹配的权限，即可认为用户有权访问此页面
		if($n=='')
		{
			continue;
		}
		if(in_array($n,$GLOBALS['groupRanks']))
		{
			$rs = true; break;
		}
	}
	return $rs;
}

function CheckPurview($n)
{
	if(!TestPurview($n))
	{
		ShowMsg("对不起，你没有权限执行此操作！<br/><br/><a href='javascript:history.go(-1);'>点击此返回上一页&gt;&gt;</a>",'javascript:;');
		exit();
	}
}

//是否没权限限制(超级管理员)
function TestAdmin()
{
	$purview = $GLOBALS['cuserLogin']->getPurview();
	if(eregi('admin_AllowAll',$purview))
	{
		return true;
	}
	else
	{
		return false;
	}
}


/*function CheckPurview()
{
	if($GLOBALS['cuserLogin']->getUserRank()<>1)
	{
		ShowMsg("对不起，你没有权限执行此操作！<br/><br/><a href='javascript:history.go(-1);'>点击此返回上一页&gt;&gt;</a>",'javascript:;');
		exit();
	}
}
*/

$admincachefile = EK_DATA.'/admin_'.cn_substr(md5($cfg_cookie_encode),24).'.php';
if(!file_exists($admincachefile))
{
	$fp = fopen($admincachefile,'w');
	fwrite($fp,'<'.'?php $admin_path ='." ''; ?".'>');
	fclose($fp);
}
require_once($admincachefile);

class userLogin
{
	var $userName = '';
	var $userPwd = '';
	var $userID = '';
	var $adminDir = '';
	var $groupid = '';
	var $keepUserIDTag = "ek_admin_id";
	var $keepgroupidTag = "ek_group_id";
	var $keepUserNameTag = "ek_admin_name";
	var $keepUserPurviewTag = 'ek_admin_purview';

	//php5构造函数
	function __construct($admindir='')
	{
		global $admin_path;
		if(isset($_SESSION[$this->keepUserIDTag]))
		{
			$this->userID = $_SESSION[$this->keepUserIDTag];
			$this->groupid = $_SESSION[$this->keepgroupidTag];
			$this->userName = $_SESSION[$this->keepUserNameTag];
			$this->userPurview = $_SESSION[$this->keepUserPurviewTag];
		}

		if($admindir!='')
		{
			$this->adminDir = $admindir;
		}
		else
		{
			$this->adminDir = $admin_path;
		}
	}

	function userLogin($admindir='')
	{
		$this->__construct($admindir);
	}

	//检验用户是否正确
	function checkUser($username,$userpwd)
	{
		global $dsql;

		//只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
		$this->userName = ereg_replace("[^0-9a-zA-Z_@!\.-]",'',$username);
		$this->userPwd = ereg_replace("[^0-9a-zA-Z_@!\.-]",'',$userpwd);
		echo
		$pwd = substr(md5($this->userPwd),5,20);
		$dsql->SetQuery("Select admin.*,atype.purviews From `ek_admin` admin left join `ek_admintype` atype on atype.rank=admin.groupid where admin.name like '".$this->userName."' and admin.state='1' limit 0,1");
		$dsql->Execute();
		$row = $dsql->GetObject();
		if(!isset($row->password))
		{
			return -1;
		}
		else if($pwd!=$row->password)
		{
			return -2;
		}
		else
		{
			$loginip = GetIP();
			$this->userID = $row->id;
			$this->groupid = $row->groupid;
			$this->userName = $row->name;
			$this->userPurview = $row->purviews;
			$inquery = "update `ek_admin` set loginip='$loginip',logintime='".time()."' where id='".$row->id."'";
			$dsql->ExecuteNoneQuery($inquery);
			return 1;
		}
	}

	//保持用户的会话状态
	//成功返回 1 ，失败返回 -1
	function keepUser()
	{
		if($this->userID!=""&&$this->groupid!="")
		{
			global $admincachefile;

			$_SESSION[$this->keepUserIDTag] = $this->userID;
			$_SESSION[$this->keepgroupidTag] = $this->groupid;
			$_SESSION[$this->keepUserNameTag] = $this->userName;
			$_SESSION[$this->keepUserPurviewTag] = $this->userPurview;

			PutCookie('EKUserID',$this->id,3600 * 24,'/');
			PutCookie('EKLoginTime',time(),3600 * 24,'/');
			$fp = fopen($admincachefile,'w');
			fwrite($fp,'<'.'?php $admin_path ='." '{$this->adminDir}'; ?".'>');
			fclose($fp);
			return 1;
		}
		else
		{
			return -1;
		}
	}


	//结束用户的会话状态
	function exitUser()
	{
		DropCookie('EKAdmindir');
		DropCookie('EKUserID');
		DropCookie('EKLoginTime');
		$_SESSION = array();
	}


	//获得用户的权限值
	function getgroupid()
	{
		if($this->groupid!='')
		{
			return $this->groupid;
		}
		else
		{
			return -1;
		}
	}

	function getUserRank()
	{
		return $this->getgroupid();
	}

	//用户权限表
	function getPurview()
	{
		return $this->userPurview;
	}

	//获得用户的ID
	function getUserID()
	{
		if($this->userID!='')
		{
			return $this->userID;
		}
		else
		{
			return -1;
		}
	}

	//获得用户名
	function getUserName()
	{
		if($this->userName!='')
		{
			return $this->userName;
		}
		else
		{
			return -1;
		}
	}
}
?>