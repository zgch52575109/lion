<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>本地银行转账</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->_fetch_compile("member/top.html"); ?>
<div id="maincontent">
 <div class="title">存款</div>
 <div id="leftcontent">
  <ul>
    <li><a href="deposit_remit.php" class="current">本地银行转账</a></li>
    <li><a href="javascript:tanchuceng(1000,700,'金狮国际娱乐城--在线支付系统','<?php echo $this->_vars['Sponsored_Connectivity']; ?>
?c=pay&a=index&uid=<?php echo $this->_vars['userID']; ?>
&Mer_key=<?php echo $this->_vars['Mer_key']; ?>
&Mer_code=<?php echo $this->_vars['Mer_code']; ?>
&Billno=<?php echo $this->_vars['BillNo']; ?>
&Amount=<?php echo $this->_vars['Mer_Amount_cash']; ?>
')">线上借记卡</a></li>
  </ul>
 </div>
 <div id="rightcontent">
<form action="" method=post id="frmMain" name="frmMain" onSubmit="">
   <ul class="list">
 
     <li>
       <div class="l"><b>银行卡 </b><span>*</span></div>
       <div class="r">       
       <?php if (count((array)$this->_vars['rbankar'])): foreach ((array)$this->_vars['rbankar'] as $this->_vars['key'] => $this->_vars['data']): ?><input type="radio" name="bankid" id="bankid<?php echo $this->_vars['data']['id']; ?>
" value="<?php echo $this->_vars['data']['id']; ?>
"<?php if ($this->_vars['data']['id'] == $this->_vars['bankid']): ?> checked<?php endif; ?> onclick="window.location.href='?bankid=<?php echo $this->_vars['data']['id']; ?>
';" />
      <label for="bankid<?php echo $this->_vars['data']['id']; ?>
"><img src="<?php echo $this->_vars['data']['image']; ?>
" width="124" height="33" /></label>
	<?php if (( $this->_vars['key'] + 1 ) % 3 == 0): ?><br><?php endif;  endforeach; endif; ?>       
       </div>
       <div class="clear"></div>
     </li>
     <li>
       <div class="l"><b>收款人姓名 </b><span>*</span></div>
       <div class="r"><?php echo $this->_vars['rowc']['realname']; ?>
 </div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>银行卡号</b><span>*</span></div>
       <div class="r"><?php echo $this->_vars['rowc']['cardnum']; ?>
</div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>开户网点 </b><span>*</span></div>
       <div class="r"><?php echo $this->_vars['rowc']['bank']; ?>
  </div>
       <div class="clear"></div>
     </li>  
   </ul>
   
   
   <ul class="list">
 
     <li>
       <div class="l"><b>汇款金额 </b><span>*</span><p>存款最低限额<?php echo $this->_vars['mincash']; ?>
元。</p></div>
       <div class="r"><input name="cash" type="text" class="text" id="cash" size="18" /></div>
       <div class="clear"></div>
     </li>
     <li>
       <div class="l"><b>汇款人姓名 </b><span>*</span></div>
       <div class="r"><input name="sender" class="text" type="text" id="sender" size="18" value="<?php echo $this->_vars['truename']; ?>
"<?php if (! $this->_vars['isedit']): ?> readonly<?php endif; ?> /></div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>银行卡后四位</b><span>*</span></div>
       <div class="r"><input name="cardnum" type="text" class="text" id="cardnum" size="18" /></div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>跨行存款 </b><span>*</span></div>
       <div class="r"><input type="checkbox" name="otherbank" id="otherbank" value="1" /></div>
       <div class="clear"></div>
     </li>  
   </ul>   
   
   <dl class="tip">
     <dt>重要提示：</dt>
     <dd>每次存款前，请注意查看我们最新的存款银行账户信息，否则可能会导致您的存款延迟</dd>
   </dl>
   <div class="btns"><div class="btndiv"><input type="hidden" name="action" value="save"><input name="提交" type="submit" class="submit" value="提交" onclick="Check_deposit();" /></div></div>
   </form>
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>
</body>
</html>
<?php echo $this->_fetch_compile("member/ifreme.html"); ?>
<script type="text/javascript">
function Check_deposit(){   /*amark 添加检查存款信息完整性*/
if(document.frmMain.cardnum.value==''){
	window.alert("请输入银行卡号后4位!");
	document.frmMain.cardnum.focus();
	return false;
}
if(document.frmMain.cardnum.value.length!=4){
	window.alert("请正确输入银行卡号后4位!");
	document.frmMain.cardnum.focus();
	return false;
}
if(document.frmMain.cash.value==''){
	window.alert("请输入金额!");
	document.frmMain.cash.focus();
	return false;
}
if(document.frmMain.cash.value<<?php echo $this->_vars['mincash']; ?>
){
	window.alert("存款金额最少为<?php echo $this->_vars['mincash']; ?>
元!");
	document.frmMain.cash.focus();
	return false;
}
if(document.frmMain.cash.value><?php echo $this->_vars['maxcash']; ?>
){
	window.alert("存款金额最大为<?php echo $this->_vars['maxcash']; ?>
元!");
	document.frmMain.cash.focus();
	return false;
}

document.frmMain.submit();
	return true;
}
</script>