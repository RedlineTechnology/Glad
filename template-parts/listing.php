<div class="left">
  <a href="<?php echo get_permalink(); ?>">
    <div class="thumb" style="background-image:url('<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>');"></div>
    <div class="info"><?php
      $sn = get_post_meta( $post->ID, 'serialnumber', true ) ? : '';
      $reg = get_post_meta( $post->ID, 'registration', true ) ? : '';
      if( $sn || $reg ) {
        ?> <p class="snreg"> <?php
        if ( $sn ) { echo '<span>SN: ' . $sn . '</span> '; }
        if ( $reg ) { echo '<span>' . $reg . '</span>'; }
        ?> </p> <?php
      } ?>
    </div>
  </a>
</div>
<div class="right">
  <h3 class="title"><?php echo get_post_meta( $post->ID, 'year', true ) . ' ' . get_post_meta( $post->ID, 'make', true ) . ' ' . get_post_meta( $post->ID, 'model', true ); ?></h3>
  <?php
  $landings = get_post_meta( $post->ID, 'landings', true ) ? : '';
  $aftt = get_post_meta( $post->ID, 'aftt', true ) ? : '';
  $aftt_number = get_post_meta( $post->ID, 'aftt-number', true ) ? : '';

  echo '<p>';
  if( $landings ) { echo '<span class="landings"> ' . number_format($landings) . ' Landings</span>'; }
  if( $aftt || $aftt_number ) { echo '<span class="time"> ' . number_format($aftt_number) . ' Hrs</span>'; }
  if ( get_post_meta( get_the_ID(), 'pdf', true) ) {
    $pdfurl = wp_get_attachment_url( get_post_meta( get_the_ID(), 'pdf', true ) ) ? : get_post_meta( get_the_ID(), 'pdf', true );
    echo '<span class="specsheet"><a href="' . $pdfurl . '" target="_blank">Specsheet</a></span>';
  } else {
    echo '<span class="moreinfo"><a href="' . get_permalink() . '">More Info</a></span>';
  }
  echo '</p>';

  $user_id = get_the_author_meta('ID');
  $name = get_post_meta( $post->ID, 'contactname', true ) ? : get_userdata($user_id)->first_name . ' ' . get_userdata($user_id)->last_name;
  $phone = get_post_meta( $post->ID, 'contactnumber', true ) ? : get_user_meta( $user_id, 'mepr_phone_number', true );
  $email = get_post_meta( $post->ID, 'contactemail', true ) ? : get_userdata( $user_id )->user_email;

  ?>

  <div class="contact-wrapper">
    <p class="contact">
      <span class="name"><?php echo $name . ' // '; ?></span>
      <span class="number"><?php echo $phone . ' // '; ?></span>
      <span class="email"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></span>
    </p>

    <?php
    $user_id = get_the_author_meta('ID');
    $website = get_user_meta($user_id, 'mepr_company_website', true) ? : get_permalink();
    $logo = get_user_meta($user_id, 'memberpress_avatar', true) ? : '' ;
    $newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $user_id ) );

    if ( $newlogo ) {
      echo '<a href="' . $website . '" class="logo" style="background-image: url(' . $newlogo . ')"></a>';
    } elseif ( $logo ) {
      $logo_url = wp_get_attachment_image_src( $logo, 'full' );
      echo '<a href="' . $website . '" class="logo" style="background-image: url(' . $logo_url[0] . ')"></a>';
    } ?>

  </div>

</div>
