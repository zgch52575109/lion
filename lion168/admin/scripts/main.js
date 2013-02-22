
function $$(id){
	if (document.getElementById(id)){
		return document.getElementById(id);
	} else {
		return false;
	}
}

function closeWin(){
	document.body.removeChild($$("bg")); 
	document.body.removeChild($$("msg"));
	if($$("searchtype"))$$("searchtype").style.display="";
}

function openWindow(zindex,width,height,alpha){
	var iWidth = document.documentElement.scrollWidth; 
	var iHeight = document.documentElement.clientHeight; 
	var bgDiv = document.createElement("div");
	bgDiv.id="bg";
	bgDiv.style.cssText = "top:0;width:"+iWidth+"px;height:"+document.documentElement.scrollHeight+"px;filter:Alpha(Opacity="+alpha+");opacity:0.3;z-index:"+zindex+";";
	document.body.appendChild(bgDiv); 
	var msgDiv=document.createElement("div");
	msgDiv.id="msg";
	msgDiv.style.cssText ="z-index:"+(zindex+1)+";width:"+width+"px; height:"+(parseInt(height)-0+29+16)+"px;left:"+((iWidth-width-2)/2)+"px;top:"+(getScroll()+(height=="auto"?150:(iHeight>(parseInt(height)+29+2+16+30)?(iHeight-height-2-29-16-30)/2:0)))+"px";
	msgDiv.innerHTML="<div class='msgtitle'><div id='msgtitle'></div><img onclick='closeWin()' src='/"+sitePath+"pic/btn_close.gif' /></div><div id='msgbody' style='height:"+height+"px'></div>";
	document.body.appendChild(msgDiv);
}

function openWindow2(zindex,width,height,alpha){
	var iWidth = document.documentElement.scrollWidth; 
	var bgDiv = document.createElement("div");
	bgDiv.id="bg";
	bgDiv.style.cssText = "top:0;width:"+iWidth+"px;height:"+document.documentElement.scrollHeight+"px;filter:Alpha(Opacity="+alpha+");opacity:0.3;z-index:"+zindex+";";
	document.body.appendChild(bgDiv); 
	var msgDiv=document.createElement("div");
	msgDiv.id="msg";
	msgDiv.style.cssText ="position: absolute;z-index:"+(zindex+1)+";width:"+width+"px; height:"+(height=="auto"?height:(height+"px"))+";";
	document.body.appendChild(msgDiv);	
}

function selectTogg(){
	var selects=document.getElementsByTagName("select");
	for(var i=0;i<selects.length;i++){
		selects[i].style.display=(selects[i].style.display=="none"?"":"none");
	}
}

function set(obj,value){
	obj.innerHTML = value
}

function view(id){
	$$(id).style.display='inline'	
}

function hide(id){
	$$(id).style.display='none'		
}

