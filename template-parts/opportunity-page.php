
<?php

  echo '<div class="the-deets">' .
    'Posted on ' . get_the_date( 'l F j, Y' ) .
  '</div>';

?>

<div class="the-content">

  <?php

  // Get and Display Branding Information
  $user_id = get_the_author_meta('ID');
  $name = get_post_meta( $post->ID, 'contactname', true ) ? : get_userdata($user_id)->first_name . ' ' . get_userdata($user_id)->last_name;
  $phone = get_post_meta( $post->ID, 'contactnumber', true ) ? : get_user_meta( $user_id, 'mepr_phone_number', true );
  $email = get_post_meta( $post->ID, 'contactemail', true ) ? : get_userdata( $user_id )->user_email;

  // Let's Gather All our Post Information Now
  $title = get_the_title();
  $url = get_post_meta( $post->ID, 'url', true) ?: get_user_meta( $user_id, 'mepr_company_website', true );
  $details = apply_filters( 'the_content', get_the_content() );

  $terms = get_the_terms( $post->ID, 'opptype' );
  $checkedterms = array();
  if( ! empty($terms) ) {
    $checkedterms = array_map( function($o) { return $o->slug; }, $terms );
  }

  echo '<h2 class="mobile">' . $title . '</h2>'; ?>

  <div class="info-main">
    <?php // types will go here ?>
    <?php the_content(); ?>
  </div>

  <div class="info-contact">
    <h3 class="name"><?php echo $name; ?></h3>
    <h3 class="number"><?php echo $phone; ?></h3>
    <h3 class="email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></h3>
  </div>

  <?php
    // Back to Archive Page
    $posttype = get_post_type( $post->ID );
    $obj = get_post_type_object( $posttype );

    echo '<div class="post-nav">';
      echo '<a href="' . get_post_type_archive_link( $posttype ) . '">Back to ' . $obj->labels->name . '</a>';
    echo '</div>';
  ?>

  <?php

  if( is_user_logged_in() && can_edit() ) {

    echo '<a href="/members/submit-a-listing/" data-postid="' . $post->ID . '" class="edit" data-form="edit-listing-formbox">Edit Opportunity Listing</a>';
    echo '<a href="/members/submit-a-listing/" data-postid="' . $post->ID . '" class="edit remove" data-form="delete-listing-formbox">Remove Listing</a>';

    include( locate_template( 'template-parts/edit-opportunities.php', false, false ) );
    wp_enqueue_script( 'editlistings', get_template_directory_uri() . '/js/editlistings.min.js', array('jquery'), '20191125', true);

  } /* End Show if Can Edit */

  ?>

</div>
