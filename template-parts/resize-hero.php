<?php
// Resize the Hero Title if it's too long ?>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/fitty.min.js'?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
	var query = Modernizr.mq('(min-width: 48em)');
	 if (query) {
	   fitty('#title');
	 }
});
</script>
