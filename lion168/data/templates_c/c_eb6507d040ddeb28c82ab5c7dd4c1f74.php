<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>立即注册 - 金狮娱乐</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/index/global.css" rel="stylesheet" type="text/css" />
    <style>
	   .yellow { color:#F3C32C; }
	</style>
 

<script language="javascript" type="text/javascript"  src="/js/main.js"></script>

<script language="javascript" type="text/javascript"  src="/js/public.js"></script>

<script language="javascript" type="text/javascript"  src="/js/usercheck.js"></script>

<script language="javascript" type="text/javascript"  src="/js/check.js"></script>

<script language="javascript" src="js/qq.js"></script>

<script language="javascript" src="js/date.js"></script>

<script language="javascript" src="js/jquery.js"></script>

</head>
<body >
 <?php echo $this->_fetch_compile("index/top.html"); ?>  
 
<div id="maincontent">
 <div id="informscroll">
  <div id="informcontent">
    <?php echo $this->_fetch_compile("index/inc_notice.html"); ?>
    <div class="tel"></div>
    </div>
 </div>
 <div id="listcontent">
   <div class="inners">
    <?php echo $this->_fetch_compile("index/left_menu.html"); ?> 
   <div id="rightcontent">
     <div class="site"><a href="sign_in.html">立即注册</a></div>
<div style=" width:100%; height:50px; text-align:left; line-height:50px;">&nbsp;<span class="yellow">开户提示</span>：*&nbsp;信息必须填写完整</div>
<form action="" method=post id="frmMain" name="frmMain"  onSubmit="" style="border:0;margin:0;padding:0;">        
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100">&nbsp;</td>
     <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;用 户 名：</td>
    <td><input name="UserName" type="text" class="text" onblur="username_check()" onkeydown="if(event.keyCode==13)event.keyCode=9" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" id="username"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;密 码：</td>
    <td><input name="Password"  id="p1" onblur="checkPassnum()" type="password" class="text" style="width:148px; height:17px;" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;密 码 确 认：</td>
    <td><input name="rePassword"  id="p2" onblur="checkPass('p1','p2')" type="password" class="text" style="width:148px; height:17px;" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;姓 名：</td>
    <td><input name="TrueName" id="Truename" onblur="Truename_check()" type="text" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" class="text" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;性 别：</td>
    <td><input name="gender" type="radio" class="text" id="SexM" value="1" style="width:35px;" checked />男<input name="gender" type="radio"  class="text" id="SexF" value="0"  style="width:20px; margin-left:35px;" />女</td>
    <td>&nbsp;</td>
  </tr>
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;电 话：</td>
    <td><input name="userTel" id="userTel" onblur="userTel_check()" type="text"   class="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;邮 箱 地 址：</td>
    <td><input name="email" id="email1" type="text"  onblur="check_email1()" class="text"  /></td>
    <td>&nbsp;</td>
  </tr>
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;验 证 码：</td>
    <td><input name="ValidateCode" type="text" class="text" style="width:80px; margin-right:25px;" onkeyup='this.value=this.value.replace(/[^0-9a-zA-Z]\D*$/,"")'/><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></td>
    <td>&nbsp;</td>
  </tr>
  
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40">&nbsp;&nbsp;推 荐 人：</td>
    <td><input name="formuser" type="text" class="text" value="<?php echo $this->_vars['formuser']; ?>
"/></td>
    <td>&nbsp;</td>
  </tr>
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40">&nbsp;&nbsp;来 源 渠 道：</td>
    <td><input name="proxyuid" type="text" class="text" value="<?php echo $this->_vars['proxyuid']; ?>
"/></td>
    <td>&nbsp;</td>
  </tr> 
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40">&nbsp;&nbsp;出 生 日 期：</td>
    <td>
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
                             </select><span id="Inner_YMD"></span>
    
    </td>
    <td>&nbsp;</td>
  </tr> 
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40">&nbsp;&nbsp;安 全 问 题：</td>
    <td>
     <select name="safequestion" id="safequestion"  style="width:160px;" size="1">
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
     </select>
    </td>
    <td>&nbsp;</td>
  </tr>
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40">&nbsp;&nbsp;答 案：</td>
    <td><input name="safeanswer" type="text" class="text"  /></td>
    <td>&nbsp;</td>
  </tr>
    <tr><td height="20" colspan="5"><input name="" type="checkbox" value="" checked="checked" />在提呈申请的同时，本人已超过合法年龄以及本人在此网站的所有活动并没有抵触本人所身在的国家所管辖的法律。</td>
      </tr>
    <tr><td height="20" colspan="5"><input name="" type="checkbox" value="" checked="checked" />本人也接受在此项申请下有关的所有规则与条例以及隐私证明。</td>
      </tr>
      <tr>
      <td height="60" colspan="5" align="center" valign="middle">
      <input type="hidden" value="save" name="action">
      <a href="javascript://" onclick="Check_Reg()"><img src="images/index/submit.jpg" name="Image9"  border="0"  /></a>
      <a href="sign_in.html"><img src="images/index/r.jpg" name="Image9"  style="margin-top:10px;" border="0" /></a>
      </td>
      </tr>       
</table>

          
  
</form>
   </div>
   <div class="clear"></div>
   </div>
 </div>
</div>
<?php echo $this->_fetch_compile("index/footer.html"); ?> 
 <script type="text/javascript">				
 $(function(){
   //$(".leftcontent dl dd").hide();
   $(".leftcontent dl dt").click(function(){
   $(".leftcontent dl dd").not($(this).next()).hide();
   $(this).next().slideToggle(500); 
    });
 });
 </script>  
</body>
</html>
