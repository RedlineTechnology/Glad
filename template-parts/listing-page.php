<div class="the-content">

  <?php

  // Get and Display Branding Information
  $user_id = get_the_author_meta('ID');
  $name = get_post_meta( $post->ID, 'contactname', true ) ? : get_userdata($user_id)->first_name . ' ' . get_userdata($user_id)->last_name;
  $phone = get_post_meta( $post->ID, 'contactnumber', true ) ? : get_user_meta( $user_id, 'mepr_phone_number', true );
  $email = get_post_meta( $post->ID, 'contactemail', true ) ? : get_userdata( $user_id )->user_email;
  $logo = get_user_meta($user_id, 'memberpress_avatar', true) ? : '' ;
  $website = get_user_meta($user_id, 'mepr_company_website', true) ? : '';

  if( $logo ) {
    $logo_url = wp_get_attachment_image_src( $logo, 'full' );
    echo '<div class="logo-wrapper">
            <a href="' . $website . '"><img src="' . $logo_url[0] . '" /></a>
          </div>';
  } else {
    echo '<h3>' . get_user_meta($user_id, 'mepr_company', true) . '</h3>';
  }
  $brand_color = get_user_meta($user_id, 'branding_color1', true ) ? : '#decc82';

  // If the post author hasn't set their company logo, show this alert
  if( ( get_current_user_id() == $user_id ) && !$logo ) { ?>
    <div class="alert">
      <h3><i class="fas fa-exclamation-triangle"></i><?php echo get_userdata( $user_id )->first_name; ?>, Did You Know?</h3>
      <p>You can upload your company Logo to your account page to customize your listings' branding. Go to <a href="/members/account/">Your Account</a> now.</p>
    </div>
  <?php }

  // Let's Gather All our Post Information Now
  $title = get_the_title();
  $type = get_the_terms( $post->ID, 'aircraft' );
  $status = get_the_terms( $post->ID, 'marketstatus' );
  $year = get_post_meta( $post->ID, 'year', true ) ?: '';
  $make = get_post_meta( $post->ID, 'make', true ) ?: '';
  $model = get_post_meta( $post->ID, 'model', true ) ?: '';
  $sn = get_post_meta( $post->ID, 'serialnumber', true ) ?: '';
  $reg = get_post_meta( $post->ID, 'registration', true ) ?: '';
  $lndgs = get_post_meta( $post->ID, 'landings', true ) ?: '';
  $aftt = get_post_meta( $post->ID, 'aftt', true ) ?: 'aftt';
  $aftt_hrs = get_post_meta( $post->ID, 'aftt-number', true ) ?: '';
  $pdf = get_post_meta( get_the_ID(), 'pdf', true);
  $url = get_post_meta( $post->ID, 'url', true ) ?: get_user_meta($user_id, 'mepr_company_website', true);

  ?>

  <div class="title-secondary">
    <h3 class="year"><?php echo $year; ?></h3>
    <h3 class="make"><?php echo $make; ?></h3>
    <h3 class="model"><?php echo $model; ?></h3>
    <br>
    <?php if( $sn ) { echo '<h3 class="sn">' . $sn . '</h3>'; } ?>
    <?php if( $reg ) { echo '<h3 class="reg">' . $reg . '</h3>'; } ?>
  </div>

  <div class="info-summary">
    <p><span class="marketstatus <?php echo $status[0]->slug; ?>">Market Status: </span><?php echo $status[0]->name; ?></p>
    <?php
      if( is_user_logged_in() && can_edit() ) {
        echo '<a href="#" data-postid="' . $post->ID . '" class="edit" data-form="edit-marketstatus-formbox">Change Market Status</a>';
      }
    ?>
    <?php if( $lndgs ) { ?> <p><span class="landings">Landings: </span><?php echo number_format($lndgs); ?></p> <?php } ?>
    <?php if( $aftt_hrs ) { ?> <p><span class="time"><?php echo $aftt . ': </span>' . number_format($aftt_hrs);?> Hours</p> <?php } ?>
    <!--<p><span class="subhead-highlights">Highlights:</span><br><?php //if( has_excerpt() ) { echo get_the_excerpt(); } ?></p> -->
  </div>

  <!-- <div class="info-main">
    <?php // the_content(); ?>
    <?php var_dump( $type ); ?>
  </div> -->

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



  <?php
    if ( $website ) { ?>
      <div class="website">
        <a class="button" href="<?php echo $website; ?>">Go to Website</a>
      </div>
  <?php } ?>

  <div class="info-contact">
    <h3 class="name"><?php echo $name; ?></h3>
    <h3 class="number"><?php echo $phone; ?></h3>
    <h3 class="email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></h3>
  </div>

  <?php
    // Back to Listings. Not sure why I did it this way.
    $posttype = get_post_type( $post->ID );
    $obj = get_post_type_object( $posttype );

    echo '<div class="post-nav">';
      echo '<a href="' . get_post_type_archive_link( $posttype ) . '">Back to ' . $obj->labels->name . '</a>';
    echo '</div>';
  ?>

  <?php

  if( is_user_logged_in() && can_edit() ) {

    echo '<a href="/members/submit-a-listing/" data-postid="' . $post->ID . '" class="edit" data-form="edit-listing-formbox">Edit Listing</a>';

    echo '<a href="#" data-postid="' . $post->ID . '"  class="edit" data-form="upload-featuredimage-formbox">Change Featured Image</a>';

    echo '<a href="#" data-postid="' . $post->ID . '"  class="edit remove" data-form="delete-listing-formbox">Delete</a>';

    include( locate_template( 'template-parts/edit-listings.php', false, false ) );
    wp_enqueue_script( 'editlistings', get_template_directory_uri() . '/js/editlistings.min.js', array('jquery'), '20191125', true);

  } /* End Show if Can Edit */

  ?>

</div>

<?php

  echo '<div class="the-deets">' .
    'Posted on ' . get_the_date( 'l F j, Y' ) .
  '</div>';

?>

<style>
/* BRANDING COLORS */
button, input[type="button"], input[type="reset"], input[type="submit"], a[class*='button'], .featherlight #mc_embed_signup .button {
  background: <?php echo $brand_color; ?>;
  opacity: .75;
}
button:hover, button:active, button:focus, input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus, a[class*='button']:hover, a[class*='button']:active, a[class*='button']:focus, .featherlight #mc_embed_signup .button:hover, .featherlight #mc_embed_signup .button:active, .featherlight #mc_embed_signup .button:focus {
  background: <?php echo $brand_color; ?>;
  opacity: 1;
}
.single-listing .title-secondary h3.sn,
.single-listing .title-secondary h3.sn:after,
.single-listing .title-secondary h3.reg,
.the-deets {
  color: <?php echo $brand_color; ?>;
}
.single-listing .info-summary, .single-listing .info-main {
  border-bottom: 1px solid <?php echo $brand_color; ?>;
}
.single-listing .info-summary {
  border-top: 1px solid <?php echo $brand_color; ?>;
}
.single-listing .info-contact a, .single-listing .info-contact a:link, .single-listing .info-contact a:visited {
  color: <?php echo $brand_color; ?>;
  opacity: .75;
}
.single-listing .info-contact a:hover, .single-listing .info-contact a:active, .single-listing .info-contact a:focus {
  color: <?php echo $brand_color; ?>;
  opacity: 1;
}
.single-listing .hero h1 {
  background: <?php echo $brand_color; ?>;
}
</style>
