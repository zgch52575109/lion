$(document).ready(
function()
{ 
  $("#leftcontent dt").click(
  function()
  {
    if($(this).parent().html() == $("#leftcontent .current").html())
    {
      $(this).parent().removeClass("current");
      return;
    }
    $("#leftcontent dl").removeClass("current");
    $(this).parent().addClass("current");
  }
  );
  $("#leftcontent dl .menu").click(
  function()
  {
    if($(this).parent().html() == $(this).parent().parent().find(".currentli").html())
    {
      $(this).parent().removeClass("currentli");
      return;
    }
    $("#leftcontent li").removeClass("currentli");
    $(this).parent().addClass("currentli");
  }
  );
});