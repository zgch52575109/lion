<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>绑定银行卡</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">绑定银行卡</div>
 <div id="leftcontent">
  <ul>
       <li><a href="info.php">账户信息</a></li>
    <li><a href="datum.php">修改信息</a></li>
    <li><a href="password.php">修改密码</a></li>
    <li><a href="bank_bd.php" class="current">绑定银行卡</a></li>
  </ul>
 </div>
 <div id="rightcontent">
 
 
 <table width="740" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0" style=" color:#000">
  <tr style="background-color:#A50B01;color:White; height:28opx; line-height:28px;">
    <td width="50" align="center" valign="bottom">序号</td>
    <td width="150" align="center" valign="bottom">开户行名称</td>
    <td width="150" align="center" valign="bottom">银行卡号码</td>
    <td width="100" align="center" valign="bottom">持卡人姓名</td>
    <td width="150" align="center" valign="bottom">持卡人身份证</td>
    <?php if ($this->_vars['isedit'] || $this->_vars['isdel']): ?><td ><?php if ($this->_vars['isedit']): ?><a href="?action=edit&id=<?php echo $this->_vars['data']['id']; ?>
">修改</a> <?php endif;  if ($this->_vars['isdel']): ?><a href="?action=del&id=<?php echo $this->_vars['data']['id']; ?>
">删除</a><?php endif; ?></td><?php endif; ?>
  </tr>
  <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <tr>
    <td height="37" align="center"><?php echo $this->_vars['data']['i']; ?>
</td>
    <td height="37" align="center"><?php echo $this->_vars['data']['tname']; ?>
</td>
    <td height="37" align="center"><?php echo $this->_vars['data']['cardnum']; ?>
</td>
    <td height="37" align="center"><?php echo $this->_vars['data']['realname']; ?>
</td>
    <td width="32" height="37" align="center"><?php echo $this->_vars['data']['idnumber']; ?>
</td>
  </tr>
  <?php endforeach; endif; ?>
  <tr>
    <td align="right" <?php if ($this->_vars['isedit'] || $this->_vars['isdel']): ?>colspan="6"<?php else: ?>colspan="5"<?php endif; ?>>共<?php echo $this->_vars['TotalResult']; ?>
条 每页<?php echo $this->_vars['numPerPage']; ?>
条 第<?php echo $this->_vars['page']; ?>
/<?php echo $this->_vars['TotalPage']; ?>
页  <a href="<?php echo $this->_vars['firstpage']; ?>
">[首页]</a> <a href="<?php echo $this->_vars['perpage']; ?>
">[上一页]</a> <a href="<?php echo $this->_vars['nextpage']; ?>
">[下一页]</a> <a href="<?php echo $this->_vars['lastpage']; ?>
">[尾页]</a></td>
    </tr>
</table>

 
 

   <dl class="tip">
     <dt>说明：</dt>
     <dd>银行卡绑定主要用于会员提款使用，一个会员可以绑定多张银行卡。</dd>
     <dd>请注意一旦绑定银行卡，不能修改，删除，请认真核对填写。 </dd>
     <dd>会员提现时请选择需要提现到已绑定的银行卡，并仔细核对。 </dd>
   </dl>
   <div class="btns"><div class="btndiv"><input type="button" onclick="location.href='?action=add'" class="submit" value="添加银行卡"></div></div>

 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>
 
</body>
</html>
