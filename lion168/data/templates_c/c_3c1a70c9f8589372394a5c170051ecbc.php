   <div class="top-1">
   
   <table width="1000" height="28" border="0" cellspacing="0" style="margin:auto" class="toubu">
  <tr>
  <?php if ($this->_vars['loginuid']): ?>
	<td width="625">欢迎您，<?php echo $this->_vars['loginname']; ?>

	
	&nbsp;&nbsp;<a href="/<?php session_start();echo $_SESSION['isMemberOrProxy'];?>/index.php"><?php session_start();echo $_SESSION['isnametext'];?>中心</a> | <a href="/<?php session_start();echo $_SESSION['isMemberOrProxy'];?>/logout.php">退出登录</a></td>
	<?php else: ?>
  <form name="loginfo" id="loginfo" method="post" action="login.php?action=login" style="margin: 0px;padding:0;" onKeyDown="jumpToNext();" target="_top">
    <td width="25">账号</td>
    <td width="107" class="wb-1"><input name="username" type="text"/ ></td>
    <td width="39">&nbsp;密码</td>
    <td width="107" class="wb-1"><input name="password" type="password"/></td>
   <td width="52" align="center">&nbsp;验证码</td>
    <td width="49" class="wb-1"><input name="ValidateCode" type="text" maxlength="4" style="width:38px"/ ></td>
    <td width="49"><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer; margin-top:-2px;" onclick="this.src=this.src+'?'" /></td>
    <td width="65"  class="tijiao"><input type="submit" name="Submit" value="" /></td>
    <td width="132" class="wangmi"><a href="sign_in.html">免费注册</a> | <a href="password_find.html">忘记密码？</a></td>
	</form>
	<?php endif; ?>
    <td width="133" style="text-align:left; line-height:22px;">
	<script language="javascript">RunGLNL1()</script>
		  </td>
    <td width="80" style="text-align:right; line-height:22px;">语言选择：</td>
    <td width="86" align="left" style="text-align:left">
	<script language="javascript">
	   function xianshi()
	   {document.getElementById("xsyc").style.overflow="visible" }
	   function guanbi()
	   {document.getElementById("xsyc").style.overflow="hidden" }
	</script>
	<div class="yyxz">
	    <div class="yyjd" id="xsyc" onmousemove="xianshi()" onmouseout="guanbi()">
		
		  <table  border="0" cellspacing="0" style="background:#000000"  >
            <tr>
              <td width="37" height="22" valign="middle"><img src="images/img4.jpg"  style="margin-left:4px; margin-bottom:1px"></td>
              <td width="60" height="22"><a href="#" >中文简体</a></td>
            </tr>
			<tr>
              <td height="22"><img src="images/img3.jpg" style="margin-left:4px; margin-bottom:1px"></td>
              <td><a href="#">中文繁體</a></td>
            </tr>
			<tr>
              <td height="22"><img src="images/img2.jpg" style="margin-left:4px; margin-bottom:1px"></td>
              <td style="padding-left:1px"> <a href="#"> English</a></td>
            </tr>
			<tr>
              <td height="22"><img src="images/img23.jpg" style="margin-left:4px; margin-bottom:1px"></td>
              <td style="padding-left:1px"><a href="#"><img src="images/img20.gif" 

border="0"></a></td>
            </tr>
          </table>
		</div>
	</div>	</td>
  </tr>
</table>

   </div>