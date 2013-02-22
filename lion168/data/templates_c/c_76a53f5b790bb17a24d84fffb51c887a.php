<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理管理中心 - 银行卡资料 </title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/agent/memberglobal.css" rel="stylesheet" type="text/css" />
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
       <div class="title"><strong>银行卡资料</strong></div>
       <div class="tablecontent">
       <div class="table">
       <div class="search"><input name="增加银行卡" type="button" class="btn"  onclick="location.href='?action=add'" value="增加新卡"/></div>
        <table cellpadding="0" cellspacing="1">
          <thead>
            <tr>
              <th>序号</th>
              <th>开户行名称</th>
              <th>银行卡号码</th>
              <th>持卡人姓名</th>
              <th>持卡人身份证</th>
              <th>操作</th>
            </tr>
          </thead>
                
          <tbody>
            <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
             <tr>
              <td><?php echo $this->_vars['data']['i']; ?>
</td>
              <td><?php echo $this->_vars['data']['tname']; ?>
</td>
              <td><?php echo $this->_vars['data']['cardnum']; ?>
</td>
              <td><?php echo $this->_vars['data']['realname']; ?>
</td>
              <td><?php echo $this->_vars['data']['idnumber']; ?>
</td>
              <td><a href="?action=edit&id=<?php echo $this->_vars['data']['id']; ?>
">修改</a>                 
                      <?php if ($this->_vars['isdel']): ?>
                      <a href="?action=del&id=<?php echo $this->_vars['data']['id']; ?>
">删除</a>
                      <?php endif; ?></td>
             </tr>
                  <?php endforeach; endif; ?> 
 
          </tbody>
        </table>
        <div class="page">
        
        共
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
