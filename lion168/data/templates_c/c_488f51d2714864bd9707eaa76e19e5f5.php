<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>绑定银行卡</title>
    <meta name="keywords" content="keyword ..." />
    <meta name="Description" content="description ..." />
    <link href="../css/member/global.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="../js/public.js"></script>
   <SCRIPT src="../js/city.js" type=text/javascript></SCRIPT>
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
 <form action ="" method="post" id="frmMain" name="frmMain" onSubmit="">
   <ul class="list">
 
     <li>
       <div class="l"><b>开户银行名称 </b><span>*</span></div>
       <div class="r">
    <select style="width:80" id=sf onchange=changecity('') name=sf> <option value=0>--省份--</option> <option 
    value=北京<?php if ($this->_vars['sf'] == '北京'): ?> selected<?php endif; ?>>北京</option> <option value=天津<?php if ($this->_vars['sf'] == '天津'): ?> selected<?php endif; ?>>天津</option> <option 
    value=上海<?php if ($this->_vars['sf'] == '上海'): ?> selected<?php endif; ?>>上海</option> <option value=重庆<?php if ($this->_vars['sf'] == '重庆'): ?> selected<?php endif; ?>>重庆</option> <option 
    value=江苏省<?php if ($this->_vars['sf'] == '江苏省'): ?> selected<?php endif; ?>>江苏省</option> <option value=广东省<?php if ($this->_vars['sf'] == '广东省'): ?> selected<?php endif; ?>>广东省</option> <option 
    value=浙江省<?php if ($this->_vars['sf'] == '浙江省'): ?> selected<?php endif; ?>>浙江省</option> <option value=福建省<?php if ($this->_vars['sf'] == '福建省'): ?> selected<?php endif; ?>>福建省</option> <option 
    value=湖南省<?php if ($this->_vars['sf'] == '湖南省'): ?> selected<?php endif; ?>>湖南省</option> <option value=湖北省<?php if ($this->_vars['sf'] == '湖北省'): ?> selected<?php endif; ?>>湖北省</option> <option 
    value=山东省<?php if ($this->_vars['sf'] == '山东省'): ?> selected<?php endif; ?>>山东省</option> <option value=辽宁省<?php if ($this->_vars['sf'] == '辽宁省'): ?> selected<?php endif; ?>>辽宁省</option> <option 
    value=吉林省<?php if ($this->_vars['sf'] == '吉林省'): ?> selected<?php endif; ?>>吉林省</option> <option value=云南省<?php if ($this->_vars['sf'] == '云南省'): ?> selected<?php endif; ?>>云南省</option> <option 
    value=四川省<?php if ($this->_vars['sf'] == '四川省'): ?> selected<?php endif; ?>>四川省</option> <option value=安徽省<?php if ($this->_vars['sf'] == '安徽省'): ?> selected<?php endif; ?>>安徽省</option> <option 
    value=江西省<?php if ($this->_vars['sf'] == '江西省'): ?> selected<?php endif; ?>>江西省</option> <option value=黑龙江省<?php if ($this->_vars['sf'] == '黑龙江省'): ?> selected<?php endif; ?>>黑龙江省</option> <option 
    value=河北省<?php if ($this->_vars['sf'] == '河北省'): ?> selected<?php endif; ?>>河北省</option> <option value=陕西省<?php if ($this->_vars['sf'] == '陕西省'): ?> selected<?php endif; ?>>陕西省</option> <option 
    value=海南省<?php if ($this->_vars['sf'] == '海南省'): ?> selected<?php endif; ?>>海南省</option> <option value=河南省<?php if ($this->_vars['sf'] == '河南省'): ?> selected<?php endif; ?>>河南省</option> <option 
    value=山西省<?php if ($this->_vars['sf'] == '山西省'): ?> selected<?php endif; ?>>山西省</option> <option value=内蒙古<?php if ($this->_vars['sf'] == '内蒙古'): ?> selected<?php endif; ?>>内蒙古</option> <option 
    value=广西<?php if ($this->_vars['sf'] == '广西'): ?> selected<?php endif; ?>>广西</option> <option value=贵州省<?php if ($this->_vars['sf'] == '贵州省'): ?> selected<?php endif; ?>>贵州省</option> <option 
    value=宁夏<?php if ($this->_vars['sf'] == '宁夏'): ?> selected<?php endif; ?>>宁夏</option> <option value=青海省<?php if ($this->_vars['sf'] == '青海省'): ?> selected<?php endif; ?>>青海省</option> <option 
    value=新疆<?php if ($this->_vars['sf'] == '新疆'): ?> selected<?php endif; ?>>新疆</option> <option value=西藏<?php if ($this->_vars['sf'] == '西藏'): ?> selected<?php endif; ?>>西藏</option> <option 
    value=甘肃省<?php if ($this->_vars['sf'] == '甘肃省'): ?> selected<?php endif; ?>>甘肃省</option> <option value=台湾省<?php if ($this->_vars['sf'] == '台湾省'): ?> selected<?php endif; ?>>台湾省</option> <option 
    value=香港<?php if ($this->_vars['sf'] == '香港'): ?> selected<?php endif; ?>>香港</option> <option value=澳门<?php if ($this->_vars['sf'] == '澳门'): ?> selected<?php endif; ?>>澳门</option> <option 
    value=国外<?php if ($this->_vars['sf'] == '国外'): ?> selected<?php endif; ?>>国外</option></select> <select id=city name=city style="width:80" > <option value=0>--城市--</option></select>
	<select id=bankid name=bankid style="width:180"> <option value=-1>-- 开户行 --</option>
	<?php if (count((array)$this->_vars['banktype'])): foreach ((array)$this->_vars['banktype'] as $this->_vars['key'] => $this->_vars['data']): ?><option value='<?php echo $this->_vars['data']['tid']; ?>
