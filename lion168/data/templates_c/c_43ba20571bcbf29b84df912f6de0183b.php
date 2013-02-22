<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>最新优惠 - 金狮娱乐</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/index/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
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
     <div class="site"><a href="preferential.html">优惠活动</a><span>&gt;</span>最新优惠</div>
 
<table width="680" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:20px; line-height:20px;">
  <tr>
    <td align="left" valign="middle">
     <p> 活动有效期限：2012年5月1日-2012年6月30日<br />
       30%首次存款优惠活动，最高金额可达88888元，需要滚动15倍。 </p>
    
    </td>
  </tr>
</table>
 
 
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
