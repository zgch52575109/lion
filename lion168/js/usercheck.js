function CheckAll() {
	for (var i=0;i<document.all.products.elements.length;i++){
		document.all.products.elements[i].checked = true;
	}
}

function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
  }

function check1(){
	var t=0;
	for (var i=1;i<document.all.products.elements.length;i++){
		t=t+document.all.products.elements[i].checked;
	}
	if (t==false){
		alert("请至少填选择一个！");
		return false;
	}
	document.products.submit;
	return true;
}

function englishCheck(name1){
	var s,i;
	s = name1.value;    //不需要指定textname所在的form名称
	for (i=0;i<s.length;i++){
		if (s.charCodeAt(i)>127||s.charCodeAt(i)<0||s.charCodeAt(i)==39){
			//文本框中的内容，可以输入英文字符，数字，标点符号，同时一些特殊的字符，比如回车等，也可以输，ascill码都包括
			alert("请输入英文!");
			name1.value=name1.value.replace(/[^\d a-z A-Z \- ]/g,'');
			name1.focus();
			break;
		}
	}
}


//用户登陆
function Check_Login(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(document.frmLogin.username,'用户名',3,20,iChars) != true){
		return false;
	}

	iChars = "";
	if (Check_Input(document.frmLogin.password,'密码',6,20,iChars) != true){
		return false;
	}
	if(document.frmLogin.ValidateCode.value==''){
		window.alert("请输入验证码!");
		document.frmLogin.ValidateCode.focus();
		return false;
	}
	document.frmLogin.submit();
	
	return true;
}

//用户注册
function Check_Reg(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(document.frmMain.UserName,'账号',5,20,iChars) != true){
		return false;
	}

	if (Check_Input(document.frmMain.rePassword,'密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(document.frmMain.Password,'重复密码',6,20,iChars) != true){
		return false;
	}



	if (document.frmMain.rePassword.value != document.frmMain.Password.value){
		alert("两次密码输入不一致");
		document.frmMain.Password.focus();
		return false;
	}

	if(document.frmMain.TrueName.value==''){
		window.alert("请输入真实姓名!");
		document.frmMain.TrueName.focus();
		return false;
	}

	if(document.frmMain.userTel.value==''){
		window.alert("请输入电话!");
		document.frmMain.userTel.focus();
		return false;
	}

	if(!isEmail(document.frmMain.email.value)) {
		alert("电子邮件格式不正确!"); 
		document.frmMain.Email.focus(); 
		return false;
	}

	//if(document.frmMain.Year.value=='' || document.frmMain.Month.value=='' || document.frmMain.Day.value==''){
	///	window.alert("请选择出生日期");
	//	return false;
	//}

	if(document.frmMain.ValidateCode.value==''){
		window.alert("请输入验证码!");
		document.frmMain.ValidateCode.focus();
		return false;
	}

	
	document.frmMain.submit();
	return true;
	
}

function Check_modify(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if(frmMain.oldpwd.value!='' || frmMain.rePassword.value!='' || frmMain.Password.value!=''){
		if (Check_Input(frmMain.oldpwd,'旧密码',6,20,iChars) != true){
			return false;
		}

		if (Check_Input(frmMain.rePassword,'密码',6,20,iChars) != true){
			return false;
		}

		if (Check_Input(frmMain.Password,'重复密码',6,20,iChars) != true){
			return false;
		}

		if (frmMain.rePassword.value != frmMain.Password.value){
			alert("两次密码输入不一致");
			frmMain.Password.focus();
			return false;
		}
	}

	if(frmMain.truename.value==''){
		window.alert("请输入真实姓名!");
		frmMain.truename.focus();
		return false;
	}

	if(frmMain.phone.value==''){
		window.alert("请输入电话!");
		frmMain.phone.focus();
		return false;
	}

	if(!isEmail(frmMain.email.value)) {
		alert("电子邮件格式不正确!"); 
		frmMain.email.focus(); 
		return false;
	}

	if(frmMain.Year.value=='' || frmMain.Month.value=='' || frmMain.Day.value==''){
		window.alert("请选择出生日期");
		return false;
	}

	if(frmMain.safequestion.value=='' && frmMain.safeanswer.value!=''){
		alert("请选择安全问题!"); 
		frmMain.safequestion.focus(); 
		return false;
	}

	if(frmMain.safequestion.value!='' && frmMain.safeanswer.value==''){
		alert("请填写问题答案!"); 
		frmMain.safeanswer.focus(); 
		return false;
	}

	frmMain.submit();
	return true;
}


