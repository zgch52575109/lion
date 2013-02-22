//检查输入格式
function Check_Input(inputName,strInputTitle,intMin,intMax,iChars){
	var strValue = inputName.value;
	if(strValue==''){
		window.alert("请输入"+strInputTitle+"！");
		inputName.style.backgroundColor="#FFECFF";
		inputName.focus();
		return false;
	}
	for(var i=0;i<strValue.length;i++){
	if(iChars.indexOf(strValue.charAt(i))!=-1){
		alert(strInputTitle+"格式不正确，请重新输入！");
		inputName.focus();
		return false;
		}
	}
	if ((strValue.length < intMin)||(strValue.length > intMax)){
        window.alert(strInputTitle+"长度不符合要求，长度必须在"+intMin+"到"+intMax+"之间！");
		inputName.focus();
		return false; 
	}
	return true;
}

//检查CheckBox 是否有选项
function boxSelected(formObj, vfldn) {
	var selected = false;
    for (var i = 0; i < formObj.elements.length; i++) {
    	if (formObj.elements[i].name == vfldn &&
    		formObj.elements[i].checked == true) {
    		selected = true;
    		break;
    	}
    }
    return selected;
}


// 邮件地址是否正确
function isEmail(emailad){
	var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
	var check=/@[\w\-]+\./;
	var checkend=/\.[a-zA-Z]{2,3}$/;
	if(((emailad.search(exclude) != -1)||(emailad.search(check)) == -1)||(emailad.search(checkend) == -1))	{
  		return false;
	}
	else {
  		return true;
	}			
	return true;	
}

//检查一个字符是否为数字
function IsDigit(cCheck) { return (('0'<=cCheck) && (cCheck<='9')); }

//检查一个字符是否为英文字母
function IsAlpha(cCheck) { return ((('a'<=cCheck) && (cCheck<='z')) || (('A'<=cCheck) && (cCheck<='Z'))); }

//检查一个字符是否为中文
function IsChinese(cCheck) { return (cCheck > 0 || cCheck < 255); }

//计算字符串长度
function strlen (str) {
	var len = str.length;
	var y = 0;	
	for (var i=0; i < len; i++)	{
		var s = str.charCodeAt (i);
		if (s < 0 || s > 255)
			y = y + 3;
		else
			y = y +1;	
	}
	return y
}

//重置确定
function CheckReset(){
	if (confirm("您确定要重置所有信息吗？")){
		return true;
	}
	return false;
}

//去除两边的空格
function trim(str)
{
  str=str.replace(/^ {1,}/g,"");
  str=str.replace(/ {1,}$/g,"");
  return str;
}

//删除确认
function btnDelete_onclick(){
    if (confirm("真的要将所选记录删除吗？")){
        document.form1.submit();
    }
}

//全选
function CheckAll(form) {
    for (var i=0;i<form.elements.length;i++) {
        var e = form.elements[i];
        if (e.name == 'ID')
            e.checked = form.SELECTALL.checked;
    }
}

function doCheck(){
//	if (eWebEditor1.getHTML()=="") {
//		alert("the contents cannot be empty!");
//		return false;
//	}
    //eWebEditor1.remoteUpload("doSubmit()");
    //return false;
}

function doSubmit(){
    document.form1.submit();
}

function openWin(url, left, top, width, height)
{
	if(url=='')
		return;
	var winOption = "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top;
	window.open(url, '', winOption);
	return;
}
