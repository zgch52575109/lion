var ajax = new AJAX();ajax.setcharset("GBK");


function checkusername(username){
	if(username!=''){
	set("divTest","<font color=red>正在检测用户名！Loading…</font>");
	ajax.get(
		"/ajax.php?action=checkusername&username="+username, 
		function(obj){
			if(obj.responseText){
				 divTest.innerHTML = obj.responseText;
				 if (obj.responseText == "<font color=#FF0000>该用户名已被注册，请重新输入！</font>")
				 {
					 alert("该用户名已被注册，请重新输入")
					 document.frmMain.UserName.value="";
					 document.frmMain.UserName.focus();
					 return false;
				}
			}
		}
	);
	}else{0
		set("divTest","<font color=red>* 请输入您的用户名</font>");
	}
}