function setInCashCheck(orderid,type){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+orderid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>拒绝选项：<select name=\"xuanxiang\" id=\"xuanxiang\"><option value=\"\">选择</option><option value=\"信息不完整\">信息不完整</option><option value=\"重复提单\">重复提单</option><option value=\"未达到投注额要求\">未达到投注额要求</option><option value=\"帐户异常\">帐户异常</option><option value=\"金额不正确\">金额不正确</option><option value=\"未收到汇款\">未收到汇款</option></select></p><p>拒绝备注：<input type='text' name='note' id='note' value=''></p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitInCashCheck('"+orderid+"','"+type+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitInCashCheck(orderid,type){
	var xuanxiang = $$("xuanxiang").value
	if (xuanxiang.length==0) {
		alert('请选择拒绝选项')
		return false;
	}

	$.get("admin_ajax.php?id="+orderid+"&type="+type+"&xuanxiang="+encodeURI(xuanxiang)+"&note="+encodeURI(note)+"&action=submitincashcheck", '', 
		function(a){
			set($$("check"+orderid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}

function setInCashOperation(orderid,type){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+orderid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>拒绝选项：<select name=\"xuanxiang\" id=\"xuanxiang\"><option value=\"\">选择</option><option value=\"信息不完整\">信息不完整</option><option value=\"重复提单\">重复提单</option><option value=\"未达到投注额要求\">未达到投注额要求</option><option value=\"帐户异常\">帐户异常</option><option value=\"金额不正确\">金额不正确</option><option value=\"未收到汇款\">未收到汇款</option></select></p><p>拒绝备注：<input type='text' name='note' id='note' value=''></p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitInCashOperation('"+orderid+"','"+type+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitInCashOperation(orderid,type){
	var xuanxiang = $$("xuanxiang").value
	if (xuanxiang.length==0) {
		alert('请选择拒绝选项')
		return false;
	}

	$.get("admin_ajax.php?id="+orderid+"&type="+type+"&xuanxiang="+encodeURI(xuanxiang)+"&note="+encodeURI(note)+"&action=submitincashoperation", '', 
		function(a){
			set($$("check"+orderid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}


function setInCashdecline(cid,money,proxyuid){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+cid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>拒绝选项：<select name=\"xuanxiang\" id=\"xuanxiang\"><option value=\"\">选择</option><option value=\"未达到活跃会员数\">未达到活跃会员数</option><option value=\"账户异常\">账户异常</option></select></p><p>拒绝备注：<input type='text' name='note' id='note' value=''></p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitInCashdecline('"+cid+"','"+money+"','"+proxyuid+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitInCashdecline(cid,money,proxyuid){
	var xuanxiang = $$("xuanxiang").value
	if (xuanxiang.length==0) {
		alert('请选择拒绝选项')
		return false;
	}

	$.get("admin_ajax.php?id="+cid+"&money="+money+"&proxyuid="+proxyuid+"&xuanxiang="+encodeURI(xuanxiang)+"&note="+encodeURI(note)+"&action=submitInCashdecline", '', 
		function(a){
			set($$("check"+cid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}


function setMemberCdailicash(cid){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+cid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>金额：<input type='text' name='cjine' size='10' id='cjine' value=''>冲负输入负数</p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitMemberCdailicash('"+cid+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitMemberCdailicash(cid){
	var jine = $$("cjine").value
	if (jine.length==0) {
		alert('请填写金额')
		return false;
	}
	var note = $$("cnote").value
	
	$.get("admin_ajax.php?id="+cid+"&jine="+jine+"&note="+encodeURI(note)+"&action=submitMemberCdailicash", '', 
		function(a){
			set($$("check"+cid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}


function setInCashCzhengfu(orderid,type){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+orderid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>金额：<input type='text' name='jine' size='10' id='jine' value=''>冲负输入负数</p><p>备注：<input type='text' name='note' id='note' value=''></p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitInCashCzhengfu('"+orderid+"','"+type+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitInCashCzhengfu(orderid,type){
	var jine = $$("jine").value
	if (jine.length==0) {
		alert('请填写冲正冲负金额')
		return false;
	}
	var note = $$("note").value

	$.get("admin_ajax.php?id="+orderid+"&jine="+jine+"&note="+encodeURI(note)+"&action=submitincashczhengfu", '', 
		function(a){
			set($$("check"+orderid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}

function setMemberCzhengfu(uid){
	openWindow2(101,230,20,0)
	var msgDiv=$$("msg")
	var topicTDObj = $$("check"+uid);
	var topicTDTop = topicTDObj.offsetTop;
    var topicTDLeft = topicTDObj.offsetLeft; 
    while (topicTDObj = topicTDObj.offsetParent){topicTDTop+=topicTDObj.offsetTop; topicTDLeft+=topicTDObj.offsetLeft;}
    msgDiv.style.cssText+="border:1px solid #CACACA;background: #E0E2E3;padding:13px 0px 13px 4px;"
	msgDiv.style.top = (topicTDTop-1)+"px";
    msgDiv.style.left = (topicTDLeft-1)+"px"; 
	msgDiv.innerHTML="<p>金额：<input type='text' name='cjine' size='10' id='cjine' value=''>冲负输入负数</p><p>备注：<input type='text' name='cnote' id='cnote' value=''></p><p style=\"text-align:center;padding-top:10px\"><input type=\"button\" class=\"btn\" value=\"提交\" onclick=\"submitMemberCzhengfu('"+uid+"')\" /> <input type=\"button\" class=\"btn\" value=\"取消\" onclick='closeWin()' /></p>";
}

function submitMemberCzhengfu(uid){
	var jine = $$("cjine").value
	if (jine.length==0) {
		alert('请填写冲正冲负金额')
		return false;
	}
	var note = $$("cnote").value

	$.get("admin_ajax.php?id="+uid+"&jine="+jine+"&note="+encodeURI(note)+"&action=submitmemberczhengfu", '', 
		function(a){
			set($$("check"+uid),"<font color='red'>"+a+"</font>");
	})
	closeWin();
}

function getbanklist(){
	var account = $$("account").value
	if (account.length==0) {
		alert('请填写用户名或者ID')
		return false;
	}
	$.get("admin_ajax.php?account="+account+"&action=getbanklist", '', 
		function(a){
		if(a.indexOf('bankinfo')>0){
			set($$("banklist"),a);
			getbankinfo(0);
		}else{
			alert('没有找到用户');
			return false;
		}
	})
}

function getbankinfo(bankid){
	if (bankid.length==0) {
		return false;
	}
	var uid = $$("uid").value;
	if (uid.length==0) {
		return false;
	}
	$.get("admin_ajax.php?id="+bankid+"&uid="+uid+"&action=getbankinfo", '', 
		function(a){
			set($$("bankinfo"),a);
	})
}