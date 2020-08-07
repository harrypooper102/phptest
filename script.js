$(document).ready(()=>{
  $(window).scroll(()=>{
    var scroll = $(window).scrollTop();

        if (scroll >= 250) {
            $("nav").addClass("fixed");
        } else {
            $("nav").removeClass("fixed");
        }
  });
});
