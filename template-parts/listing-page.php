

<div class="the-content">

  <div class="title-secondary">
    <h3 class="year"><?php echo get_post_meta( $post->ID, 'year', true ); ?></h3>
    <h3 class="make"><?php echo get_post_meta( $post->ID, 'make', true ); ?></h3>
    <h3 class="model"><?php echo get_post_meta( $post->ID, 'model', true ); ?></h3><br>
    <h3 class="sn"><?php echo get_post_meta( $post->ID, 'serialnumber', true ); ?></h3>
    <h3 class="reg"><?php echo get_post_meta( $post->ID, 'registration', true ); ?></h3>
  </div>

  <div class="info-summary">
    <p><span class="subhead-landings">Landings: </span><?php echo get_post_meta( $post->ID, 'landings', true ); ?></p>
    <p><span class="subhead-aftt"><?php echo get_post_meta( $post->ID, 'aftt', true ) . ': </span>' . get_post_meta( $post->ID, 'aftt-number', true );?></p>
    <p><span class="subhead-highlights">Highlights:</span><br><?php if( has_excerpt() ) { echo get_the_excerpt(); } ?></p>
  </div>

  <div class="info-main">
    <?php the_content(); ?>
  </div>

  <div class="info-contact">
    <h3 class="name"><?php echo get_post_meta( $post->ID, 'contactname', true ); ?></h3>
    <h3 class="number"><?php echo get_post_meta( $post->ID, 'contactnumber', true ); ?></h3>
    <h3 class="email"><?php echo get_post_meta( $post->ID, 'contactemail', true ); ?></h3>
  </div>

  <?php
  $posttype = get_post_type( $post->ID );
  $obj = get_post_type_object( $posttype );
  echo '<div class="post-nav">';
    echo '<a href="' . get_post_type_archive_link( $posttype ) . '">Back to ' . $obj->labels->name . '</a>';
  echo '</div>';
  ?>

</div>

<?php

echo '<div class="the-deets">' .
  'Posted on ' . get_the_date( 'l F j, Y' ) .
'</div>';

?>
