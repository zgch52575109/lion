//会员重复判断	
function username_check(){	
    document.getElementById("divTest").innerHTML = "<font color=#ff0000>正在检测! loading....</font>";
var username = $('#username').val();
if(username == "" || username.length < 5 || username.length > 20){
    document.getElementById("divTest").innerHTML = "<font color=#ff0000>* 填写5-20位，且有英文(a-z)、数字(0-9)组成</font>";
}else{

jQuery.ajax({
   type: "POST",
   url: "check.php?check=us",
   data: 'username='+ username,
   cache: false,
   success: function(response){
if(response == 1){
	//不可以注册
    document.getElementById("divTest").innerHTML = "<font color=#ff0000>用户名被占用，请换一个！</font>";
	}else{
    document.getElementById("divTest").innerHTML = "<font color=#DB631D>用户名可以使用！</font>";
	     }
}
});
}
}
//真实姓名验证
function Truename_check(){
var Truename = document.getElementById("Truename").value;
if (Truename != "") {
    document.getElementById("Truenametest").innerHTML = "<font color=#DB631D>真实姓名可以使用！</font>";
  }else{
alert("真实姓名不能为空！");
document.getElementById("Truenametest").innerHTML = "<font color=#ff0000>真实姓名格式不正确！</font>";
  }
}
//电话号码验证
function userTel_check(){
var userTel = document.getElementById("userTel").value;
if (userTel != "") {
    document.getElementById("userTeltest").innerHTML = "<font color=#DB631D>电话号码可以使用！</font>";
  }else{
alert("电话号码不能为空！");
document.getElementById("userTeltest").innerHTML = "<font color=#ff0000>电话号码格式不正确！</font>";
  }
}
//邮箱验证
function check_email1(){
var email1 = document.getElementById("email1").value;
if (email1 != "") {
var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
flag = reg.test(email1);
if (!flag) {
alert("邮箱格式不正确！");
    document.getElementById("emailTest").innerHTML = "<font color=#ff0000>邮箱格式不正确！</font>";
return false;
    }else{
    document.getElementById("emailTest").innerHTML = "<font color=#DB631D>邮箱可以使用！</font>";
	}
  }else{
alert("邮箱格式不正确！");
document.getElementById("emailTest").innerHTML = "<font color=#ff0000>邮箱格式不正确！</font>";
  }
}
 //密码验证
 function checkPassnum(){	
 var p1 = document.frmMain.p1.value;
 
 if (p1.length>16){
  alert('密码必须小于16位!');
    document.getElementById("p1test").innerHTML = "<font color=#ff0000>* 请输入6-16位密码</font>";
  return;
 }else if(p1.length<6){
  alert('密码必须大于6位!');
    document.getElementById("p1test").innerHTML = "<font color=#ff0000>* 请输入6-16位密码</font>";
  return;
 }else{
    document.getElementById("p1test").innerHTML = "<font color=#DB631D>密码正确！</font>";
 }
}

//密码是否一致验证
	function checkPass(p1,p2){
		p1Value=document.getElementById(p1).value;
		p2Value=document.getElementById(p2).value;
		if(p1Value!=p2Value){
			alert("两次输入密码不一致，请确认密码！");
			document.getElementById(p2).value='';
			}else{
    document.getElementById("p2test").innerHTML = "<font color=#DB631D>密码一致！</font>";
			}
		}
