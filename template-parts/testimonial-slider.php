<?php

/* Testimonial Slider */
wp_enqueue_script( 'ta-testimonial-slider', get_template_directory_uri() . '/js/testimonial-slider.js', array('slick'), '20190220', true);

?>

<div data-slick='{"autoplay": true, "autoplaySpeed": 6000}' class="testimonial-slider">
  <?php
    $args = array(
      'post_type'       => 'testimonials',     // searching the 'testimonials'
      'post_status'     => 'publish',          // we only want published posts
      'tax_query'       => array('relation' => 'AND'), // we need this to be available for pushing
      'orderby'         => 'title',            // we will sort posts by title
      'order'           => 'ASC',              // descending order
      'nopaging'        => true
    );

    $query = new WP_Query( $args ); // make the query
    if( $query->have_posts() ) :
      // Here's the thing!
      while( $query->have_posts() ): $query->the_post();

        echo'<div>';
          echo the_content();
          echo '<h6>- ' . get_the_title() . '</h6>';
        echo '</div>';

      endwhile;
    endif;

    // Now reset all the things before we do it again
    $query = null;
    $args = null;
    wp_reset_postdata();
  ?>
</div>
