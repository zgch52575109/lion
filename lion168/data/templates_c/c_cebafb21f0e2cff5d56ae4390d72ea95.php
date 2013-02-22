<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>账户信息</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">账户信息</div>
 <div id="leftcontent">
  <ul>
    <li><a href="info.php" class="current">账户信息</a></li>
    <li><a href="datum.php">修改信息</a></li>
    <li><a href="password.php">修改密码</a></li>
    <li><a href="bank_bd.php">绑定银行卡</a></li>
  </ul>
 </div>
 <div id="rightcontent">
 <dl class="tip">
     <dt>公告：</dt>
     <dd></dd>
   </dl>
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle" width="50" height="35"><b>用户：</b></td>
    <td align="left" valign="middle"><?php echo $this->_vars['username']; ?>
</td>
    <td align="right" valign="middle" width="150"><strong>今日真人有效：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['todayLiveGameExcludeEvenandTieAmount']; ?>
</td>
  </tr>
  <tr>
    <td height="35" align="left" valign="middle"><strong>级别：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['groupname']; ?>
</td>
    <td align="right" valign="middle"><strong>本周真人有效：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['allweeklivetouzhumoney']; ?>
</td>
  </tr>
  <tr>
    <td height="35" align="left" valign="middle"><strong>积分：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['credits']; ?>
</td>
    <td align="right" valign="middle"><strong>真人视讯投注：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['allLiveGameExcludeEvenandTieAmount']; ?>
</td>
  </tr>
  <tr>
    <td height="35" align="left" valign="middle"><strong>余额：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['money']; ?>
</td>
    <td align="right" valign="middle"><strong>总投注额：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['allStakedAmount']; ?>
</td>
  </tr>
    <tr>
    <td height="35" align="left" valign="middle"><strong>HG：</strong></td>
    <td align="left" valign="middle"><?php echo $this->_vars['tmount']; ?>
</td>
    <td align="right" valign="middle"><strong>IPM：</strong></td>
    <td align="left" valign="middle">即将开放</td>
  </tr>
  <tr>
    <td height="35" colspan="4" align="left" valign="middle"><div class="btns"><div class="btndiv">
    <?php if ($this->_vars['hongli_Status'] == 0): ?>
    <input type="button" onclick="location.href='info.php?action=save'" class="submit" value="申请30%首存">
    <?php else: ?>
    <input type="button" style=" background-image:none; background-color:#666;" class="submit" value="已经领取30%红利">
    <?php endif; ?>
    </div></div></td>
    </tr>
</table>

 
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>

</body>
</html>
