<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<link type="text/css" rel="stylesheet" href="css.css" >
<title>代理中心</title>
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
<?php echo $this->_fetch_compile("proxy/top.html"); ?>

<div class="content">
  <div  class="left"></div>
  <div  class="m">
    <div  class="top"></div>
    <div class="top2"></div>
    <div class="c">
      <div class="l">
        <!--Left middle content-->
        <?php echo $this->_fetch_compile("proxy/member_left.html"); ?>
        <div  id="link"> <a href="information.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image18','','images/grzlb.gif',1)"> <img src="images/grzl.gif" name="Image18" width="138" height="36" border="0" id="Image18" /> </a> </div>
        <div id="link"> <a href="news.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image15','','images/zxxxb.gif',1)"> <img src="images/zxxxb.gif" name="Image15" width="138" height="36" border="0" id="Image15" /> </a> </div>
        <div id="link"> <a href="join_in.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image20','','images/jmhyb.gif',1)"><img src="images/jmhy.gif" name="Image20" width="138" height="36" border="0" id="Image20" /></a> </div>
        <div id="link"> <a href="profit.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image24','','images/lrfcb.gif',1)"><img src="images/lrfc.gif" name="Image24" width="138" height="36" border="0" id="Image24" /></a> </div>
        <div id="link"> <a href="proxy_join_in.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/dali_29.gif',1)"><img src="images/dali_27.gif" name="Image5" width="142" height="36" border="0" id="Image5" /></a></div>

        <!--Left middle content-->
      </div>
      <div id="content">
        <!-- right middle content-->
        <div class="con">
          <div style="height:23px;">
            <ul>
              <li><a href="notice.php">公告</a></li>
              <li style="margin:0; background-color:#B8EFF9"><a href="news.php">最新消息</a></li>
              <li ><a href="feedback.php">问题反馈</a></li>
            </ul>
          </div>
          <div class="nr">
            <div class="nrbanner"><strong>最新消息</strong></div>
            <div class="qt">
              <table width="747" align="center"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="font-size:12px; text-align:center; line-height:18px;">
                <?php if (count((array)$this->_vars['datas'])): foreach ((array)$this->_vars['datas'] as $this->_vars['key'] => $this->_vars['data']): ?>
                <tr>
                  <td width="606" height="20" align="left" bgcolor="#FFFFFF"><?php echo $this->_vars['data']['l_body']; ?>
</td>
                  <td width="118" height="20" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $this->_vars['data']['l_addtime']; ?>
</td>
                </tr>
                <?php endforeach; endif; ?>
                <tr>
                  <td height="20" colspan="2" bgcolor="#B8EFF9" style="color:#000; font-size:12px;">共
                    <?php echo $this->_vars['TotalResult']; ?>

                    条 每页
                    <?php echo $this->_vars['numPerPage']; ?>

                    条 第
                    <?php echo $this->_vars['page']; ?>

                    /
                    <?php echo $this->_vars['TotalPage']; ?>

                    页 <a href="<?php echo $this->_vars['firstpage']; ?>
">[首页]</a> <a href="<?php echo $this->_vars['perpage']; ?>
">[上一页]</a> <a href="<?php echo $this->_vars['nextpage']; ?>
">[下一页]</a> <a href="<?php echo $this->_vars['lastpage']; ?>
">[尾页]</a></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- right middle content-->
        </div>
      </div>
    </div>
    <div style=" clear:left; background-image:url(images/42.png);  height:5px; margin-top:4px; "></div>
  </div>
  <div style="display:block; float:left; width:201px; height:692px; background-image:url(images/04.gif)"></div>
  <!-- end .content -->
</div>
<?php echo $this->_fetch_compile("proxy/foot.html"); ?>
</body></html>
