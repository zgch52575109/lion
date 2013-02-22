<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理管理中心 - 提款记录</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/agent/memberglobal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="all" href="../js/calendar/calendar-win2k-cold-1.css"/>
<script type="text/javascript" src="../js/calendar/calendar.js"></script>
<script type="text/javascript" src="../js/calendar/calendar-zh.js"></script>
<script type="text/javascript" src="../js/calendar/calendar-setup.js"></script>
 
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
       <div class="title"><strong>提款记录</strong></div>
       <div class="tablecontent">
       <div class="table">


       
       
       
       
        <table cellpadding="0" cellspacing="1">
          <thead>
            <tr>
              <th>序号</th>
              <th>会员账号</th>
              <th>真实姓名</th>
              <th>金额</th>
              <th>状态</th>
              <th>申请时间</th> 
            </tr>
          </thead>
          <tbody>
           <?php if (count((array)$this->_vars['datas_f'])): foreach ((array)$this->_vars['datas_f'] as $this->_vars['key'] => $this->_vars['data']): ?>
             <tr>
              <td><?php echo $this->_vars['data']['proxyuid']; ?>
</td>
              <td><?php echo $this->_vars['data']['username']; ?>
</td>
              <td><?php echo $this->_vars['data']['truename']; ?>
</td> 
              <td><?php echo $this->_vars['data']['cashmoney']; ?>
</td>
              <td><?php if ($this->_vars['data']['outcash'] == 1): ?>已发放<?php else: ?>等待审核<?php endif; ?></td>
              <td><?php echo $this->_vars['data']['addtime']; ?>
</td>
   
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
