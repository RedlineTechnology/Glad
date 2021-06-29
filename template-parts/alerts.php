<?php

  echo '<h3>GLADA Alerts</h3>';
  echo '<div class="upper">';

    echo '<div class="alerts-container">';
    ?> <!-- <a href="#">See All</a> -->

      <!-- <div class="g_alert mine">
        <div class="sender">
          GLADA Admin
        </div>
        <div class="message">
          <p>Now you can send GLADA Alerts directly to other Members here through the Dashboard!</p>
        </div>
      </div> -->

      <?php

      // Get Posts
      $args = array(
        'post_type'			=> 'alert',
        'orderby'       =>  'date',
        'order'         =>  'DESC',
        'nopaging'			=> 	true,
        // 'tax_query'     => array(
        // array(
        //   'taxonomy' => 'alerttype',
        //   'terms'    => 'service',
        //   'field'    => 'slug',
        //   'operator' => 'NOT IN',
        //   )
        // )
      );

      $alerts_query = new WP_Query( $args );

  		if( $alerts_query->have_posts() ) :

  			while ( $alerts_query->have_posts() ) : $alerts_query->the_post();

          $user_id = get_the_author_meta('ID');
          $fname = get_the_author_meta('first_name');
  				$lname = get_the_author_meta('last_name');

          $link = bp_core_get_user_domain( $user_id );
          $type = get_the_terms( $post->ID, 'alerttype' ); ?>

          <div class="g_alert<?php if( $user_id == get_current_user_id() ){ echo ' mine'; } if( $type ){ echo ' ' . $type['slug']; } ?>">
            <div class="sender">
              <a href="<?php echo $link; ?>"><?php echo $fname . ' ' . $lname; ?></a>
            </div>
            <div class="time">
              <?php echo get_the_date('M j'); ?>
            </div>
            <div class="message">
              <?php if( $type && $type['slug'] == 'charter' ) {
                echo '<h5>Charter Alert</h5>';
              } ?>
              <p><strong><?php echo get_the_title(); ?></strong></p>
              <?php the_content(); ?>
            </div>
          </div>

        <?php
        endwhile;
  		endif;


    echo '</div>';

  echo '</div>';

?>

<?php if ( is_dealer() ): ?>
  <div class="lower">
      <form action="#" method="POST" id="alert-form" enctype="multipart/form-data">
        <input type="hidden" name="action" value="sendalert">
        <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
        <input type="text" name="msg_title" id="msg_title" class="regular-text" placeholder="Title" value="">
        <textarea name="msg_content" id="msg_content" rows="5" placeholder="Message" value=""></textarea>
        <button id="alert-form-submit" value="sendalert">Send Alert</button>
      </form>
  </div>
<?php endif; ?>

<?php

wp_enqueue_script( 'mobilealerts', get_template_directory_uri() . '/js/mobilealerts.min.js', array('jquery'), '20210104', true);
