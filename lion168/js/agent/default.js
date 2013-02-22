$(document).ready(
function()
{ 
  $(".slider").slideshow({
    width      : 980,
    height     : 329,
    pauseOnHover : false,
    transition : ['slideLeft', 'slideRight', 'slideTop', 'slideBottom']
  });
  
 // $(".caption").fadeIn(500);
  
  // playing with events:
  
//  $(".slider").bind("sliderChange", function(event, curSlide) {
//    $(curSlide).children(".caption").hide();
//  });
//  
  $(".slider").bind("sliderTransitionFinishes", function(event, curSlide) {
   // $(curSlide).children(".caption").fadeIn(500);
  });
}
);
