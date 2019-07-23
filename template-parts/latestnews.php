<div class="latestnews">
  <a class="sectiontitle <?php echo is_home() ? 'alignright' : '';?>" href="/archive"><h3>Latest News</h3></a>
  <?php

  wp_reset_postdata();
  wp_reset_query();

  if( is_single() ) {
    $skipIDs[]=$post->ID;
  } else {
    $skipIDs[]='';
  }

  // Let's get Featured Posts first
  $feat_query = new WP_Query(
    array(
      'post_status' => 'publish',
      'category_name' => 'featured-articles',
      'showposts' => 3,
      'post__not_in' => $skipIDs
  ));

  while ($feat_query -> have_posts()) : $feat_query -> the_post();
    $header_img =  wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') ); ?>
    <article class="featured" data-thumb="<?php echo $header_img ?>">
      <a href="<?php the_permalink() ?>">
        <div class="featured-img mobile" style="background-image:url('<?php echo $header_img ?>');"></div>
        <h2><span><?php the_title(); ?></span></h2>
      </a>
    </article>
    <?php
    $skipIDs[]=$post->ID;
  endwhile;
  wp_reset_postdata();

  // Now let's see if there's room for regular posts
  $post_num = 3 - count( $feat_query );
  if ( $post_num != 0 ) {
    // If so, let's get the ones we need
    $the_query = new WP_Query(
      array(
        'showposts' => $post_num,
        'post__not_in' => $skipIDs
    ));
    // Start the Loop
    while ($the_query -> have_posts()) : $the_query -> the_post();
      $header_img =  wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') ); ?>
      <article data-thumb="<?php echo $header_img ?>">
        <a href="<?php the_permalink() ?>">
          <div class="featured-img mobile" style="background-image:url('<?php echo $header_img ?>');"></div>
          <h2><span><?php the_title(); ?></span></h2>
        </a>
      </article>
    <?php
    endwhile;
    wp_reset_postdata();
  } ?>
  <a href="#" class="readmore"><h5>Read More</h5></a>
</div>
