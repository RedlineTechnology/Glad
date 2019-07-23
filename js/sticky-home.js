jQuery(document).ready( function($){
  // STICKY NAV
  var $stickyheight = $("#nav-desktop").offset().top;
  $(window).scroll( function() {
    if( $(this).scrollTop() > $stickyheight ) {
      $("#primary-menu").addClass('sticky');
      $(".about-us").addClass('stuck');
    } else {
      $("#primary-menu").removeClass('sticky');
      $(".about-us").removeClass('stuck');
    }
  });
});
