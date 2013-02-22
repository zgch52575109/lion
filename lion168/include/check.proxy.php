<?php
if(!defined('EK_INC')) exit('Request Error!');
@session_start();
//检查用户名的合法性
function CheckUserEmail($uid, $msgtitle='邮箱',$ckhas=true)
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

	if($cfg_soft_lang=='utf-8')
	{
		$ck_uid = utf82gb($uid);
	}
	else
	{
		$ck_uid = $uid;
	}

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
		$sql="Select * From `ek_proxy` where email='$uid'";
		$row = $dsql->GetOne($sql);
		if(is_array($row)) return $msgtitle."已经存在！";
	}
	return 'ok';
}

//检查用户名的合法性
function Checkuid($uid, $msgtitle='用户名', $ckhas=true)
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
		$row = $dsql->GetOne("Select * From `ek_proxy` where username like '$uid' ");
		if(is_array($row)) return $msgtitle."已经存在！";
	}
	return 'ok';
}

//网站会员登录类
class PoxyLogin
{
	var $M_ID;
	var $M_LoginID;
	var $M_Money;
	var $M_Scores;
	var $M_UserName;
	var $M_Groupid;
	var $M_LoginTime;
	var $M_KeepTime;
	var $M_Status;
	var $fields;

	var $M_Honor = '';

	//php5构造函数
	function __construct($kptime = -1)
	{
		global $dsql;
		if($kptime==-1)
		{
			$this->M_KeepTime = 3600 * 24 * 7;
		}
		else
		{
			$this->M_KeepTime = $kptime;
		}
		$this->M_ID = $this->GetNum(GetCookie("EKuid"));
		$this->M_LoginTime = GetCookie("EKLoginTime");
		$this->fields = array();
		$this->isAdmin = false;
		if(empty($this->M_ID))
		{
			$this->ResetUser();
		}
		else
		{
			$this->M_ID = intval($this->M_ID);
			$this->fields = $dsql->GetOne("Select * From `ek_proxy` where uid='{$this->M_ID}' ");
			if(is_array($this->fields))
			{
			
				//间隔一小时更新一次用户登录时间
				if(time() - $this->M_LoginTime > 3600)
				{
					$dsql->ExecuteNoneQuery("update `ek_proxy` set logintime='".time()."',loginip='".GetIP()."' where uid='".$this->fields['mid']."';");
					PutCookie("EKLoginTime",time(),$this->M_KeepTime);
				}
				$this->M_LoginID = $this->fields['uid'];
				$this->M_UserName = $this->fields['username'];
				$this->M_Groupid = $this->fields['groupid'];
				$this->M_Money = $this->fields['money'];
				$this->M_Status = $this->fields['status'];
			}
			else
			{
				$this->ResetUser();
			}
		}
	}

	function MemberLogin($kptime = -1)
	{
		$this->__construct($kptime);
	}

	//退出cookie的会话
	function ExitCookie()
	{
		$this->ResetUser();
	}

	//验证用户是否已经登录
	function IsLogin()
	{
		if($this->M_ID > 0) return true;
		else return false;
	}

	//重置用户信息
	function ResetUser()
	{
		$this->fields = '';
		$this->M_ID = 0;
		$this->M_LoginID = '';
		$this->M_UserName = "";
		$this->M_Groupid = '';
		$this->M_Money = 0;
		$this->M_Status = 0;
		$this->M_LoginTime = 0;
		DropCookie('EKuid');
		DropCookie('EKTrueName');
		DropCookie('EKPhone');
		DropCookie('EKLoginTime');
	}

	//获取整数值
	function GetNum($fnum){
		$fnum = ereg_replace("[^0-9\.]",'',$fnum);
		return $fnum;
	}

	//用户登录
	//把登录密码转为指定长度md5数据
	function GetEncodePwd($pwd)
	{
		global $cfg_mb_pwdtype;
		if(strlen($pwd)=='32') return $pwd;
		if(empty($cfg_mb_pwdtype)) $cfg_mb_pwdtype = '32';
		switch($cfg_mb_pwdtype)
		{
			case 'l16':
				 return substr(md5($pwd), 0, 16);
			case 'r16':
				 return substr(md5($pwd), 16, 16);
			case 'm16':
				 return substr(md5($pwd), 8, 16);
			default:
				return md5($pwd);
		}
	}
	
	//把数据库密码转为特定长度
	//如果数据库密码是明文的，本程序不支持
	function GetShortPwd($dbpwd)
	{
		global $cfg_mb_pwdtype;
		if(empty($cfg_mb_pwdtype)) $cfg_mb_pwdtype = '32';
		$dbpwd = trim($dbpwd);
		if(strlen($dbpwd)==16)
		{
			return $dbpwd;
		}
		else
		{
			switch($cfg_mb_pwdtype)
			{
				case 'l16':
					return substr($dbpwd, 0, 16);
				case 'r16':
					return substr($dbpwd, 16, 16);
				case 'm16':
					return substr($dbpwd, 8, 16);
				default:
					return $dbpwd;
			}
		}
	}
	
	function CheckUser(&$loginuser,$loginpwd)
	{
		global $dsql;

		//检测用户名的合法性
		$rs = Checkuid($loginuser,'用户名',false);

		//用户名不正确时返回验证错误，原登录名通过引用返回错误提示信息
		if($rs!='ok')
		{
			$loginuser = $rs;
			return '0';
		}

		$row = $dsql->GetOne("Select uid,password,logintime,username,phone From `ek_proxy` where username='$loginuser' ");
		if(is_array($row))
		{
			if($this->GetShortPwd($row['password']) != $this->GetEncodePwd($loginpwd))
			{
				return -1;
			}
			else
			{
				$this->PutLoginInfo($row['uid'],$row['username'],$row['phone'], $row['logintime']);
				return 1;
			}
		}
		else
		{
			return 0;
		}
	}

	//保存用户cookie
	function PutLoginInfo($uid,$truename,$phone, $logintime=0)
	{
		global $dsql;
		$this->M_ID = $uid;
		$this->M_LoginTime = time();
		if($this->M_KeepTime > 0)
		{
			PutCookie('EKuid',$uid,$this->M_KeepTime);
			PutCookie('EKUserName',$truename,$this->M_KeepTime);
			PutCookie('EKPhone',$phone,$this->M_KeepTime);
			PutCookie('EKLoginTime',$this->M_LoginTime,$this->M_KeepTime);
		}
		else
		{
			PutCookie('EKuid',$uid);
			PutCookie('EKUserName',$truename);
			PutCookie('EKPhone',$phone);
			PutCookie('EKLoginTime',$this->M_LoginTime);
		}
	}
}

//检查用户是否被禁言
function CheckNotAllow()
{
	global $cfg_cl;
	if(empty($cfg_cl->M_ID)) return ;
	if($cfg_cl->fields['status'] == '0')
	{
		ShowMsg('您的帐号已被冻结，请联系管理员处理！', '-1');
		exit();
	}
}
?>