'<?php if ($this->_vars['data']['tid'] == $this->_vars['bankid']): ?> selected<?php endif; ?>><?php echo $this->_vars['data']['tname']; ?>
（<?php echo $this->_vars['data']['intro']; ?>
）</option><?php endforeach; endif; ?></select>
	<input width="100" id=zhihang maxLength=128 size=15 name=zhihang value="<?php echo $this->_vars['zhihang']; ?>
" /> 
	<span style="color:#000">*支行</span>
   <script>changecity('<?php echo $this->_vars['city']; ?>
');</script>
   </div>
       <div class="clear"></div>
     </li>
     <li>
       <div class="l"><b>新银行卡账号 </b><span>*</span></div>
       <div class="r"><input name="cardnum" type="text" class="text" id="cardnum" value="<?php echo $this->_vars['cardnum']; ?>
" maxlength="32" /></div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>确认新银行卡账号 </b><span>*</span></div>
       <div class="r"><input name="cardnum1" type="text" class="text" id="cardnum1" value="<?php echo $this->_vars['cardnum']; ?>
" maxlength="32" onblur="verify()" /></div>
       <div class="clear"></div>
     </li>     
     <li>
       <div class="l"><b>真实姓名 </b><span>*</span></div>
       <div class="r"><input name="realname" type="text" class="text" id="realname" value="<?php if ($this->_vars['id']):  echo $this->_vars['realname'];  else:  echo $this->_vars['truename'];  endif; ?>" maxlength="18" /></div>
       <div class="clear"></div>
     </li>
     
          <li>
       <div class="l"><b>身份证号 </b><span>*</span><P>(可不填)</P></div>
       <div class="r"><input name="idnumber" type="text" class="text" id="idnumber" value="<?php echo $this->_vars['idnumber']; ?>
" maxlength="18" /></div>
       <div class="clear"></div>
     </li>
       
   </ul>
   <dl class="tip">
     <dt>重要提示：</dt>
     <dd>每次存款前，请注意查看我们最新的存款银行账户信息，否则可能会导致您的存款延迟</dd>
   </dl>
   <div class="btns"><div class="btndiv">
   <input type="hidden" name="id" value="<?php echo $this->_vars['id']; ?>
">
<input type="hidden" name="action" value="save">
<input name="提交" type="submit" class="submit" value="提交"  onclick="check();" /></div></div>
   </form>
 </div>
 <div class="clear"></div>
</div>
<?php echo $this->_fetch_compile("member/footer.html"); ?>
 <script type="text/javascript">
function check(){
var idcardnum = /(^\d{15}$)|(^\d{17}([0-9]|X)$)/;//身份证验证
var matchehtml=/<(.*)>.*<\/\1>|<(.*)\/>/;//验证是否含有HTML标签
var name = /^\S{2,}$/;//真实姓名验证
var bankname = /^[_]*$/;//验证开户行，不能有下划线

//验证有没有选省份
if(document.frmMain.sf.value!=null){
var province = document.frmMain.sf.value;
if(province=="0"){
alert("请选择省份");
return false;
}}

if(document.frmMain.zhihang.value!=null){
if( document.frmMain.zhihang.value==""){
document.frmMain.zhihang.focus();
alert("请填写支行名称！");
return false;
}}

//验证有没有选城市
if(document.frmMain.city.value!=null){
var city = document.frmMain.city.value;
if(city=="0"){
alert("请选择城市");
return false;
}}

var bank = document.frmMain.bankid.value;
if(bank=="" ||bank=="-1"){
	alert("请选择开户行！");
		return false;
}
var bankleaft=document.frmMain.zhihang.value;
if(bankleaft.length>0)
{
  if (matchehtml.exec(bankleaft)) {
	alert("支行不能含有HTML标签！");
	return false;
 }
}
var cardnum = document.frmMain.cardnum.value;
var cardnum1 = document.frmMain.cardnum1.value;
if(cardnum.length<15||cardnum1<15){
alert("银行卡号码格式不对！");
return false;
}
if(cardnum!=cardnum1){
alert("两次输入银行卡号码不一致！");
return false;
}
if (matchehtml.exec(cardnum)) {
	alert("银行卡号不能含有HTML标签！");
	return false;
 }

var realname=document.getElementById("realname").value;
if (realname.length>8) {
		alert("持卡人姓名过长！"+realname);
		return false;
}
if (matchehtml.exec(realname)) {
	alert("持卡人姓名不能含有HTML标签！");
	return false;
 }

/*if(document.frmMain.idnumber.value!=null){*/
var idnumber=document.frmMain.idnumber.value;

if(idnumber!=null && idnumber!=""){
	if (!idcardnum.exec(idnumber)) {
			alert("身份证格式不正确！");
			return false;
	}
}

	document.frmMain.submit();
	return true;
}



function verify(){
	var cardnum = document.frmMain.cardnum.value;
	var cardnum1 = document.frmMain.cardnum1.value;
	if(cardnum!=cardnum1){
		alert("两次输入银行卡号码不一致");
	}
}

</script>
</body>
</html>
