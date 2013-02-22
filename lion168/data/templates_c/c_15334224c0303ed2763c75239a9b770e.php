<div class="r2">
<div class="1" style="background-image:url(images/11.png); height:112px; width:142px;padding-top:2px;">
<div class="div"><?php echo $this->_vars['mdnowtime']; ?>
</div>
<div class="div"><?php echo $this->_vars['nowtime']; ?>
</div>
</div>

<div style="border-bottom:#FEB638 solid 1px; padding-bottom:20px; margin-top:17px;"> <a href="notice.html"><img src="images/30.gif" width="144" height="17" /></a></div>
<div>
<marquee scrollAmount="1.5" direction=up width=144 height="150" onmouseover=stop() onmouseout=start()> 
<?php if (count((array)$this->_vars['noticear'])): foreach ((array)$this->_vars['noticear'] as $this->_vars['key'] => $this->_vars['data']): ?>
<a href="notice.php" style=" text-decoration:none;font-size:12px; color:#FEB638;" ><?php echo $this->_vars['data']['l_body']; ?>
</a><br>
<?php endforeach; endif; ?>
</marquee>
</div>
<div style="margin-top:20px;" >
  <a href="../client_download.php"><img src="images/44.png" width="142" height="66" /></a>
</div>
<div style="margin-bottom:4px;*margin-bottom:7px;margin-top:20px;"><a href="http://chat.53kf.com/company.php?arg=lion168&style=1" target="_blank"><img src="images/36.gif" width="144" height="68" /></a></div>
</div>
