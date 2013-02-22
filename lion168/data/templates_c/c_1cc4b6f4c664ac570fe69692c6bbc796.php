<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理管理中心 - 帐目统计</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/agent/memberglobal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="all" href="../js/calendar/calendar-win2k-cold-1.css"/>
<script type="text/javascript" src="../js/calendar/calendar.js"></script>
<script type="text/javascript" src="../js/calendar/calendar-zh.js"></script>
<script type="text/javascript" src="../js/calendar/calendar-setup.js"></script>
<script type="text/javascript">
      //iframe弹出层
        function tanchuceng(width, height, tit, url) {
			//document.getElementById("type_class").style.display = 'none';
			$("#type_class").hide();
            var winWinth = $(window).width(), winHeight = $(document).height();
            $("body").append("<div class='winbj'></div>");
            $("body").append("<div class='tanChu'><div class='tanChutit'><span class='tanchuTxt'>" + tit + "</span><span class='tanchuClose'  onClick='javascript:window.reload()'>关闭</span></div><iframe class='winIframe' frameborder='0' hspace='0' src=" + url + "></iframe></div>");
            $(".winbj").css({ width: winWinth, height: winHeight, background: "#000", position: "absolute", left: "0", top: "0" });
            $(".winbj").fadeTo(0, 0.5);
            var tanchuLeft = $(window).width() / 2 - width / 2;
            var tanchuTop = $(window).height() / 2 - height / 2 + $(window).scrollTop();
            $(".tanChu").css({ width: width, height: height, border: "3px #ccc solid", left: tanchuLeft, top: tanchuTop, background: "#fff", position: "absolute" });
            $(".tanChutit").css({ width: width, height: "25px", "border-bottom": "1px #ccc solid", background: "#eee", "line-height": "25px" });
            $(".tanchuTxt").css({ "text-indent": "5px", "float": "left", "font-size": "14px" });
            $(".tanchuClose").css({ "width": "40px", "float": "right", "font-size": "12px", "color": "#666", "cursor": "pointer" });
            var winIframeHeight = height - 26;
            $(".winIframe").css({ width: width, height: winIframeHeight, "border-bottom": "1px #ccc solid", background: "#ffffff" });
            $(".tanchuClose").hover(
            function() {
       $(this).css("color", "#333");
   }, function() {
       $(this).css("color", "#666");
   }
  );
          $(".tanchuClose").click(function() {

                $(".winbj").remove();
                $(".tanChu").remove();
				//location.reload();
				//document.getElementById("type_class").style.display = 'block';

            });

        }
		</script>
</head>
<body>
<?php echo $this->_fetch_compile("agent/top.html"); ?>  
<div id="maincontent">
 <div id="informscroll">
  <div id="informcontent">
     <?php echo $this->_fetch_compile("agent/inc_notice.html"); ?>  
    <div class="tel"></div>
    </div>
 </div>
 <div id="listcontent">
   <div class="inners">
   <?php echo $this->_fetch_compile("agent/left_menu.html"); ?>  
   <div id="rightcontent">
     <div class="site"><strong>管理中心</strong></div>
     <div class="bodycontent">
<?php echo $this->_fetch_compile("agent/accountinfo.html"); ?>  
     <div class="content">
       <div class="title"><strong>帐目统计</strong></div>
       <div class="tablecontent">
       <div class="table">
       <div class="search">
 <form action="" method="post" id="BasicInformation" name="BasicInformation" onSubmit="">
 注册：<input type="text" name="begin_date" value="<?php echo $this->_vars['begin_date']; ?>
" size="12" class="text" id="begin_date" onclick="return showCalendar('begin_date', 'y-m-d');" />
 至
<input type="text" name="end_date" size="12" value="<?php echo $this->_vars['end_date']; ?>
" class="text" id="end_date" onclick="return showCalendar('end_date', 'y-m-d');" />
<select name="select4" id="select4">
 <option value="1">状态</option>							
 <option value="1">启用</option>
 <option value="0">停用</option>
 <!--<option value="存款">存款</option>
 <option value="冻结">冻结</option>-->
