<?php
// Set Up and Prep All the Info
$airframe_time = get_post_meta( get_the_ID(), 'airframe_time', true );
$days_mkt = get_post_meta( get_the_ID(), 'days_mkt', true);
$date_listed = get_post_meta( get_the_ID(), 'date_listed', true );
$date_sold = get_post_meta( get_the_ID(), 'date_sold', true );

if( !empty( $date_listed )) {
  $listed = new DateTime( $date_listed );
} else {
  $listed = false;
}
if( !empty( $date_sold )) {
  $sold = new DateTime( $date_sold );
} else {
  $sold = false;
}

$price_ask = get_post_meta( get_the_ID(), 'price_ask', true );
$ask_formatted = false;
$price_sell = get_post_meta( get_the_ID(), 'price_sell', true );
$sell_formatted = false;
$comparator = '';
$fmt = numfmt_create( 'en_US', NumberFormatter::CURRENCY );
$fmt->setTextAttribute( NumberFormatter::CURRENCY_CODE, 'USD');
$fmt->setAttribute( NumberFormatter::FRACTION_DIGITS, 0);
// in place of numfmt_format_currency($fmt,$data,'USD');

if( !empty($price_ask)) {
  $ask_formatted = is_numeric( $price_ask ) ? $fmt->formatCurrency($price_ask, 'USD') : ucwords( $price_ask );
}
if( !empty($price_sell)) {
  $sell_formatted = is_numeric( $price_sell ) ? $fmt->formatCurrency($price_sell, 'USD') : ucwords( $price_sell );
}
if( is_numeric( $price_sell ) && is_numeric( $price_ask ) ) {
  if( $price_ask > $price_sell ) {
    // this is the normal thing, do nothing
    $comparator = 'biz';
  } elseif( $price_ask < $price_sell ) {
    //wha?
    $comparator = 'dang';
  } elseif ( $price_ask == $price_sell ) {
    //the same!
    $comparator = 'same';
  }
}

// Now Generate the Actual Thing
?>
<li data-comp="<?php echo get_the_ID(); ?>">
  <div class="comp_column_1">
    <?php echo '<a href="#" class="comp_inspect" id="' . get_the_ID() . '">'; ?>
    <?php echo ucwords( get_post_meta( get_the_ID(), 'year_mfr', true ) . ' ' . get_post_meta( get_the_ID(), 'model', true )); ?>
    <?php echo '</a>'; ?>
  </div>
  <div class="comp_column_2">
    <?php echo $airframe_time ? $airframe_time : '<span class="empty"></span>'; ?>
  </div>
  <div class="comp_column_3">
    <?php
      if( !empty( $days_mkt )) {
        echo $days_mkt;
      } elseif ($listed && $sold) {
        $interval = $listed->diff($sold);
        $days_mkt = $interval->days;
        echo $days_mkt;
        // let's update this so we don't have to go through this again
        $update = update_post_meta( get_the_ID(), 'days_mkt', $days_mkt );
        echo '<!-- UPDATED DAYS ON MARKET: ' . $update . '-->';
      } else {
        echo '<span class="empty"></span>';
      }
    ?>
  </div>
  <div class="comp_column_4">
    <?php echo $thedate = $sold ? date_format( $sold, 'M j, \'y' ) : '<span class="empty"></span>'; ?>
  </div>
  <div class="comp_column_5">
    <?php echo $ask_formatted ? $ask_formatted : '<span class="empty"></span>';
          echo '<span class="comparator '. $comparator . '"></span>'; ?>
  </div>
  <div class="comp_column_6">
    <?php echo $sell_formatted ? $sell_formatted : '<span class="empty"></span>'; ?>
  </div>
</li>
