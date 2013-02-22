<div class="box">
 <link type="text/css" rel="stylesheet" href="css/mav.css" >

<div class="mavmk" style="background-image:url(images/index_new_02.gif);">
<div class="mav_top">
<div class="mav_logo"><a href="index.html"><img src="images/index_new_03.gif" width="210" height="99" border="0" /></a></div>

<div class="mav_bottom">
<div class="mav_bottom_1"><a href="real_person.html"><img src="images/index_new_05_a.gif" name="Image17" width="143" height="87" border="0" id="Image17" onmouseover="this.src='images/index_new_05_b.gif';" onmouseout="this.src='images/index_new_05_a.gif';" /></a></div>
<div class="mav_bottom_1"><a href="preferential.html"><img src="images/index_new_06_a.gif" name="Image18" width="85" height="87" border="0" id="Image18"  onmouseover="this.src='images/index_new_06_b.gif';" onmouseout="this.src='images/index_new_06_a.gif';" /></a></div>
<div class="mav_bottom_1"><a href="agency.html"><img src="images/index_new_07_a.gif" name="Image19" width="123" height="87" border="0" id="Image19" onmouseover="this.src='images/index_new_07_b.gif';" onmouseout="this.src='images/index_new_07_a.gif';" /></a></div>
<div class="mav_bottom_1"><a href="vip_level.php"><img src="images/index_new_10_a.gif" name="Image20" width="117" height="87" border="0" id="Image20"  onmouseover="this.src='images/index_new_10_b.gif';" onmouseout="this.src='images/index_new_10_a.gif';" /></a></div>
</div>


<div class="mav_login">
<table width="236" border="0" cellspacing="4" cellpadding="0" style="margin-top:15px;">
  <?php if ($this->_vars['loginuid']): ?>
  <tr style=" text-decoration:none;font-size:12px; color:#FEB638;">
	<td>欢迎您，<?php echo $this->_vars['loginname']; ?>

	<br><br><a href="/member/index.php" style=" text-decoration:none;font-size:12px; color:#FEB638;">会员中心</a> | <a href="/member/logout.php" style=" text-decoration:none;font-size:12px; color:#FEB638;">退出登录</a></td>
  </tr>
	<?php else: ?>
  <form name="loginfo" id="loginfo" method="post" action="login.php?action=login" style="margin: 0px;padding:0;" onKeyDown="jumpToNext();" target="_top">
  <tr>
    <td width="132"><label for="textfield"></label>
      <input name="username" type="text" id="textfield" style="width:132px; font-size:12px; color:#333;" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/></td>
    <td width="38"><label for="textfield3"></label>
      <input name="ValidateCode" type="text" id="textfield3" style=" float:left; width:44px; font-size:12px; color:#333;" /></td>
    <td width="46" rowspan="2"><img src="images/index_new_18.gif" width="46" height="46" onclick="document.loginfo.submit()"/></td>
  </tr>
  <tr>
    <td width="132"><label for="textfield2"></label>
      <input name="password" type="password" id="textfield2" style="width:132px; font-size:12px; color:#333;"" /></td>
    <td><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></td>
    </tr>
 	</form>
 <tr>
    <td width="132"><a href="password_find.html" class="mav_wz3">忘记密码？ </a><span class="mav_wz1" style="margin-left:2px; margin-right:8px;">|</span><a href="sign_in.html" class="mav_wz2">立即注册</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<?php endif; ?>
</table>

</div>
</div>
<script>
window.onload=function(){
	function nowTime1(ev){
		var Y,M,D,W,H,I,S;
		function fillZero(v){
			if(v<10){v='0'+v;}
			return v;
		}
		(function(){
			var d=new Date();
			Y=fillZero(d.getFullYear());
			M=fillZero(d.getMonth()+1);
			D=fillZero(d.getDate());
			
			H=fillZero(d.getHours());
			I=fillZero(d.getMinutes());
			S=fillZero(d.getSeconds());
			ev.innerHTML= D + '/' + M + '/' + Y + '  '+H+':'+I+':'+S+' (GMT+8)';
			//每秒更新时间
			setTimeout(arguments.callee,1000);
		})();
	}
 nowTime1(document.getElementById('time_chn'));
}
</script> 
<div class="mav_list">
<div class="mav_wz"><a href="index.php" class="mav_wz1">首页</a> | <a href="deposit_process.html" class="mav_wz1">存款流程</a> | <a href="withdrawals_process.html"  class="mav_wz1"> 取款流程</a> | <a href="responsibility.php"  class="mav_wz1">责任博彩</a> | <a href="about_us.html"  class="mav_wz1">关于我们</a></div>
<div class="mav_news"><marquee width=100% scrollamount=2 behavior=scroll direction=left><?php if (count((array)$this->_vars['noticear'])): foreach ((array)$this->_vars['noticear'] as $this->_vars['key'] => $this->_vars['data']): ?><a href="member/notice.php" style=" text-decoration:none;font-size:12px; color:#FEB638;" ><?php echo $this->_vars['data']['l_body']; ?>
</a><?php endforeach; endif; ?></marquee></div>
<div align="center" class="mav_time"><span id="time_chn">loading...</span></div>
</div>

</div>
