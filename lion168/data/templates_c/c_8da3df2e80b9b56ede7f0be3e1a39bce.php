<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <title>代理管理中心 - 基本资料</title>
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
       <div class="title"><strong>基本资料</strong></div>
       <ul class="tablelist">
  <form action="" method="post" id="BasicInformation" name="BasicInformation" onSubmit="">
         <li><label>用户名：</label><input type="text" value="<?php echo $this->_vars['username']; ?>
" disabled="disabled" class="text" /></li>
         <li><label>电子邮箱：</label><input name="textfield2" type="text" class="text" value="<?php echo $this->_vars['email_dl']; ?>
" maxlength="50" /></li>         
         <li><label>QQ号码：</label><input name="textfield3" type="text" class="text" id="textfield3" value="<?php echo $this->_vars['qq_dl']; ?>
" maxlength="15" /></li>
         <li><label>手机号码：</label><input name="textfield4" type="text" class="text long" id="textfield4" value="<?php echo $this->_vars['phone_dl']; ?>
" maxlength="12" /></li>
          <input type="hidden" name="action" value="save"> 
         <li class="btnli"><input type="button" class="btn" name="button" id="button" value="确定" onclick="Check_Reg()" /> <input type="button" class="btn" value="取消" />
           
         </li>
    </form>
       </ul>
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

<script type="text/javascript">
function Save_Basic_form(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	iQQNumber= "^-?\d+$";
	iEmil= "^[a-z A-Z 0-9 _]+@[a-z A-Z 0-9 _]+(\.[a-z A-Z 0-9 _]+)+(\,[a-z A-Z 0-9 _]+@[a-z A-Z 0-9 _]+(\.[a-z A-Z 0-9 _]+)+)*$";
	iEmill="^(?://w+//.?)*//w+@(?://w+//.?)*//w+$";
	iChins="[\u4e00-\u9fa5]";
	
	if (Check_Emil(document.BasicInformation.textfield2,'Emil地址',9,38,iEmil) != true){
		return false;
	}	
	if (Check_Input(document.BasicInformation.textfield3,'QQ号码',4,12,iQQNumber) != true){
		return false;
	}
	if (Check_Input(document.BasicInformation.textfield4,'手机号码',7,11,iQQNumber) != true){
		return false;
	}
	document.BasicInformation.submit();
	return true;
/*	
	alert("运行完成！");
	document.BasicInformation.submit();
	return true;*/
}

function Check_Emil(inputName,strInputTitle,intMin,intMax,iChars){
	var strValue = inputName.value;
	if(strValue==''){
		window.alert("请输入"+strInputTitle+"！");
		inputName.style.backgroundColor="#FFECFF";
		inputName.focus();
		return false;
	}
	
	 if(strValue.search(iChars)!=0){
		alert(strInputTitle+"格式不正确，请重新输入！");
		inputName.focus();
		return false;
		}
	
	
	if ((strValue.length < intMin)||(strValue.length > intMax)){
        //window.alert(strInputTitle+"长度不符合要求，长度必须在"+intMin+"到"+intMax+"之间！");
		alert(strInputTitle+"格式不正确，请重新输入！");
		inputName.focus();
		return false; 
	}
	return true;
}
</script>