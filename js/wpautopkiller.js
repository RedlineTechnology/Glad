/* we need to get rid of all the <p> tags that wordpress likes to grace us with */
jQuery(document).ready( function($){
    $( 'p:empty' ).remove();
});
