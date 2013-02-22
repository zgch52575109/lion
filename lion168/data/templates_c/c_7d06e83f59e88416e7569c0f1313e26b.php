<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<link type="text/css" rel="stylesheet" href="css.css" >
<title>个人中心</title>
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
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
</head>

<?php echo $this->_fetch_compile("member/top.html"); ?>
  <div class="content">
<div  class="left"></div>
<div  class="m">
<div  class="top">
<ul>
<li style="margin-right:1px;"><a href="limit_operation.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image14','','images/wdqbbb.png',1)"><img src="images/wdqbaa.png" name="Image14" width="84" height="31" border="0" id="Image14" /></a></li>
<li><a href="latest_preferential.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image15','','images/yhbb.png',1)"><img src="images/yhaa.png" name="Image15" width="84" height="31" border="0" id="Image15" /></a></li>
<li><a href="deposit_remit.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image16','','images/cqkbb.png',1)"><img src="images/cqkaa.png" name="Image16" width="84" height="31" border="0" id="Image16" /></a></li>
<li><a href="feedback.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image17','','images/wtfkbb.png',1)"><img src="images/wtfkbb.png" name="Image17" width="84" height="31" border="0" id="Image17" /></a></li>
</ul>
</div>
<div class="top2"></div>
<div class="c">
<div class="l">
<?php echo $this->_fetch_compile("member/member_left.html"); ?>
</div>
<div id="content">
<?php echo $this->_fetch_compile("member/topnews.html"); ?>
<div class="con" style=" padding-bottom:10px; *padding-bottom:40px;">
  <div style="height:23px;">
    <ul>
      <li style="margin:0"><a href="notice.php">公告</a></li>
      <li style=" margin-left:1px;"><a href="news.php">最新消息</a></li>
      <li style="background-color:#FEB638"><a href="notice.php">问题反馈</a></li>
    </ul>
  </div>
  <div class="nr" style="height:395px;*height:365px;_height:370px;">
<div class="nrbanner">
<strong>
问题反馈</strong>
</div>
<div class="qt">
<div style="SCROLLBAR-FACE-COLOR:#623313; SCROLLBAR-HIGHLIGHT-COLOR:#2C1D07; OVERFLOW:
auto; SCROLLBAR-SHADOW-COLOR:
COLOR:#000000 ; SCROLLBAR-3DLIGHT-COLOR:#351C0D; SCROLLBAR-ARROW-COLOR:
#300; SCROLLBAR-DARKSHADOW-COLOR: #351C0D; HEIGHT:160px; WIDTH:100%;">
  <table width="97%" align="center"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="font-size:12px;  text-align:left; line-height:18px;">
  <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <tr>
    <td width="18%" align="center" height="20" bgcolor="#FFFFFF">我的提问：</td>
    <td width="60%" bgcolor="#FFFFFF"><?php echo $this->_vars['data']['msg']; ?>
</td>
    <td width="20%" align="center" height="20" bgcolor="#FFFFFF"><?php echo $this->_vars['data']['dtime']; ?>
</td>
    </tr>
  <tr>
    <td height="20" align="center" bgcolor="#FFFFFF">客服解答：</td>
    <td height="20" bgcolor="#FFFFFF"><?php if ($this->_vars['data']['mid']):  echo $this->_vars['data']['name']; ?>
回复：<?php endif;  echo $this->_vars['data']['remsg']; ?>
</td>
    <td height="20" align="center" bgcolor="#FFFFFF"><?php echo $this->_vars['data']['retime']; ?>
</td>
    </tr>
	<?php endforeach; endif; ?>
      <tr>
    <td height="20" colspan="3" bgcolor="#FEB638" align="center" style="color:#000; font-size:12px;">共<?php echo $this->_vars['TotalResult']; ?>
条 每页<?php echo $this->_vars['numPerPage']; ?>
条 第<?php echo $this->_vars['page']; ?>
/<?php echo $this->_vars['TotalPage']; ?>
页  <a href="<?php echo $this->_vars['firstpage']; ?>
">[首页]</a> <a href="<?php echo $this->_vars['perpage']; ?>
">[上一页]</a> <a href="<?php echo $this->_vars['nextpage']; ?>
">[下一页]</a> <a href="<?php echo $this->_vars['lastpage']; ?>
">[尾页]</a></td>
    </tr>
  </table>
  </div>
  <form action="" method="post" id="frmMain" name="frmMain">
  <table width="500" border="0" style="margin-top:10px;">
  <tr>
    <td align="center"><label for="textarea"></label>
      <textarea name="msg" id="msg" cols="60" rows="6"></textarea></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="button" id="button" value="提交问题" /></td>
  </tr>
</table>
<input type="hidden" name="action" value="save">
</form>
</div>
</div>
</div>
</div>
</div>
<?php echo $this->_fetch_compile("member/left.html"); ?>
  <div style=" clear:left; background-image:url(images/42.png);  height:5px; margin-top:4px;margin-top:-9px!important; "></div>
</div>
<div style="display:block; float:left; width:201px; height:692px; background-image:url(images/04.gif)"></div>

  <!-- end .content --></div>
<?php echo $this->_fetch_compile("member/foot.html"); ?>
</body>
</html>