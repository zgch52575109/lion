<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金狮国际</title>
<link type="text/css" href="css/style.css" rel="stylesheet">
<script language="javascript" src="js/qq.js"></script>
<script language="javascript" src="js/date.js"></script>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>

<body onload="MM_preloadImages('images/choice_12b.gif','images/choice_14b.gif')">
 <div class="box">
   <div class="top">
     <div class="top-2"></div>
   
   </div>
<div class="banner-2" style="height:450px;">
   <div style="background-image:url(images/Password_findv02_07.gif); height:47px; width:786px; margin:0 auto;"></div>
   <div style=" width:786px; margin:0 auto;height: auto; color:#FC0">
   <?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
CheckNotAllow();
if(!isset($type)){
?>
   <table width="786" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="6" rowspan="2"><img src="images/Password_find_05.gif" width="6" height="256" /></td>
    <td align="center" valign="middle"><img src="images/choice_07.gif" width="209" height="89" /></td>
    <td width="6" rowspan="2"><img src="images/Password_find_07.gif" width="6" height="256" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
<div style="text-align:center;">
<a href="#" onmouseout="MM_swapImgRestore()" onclick="location.href='?type=1'" onmouseover="MM_swapImage('Image4','','images/choice_12b.gif',1)"><img src="images/choice_12.gif" name="Image4" width="237" height="82" border="0" id="Image4" /></a><a href="#" onmouseout="MM_swapImgRestore()" onclick="location.href='?type=0'" onmouseover="MM_swapImage('Image5','','images/choice_14b.gif',1)"><img src="images/choice_14.gif" name="Image5" width="237" height="82" border="0" id="Image5" /></a>    
    </td>
    </tr>
   </table>
  <?php
}else{
	$type = in_array($type,array(0,1)) ? $type : 0;
	$ticketid=regHGuser($cfg_cl->fields['username'],$cfg_cl->fields['truename'],$type);
	if($ticketid){
		header("Location:".$cfg_apiloginurl.$ticketid."&lang=ch");
		exit();
	}else{
		ShowMsg("系统出现错误，请联系客服人员！","-1");
		exit();
	}
} ?>

   </div>
   <div style="background-image:url(images/Password_find_16.gif); height:47px; width:786px; margin:0 auto;"></div>
   </div>
 <div class="neirong"></div>
</div>
</body>

</html>
