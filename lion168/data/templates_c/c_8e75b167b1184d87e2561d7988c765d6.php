<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
      //iframe弹出层
        function tanchuceng(width, height, tit, url) {
			//document.getElementById("type_class").style.display = 'none';
			$("#type_class").hide();
            var winWinth = $(window).width(), winHeight = $(document).height();
            $("body").append("<div class='winbj'></div>");
            $("body").append("<div class='tanChu'><div class='tanChutit'><span class='tanchuTxt'>" + tit + "</span><span class='tanchuClose'  onClick='javascript:window.reload()'>关闭</span></div><iframe class='winIframe' frameborder='0' hspace='0' src=" + url + "></iframe></div>");
            $(".winbj").css({ width: winWinth, height: winHeight, background: "#000", position: "absolute", left: "0", top: "0" });
            $(".winbj").fadeTo(0, 0.5);
            var tanchuLeft = $(window).width() / 2 - width / 2;
            var tanchuTop = $(window).height() / 2 - height / 2 + $(window).scrollTop();
            $(".tanChu").css({ width: width, height: height, border: "3px #ccc solid", left: tanchuLeft, top: tanchuTop, background: "#fff", position: "absolute" });
            $(".tanChutit").css({ width: width, height: "25px", "border-bottom": "1px #ccc solid", background: "#eee", "line-height": "25px" });
            $(".tanchuTxt").css({ "text-indent": "5px", "float": "left", "font-size": "14px" });
            $(".tanchuClose").css({ "width": "40px", "float": "right", "font-size": "12px", "color": "#666", "cursor": "pointer" });
            var winIframeHeight = height - 26;
            $(".winIframe").css({ width: width, height: winIframeHeight, "border-bottom": "1px #ccc solid", background: "#ffffff" });
            $(".tanchuClose").hover(
            function() {
       $(this).css("color", "#333");
   }, function() {
       $(this).css("color", "#666");
   }
  );
          $(".tanchuClose").click(function() {

                $(".winbj").remove();
                $(".tanChu").remove();
				location.reload();
				//document.getElementById("type_class").style.display = 'block';

            });

        }
</script>