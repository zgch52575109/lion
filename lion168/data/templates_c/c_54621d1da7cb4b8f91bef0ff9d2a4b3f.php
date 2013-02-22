<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_vars['webname']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_vars['cfg_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_vars['cfg_description']; ?>
" />
<link type="text/css" href="css/style.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="css/index.css" >
<link rel="stylesheet" type="text/css" href="css/focus/jquery.slider.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="css/focus/jquery.slider.ie6.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.slider.min.js"></script>
</head>

<body>
<?php echo $this->_fetch_compile("top.html"); ?>
<div class="content">
<div class="content_left">
<div class="banner">
<!--焦点图-->
<div class="slider">
 <div id="focus_1"><a href="preferential.html#yh_1" target="_blank"><img src="images/focus/index.gif" alt=""  width="747" border="0" height="268" /></a></div> 
 <div id="focus_2" style="display:none;">><a href="http://www.jinshi168.org/model/lion168.html" target="_blank"><img src="images/focus/index_new_30.gif" alt=""  width="747" border="0" height="268" /></a></div> 
 <div id="focus_3" style="display:none;"><a href="preferential.html#yh_2" target="_blank"><img src="images/focus/1.gif" alt=""  width="747" border="0" height="268" /></a></div> 
 <div id="focus_4" style="display:none;"><a href="agency.html" target="_blank"><img src="images/focus/2.gif" alt=""  width="747" border="0" height="268" /></a></div> 
 <div id="focus_5" style="display:none;"><a href="preferential.html#yh_3" target="_blank"><img src="images/focus/3.gif" alt=""  width="747" border="0" height="268" /></a></div> 
</div>
<!--焦点图-->
</div>
<div class="container">
<div class="sidebar"><a href="real_person.html"><img src="images/index_new_41.gif" name="Image2" width="242" height="251" border="0" id="Image2"  onmouseover="this.src='images/index_new_41b.gif';" onmouseout="this.src='images/index_new_41.gif';" /></a></div>
<div class="sidebar"><a href="real_person.html"><img src="images/index_new_43.gif" name="Image3" width="242" height="251" border="0" id="Image3"  onmouseover="this.src='images/index_new_43b.gif';" onmouseout="this.src='images/index_new_43.gif';" /></a></div>
<div class="sidebar2"><a href="real_person.html"><img src="images/index_new_45.gif" name="Image4" width="242" height="251" border="0" id="Image4"   onmouseover="this.src='images/index_new_45b.gif';" onmouseout="this.src='images/index_new_45.gif';" /></a></div>
</div>
</div>
<div class="content_right">
<div class="mav_bottom2" style="margin-bottom:5px; margin-top:5px;"><a href="sign_in.html" ><img src="images/index_new_33a.gif" name="Image5" width="245" height="54" border="0" id="Image5"   onmouseover="this.src='images/index_new_33b.gif';" onmouseout="this.src='images/index_new_33a.gif';" /></a></div>
<div class="mav_bottom2" style="margin-bottom:5px; margin-top:0px"><a target="_blank" href="gotogame.php"><img src="images/index_new_35a.gif" name="Image6" width="245" height="54" border="0" id="Image6"  onmouseover="this.src='images/index_new_35b.gif';" onmouseout="this.src='images/index_new_35a.gif';" /></a></div>

<div class="mav_yh" style="height:35px;"><img src="images/index_new_v02_49.gif" width="245" height="33" border="0" /></div>
<div class="mav_yh"><a href="preferential.html#yh_1"><img src="images/index_new_37.gif" width="245" height="84" border="0" /></a></div>
<div class="mav_yh"><a href="preferential.html#yh_2"><img src="images/index_new_39.gif" width="245" height="84" border="0" /></a></div>
<div class="mav_yh"><a href="preferential.html#yh_4"><img src="images/index_new_49.gif" width="245" height="84" border="0" /></a></div>
<div class="mav_yh"><a href="preferential.html#yh_3"><img src="images/index_new_51.gif" width="245" height="84" border="0" /></a></div>
</div>
</div>
<?php echo $this->_fetch_compile("foot.html"); ?>

  <script type="text/javascript">
    jQuery(document).ready(
	function($) 
	{
	  $("#focus_2").show(); $("#focus_3").show(); $("#focus_4").show();  $("#focus_5").show(); 
      $(".slider").slideshow({
        width      : 747,
        height     : 268,
        transition : ['barLeft', 'barRight']
      });
    });
  </script>
</body>
</html>
