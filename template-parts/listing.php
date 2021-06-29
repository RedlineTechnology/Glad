<?php
// Set up Some Variables

$url = get_post_meta( $post->ID, 'url', true ) ?: false;
$pdf = get_post_meta( $post->ID, 'pdf', true ) ?: false;
$sn = get_post_meta( $post->ID, 'serialnumber', true ) ? : '';
$reg = get_post_meta( $post->ID, 'registration', true ) ? : '';
$landings = get_post_meta( $post->ID, 'landings', true ) ?: false;
$time = get_post_meta( $post->ID, 'aftt-number', true ) ?: false;
$status = get_the_terms( $post->ID, 'marketstatus' );
$new = strtotime(get_the_date()) < strtotime('-1 week') ? false : true;


$user_id = get_the_author_meta('ID');
$user = get_userdata($user_id);

$name = get_post_meta( $post->ID, 'contactname', true ) ?: $user->first_name . ' ' . $user->last_name;
$phone = get_post_meta( $post->ID, 'contactnumber', true ) ?: get_user_meta( $user_id, 'mepr_phone_number', true );
$email = get_post_meta( $post->ID, 'contactemail', true ) ?: $user->user_email;

$company = get_user_meta( $user_id, 'mepr_company', true ) ?: false;
$website = get_user_meta( $user_id, 'mepr_company_website', true) ?: false;
$website_stripped = preg_replace('#^https?://#', '', rtrim($website,'/'));
$logo = get_company_logo( $user_id );

?>

<div class="status <?php echo $new ? 'new' : $status[0]->slug; ?>">
  <h3><?php echo $new ? 'new!' : $status[0]->name; ?></h3>
</div>
<div class="listing-upper" style="background-image:url('<?php echo get_the_post_thumbnail_url($post->ID, 'medium-large'); ?>');">
  <div class="info">
    <a class="plane" href="#<?php //echo get_permalink(); ?>">
      <h3 class="title"><?php echo get_post_meta( $post->ID, 'year', true ) . ' ' . get_post_meta( $post->ID, 'make', true ) . ' ' . get_post_meta( $post->ID, 'model', true ); ?></h3> <?php
      if( $sn || $reg ) {
        echo '<p class="snreg">';
          if ( $sn ) { echo '<span>SN: ' . $sn . '</span> '; }
          if ( $reg ) { echo '<span>REG: ' . $reg . '</span>'; }
        echo '</p>';
      }
      if( $landings || $time ) {
        echo '<p class="time">';
          if( $landings ) {
            echo '<span class="landings"> ' . number_format($landings) . ' Landings</span>';
          }
          if( $time ) {
            echo '<span class="hours">' . number_format($time) . ' Hrs ' . strtoupper( get_post_meta( $post->ID, 'aftt', true )) . '</span>';
          }
        echo '</p>';
      } ?>
    </a> <?php
    if ( $url ) {
      echo '<a class="jump" href="' . $url . '" target="_blank"><i class="fas fa-link"></i></a>';
    }
    if ( $pdf ) {
      $pdfurl = wp_get_attachment_url( $pdf ) ?: $pdf;
      echo '<a class="jump" href="' . $pdfurl . '" target="_blank"><i class="fas fa-file-pdf"></i></a>';
    } ?>
  </div>
</div>
<div class="listing-lower">
  <div class="little">
    <h4><span class="name"><?php echo $name . ', '; ?></span><span class="company"><?php echo $company; ?></span></h4>
    <a href="mailto:<?php echo $email; ?>"><i class="far fa-envelope"></i></a>
    <a href="tel:<?php echo $phone; ?>"><i class="far fa-mobile"></i></a>
  </div>
  <div class="big">
    <?php // echo '<a href="' . $website . '" class="logo" style="background-image: url(' . $logo . ')"></a>'; ?>
    <a href="mailto:<?php echo $email; ?>"><i class="far fa-envelope"></i> <?php echo ' ' . $email; ?></a>
    <a href="tel:<?php echo $phone; ?>"><i class="far fa-mobile"></i> <?php echo ' ' . formatPhoneNumber( $phone ); ?></a>
    <?php if( $website ) {
      echo '<a href="' . $website . '">' . $website_stripped . '</a>';
    } ?>
  </div>
</div>
