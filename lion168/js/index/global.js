$(document).ready(
function()
{ 
  $("#navcontent li").mouseover(
  function()
  {
    $("#navcontent .bg").stop().animate({left:25 + 100*Number($(this).attr("tabindex"))},'fast');
  }
  );
  $("#navcontent li").mouseout(
  function()
  {
    $("#navcontent .bg").stop().animate({left:25 + 100*Number($("#navcontent .current").attr("tabindex"))},'fast');
  }
  );
  $("#navcontent .bg").stop().animate({left:25 + 100*Number($("#navcontent .current").attr("tabindex"))},'slow');
  $("#informlist").mouseout(
  function()
  {
    time_link = setInterval("scroll_link()",30);
  });
  $("#informlist").mouseover(
  function()
  {    
    clearTimeout(time_link);
  });
  
  $("#informlist li").each(
  function()
  {
    linkwidth += $(this).width();
  });
  $("#informlist ul").css("width",linkwidth);
  $("#informlist ul").html($("#informlist ul").html() + $("#informlist ul").html());  
  time_link = setInterval("scroll_link()",30);
  if(isie6()) correctPNG();
}
);
var linkwidth = 0;
var time_link;
function scroll_link()
{
  var l = Number($("#informlist ul").css("left").replace("px","")) - 1;
  $("#informlist ul").css("left",l + "px");
  if(l + linkwidth <= 0)
  {
    $("#informlist ul").css("left","0px");
  }
}
function correctPNG()
{
   for(var i=0; i<document.images.length; i++)
   {
   var img = document.images[i]
   var imgName = img.src.toUpperCase()
   if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
   {
   var imgID = (img.id) ? "id='" + img.id + "' " : ""
   var imgClass = (img.className) ? "class='" + img.className + "' " : ""
   var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
   var imgStyle = "display:inline-block;" + img.style.cssText
   if (img.align == "left") imgStyle = "float:left;" + imgStyle
   if (img.align == "right") imgStyle = "float:right;" + imgStyle
   if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle 
   var strNewHTML = "<span " + imgID + imgClass + imgTitle
   + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
   + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
   + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
   img.outerHTML = strNewHTML
   i = i-1
   };
   };
};
function isie6() {
    if ($.browser.msie) {
        if ($.browser.version == "6.0") return true;
    }
    return false;
}