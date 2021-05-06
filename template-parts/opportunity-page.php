
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
  $website = get_user_meta($user_id, 'mepr_company_website', true) ? : '';

  // Let's Gather All our Post Information Now
  $title = get_the_title();
  $category_array = get_the_category();
  $cat_id = $category_array[0]->term_id;
  $cat_name = $category_array[0]->name;

  if ( $cat_id == '18' ) {
    $type = get_the_terms( $post->ID, 'aircraft' );
    $status = get_the_terms( $post->ID, 'marketstatus' );
    $year = get_post_meta( $post->ID, 'year', true ) ? : '';
    $make = get_post_meta( $post->ID, 'make', true ) ? : '';
    $model = get_post_meta( $post->ID, 'model', true ) ? : '';
    $sn = get_post_meta( $post->ID, 'serialnumber', true ) ? : '';
    $reg = get_post_meta( $post->ID, 'registration', true ) ? : '';
    $lndgs = get_post_meta( $post->ID, 'landings', true ) ? : '';
    $aftt = get_post_meta( $post->ID, 'aftt', true ) ? : 'aftt';
    $aftt_hrs = get_post_meta( $post->ID, 'aftt-number', true ) ? : '';
    $pdf = get_post_meta( get_the_ID(), 'pdf', true);
    $url = get_post_meta( $post->ID, 'url', true ) ? : get_user_meta($user_id, 'mepr_company_website', true);
  } else {
    $details = apply_filters( 'the_content', get_the_content() );
  }

  echo '<h2 class="mobile">' . $title . '</h2>';

  // OFF-MARKET AIRCRAFT
  if ( $cat_id == '18' ) { ?>

    <div class="title-secondary">
      <?php if( $year ) { echo '<h3 class="year">' . $year . '</h3>'; } ?>
      <?php if( $make ) { echo '<h3 class="make">' . $make . '</h3>'; } ?>
      <?php if( $model ) { echo '<h3 class="model">' . $model . '</h3>'; } ?>
      <br>
      <?php if( $sn ) { echo '<h3 class="sn">' . $sn . '</h3>'; } ?>
      <?php if( $reg ) { echo '<h3 class="reg">' . $reg . '</h3>'; } ?>
    </div>

    <div class="info-summary">
      <?php if( $lndgs ) { echo '<p><span class="subhead-landings">Landings: </span>' . $lndgs . '</p>'; } ?>
      <?php if( $aftt_hrs ) { echo '<p><span class="subhead-aftt">' . $aftt . ': </span>' . $aftt_hrs . ' Hours</p>'; } ?>
    </div>

    <div class="specsheet">
      <?php
        if ( $pdf ) {
          $pdfurl = wp_get_attachment_url( $pdf ) ? : $pdf;
          echo '<a class="button" href="' . $pdfurl . '" target="_blank">View Specsheet</a>';
        }
        if( is_user_logged_in() && can_edit() ) {
          echo '<a href="#" data-postid="' . $post->ID . '"  class="edit" data-form="upload-specsheet-formbox">Add/Replace Specsheet</a>';
        } ?>
    </div>

  <?php } else { ?>

    <div class="info-main">
      <div class="cat">
        <h3><?php echo $cat_name; ?></h3>
      </div>
      <?php the_content(); ?>
    </div>

  <?php } ?>

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
