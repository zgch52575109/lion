<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>获奖信息</title>
<meta name="keywords" content="<?php echo $this->_vars['cfg_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_vars['cfg_description']; ?>
" />
<link type="text/css" href="css/preferential.css" rel="stylesheet">

</head>

<body>
<?php echo $this->_fetch_compile("top.html"); ?>
   <div class="neirong">
   <div class="preferential_center_left">
   <div class="guidance">
 
   <div class="guidance_center">
   <div class="guidance_center_1" style="margin:0"><a href="preferential.html"><img src="images/preferential_16.gif" name="Image11" border="0" id="Image11" onmouseover="this.src='images/preferential_16b.gif';" onmouseout="this.src='images/preferential_16.gif';"  /></a></div>
   <div class="guidance_center_z"></div>
   <div class="guidance_center_1"><a href="history_preferential.html"><img src="images/preferential_19.gif" name="Image9" border="0" id="Image9"  onmouseover="this.src='images/preferential_19b.gif';" onmouseout="this.src='images/preferential_19.gif';"/></a></div>
   <div class="guidance_center_z"></div>
   <div class="guidance_center_1"><a href="winning_information.html"><img src="images/preferential_21b.gif" name="Image10" border="0" id="Image10" ></a></div>
   
<div class="guidance_center_z"></div>
   <div class="guidance_center_1"><a href="activities.html"><img src="images/preferential_23.gif" name="Image12"  border="0" id="Image12" onmouseover="this.src='images/preferential_23b.gif';" onmouseout="this.src='images/preferential_23.gif';"  /></a></div>
   </div>
 
   </div>
   </div>
   
   
   <div class="preferential_center_right">
   <div class="title" style="background-image:url(images/hjxx.gif)"></div>
   <div class="line_1"></div> 

   <div align="left" class="w_1" style="padding:10px;">
    <span style="color:#FF0; font-size:14px;">获奖信息：</span><br />
<?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <span style="color:#C60; font-size:12px;"><?php echo $this->_vars['data']['i']; ?>
、<?php echo $this->_vars['data']['l_title']; ?>
</span><br>
  <span style="color:#FC0; font-size:14px;"><?php echo $this->_vars['data']['l_body']; ?>
</span>
<?php endforeach; endif; ?>
   </div>
 
   </div>
   </div>
<?php echo $this->_fetch_compile("foot.html"); ?>
</body>

</html>
