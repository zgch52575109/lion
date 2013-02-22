<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册</title>
<meta name="keywords" content="<?php echo $this->_vars['cfg_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_vars['cfg_description']; ?>
" />
<link type="text/css" href="css/user_sign_in.css" rel="stylesheet">
<script language="javascript" type="text/javascript"  src="/js/common.js"></script>
<script language="javascript" type="text/javascript"  src="/js/main.js"></script>
<script language="javascript" type="text/javascript"  src="/js/public.js"></script>
<script language="javascript" type="text/javascript"  src="/js/usercheck.js"></script>
<script language="javascript" type="text/javascript"  src="/js/check.js"></script>
<script language="javascript" src="js/qq.js"></script>
<script language="javascript" src="js/date.js"></script>
<script language="javascript" src="js/jquery.js"></script>
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

<body onload="MM_preloadImages('images/A5-C.gif')">

<?php echo $this->_fetch_compile("top.html"); ?>
<form action="" method=post id="frmMain" name="frmMain"  onSubmit="" style="border:0;margin:0;padding:0;">
  <div class="neirong">
   <div class="sign_in_left">
   <div class="left_top"></div>
   <div class="left_center"></div>
   <div class="left_bottom"></div>
   </div>
   <div class="sign_in_center">
   <div class="center_top"></div>
   <div class="center_center">
   <div class="center_1">
<table width="543"  border="0" cellspacing="0" style="color:#DB631D; text-align:right; margin-top:20px; line-height:17px;">
  <tr>
    <td width="76" height="30">用户名 ：</td>
    <td height="30" colspan="2" align="left" valign="middle">
      <span class="line_1">
      <input name="UserName" type="text" style="height:16px; padding-top:3px; padding-left:3px;" size="40" border="0"  onblur="username_check()" onkeydown="if(event.keyCode==13)event.keyCode=9" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" id="username"/>
      </span></td>
    <td width="270" height="30" align="left"  style="font-size:12px;"  id="divTest">* 填写5-20位，且有英文(a-z)、数字(0-9)组成</td>
  </tr>
  <tr>
    <td width="76" height="30">真实姓名 ：</td>
    <td height="30" colspan="2" align="left" valign="middle">
      <input name="TrueName" id="Truename" onblur="Truename_check()" type="text" style="height:16px; padding-top:3px; padding-left:3px;" size="40" border="0" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')"/></td>
    <td width="270" height="30" align="left" style="font-size:12px; color:#F00" id="Truenametest" >* 必须与提款时的收款人姓名一致</td>
  </tr>
  <tr>
    <td height="30">性别 ：</td>
    <td height="30" colspan="2" align="left" valign="middle">
     
        <input type="radio" name="gender" id="SexM" value="1" checked style="width:35px;"/> 
         男
      <input type="radio" name="gender" id="SexF" value="0" style="width:20px; margin-left:35px;"/>
      <label for="SexF"></label>
<label for="SexM"></label>
   女
<label for="radio"></label>
     <label for="radio2"></label>

</td>
    <td width="270" height="30" align="left" style="font-size:12px;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">电话 ：</td>
    <td height="30" colspan="2" align="left" valign="middle">
      <span class="line_1">
      <input name="userTel" id="userTel" onblur="userTel_check()" type="text" style="height:16px; padding-top:3px; padding-left:3px;" size="40" border="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
      </span></td>
    <td width="270" height="30" align="left" style="font-size:12px;" id="userTeltest">* 请填写真实电话，保证我们能及时联系到您</td>
  </tr>
  <tr>
    <td height="30">邮箱地址 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"><input name="email" id="email1" type="text"  onblur="check_email1()" style=" height:16px; padding-top:3px; padding-left:3px;" size="40" border="0"/></td>
    <td width="270" height="30" align="left" style="font-size:12px;"  id="emailTest">* 请填写真实Email，保证信件发送到您的邮箱</td>
  </tr>
    <tr>
    <td height="30">密码 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"><input name="Password"  id="p1" onblur="checkPassnum()" type="password" style=" height:16px; padding-top:3px; padding-left:3px;" size="40" border="0"/></td>
    <td width="270" height="30" align="left" style="font-size:12px;" id="p1test">* 请输入6-16位密码</td>
  </tr>
  <tr>
    <td height="30">确认密码 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"><input name="rePassword"  id="p2" onblur="checkPass('p1','p2')" type="password" style=" height:16px; padding-top:3px; padding-left:3px;" size="40" border="0"/></td>
    <td width="270" height="30" align="left" style="font-size:12px;" id="p2test">* 请确认密码</td>
  </tr>
  <tr>
    <td height="30">推荐人 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"><input name="formuser" type="text" style=" height:16px; padding-top:3px; padding-left:3px;" size="40" border="0" value="<?php echo $this->_vars['formuser']; ?>
