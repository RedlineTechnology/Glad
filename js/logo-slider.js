/**
 * File logo-slider.js.
 *
 * Calls the Slick function for logo page element
 */

 jQuery(document).ready( function($){
     $('.logo-slider').slick({
       slidesToShow: 7,
       slidesToScroll: 1,
       arrows: false,
       infinite: true,
       pauseOnHover: true,
       paseOnFocus: false,
       variableWidth: true
     });
 });
