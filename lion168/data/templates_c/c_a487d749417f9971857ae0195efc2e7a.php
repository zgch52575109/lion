<div id="header_scroll">
<div id="headercontent">
<div id="header">
 <h1 id="logo"><a href="index.html">金狮娱乐</a></h1>
 <div id="logincontent">
<?php if ($this->_vars['loginuid']): ?> 
 
 <div class="member">
    <div class="name">欢迎&nbsp;<a href="member/datum.php"><?php echo $this->_vars['loginname']; ?>
</a><span>|</span><a class="exit" href="member/logout.php">退出</a></div>
    <!--<div class="rmb">金狮国际 <span style="color:#FFF"><?php echo $this->_vars['groupname']; ?>
</span> 余额 <span>RMB<?php echo $this->_vars['money']; ?>
</span></div>-->
    <div class="link"><a href="member/cash.php">存款</a><span>|</span><a href="member/limit_operation.php">户头转账</a><span>|</span><a href="member/cash_out.php">取款</a><span>|</span><a href="member/info.php">我的账户</a></div>
  </div>
<?php else: ?> 
   <ul class="reg">
     <li class="li1"><a href="sign_in.html">立即注册</a></li>
     <li class="li2"><a href="gotogame.php">免费试玩</a></li>
   </ul>
   <div class="split"></div>
   <ul class="login">
   <form name="loginfo" id="loginfo" method="post" action="login.php?action=login" style="margin: 0px;padding:0;" onKeyDown="jumpToNext();" target="_top">
     <li><input name="username1" class="text" type="text" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/></li>
     <li><input name="password1" class="text psw" type="password" /></li>
     <li><input type="text" name="ValidateCode1" id="ValidateCode1" class="text code" /><img id="vdimgck" src="/include/vdimgck.php" alt="看不清？点击更换" align="absmiddle" style="cursor:pointer" onclick="this.src=this.src+'?'" /></li>
     </form>
   </ul>
   <ul class="btns">
     <li><input type="button" class="loginbtn" onclick="document.loginfo.submit()" /></li>
     <li><a href="password_find.html">忘记密码?</a></li>
   </ul> 
<?php endif; ?> 
 </div>
</div>
<div id="nav_scroll">
<div id="navcontent">
 <ul>
   <li tabindex="0" <?php if ($this->_vars['page_name'] == 'index'): ?> class="current" <?php endif; ?>><a href="index.html">首&nbsp;&nbsp;页</a></li>
   <li tabindex="1" <?php if ($this->_vars['page_name'] == 'real_person'): ?> class="current" <?php endif; ?>><a href="real_person.html">真人娱乐</a></li>
   <li tabindex="2" <?php if ($this->_vars['page_name'] == 'preferential'): ?> class="current" <?php endif; ?>><a href="preferential.html">优惠活动</a></li>
   <li tabindex="3" <?php if ($this->_vars['page_name'] == 'about_us'): ?> class="current" <?php endif; ?>><a href="about_us.html">关于我们</a></li>
   <li tabindex="4" <?php if ($this->_vars['page_name'] == 'agency'): ?> class="current" <?php endif; ?>><a href="agent_joinus.php">合作加盟</a></li>
   <li tabindex="5" ><a href="vip/vip_club.html" target="_blank">VIP CLUB</a></li>
 </ul>
 <div class="gmt" id="time_chn">loading...</div>
 <div class="bg"></div>
</div>
</div>
<div class="header_l"></div>
<div class="header_r"></div>
</div>
</div>