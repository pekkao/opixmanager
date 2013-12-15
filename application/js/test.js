$(document).ready(function() {
  $("p.pop-up").css({'display':'block','opacity':'0'})
});

$("a.trigger").hover(
  function () {
    $(this).prev().stop().animate({
      opacity: 1
    }, 500);
  },
  function () {
    $(this).prev().stop().animate({
      opacity: 0
    }, 200);
  }

)


