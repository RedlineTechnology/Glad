<?php

// First Get the Author IDs (posts authored by user or owner)
$icanhaz = icanhaz();

// CHECK FOR NEXT STEPS COMPLETION:
$step1 = get_user_meta($current_user->ID, 'achievementget', true);
$step2 = get_user_meta($current_user->ID, 'memberpress_avatar', true);

// Check to see if we've authored anything
$args = array(
  'post_type'			=> 'listing',
  'author__in'    =>  $icanhaz,
  'orderby'       =>  'date',
  'order'         =>  'ASC',
  'nopaging'			=> 	true
);
$listing_query = new WP_Query( $args );
$listings = $listing_query->found_posts;

// Have we created an Opportunity?
$args = array(
  'post_type'			=> 'opportunity',
  'author__in'    =>  $icanhaz,
  'orderby'       =>  'date',
  'order'         =>  'ASC',
  'nopaging'			=> 	true
);
$opportunity_query = new WP_Query( $args );
$opportunities = $opportunity_query->found_posts;

// Have we submitted a Testimonial?
$args = array(
  'post_type'			=> 'testimonials',
  'author__in'    =>  $icanhaz
);
$test_query = new WP_Query( $args );
$testimonials = $test_query->found_posts;

if( $step1 && $step2 && $listings && $opportunities ) {
  // All Next Steps Have Been Completed
  echo '<!-- ALL STEPS COMPLETE! -->';
} else {
  ?>
  <div class="nextsteps">
    <div class="intro">
      <h3>Next Steps</h3>
      <p>Welcome to GLADA! Now that you're a trusted member, a new world of possibility has just opened up! Here are your next steps to get the most out of your membership.</p>
    </div>

    <?php // EVERYONE GETS THIS ONE
    if( empty( $step1 ) ) { ?>
      <div class="step1">
        <form id="memberlogo" data-href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_sm.png'; ?>">
          <input type="hidden" name="action" value="achievementget">
          <input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>">
          <button id="memberlogo-submit" value="achievementget">Download the Member Logo</button>
        </form>
        <h6><a id="memberlogolink" target="_blank" href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_Logos.zip'; ?>">Download the Member Logo</a></h6>
        <p>You can add the GLADA Member Logo to your website or other publications to show others that you are a trusted GLADA Member.</p>
      </div>
    <?php } else {
      echo '<div class="stepcomplete"><h6>Download the Member Logo</h6></div>';
    }

    // DEALER MEMBER NEXT STEPS - 2, 3, and 4
    if( current_user_can('mepr-active','membership:19,232,580,588') ):

      if( empty( $step2 ) ) { ?>
        <div class="step2">
          <h6><a href="/members/account/">Upload Your Logo</a></h6>
          <p>Upload your Company's Logo to <a href="/members/account/">your Account page</a>. It will be displayed with every Listing you post and featured alongside other trusted organizations.</p>
        </div>
      <?php } else {
        echo '<div class="stepcomplete"><h6>Upload Your Logo</h6></div>';
      }

      if( !$listings ) { ?>
        <div class="step3">
          <h6><a href="/members/submit-a-listing/">Create a Listing on the GLADA Listings page.</a></h6>
          <p>When your Aircraft is posted here, others will know it's safe to do business with you.</p>
        </div>
      <?php } else {
         echo '<div class="stepcomplete"><h6>Create a Listing</h6></div>';
      }

      if( !$opportunities ) { ?>
        <div class="step4">
          <h6><a href="/members/submit-opportunity/">What's an Opportunity?</a></h6>
          <p>Opportunity listings can only be seen by other GLADA members. Here's where you can post Aircraft Wanted, List Off-Market aircraft, or offer incentives for your services exclusively to other GLADA members. <a href="/members/submit-opportunity/">Add your first opportunity.</a></p>
        </div>
      <?php } else {
        echo '<div class="stepcomplete"><h6>Create an Opportunity</h6></div>';
      }

    else:
      // INDUSTRY MEMBER VARIANT STEP #2 and #4
      if( empty( $step2 ) ) { ?>
        <div class="step2">
          <h6><a href="/members/account/">Upload Your Logo</a></h6>
          <p>Upload your Company's Logo to <a href="/members/account/">your Account page</a>. It will be displayed alongside other trusted organizations.</p>
        </div>
      <?php }

      if( !$opportunities ) { ?>
        <div class="step4">
          <h6><a href="/members/submit-opportunity/">What's an Opportunity?</a></h6>
          <p>Opportunity listings can only be seen by other GLADA members. Here's where you can offer incentives for your services exclusively to other GLADA members. <a href="/members/submit-opportunity/">Add your first opportunity.</a></p>
        </div>
      <?php } else {
        echo '<div class="stepcomplete"><h6>Create an Opportunity</h6></div>';
      }
    endif; ?>
  </div> <?php

} // End Steps

?>

<script>
 jQuery(document).ready(function($){
    $.ajaxSetup({cache:false});

    // Next Steps
    $('#memberlogolink').click(function(e) {
      e.preventDefault();
      $('#memberlogo').submit();
      $('.step1').fadeOut();
    });

    $('#memberlogo').submit( function() {
      $.ajax({
          url: 'https://glada.aero/wp-admin/admin-ajax.php',
          type: 'POST',
          data: $('#memberlogo :input').serialize(),
          dataType: 'json',
          beforeSend: function( xhr ) { },
          success: function( data ) { }
      });

      $url = $('#memberlogo').data('href');
      window.open( $url );

      return false;
    });

  });
</script>
