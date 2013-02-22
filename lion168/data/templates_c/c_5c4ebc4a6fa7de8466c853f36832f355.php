<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理管理中心 - 密码更改 </title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/agent/memberglobal.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="../js/public.js"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
 
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("agent/top.html"); ?>  
<div id="maincontent">
 <div id="informscroll">
  <div id="informcontent">
     <?php echo $this->_fetch_compile("agent/inc_notice.html"); ?>  
    <div class="tel"></div>
    </div>
 </div>
 <div id="listcontent">
   <div class="inners">
   <?php echo $this->_fetch_compile("agent/left_menu.html"); ?>  
   <div id="rightcontent">
     <div class="site"><strong>管理中心</strong></div>
     <div class="bodycontent">
<?php echo $this->_fetch_compile("agent/accountinfo.html"); ?>  
     <div class="content">
       <div class="title"><strong>密码更改</strong></div>
       <ul class="tablelist">
              <form action="" method="post" id="frmMain" name="frmMain" onSubmit="">
 
         <li><label>用户名：</label> <input name="username" type="text" id="username" class="text"  value="<?php echo $this->_vars['username']; ?>
" readonly /></li>         
         <li><label>旧密码：</label> <input name="password3" type="password" id="password3"  class="text" /><span class="passwordRequiredMsg">需要输入一个值。</span></li> 
         <li><label>新密码：</label> <input name="password2" value="" type="password" id="password2"  class="text" /><span class="passwordRequiredMsg">需要输入一个值。</span></li> 
         <li><label>确认新密码：</label> <input name="password1" type="password" id="password1"  class="text" /><span class="passwordRequiredMsg">需要输入一个值。</span></li>  
              <input type="hidden" name="action" value="save">
         <li class="btnli"><input type="button" class="btn" name="button" id="button" value="确认提交"  onclick="Save_form();" /> <input type="button" class="btn" value="取消" />
           
         </li>
    </form>
       </ul>
     </div>
     </div>
   </div>
   <div class="clear"></div>
   </div>
 </div>
</div>
<?php echo $this->_fetch_compile("agent/footer.html"); ?>  
</body>
</html>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, maxChars:20, validateOn:["blur"]});
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2", {minChars:6, maxChars:20, validateOn:["blur"]});
var sprypassword3 = new Spry.Widget.ValidationPassword("sprypassword3", {minChars:6, maxChars:20, validateOn:["blur"]});
</script>
</body></html>
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
