$(document).ready(
function()
{
  $("#action_menu li").mouseover(
  function()
  {
    $("#action_menu li").removeClass("current");
    $(this).addClass("current");
    $("#action_content01").hide();
    $("#action_content02").hide();
    $("#action_content03").hide();
    $("#action_content0" + $(this).attr("tabindex")).show();
  }
  );
  $("#prevbtn").click(
  function()
  {
    if($("#imagelist ul").css("left").replace("px","") < (-134 * ($("#imagelist ul li").length - 8)))
    {
      $("#imagelist ul").animate({left:'0px'});
    }
    else
    {
     $("#imagelist ul").animate({left:'-=134px'});
    }
  }
  );
  $("#nextbtn").click(
  function()
  {
    if($("#imagelist ul").css("left").replace("px","") >= 0)
    {
     $("#imagelist ul").animate({left:"-" + 134 * ($("#imagelist ul li").length - 7) + "px"});
    }
    else
    {
     $("#imagelist ul").animate({left:'+=134px'});
    }
  }
  );
  setInterval(function(){$("#prevbtn").click();},5000);
  $("#bannermenus li").mouseover(
  function()
  {
    $("#bannermenus li").removeClass("current");
    currents = $(this);
    $(this).addClass("current");
    $("#bannerlist ul").stop().animate({top:-230*Number($(this).attr("tabindex"))});
  }
  );
  setInterval("scrollimg()",5000);
}
);
var current = $("#bannermenus li:first");
function scrollimg()
{
  current = $(current).next();
  if($(current).length <= 0)
  current = $("#bannermenus li:first");
  $(current).mouseover();
}
