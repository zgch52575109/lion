<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理注册 - 金狮娱乐</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/index/global.css" rel="stylesheet" type="text/css" />
    <style>
	   .yellow { color:#F3C32C; }
	</style>
 

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
     <div class="site"><a href="sign_in.html">代理注册</a></div>
<div style=" width:100%; height:50px; text-align:left; line-height:50px;">&nbsp;<span class="yellow">代理注册</span>：*&nbsp;信息必须填写完整</div>
<form action="" method=post id="frmMain" name="frmMain"  onSubmit="" style="border:0;margin:0;padding:0;">        
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100">&nbsp;</td>
     <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;用 户 名：</td>
    <td><input name="UserName" type="text" class="text" onkeydown="if(event.keyCode==13)event.keyCode=9" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" id="username"/></td>
    <td><span id="username_result">&nbsp;</span></td>
  </tr>
  <tr>
  <td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;密 码：</td>
    <td><input name="Password"  id="p1"  type="password" class="text" style="width:148px; height:17px;" /></td>
    <td><span id="p1_result">&nbsp;</span></td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;密 码 确 认：</td>
    <td><input name="rePassword"  id="p2" type="password" class="text" style="width:148px; height:17px;" /></td>
    <td><span id="p2_result">&nbsp;</span></td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;姓 名：</td>
    <td><input name="TrueName" id="Truename"  type="text" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" class="text" /></td>
    <td><span id="TrueName_result">&nbsp;</span></td>
  </tr>
 
  
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;电 话：</td>
    <td><input name="userTel" id="userTel" onblur="userTel_check()" type="text"   class="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></td>
    <td><span id="userTel_result">&nbsp;</span></td>
  </tr>
  
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;邮 箱 地 址：</td>
    <td><input name="email" id="email" type="text"  class="text"  /></td>
     <td><span id="email_result">&nbsp;</span></td>
  </tr>
  <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;QQ：</td>
    <td><input name="qq" id="qq" type="text"  class="text"  /></td>
     <td><span id="qq_result">&nbsp;</span></td>
  </tr>
  
    <tr><td width="100">&nbsp;</td>
    <td align="left" valign="middle" width="100" height="40"><span class="yellow">*</span>&nbsp;验 证 码：</td>
    <td><input name="ValidateCode" id="ValidateCode1" type="text" class="text" style="width:80px; margin-right:25px;" onkeyup='this.value=this.value.replace(/[^0-9a-zA-Z]\D*$/,"")'/><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></td>
    <td><span id="ValidateCode_result">&nbsp;</span></td>
  </tr>
 
      <tr>
      <td height="60" colspan="5" align="center" valign="middle">
      <input type="hidden" value="save" name="action">
      <input type="image" src="images/index/submit.jpg" name="submit_bottom" id="submit_bottom" />
 
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
<script type="text/javascript">
$(document).ready(function(){
		    $('#username').blur(function(){
		    var username = $.trim($('#username').val());
		    $.get('agency_reg.php?action=check_username', 'username='+username, function(result){
			   $('#username_result').html(result);	
		   });
	     }); 

		    $('#email').blur(function(){
		    var email = $.trim($('#email').val());
		    $.get('agency_reg.php?action=check_email', 'email='+email, function(result){
			   $('#email_result').html(result);	
           });
       }); 

	      //////验证表单

         $('#submit_bottom').click(function(){
			 var username = $.trim($('#username').val());
			 var Truename = $.trim($('#Truename').val());
		     var userTel = $.trim($('#userTel').val());
			 var email = $.trim($('#email').val());
             var p1 = $.trim($('#p1').val()); 
			 var p2 = $.trim($('#p2').val());
    		  var ValidateCode = $.trim($('#ValidateCode1').val()); 

			  if (username == "")
              {
				$('#username_result').html("请输入帐号名称");
                 $('#username').focus();
                 return false;
              } 

			 if(username.length > 20 || username.length < 5) 
			  {
                 $('#username_result').html("帐号长度为5-20个字符");
                 $('#username').focus();
                return false;
			 } 
            else
            { $('#username_result').html(""); }

 	         if (p1 == "")
              {
                $('#p1_result').html("请输入密码");
                $('#p1').focus();
                return false;
              }

			   

			if(p1.length < 6 || p1.length > 16)
			{
				$('#p1_result').html("密码长度为6-16个字符");
                $('#p1').focus();
                return false;
		    }
            else
			{ $('#p1_result').html(""); }  

		    if (p1 != p2) 
              {
              $('#p2_result').html("*&nbsp;&nbsp;帐号密码与确认密码不一致");
              $('#p2').focus(); 
                return false;
              }
            else 	 	    	  
            { $('#p2_result').html(""); } 
	
           if (Truename == "")
             {
                $('#TrueName_result').html("请输入真实姓名");
                $('#Truename').focus();
                return false;
            }
          else
           { $('#TrueName_result').html(""); }

			  //电话

      	     if (userTel == "")

              {
               $('#userTel_result').html("请输入真实电话");
               $('#userTel').focus();
               return false;
             }

			  else

			  { $('#userTel_result').html(""); }

			  //email

              if(!$("#email").val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/))

			       {

                    $('#email_result').html("请输入电子邮箱");

                    $('#email').focus();

                    return false;

			       }

				  else
                 { $('#email_result').html(""); } 

 	             if (ValidateCode == "")
                    {
                       $('#ValidateCode_result').html("请填写验证码");
                       $('#ValidateCode').focus();
                       return false;
			        } 
               else 	 	    	  
                   { $('#ValidateCode_result').html(""); } 
                $("#frmMain").submit();
			 }); 
}); 
</script>

</body>
</html>
