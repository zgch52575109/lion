<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>取款</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <!--<link href="favicon.ico" rel="shortcut icon" />-->
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>

<div id="maincontent">
 <div class="title">取款</div>
 <div id="leftcontent">
  <ul> 
    <li><a href="withdrawals.php" class="current">立即取款</a></li>
  </ul>
 </div>
 <div id="rightcontent">
 <form action="" method=post id="frmMain" name="frmMain">
   <ul class="list">
    <li>
       <div class="l"><b>您的资金余额 </b></div>
       <div class="r"><?php echo $this->_vars['money']; ?>
元</div>
       <div class="clear"></div>
     </li>
   
 
     
     <li>
       <div class="l"><b>请选择银行卡</b><span>*</span><p>(选择取款银行卡)</p></div>
       <div class="r">
       <select name="bankid" id="bankid" class="select" onchange="window.location.href=('?bankid='+this.options[this.selectedIndex].value);">
	  <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
        <option value="<?php echo $this->_vars['data']['id']; ?>
"<?php if ($this->_vars['data']['id'] == $this->_vars['bankid']): ?> selected<?php endif; ?>><?php echo $this->_vars['data']['tname']; ?>
(<?php echo $this->_vars['data']['intro']; ?>
)</option>
		<?php endforeach; endif; ?>
      </select>
       </div>
       <div class="clear"></div>
     </li>

     <li>
       <div class="l"><b>持卡人 </b></div>
       <div class="r"><?php echo $this->_vars['rowc']['realname']; ?>
</div>
       <div class="clear"></div>
     </li>
     
     <li>
       <div class="l"><b>省份 </b></div>
       <div class="r"><?php echo $this->_vars['rowc']['sf']; ?>
</div>
       <div class="clear"></div>
     </li>
     
     <li>
       <div class="l"><b>城市 </b></div>
       <div class="r"><?php echo $this->_vars['rowc']['city']; ?>
</div>
       <div class="clear"></div>
     </li>
     
     <li>
       <div class="l"><b>开户行 </b></div>
       <div class="r"><?php echo $this->_vars['rowc']['tname']; ?>
 <?php echo $this->_vars['rowc']['zhihang']; ?>
</div>
       <div class="clear"></div>
     </li>
     <li>
       <div class="l"><b>银行卡号 </b></div>
       <div class="r"><?php echo $this->_vars['rowc']['cardnum']; ?>
</div>
       <div class="clear"></div>
     </li>  
     
     
     
     
     
     
     
     <li>
       <div class="l"><b>提款金额 </b><span>*</span><p>(单笔不得低于<?php echo $this->_vars['mincash']; ?>
元)</p></div>
       <div class="r"><input name="cash" type="text" class="text" id="cash" maxlength="12" onkeyup="clearNoNum(this)" /></div>
       <div class="clear"></div>
     </li>
 
   </ul>
   <dl class="tip">
     <dt>重要提示：</dt>
     <dd>单日取款限<?php echo $this->_vars['dayoutcashnum']; ?>
次。</dd>
     <dd>取款时间间隔小于24小时，扣除手续费3元。</dd>     
   </dl>
   <div class="btns"><div class="btndiv"><input type="hidden" name="action" value="save"><input type="button" class="submit" value="确  认" onclick="WithDrawal()" /></div></div>
   </form>
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>

<script language="javascript">
function WithDrawal()
{
	var value=document.frmMain.cash.value;
	var reg=/[^\d]/;
	var reg1=/^\d+(\.\d+)?$/;
	if(document.frmMain.cash.value=='')
	{
		alert("请填写提款金额");
		document.frmMain.cash.focus();
		return;
	}
	else if(isNaN(value))
	{
		alert("提款金额必须为数字");
		document.frmMain.cash.focus();
		return;
	}
	else if(reg1.test(value)==false)
	{
		alert("提款金额必须为数字");
		document.frmMain.cash.focus();
		return;
	}
	else if(value<<?php echo $this->_vars['mincash']; ?>
||value><?php echo $this->_vars['maxcash']; ?>
)
	{
		alert("提款金额不得小于<?php echo $this->_vars['mincash']; ?>
元或大于<?php echo $this->_vars['maxcash']; ?>
");
		document.frmMain.cash.focus();
		return;
	}
	else if(value><?php echo $this->_vars['money']; ?>
)
	{
		alert("提款金额不得大于账户余额");
		document.frmMain.cash.focus();
		return;
	}
	else
	{
		var len=value.split(".").length;
		if(len==2)
		{
			if(value.split(".")[1].length>2)
			{
				alert("提款金额填写错误，最多支持小数点后2位");
				document.frmMain.cash.focus();
				return;
			}
		}
	}
	document.frmMain.submit();
}
function clearNoNum(obj)
{
	//先把非数字的都替换掉，除了数字和.
	obj.value = obj.value.replace(/[^\d.]/g,"");
	//必须保证第一个为数字而不是.
	obj.value = obj.value.replace(/^\./g,"");
	//保证只有出现一个.而没有多个.
	obj.value = obj.value.replace(/\.{2,}/g,".");
	//保证.只出现一次，而不能出现两次以上
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}
</script>

</body>
</html>