//修改密码
function Check_ChgPassWord(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(frmMain.UserName,'用户名',4,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.rePassword,'密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.Password,'重复密码',6,20,iChars) != true){
		return false;
	}

	if (frmMain.rePassword.value != frmMain.Password.value){
		alert("两次密码输入不一致");
		frmMain.Password.focus();
		return false;
	}

if(frmMain.TrueName.value==''){
		window.alert("请输入用户名称!");
		frmMain.TrueName.focus();
		return false;
	}


   frmMain.submit();
	return true;
}


//用户注册
function Check_try(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(frmMain.PostID,'账号',4,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.rePassword,'密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.Password,'重复密码',6,20,iChars) != true){
		return false;
	}
	iChars= "/^\d*$/";


	if (frmMain.rePassword.value != frmMain.Password.value){
		alert("两次密码输入不一致");
		frmMain.Password.focus();
		return false;
	}


	if(!isEmail(frmMain.email.value)) {
		alert("电子邮件格式不正确!"); 
		frmMain.Email.focus(); 
		return false;
	}

	
	frmMain.submit();
	return true;

}



//修改密码
function Check_ChgPassWord(){
	var iChars;

	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(frmMain.UserName,'用户名',4,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.rePassword,'密码',6,20,iChars) != true){
		return false;
	}

	if (Check_Input(frmMain.Password,'重复密码',6,20,iChars) != true){
		return false;
	}

	if (frmMain.rePassword.value != frmMain.Password.value){
		alert("两次密码输入不一致");
		frmMain.Password.focus();
		return false;
	}

if(frmMain.TrueName.value==''){
		window.alert("请输入用户名称!");
		frmMain.TrueName.focus();
		return false;
	}


   frmMain.submit();
	return true;
}

//提交存款
function Check_cash(){


if(frmMain.BankName.value==''){
		window.alert("您的银行账户信息不完整，请先补充信息！");
		location.href='UsersChange.html';
		return false;
	}

if(frmMain.BankID.value==''){
		window.alert("您的银行账户信息不完整，请先补充信息！");
		location.href='UsersChange.html';
		return false;
	}
	
if(frmMain.cash.value==''){
		window.alert("请输入金额!");
		frmMain.cash.focus();
		return false;
	}


frmMain.submit();
	return true;
}

function Check_deposit(){   /*amark 添加检查存款信息完整性*/

/*
if(frmMain.BankName.value==''){
		window.alert("您的银行账户信息不完整，请先补充信息！");
		location.href='UsersChange.html';
		return false;
	}

if(frmMain.BankID.value==''){
		window.alert("您的银行账户信息不完整，请先补充信息！");
		location.href='UsersChange.html';
		return false;
	}
*/	
if(frmMain.cash.value==''){
		window.alert("请输入金额!");
		frmMain.cash.focus();
		return false;
	}


frmMain.submit();
	return true;
}


function CC(){
	if (frmMain.ChkService.checked != true){
		frmMain.btnSubmit.disabled=true;
	}else{
		frmMain.btnSubmit.disabled=false;
	}
}

//检查E-mail是否注册
function Check_Email(inputName)
{
	var iChars = "";
	if (Check_Input(inputName,'E-mail',1,100,iChars)){
		if(!isEmail(inputName.value)) {
			window.alert("电子邮件格式不正确!"); 
			inputName.focus(); 
			return false;
		}else{
			frmCheck.location="CheckUserID.asp?Email="+inputName.value;
		}
	}
	return false;
}

   
     

//供应商注册
function Check_Reg1(){
	iChars= "~!@#$%^&*(){}:?<>,/;'[]\=`-+|";
	if (Check_Input(frmMain.UserName,'用户名',3,50,iChars) != true){
		return false;
	}

	iChars = "";
	if (Check_Input(frmMain.Password,'密码',6,50,iChars) != true){
		return false;
	}

	if (frmMain.Password.value != frmMain.cfPassWord.value){
		alert("两次密码输入不一致");
		frmMain.cfPassWord.focus();
		return false;
	}

	iChars = "'";
	if (Check_Input(frmMain.TrueName,'联系人',1,50,iChars) != true){
		return false;
	}

	iChars = "'";
	if (Check_Input(frmMain.userTel,'联系电话',3,20,iChars) != true){
		return false;
	}

	iChars = "";
	if (Check_Input(frmMain.email,'E-mail',1,50,iChars) != true){
		return false;
	}

	if(!isEmail(frmMain.email.value)) {
		alert("电子邮件格式不正确!"); 
		frmMain.email.focus(); 
		return false;
	}

	if (!frmMain.agree.checked){
		alert("您需要同意各项开户条约!"); 
		frmMain.agree.focus();
		return false;
	}
	
frmMain.submit();
	return true;
}