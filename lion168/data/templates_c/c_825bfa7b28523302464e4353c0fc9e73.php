<div id="headerscroll">
<div id="header">
  <h1 id="logo"><a href="../" target="_blank">这儿放标题</a></h1>
  <div style=" width:100px;margin-left:50px; padding-top:30px; float:left;">  
  <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="80" height="16">
       <param name="movie" value="images/game.swf" />
       <param name="quality" value="high" />
       <param name="wmode" value="opaque" />
       <param name="swfversion" value="8.0.35.0" />
       <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
       <param name="expressinstall" value="Scripts/expressInstall.swf" />
       <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
       <!--[if !IE]>-->
       <object type="application/x-shockwave-flash" data="images/game.swf" width="80" height="16">
         <!--<![endif]-->
         <param name="quality" value="high" />
         <param name="wmode" value="opaque" />
         <param name="swfversion" value="8.0.35.0" />
         <param name="expressinstall" value="Scripts/expressInstall.swf" />
         <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
         <div>
           <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
           <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
         </div>
         <!--[if !IE]>-->
       </object>
       <!--<![endif]-->
     </object>
  </div>
  <div class="member">
    <div class="name">欢迎&nbsp;<a href="datum.php"><?php echo $this->_vars['username']; ?>
</a><span>|</span><a class="exit" href="logout.php">退出</a></div>
    <div class="rmb">金狮国际 <span style="color:#FFF"><?php echo $this->_vars['groupname']; ?>
</span> 余额 <span>RMB<?php echo $this->_vars['money']; ?>
</span></div>
    <div class="link"><a href="cash.php">存款</a><span>|</span><a href="limit_operation.php">户头转账</a><span>|</span><a href="cash_out.php">取款</a><span>|</span><a href="info.php">我的账户</a></div>
  </div>
</div>
<div id="navcontent">
  <div style="float:left; padding-left:20px;" ><a href="../">首页</a><span style="padding:0px 5px; color:#FFF"> | </span> <span  id="time_chn" style="padding:0px 5px; color:#FFF">loading</span>   </div> 

  <ul>
    <li><a href="contactus.php">联络我们</a></li><li>|</li>
    <li><a href='http://chat.53kf.com/company.php?arg=lion168&style=1' target="_blank">在线咨询</a></li><li>|</li>
    <li><a href="#">简体中文</a></li>
  </ul>
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
