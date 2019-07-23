<?php


?>

<a href="<?php echo get_permalink(); ?>">
  <div class="thumb">
    <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>">
  </div>
  <div class="info">
    <h3 class="year"><?php echo get_post_meta( get_the_ID(), 'year', true ); ?></h3>
    <h3 class="make"><?php echo get_post_meta( get_the_ID(), 'make', true ); ?></h3>
    <h3 class="model"><?php echo get_post_meta( get_the_ID(), 'model', true ); ?></h3>
  </div>
</a>