</select>


<select name="select3" id="select3">
							 <?php if (count((array)$this->_vars['datas_mg'])): foreach ((array)$this->_vars['datas_mg'] as $this->_vars['key'] => $this->_vars['data']): ?>
							<option value="<?php echo $this->_vars['data']['groupid']; ?>
"><?php echo $this->_vars['data']['grouptitle']; ?>
</option>
							 <?php endforeach; endif; ?>
 </select>
 <select name="select2" id="select2">							
	 <option value="DESC">降序</option>
	 <option value="ASC">升序</option>
 </select>   
账户:<input name="textfield" type="text" id="textfield" size="10" />                        
 <input type="submit" class="btn" name="button" id="button" value="查询" />
 </form>       
       </div>
        <table cellpadding="0" cellspacing="1">
          <thead>
            <tr>
              <th>序号</th>
              <th>会员账号</th>
              <th>投注额</th>
              <th>开通日期</th>
              <th>利润（元）</th>
              <th>分成比例</th>
              <th>提成（元）</th>
              <th>状态</th>
              <th>活跃度</th>
 
            </tr>
          </thead>
          <tbody>
           <?php if (count((array)$this->_vars['datas_f'])): foreach ((array)$this->_vars['datas_f'] as $this->_vars['key'] => $this->_vars['data']): ?>
             <tr>
              <td><?php echo $this->_vars['data']['i']; ?>
</td>
              <td><a href="javascript:tanchuceng(550,150,'用户详情','member.php?uid=<?php echo $this->_vars['data']['userUid']; ?>
')"><?php echo $this->_vars['data']['userNumber']; ?>
</a></td>
              <td><?php echo $this->_vars['data']['userAllStakedAmount']; ?>
</td>
              <td><?php echo $this->_vars['data']['userJointime']; ?>
</td>
              <td><?php echo $this->_vars['data']['netoKita']; ?>
</td>
              <td><?php echo $this->_vars['data']['fencheng']; ?>
%</td>
              <td><a href="#" title="<?php echo $this->_vars['data']['netoKita']; ?>
 &times; <?php echo $this->_vars['data']['fencheng']; ?>
%"><div style="widows:100%; height:100%"> <?php echo $this->_vars['data']['komisyon']; ?>
</div></a></td>
              <td><?php if ($this->_vars['data']['userStatus']): ?>
                    <strong style="color:#3366FF">启用</strong>
                    <?php endif; ?>
                    <?php if (! $this->_vars['data']['userStatus']): ?>
                    <strong style="color:#FF0000">停用</strong>
                    <?php endif; ?></td>
              <td><?php if ($this->_vars['data']['userActive']): ?>
                    <a title='活跃用户'><img src='images/active.png' width='16' height='16'></a>
                    <?php endif; ?>
                    <?php if (! $this->_vars['data']['userActive']): ?>
                   	<a title='非活跃用户'><img src='images/active2.png' width='16' height='16'></a>
                    <?php endif; ?></td>
   
             </tr>
				  <?php endforeach; endif; ?>
 
          </tbody>
        </table>
        <div class="page">
         <?php echo $this->_vars['TotalResult']; ?>

                    条 每页
                    <?php echo $this->_vars['numPerPage']; ?>

                    条 第
                    <?php echo $this->_vars['page']; ?>

                    /
                    <?php echo $this->_vars['TotalPage']; ?>

                    页 <a href="<?php echo $this->_vars['firstpage']; ?>
">[首页]</a> <a href="<?php echo $this->_vars['perpage']; ?>
">[上一页]</a> <a href="<?php echo $this->_vars['nextpage']; ?>
">[下一页]</a> <a href="<?php echo $this->_vars['lastpage']; ?>
">[尾页]</a>
        
        </div>
       </div>
       </div>
     </div>
     </div>
   </div>
   <div class="clear"></div>
   </div>
 </div>
</div>
<?php echo $this->_fetch_compile("agent/footer.html"); ?>  
</body>
</html>
