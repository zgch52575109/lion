<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登陆</title>
<link type="text/css" href="css/login.css" rel="stylesheet">
<script language="javascript" type="text/javascript"  src="/js/common.js"></script>
<script language="javascript" type="text/javascript"  src="/js/main.js"></script>
<script language="javascript" type="text/javascript"  src="/js/public.js"></script>
<script language="javascript" type="text/javascript"  src="/js/usercheck.js"></script>
<script language="javascript" src="js/qq.js"></script>
<script language="javascript" src="js/date.js"></script>
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>

<body onload="MM_preloadImages('images/AAE5.gif')">
<?php echo $this->_fetch_compile("top.html"); ?>
<form action="" method=post id="frmLogin" name="frmLogin"  onSubmit="" style="border:0;margin:0;padding:0;">
   <div class="neirong">
   <div class="login_top"></div>
   <div class="login_center">
   <div class="login_center_1"></div>
   <div class="login_center_2">
   <div class="login_center_2_top">
   </div>
   <div class="login_center_2_1eft">
   <div>账号 ：</div>
   <div style="margin-top:41px;">密码 ：</div>
   <div style="margin-top:41px;">验证码 ：</div>
   </div>
   <div class="login_center_2_center">
   <ul>
   <li class="line_1"> </li>
   <li class="line_2"><input name="username" type="text" style="height:19px; font-size:16px; padding-top:3px; padding-left:3px;" size="22" border="0" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/></li>
   <li class="line_1"></li>
   <li class="line_2"><input name="password" type="password" style="height:19px; font-size:16px; padding-top:3px; padding-left:3px;" size="23" border="0"/></li>
   <li class="line_1"></li>
   <li class="line_3"><table width="111%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="ValidateCode" type="text" style="height:19px; font-size:16px; padding-top:3px; padding-left:3px; margin-left: 10px;" size="8" onkeyup='this.value=this.value.replace(/[^0-9a-zA-Z]\D*$/,"")'/></td>
    <td><div style="padding-left:20px;"><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></div></td>
  </tr>
</table></li>
   <li class="line_4"></li>
   </ul>
   </div>
   <div class="login_center_2_right">
   <div style="margin-top:20px; text-align:left; margin-left:6px;"><a href="#" onclick="Check_Login()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','images/AAE5.gif',1)"><img src="images/4893.gif" name="Image8" width="95" height="97" border="0" id="Image8" /></a></div>
   </div>
   <div class="login_center_2_bottom">
   <ul>
   <li> <a href="sign_in.html"><strong>免费注册</strong></a></li>
   <li style="margin-left:45px;"> <strong><a href="password_find.html">忘记密码</a></strong></li>  
   </ul>
   </div>
   </div>
   <div class="login_center_3"></div>  
   </div>
   </div>
<input type="hidden" value="login" name="action">
</form>
<?php echo $this->_fetch_compile("foot.html"); ?>
</body>

</html>
