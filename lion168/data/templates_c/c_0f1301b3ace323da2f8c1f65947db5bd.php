<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>存取款记录</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="all" href="../js/calendar/calendar-win2k-cold-1.css"/>  
<script type="text/javascript" src="../js/calendar/calendar.js"></script>  
<script type="text/javascript" src="../js/calendar/calendar-zh.js"></script>
<script type="text/javascript" src="../js/calendar/calendar-setup.js"></script>
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">存取款记录</div>
 <div id="leftcontent">
  <ul>
    <li><a href="limit_operation.php">户头转账</a></li>
    <li><a href="limit_operation_list.php">转账记录</a></li>
    <li><a href="cash_system.php" class="current">存取款记录</a></li>
  </ul>
 </div>
 <div id="rightcontent">
 <form action="" method="get" id="searchform" name="searchform">
 <table width="740" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#F0F0F0" style=" color:#000 ; margin-bottom:30px; height:30px;">
   <tr>
   <td>日期：</td>
   <td>
   <input type="text" name="begin_date" value="<?php echo $this->_vars['begin_date']; ?>
" size="12"  style="line-height:12px; height:12px;" id="begin_date" onclick="return showCalendar('begin_date', 'y-m-d');" />
   至
   <input type="text" name="end_date" size="12" value="<?php echo $this->_vars['end_date']; ?>
" style="line-height:12px; height:12px;" id="end_date" onclick="return showCalendar('end_date', 'y-m-d');" /></td>
   <td>  
   <label><input type="checkbox" name="state[]" value="1" id="state1"<?php if (in_array ( 1 , $this->_vars['state'] )): ?> checked<?php endif; ?> />处理</label>
   <label><input type="checkbox" name="state[]" value="3" id="state2"<?php if (in_array ( 3 , $this->_vars['state'] )): ?> checked<?php endif; ?> />拒绝</label>
   <label><input type="checkbox" name="state[]" value="4" id="state4"<?php if (in_array ( 4 , $this->_vars['state'] )): ?> checked<?php endif; ?> />审核</label>
   <label><input type="checkbox" name="state[]" value="2" id="state3"<?php if (in_array ( 2 , $this->_vars['state'] )): ?> checked<?php endif; ?> />完成</label>
   </td>
   <td><input type="button" class="submit" value="查询" onclick="search_submit();" /></td>
    </tr>
 </table>
 </form>
 <table width="740" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0" style=" color:#000">
  <tr style="background-color:#A50B01;color:White; height:28opx; line-height:28px;">
    <td width="60" align="center" valign="bottom">会员名称</td>
    <td width="60" align="center" valign="bottom">会员帐号</td>
    <td width="40" align="center" valign="bottom">类型</td>
    <td width="40" align="center" valign="bottom">手续费</td>
    <td width="50" align="center" valign="bottom">现金红利</td>
    <td width="60" align="center" valign="bottom">存取款</td>
    <td width="100" align="center" valign="bottom">出款平台</td>
    <td width="60" align="center" valign="bottom">账户调整</td>
    <td width="80" align="center" valign="bottom">出入款状况</td>
    <td width="150" align="center" valign="bottom">出入款日期</td>
    <td width="" align="center" valign="bottom">备注</td>
  </tr>
  <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <tr>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['truename']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['username']; ?>
</td>
	<td height="35" align="center" valign="middle" ><?php if ($this->_vars['data']['type'] == 1): ?>存款<?php elseif ($this->_vars['data']['type'] == 2): ?>取款<?php elseif ($this->_vars['data']['type'] == 5): ?>首存红利<?php elseif ($this->_vars['data']['type'] == 11): ?>反水奖励<?php endif; ?></td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['shouxufei']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['hongli']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['cash']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php if ($this->_vars['data']['ctype'] == '1'):  echo $this->_vars['data']['bank']; ?>
<br><?php echo $this->_vars['data']['realname']; ?>
,<?php echo $this->_vars['data']['cardnum'];  if ($this->_vars['data']['otherbank'] == '1'): ?>,<font color="red">跨行</font><?php endif;  else:  echo $this->_vars['data']['bank'];  endif; ?></td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['czhengfu']; ?>
</td>
    <td height="35" align="center" valign="middle"><strong><?php if ($this->_vars['data']['state'] == '1'): ?>处理中<?php elseif ($this->_vars['data']['state'] == '2'): ?>完成<?php elseif ($this->_vars['data']['state'] == '3'): ?>拒绝<?php elseif ($this->_vars['data']['state'] == '4'): ?>审核<?php endif; ?></strong></td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['addtime']; ?>
</td>
    <td height="35" align="center" valign="middle" ><?php echo $this->_vars['data']['operationxuanxiang']; ?>
</td>
  </tr>
  <?php endforeach; endif; ?>
  <tr>
    <td height="50" colspan="11" align="right" valign="middle">共<?php echo $this->_vars['TotalResult']; ?>
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
