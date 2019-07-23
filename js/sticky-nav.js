jQuery(document).ready( function($){
  // STICKY NAV
  var $stickyheight = $(".footer-logo").offset().top;

  $(window).scroll( function() {
    var $scrollBottom = $(this).scrollTop() + $(this).height();
    if( $scrollBottom > $stickyheight ) {
      $("header, .content-area").addClass('unstuck');
    } else {
      $("header, .content-area").removeClass('unstuck');
    }
  });
});
