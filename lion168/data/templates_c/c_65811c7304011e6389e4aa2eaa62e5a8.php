<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>转账记录</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
 
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">转账记录</div>
 <div id="leftcontent">
  <ul>
    <li><a href="limit_operation.php">户头转账</a></li>
    <li><a href="limit_operation_list.php" class="current">转账记录</a></li>
    <li><a href="cash_system.php">存取款记录</a></li>
  </ul>
 </div>
 <div id="rightcontent">
 
 <table width="740" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0" style=" color:#000">
  <tr style="background-color:#A50B01;color:White; height:28opx; line-height:28px;">
<!--    <td width="60" align="center" valign="bottom">姓名</td>-->
    <td width="50" align="center" valign="bottom">账号</td>
    <td width="100" align="center" valign="bottom">游戏</td>
    <td width="80" align="center" valign="bottom">转前资金</td>
   <!-- <td width="80" align="center" valign="bottom">转前额度</td>-->
    <td width="80" align="center" valign="bottom">转入额度</td>
    <td width="80" align="center" valign="bottom">转出额度</td>
    <td width="" align="center" valign="bottom">日期</td>
    <td width="100" align="center" valign="bottom">明细</td>
     <td width="50" align="center" valign="bottom">备注</td>
  </tr>
  <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <tr>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['username']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php if ($this->_vars['data']['zhuanhuanly'] == '本站账户'): ?> 主->HG <?php else: ?> 主<-HG <?php endif; ?></td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['zqcash']; ?>
</td>
  <!--  <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['zqedu']; ?>
</td>-->
    <td height="35" align="center" valign="middle" ><?php if ($this->_vars['data']['type'] == '1'):  echo $this->_vars['data']['cash'];  else: ?>0<?php endif; ?></td>
    <td height="35" align="center" valign="middle" ><?php if ($this->_vars['data']['type'] == '2'):  echo $this->_vars['data']['cash'];  else: ?>0<?php endif; ?></td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['addtime']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['mingxi']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['note']; ?>
</td>
  </tr>
  <?php endforeach; endif; ?>
  <tr>
    <td height="50" colspan="8" align="right" valign="middle">共<?php echo $this->_vars['TotalResult']; ?>
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

 
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>
<script type="text/javascript">
function search_submit(){
	document.searchform.submit();
	return true;
}
</script> 
</body>
</html>
