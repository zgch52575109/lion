$(document).ready(
function()
{
  $("#prevbtn").click(
  function()
  {
    if($("#bannerlist ul").css("left").replace("px","") < (-960 * ($("#bannerlist ul li").length - 2)))
    {
      $("#bannerlist ul").animate({left:'0px'});
    }
    else
    {
     $("#bannerlist ul").animate({left:'-=960px'});
    }
  }
  );
  $("#nextbtn").click(
  function()
  {
    if($("#bannerlist ul").css("left").replace("px","") >= 0)
    {
     $("#bannerlist ul").animate({left:"-" + 960 * ($("#bannerlist ul li").length - 1) + "px"});
    }
    else
    {
     $("#bannerlist ul").animate({left:'+=960px'});
    }
  }
  );
  setInterval(function(){$("#prevbtn").click();},5000);
 
}
);
