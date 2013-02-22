<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>修改密码</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="../js/public.js"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">修改密码</div>
 <div id="leftcontent">
  <ul>
        <li><a href="info.php">账户信息</a></li>
    <li><a href="datum.php">修改信息</a></li>
    <li><a href="password.php" class="current">修改密码</a></li>
    <li><a href="bank_bd.php">绑定银行卡</a></li>
  </ul>
 </div>
 <div id="rightcontent">
<form action="" method="post" id="frmMain" name="frmMain" onSubmit="">
   <ul class="list">
 
     <li>
       <div class="l"><b>用户名 </b><span>*</span></div>
       <div class="r"><input name="username" readonly="readonly" type="text" class="text" id="username" value="<?php echo $this->_vars['username']; ?>
" maxlength="10" /></div>
       <div class="clear"></div>
     </li>
     <li id="sprypassword3">
       <div class="l"><b>旧密码 </b><span>*</span><p><span class="passwordRequiredMsg">需要输入一个值。</span></p></div>
       <div class="r"><input name="password3" type="text" class="text" id="password3" maxlength="20" /></div>
       <div class="clear"></div>
     </li>     
     <li id="sprypassword2">
       <div class="l"><b>新密码 </b><span>*</span><p><span class="passwordRequiredMsg">需要输入一个值。</span></p></div>
       <div class="r"><input name="password2" type="text" class="text" id="password2" maxlength="15" /></div>
       <div class="clear"></div>
     </li>     
     <li id="sprypassword1">
       <div class="l"><b>确认新密码 </b><span>*</span><p><span class="passwordRequiredMsg">需要输入一个值。</span></p></div>
       <div class="r"><input name="password1" type="text" class="text" id="password1" maxlength="15" /></div>
       <div class="clear"></div>
     </li>  
   </ul>
   <dl class="tip">
     <dt>重要提示：</dt>
     <dd>每次存款前，请注意查看我们最新的存款银行账户信息，否则可能会导致您的存款延迟</dd>
   </dl>
   <div class="btns"><div class="btndiv"><input type="hidden" name="action" value="save"><input name="提交" type="submit" class="submit" value="提交"  onclick="Save_form();" /></div></div>
   </form>
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, maxChars:20, validateOn:["blur"]});
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2", {minChars:6, maxChars:20, validateOn:["blur"]});
var sprypassword3 = new Spry.Widget.ValidationPassword("sprypassword3", {minChars:6, maxChars:20, validateOn:["blur"]});
</script>
<script type="text/javascript">
function Save_form(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";

	if (Check_Input(document.frmMain.password3,'旧密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(document.frmMain.password2,'密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(document.frmMain.password1,'重复密码',6,20,iChars) != true){
		return false;
	}

	if (document.frmMain.password1.value != document.frmMain.password2.value){
		alert("两次密码输入不一致");
		document.frmMain.password2.focus();
		return false;
	}
	document.frmMain.submit();
	return true;
}
</script>
</body>
</html>
