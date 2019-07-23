/**
 * File navigation.js.
 *
 * Handles Full Screen Video Background Functions
 */

jQuery(document).ready( function($){
  initBannerVideoSize('.video-container .poster');
  initBannerVideoSize('.video-container .filter');
  initBannerVideoSize('.video-container video');

  $(window).on('resize', function() {
    scaleBannerVideoSize('.video-container .poster');
    scaleBannerVideoSize('.video-container .filter');
    scaleBannerVideoSize('.video-container video');
  });
});

function initBannerVideoSize(element){
  jQuery(element).each(function(){
    jQuery(this).data('height', jQuery(this).height());
    jQuery(this).data('min-width', jQuery(this).width());
  });

  scaleBannerVideoSize(element);
}

function scaleBannerVideoSize(element) {

  var windowWidth = jQuery(window).width(),
  windowHeight = jQuery(window).height() + 5,
  videoWidth,
  videoHeight;

  // console.log(windowHeight);

  jQuery(element).each(function(){
    var videoAspectRatio = jQuery(this).data('height')/jQuery(this).data('width');

    jQuery(this).css('min-width',windowWidth);

    if(windowWidth < 1000){
        videoHeight = windowHeight;
        videoWidth = videoHeight / videoAspectRatio;
        jQuery(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

        jQuery(this).css('min-width',videoWidth).height(videoHeight);
    }

    jQuery('.hero .video-container video').addClass('fadeIn animated');

  });
}
