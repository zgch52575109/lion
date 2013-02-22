<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>金狮国际 - 金狮国际娱乐城官方网站多款真人真钱游戏</title>
    <meta name="keywords" content="金狮,金狮国际,金狮国际娱乐,金狮国际官网,金狮国际娱乐城" />
    <meta name="description" content="金狮国际娱乐城官方网站提供多款真人真钱博彩游戏 - 信誉，安全，服务并具的线上娱乐平台。金狮国际提供24小时随时兑换，方便，快捷，并让您享受意料之外的游戏体验。" />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/index/global.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../css/focus/jquery.slider.css" />
    <!--[if IE 6]>
     <link rel="stylesheet" type="text/css" href="../css/focus/jquery.slider.ie6.css" />
    <![endif]-->
</head>
<body>
<?php echo $this->_fetch_compile("index/top.html"); ?>  
<div id="main_scroll">
<div id="indexbanner">
<div class="slider">
  <div id="f1">
    <div class="caption">
      <!--<h4>First Slide</h4>-->
    </div>
    <a href="preferential_first.php" target="_blank"><img src="images/focus/1.jpg" alt=""/></a>
  </div>
  <div id="f2" style="display:none;">
    <div class="caption">
     <!-- <h4>Second Slide</h4>-->
    </div>
    <a href="preferential_fs.php" target="_blank"><img src="images/focus/2.jpg" alt=""/></a>
  </div>
  <div id="f3" style="display:none;">
    <div class="caption">
      <!--<h4>Third Slide</h4>-->
    </div>
    <a href="preferential_friend.php" target="_blank"><img src="images/focus/3.jpg" alt=""/></a>
  </div>
  <div  id="f4" style="display:none;">
    <div class="caption">
      <!--<h4>Fourth Slide</h4>-->
    </div>
    <a href="activities_lc.php" target="_blank"><img src="images/focus/4.jpg" alt=""/></a>
  </div>
  <div id="f5" style="display:none;">
    <div class="caption">
      <!--<h4>Fourth Slide</h4>-->
    </div>
    <a href="activities_sm.php" target="_blank"><img src="images/focus/5.jpg" alt=""/></a>
  </div>
</div>
</div>
<div id="informcontent">
<?php echo $this->_fetch_compile("index/inc_notice.html"); ?> 
<div class="tel"></div>
</div>
<div id="helpmenu">
   <ul>
     <li class="li1"><a href="open.php">如何开户</a></li>
     <li class="li2"><a href="deposit_process.html">如何存款</a></li>
     <li class="li3"><a href="withdrawals_process.html">如何取款</a></li>
     <li class="li4"><a href="vip/vip_club.html" target="_blank">VIP俱乐部</a></li>
   </ul>
  </div>
<div id="projectlist">
  <ul>
    <li><div class="img"><a href="#"><img src="images/index/img01.jpg" alt="" title="" /></a></div><div class="pic"><img src="images/index/pic01.jpg" alt="" title="" /></div><div class="link"><a href="#">进入游戏</a></div></li>
    <li><div class="img"><a href="#"><img src="images/index/img02.jpg" alt="" title="" /></a></div><div class="pic"><img src="images/index/pic02.jpg" alt="" title="" /></div><div class="link"><a href="#">进入游戏</a></div></li>
    <li><div class="img"><a href="#"><img src="images/index/img03.jpg" alt="" title="" /></a></div><div class="pic"><img src="images/index/pic03.jpg" alt="" title="" /></div><div class="link"><a href="#">进入游戏</a></div></li>
    <li><div class="img"><a href="#"><img src="images/index/img04.jpg" alt="" title="" /></a></div><div class="pic"><img src="images/index/pic04.jpg" alt="" title="" /></div><div class="link" style="background-image:url(images/index/joinus.jpg)"><a href="agent_joinus.php"><img src="images/index/joinus.jpg" border="0" /></a></div></li>
  </ul>
</div>
</div>
<?php echo $this->_fetch_compile("index/footer.html"); ?> 

<script type="text/javascript" src="js/index/jquery.slider.min.js"></script>
<script language="javascript">
$(document).ready(
function()
{ 
   $("#f2").show(); $("#f3").show(); $("#f4").show();  $("#f5").show(); 

  $(".slider").slideshow({
    width      : 980,
    height     : 329,
    pauseOnHover : false,
    transition : ['slideLeft', 'slideRight', 'slideTop', 'slideBottom']
  });
  $(".slider").bind("sliderTransitionFinishes", function(event, curSlide) {
  });
}
);
</script>
</body>
</html>