"/></td>
    <td width="270" height="30" align="left" style="font-size:12px; color:#F00">如果不存在请不要填写</td>
  </tr>
  <tr>
    <td height="30">来源渠道 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"> <input name="proxyuid" type="text" style=" height:16px; padding-top:3px; padding-left:3px;" size="40" border="0" value="<?php echo $this->_vars['proxyuid']; ?>
"/></td>
    <td width="270" height="30" align="left" style="font-size:12px;">如果不存在可以不填写</td>
  </tr>
  <tr>
    <td height="30">出生日期 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"> &nbsp;&nbsp;
      <select id="Year" name="Year" style="width:50px">
                                        <option value="" selected="selected">年</option>
										<?php
										for($i=1900;$i<=2012;$i++){
										echo "<option value='".$i."'>".$i."</option>";
										}
										?>
                                    </select>
                                    <select id="Month" name="Month" onchange="SetDay()" style="width:40px">
                                        <option value="" selected="selected">月</option>
										<?php
										for($i=1;$i<=12;$i++){
										echo "<option value='".$i."'>".$i."</option>";
										}
										?>
                                    </select>
                                    <select id="Day" name="Day" onchange="SetD()" style="width:40px">
                                        <option value="" selected="selected">日</option>
										<?php
										for($i=1;$i<=31;$i++){
										echo "<option value='".$i."'>".$i."</option>";
										}
										?>
                             </select><span id="Inner_YMD"></span></td>
  </tr>
  <tr>
    <td height="30">安全问题 ：</td>
    <td height="30" colspan="2" align="left" valign="middle">    <label for="select"></label>
      <select name="safequestion" id="safequestion"  style="width:163px; margin-left:10px;" size="1">
        <option value="">----- 选择一项 -----</option>
	<option value="1">母亲的名字？</option>
	<option value="2">喜爱的书名？</option>
	<option value="3">最喜欢的宠物的名字？</option>
	<option value="4">最喜欢的电影？</option>
	<option value="5">最喜欢做的事？</option>
	<option value="6">最喜欢的运动队名？</option>
	<option value="7">我的儿时英雄？</option>
	<option value="8">我的秘密代码？</option>
	<option value="9">我最喜欢的明星？</option>
	<option value="10">我的梦想？</option>
     </select></td>
    <td width="270" height="30" align="left" style="font-size:12px;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">答案 ：</td>
    <td height="30" colspan="2" align="left" valign="middle"><input name="safeanswer" type="text" style="height:16px; padding-top:3px; padding-left:3px;" size="40" border="0"/></td>
    <td width="270" height="30" align="left" style="font-size:12px;">* 请填写答案，方便您找回密码</td>
  </tr>
  <tr>
    <td height="30">验证码 ：</td>
    <td width="79" height="30" align="left" valign="middle" style="font-size:12px;"> <input name="ValidateCode" type="text" style=" width:70px; height:16px; padding-top:3px; padding-left:3px;" size="20" border="0" onkeyup='this.value=this.value.replace(/[^0-9a-zA-Z]\D*$/,"")'/> </td>
    <td width="110" height="30" align="left" valign="middle" style="font-size:12px;"><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></td>
    <td width="270" height="30" align="left" style="font-size:12px;">* 请填写验证码</td>
  </tr>
</table>

  <a href="#" onclick="Check_Reg()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image9','','images/A5-C.gif',1)"><img src="images/49E7.gif" name="Image9" width="160" height="63" style="margin-top:10px;" border="0" id="Image9" /></a> </div>
  <div class="center_2">
   
   </div>
   
   </div>
   <div class="center_bottom"></div>
   </div>
   <div class="sign_in_right">
   <div class="right_top"></div>
   <div class="right_center"></div>
   <div class="right_bottom"></div>
   </div>
   </div>
  </div>
<input type="hidden" value="save" name="action">
</form>
<?php echo $this->_fetch_compile("foot.html"); ?>
</body>

</html>