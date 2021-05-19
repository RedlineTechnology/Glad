<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */

get_header();

$current_user = wp_get_current_user();
$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-members.jpg'; ?>

	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
		<img id="members-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/members.png">
		<a class="button" href="/login">Log in</a>
		<div class="membership-box"></div>
	</section>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

			<section class="content">
				<?php

				if( current_user_can('mepr-active','membership:19,232,580,588,1268,1499,1307') || current_user_can('mepr-active','membership:1416') ): //dealers only? + free trial
					echo '<div class="alerts-sidebar">';
						get_template_part('template-parts/alerts');
					echo '</div>';
				endif;

				echo '<div class="the-content">';

          if( current_user_can('mepr-active','rule:37') ):
						echo '<!-- User is a Member -->';
            // For All Members

            /////////////////////////////

            // First Get the Author IDs (posts authored by user or owner)
            $icanhaz = icanhaz();
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

          	if( current_user_can('mepr-active','membership:19,232,580,588,1268,1499,1307') || current_user_can('mepr-active','membership:1416') ): ?>
						<section class="mylistings manage" id="mylistings">
							<h3>My Listings</h3>
							<div class="listings">
								<div class="mypost_wrapper">

									<?php
									// Display Active Listings. New Query excluding Deleted Posts
									$args = array(
										'post_type'			=> 'listing',
										'author__in'    =>  $icanhaz,
										'orderby'       =>  'date',
										'order'         =>  'ASC',
										'nopaging'			=> 	true,
										'tag__not_in'   => array('29'),
										'tax_query'			=> array( array(
											'taxonomy' => 'marketstatus',
											'terms' => array('sold'),
											'field' => 'slug',
											'operator' => 'NOT IN'
										))
									);
									$listing_query = new WP_Query( $args );

									if( $listing_query->have_posts() ) :
										while( $listing_query->have_posts() ): $listing_query->the_post();

											$marketstatus = get_the_terms( $post->ID, 'marketstatus');
											$title = get_post_meta( get_the_ID(), 'year', true ) . ' ' . get_post_meta( get_the_ID(), 'model', true );
											$sr = get_post_meta( get_the_ID(), 'serialnumber', true ) ?: '';
											$background = "url('" . get_stylesheet_directory_uri() . "/images/gradient.png') left top/1px 170px repeat-x, url('" . get_the_post_thumbnail_url($post->ID, 'medium') . "') center/cover no-repeat";

											echo '<div class="mypost ' . $marketstatus[0]->slug . '" data-post="' . $post->ID . '" style="background: ' . $background . '" data-form="edit-marketstatus-formbox" href="' . get_permalink() . '">';
												echo '<h6>' . $title . '<br>' . $sr . '</h6>';
												echo '<p>' . the_modified_date( 'n/j/y', 'last updated ', '', false ) . '</p>';
												echo '<a href="' . get_permalink() . '" data-postid="' . $post->ID . '" class="delete" data-form="delete-listing-formbox"></a>';
												echo '<a href="' . get_permalink() . '" data-postid="' . $post->ID . '" class="edit button" data-form="edit-listing-formbox">edit listing</a>';
											echo '</div>';

										endwhile;
									endif;
									?>

									<div id="addnew_listings" class="mypost addnew">
										<a href="/members/submit-a-listing/"><i class="fas fa-plus-circle"></i></a>
									</div>

								</div>

							</div>
						</section>
            <?php endif; ?>

						<?php if( current_user_can('mepr-active','rule:37') ) :
							// ALL MEMBERS - OPPORTUNITIES ?>
							<section class="myservices manage" id="myservices">
								<h3>My Services<?php if( current_user_can('mepr-active','membership:19,232,580,588,1268,1499,1307') ) { echo '<span><a href="' . bp_loggedin_user_domain() . 'profile/edit/group/2/">edit services list</a></span>'; }?></h3>
								<div class="services">
									<h4>Industry: <span><?php echo get_user_meta( $current_user->ID, 'mepr_industry_type', true ); ?></span></h4>
									<h4>Services: <span><?php echo implode(', ', array_keys( get_user_meta( $current_user->ID, 'mepr_services', true ) )); ?></span></h4>

									<div class="mypost_wrapper">

										<?php
										// Display Active Opportunities. New Query excluding Deleted Posts
										$args = array(
											'post_type'			=> 'opportunity',
											'author__in'    =>  $icanhaz,
											'orderby'       =>  'date',
											'order'         =>  'ASC',
											'nopaging'			=> 	true,
											'tag__not_in'   => array('29')
										);
										$opp_query = new WP_Query( $args );

										if( $opp_query->have_posts() ) :
											while( $opp_query->have_posts() ): $opp_query->the_post();

												// probably template part, but for now:

												echo '<div class="mypost" data-post="' . $post->ID . '">';
													echo '<h6>' . get_the_title() . '</h6>';
													echo '<p>' . the_modified_date( 'n/j/y', 'last updated ', '', false ) . '</p>';
													echo '<a href="' . get_permalink() . '" data-postid="' . $post->ID . '" class="delete" data-form="delete-listing-formbox"></a>';
													echo '<a href="' . get_permalink() . '" data-postid="' . $post->ID . '" class="edit button" data-form="edit-listing-formbox">edit post</a>';
												echo '</div>';

											endwhile;
										endif;
										?>

										<div id="addnew_services" class="mypost addnew">
											<a href="/members/submit-opportunity/"><i class="fas fa-plus-circle"></i></a>
										</div>

									</div>

								</div>
							</section>
						<?php endif; ?>

            <!-- Here's where the Magic Happens -->
            <div class="edit-forms formbox"></div>

            <?php
            // COMPS for Dealers
            if( current_user_can('mepr-active','membership:19,232,580,588,1268,1499,1307') || current_user_can('mepr-active','membership:1416') ): ?>

              <div class="comps-wrapper">
                <a class="addnew" href="/members/add-comp/">Add New</a>
                <div class="table-wrapper">
                  <h3 class="section-title">Comps</h3>
                  <?php

                  // Display Active Ops. New Query excluding Deleted Posts
                  $args = array(
                    'post_type'				=> 'comp',
                    'orderby'       	=> 'date',
                    'order'         	=> 'ASC',
                    'posts_per_page' 	=> 10,
                    'tag__not_in'   	=> array('29')
                  );
                  $comp_query = new WP_Query( $args );

                  if( $comp_query->have_posts() ) {
                    echo '<ul id="comps_table">';
                      echo '<li class="comp_column_header">
                        <div class="comp_column_1"><a href="#" class="sort_heading active" id="model" data-sort="asc">Year/Model</a></div>
                        <div class="comp_column_2"><a href="#" class="sort_heading active" id="airframe_time" data-sort="asc">Hours</a></div>
                        <div class="comp_column_3"><a href="#" class="sort_heading active" id="days_mkt" data-sort="asc">Days on Mkt</a></div>
                        <div class="comp_column_4"><a href="#" class="sort_heading active" id="date_sold" data-sort="asc">Date Sold</a></div>
                        <div class="comp_column_5"><a href="#" class="sort_heading active" id="price_ask" data-sort="asc">Asking Price</a></div>
                        <div class="comp_column_6"><a href="#" class="sort_heading active" id="price_sell" data-sort="asc">Selling Price</a></div>
                        </li>';


                        while( $comp_query->have_posts() ): $comp_query->the_post();
                          get_template_part('template-parts/comp');
                        endwhile;

                    echo '</ul>';
                  } else {
                    echo '<p>There has been an error retrieving this data. Please try again later.</p>';
                  }

                  ?>
                </div>
                <div class="paginate">
                    <a href="#" class="comp_paginate" id="prev" data-page="1">prev</a>
                    <a href="#" class="comp_paginate" id="next" data-page="1">next</a>
                </div>
              </div>

              <div class="fullcomp-wrapper">
                <div id="fullcomp">

                </div>
              </div>

              <?php wp_enqueue_script( 'comps', get_template_directory_uri() . '/js/comps.min.js', array('jquery'), '20210217', true);

            endif; // Comps
            ?>

            <!-- <div class="morelinks calendar">
              <h3 class="section-title">Comps</h3>
              <p>Watch this <a href="#" class="compsvideo" data-featherlight="#compsvideo">How-to Walkthrough</a> of Adding a GLADA Member Comp</p>
              <div class="featherlight" id="compsvideo">
                <video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
                  <source src="https://www.glada.aero/assets/meetings/glada_comps.mp4" type="video/mp4">
                  Your browser does not support the HTML5 video tag.
                </video>
              </div>
              <a class="button-sm" target="_blank" href="https://survey.jetadvisors.com/ResearchingTool/GLADACustomerSurvey.aspx?notracking=true">Add a Comp</a>
            </div> -->

            <div class="morelinks calendar">
              <h3 class="section-title">Events</h3>
              <?php echo do_shortcode('[add_eventon_list number_of_months="12" event_count="4" hide_past="yes" ux_val="3" hide_empty_months="yes" ft_event_priority="yes" tiles="no" hide_month_headers="yes" tile_height="400" ]'); ?>
            </div>

            <?php if( current_user_can( 'manage_options' ) || !current_user_can('mepr-active','membership:1416') ): ?>

              <div class="morelinks memberlogo">
                <h3 class="section-title">Membership Logo</h3>
                <p>Re-download the GLADA Membership Logo: <a href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_sm.png'; ?>">Small</a> -
                  <a href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_UseOnLight.png'; ?>"> Large</a> -
                  <a href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_UseOnDark.png'; ?>"> Inverted</a> -
                  <a href="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_Member_Logos.zip'; ?>"> Download All</a></p>
              </div>

              <?php if( !$testimonials ) { ?>
                <div class="testimonialform">
                  <p>Have a GLADA success story? We'd love to hear it!</p>
                  <?php echo do_shortcode('[wpforms id="919"]'); ?>
                </div>
              <?php }

            endif; // Not Trial Members

          elseif( current_user_can('mepr-active','membership:157') && !(current_user_can('mepr-active','rule:37')) ):
						echo '<!-- User is an Applicant -->';
            // For Applicants

            $roles = $current_user->roles;
            $meta = get_user_meta( $current_user->ID );
            $membership = $meta['mepr_membership_type'][0];
            echo '<!-- membership type: '; var_dump( $membership ); echo '-->';
            if( !in_array('applicant', $roles) || $membership == 'industry') {

              $url = 'memberships/' . $membership . '-member/';
              ?>

              <div class="approved">
                <h3>Congratulations, <?php echo $current_user->user_firstname; ?>!</h3>
                <p>Your <?php echo ucfirst($membership); ?> Member application has been approved. To submit a payment and complete your Membership, <a href="/<?php echo $url; ?>"> Click Here </a>.</p>
              </div>

            <?php } else { ?>

              <div class="under-review">
                <h3>Hi, <?php echo $current_user->user_firstname; ?></h3>
                <p>Thank you for submitting an Application.  The Board will review your application and respond to you within 7 business days.</p>
                <a class="button" href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a>
              </div>

            <?php }

          elseif( is_user_logged_in() ):
            // For Non-Members who are Logged in
						echo '<!-- User is not a Member and not an Applicant, but they are Logged in -->';

            $userMeta = get_user_meta( $current_user->ID );
            $userObj = get_userdata( $current_user->ID );

            $logo = bp_attachments_get_attachment( 'url', array( 'item_id' => $current_user->ID ) );

            $member = new MeprUser( $current_user->ID );
            $sub_ids    = $member->current_and_prior_subscriptions();
            $activesubs = $member->active_product_subscriptions('ids');

            echo '<div class="reactivate-wrapper">
              <div class="reactivate">
                <img class="reactivate-glada" src="' . get_stylesheet_directory_uri() . '/images/GLADA_logo_sm.png' . '" />' . '<span>+</span>' . '<img class="reactivate-logo" src="' . $logo . '" />
              </div>';

              if( in_array('1269', $activesubs )) {
                // Referral
                $m = $userMeta['mepr_membership_type'][0];
                echo '<div>
                  <h1>Hi, ' . $userMeta['first_name'][0] . '</h1>
                  <h4>Congratulations on getting that Referral Discount!</h4>
                  <p>To apply your discount, choose a membership type below.</p>
                  <a class="dark button" href="/memberships/' . $m . '-member-20/">Pay a Full Year</a>
                  <p style="margin:0;">OR</p>
                  <a class="dark button" href="/memberships/' . $m . '-member-quarterly-20/">Pay Quarterly</a>';
                echo '</div>';
              }

              if( empty( $activesubs )) {

                // Was this a Free Trial?
                if( in_array( $sub_ids, '1416' ) ) {
                  echo '<div>
                    <h1>Thank You, ' . $userMeta['first_name'][0] . '</h1>
                    <h4>Your <strong>Free Trial</strong> has ended.</h4>
                    <p>We hope you were able to get a glimpse at the kinds of things you\'ll be able to do as a part of GLADA! As a Dealer or Industry Member, you can get access to all these benefits and more:</p>';
                    echo '<ul>
                      <li>Post Aircraft to GLADA\'s Public and Emailed Listings</li>
                      <li>Send and Receive Alerts about Off-Market and Wanted Aircraft with other Members</li>
                      <li>Search and View Members\' Comps for Bleeding-Edge Market Analysis</li>
                      <li>Vast Networking Opportunities</li>
                      <li>Industry Service Discounts</li>
                      <li>Member Committees to Help Shape the Future of our Industry</li>
                      <li>And More!</li>
                    </ul>';
                    echo '<p>The Global Licensed Aircraft Dealers Association is For the Members, By the Members. Where Industry Meets Integrity.</p>';
                    echo '<div>
                      <a href="/memberships/membership-application/" data-memb="industry" class="reg button">Become an Industry Member</a>
                      <p>or</p>
                      <a href="/memberships/membership-application/" data-memb="dealer" class="reg button">Submit a Dealer Application</a>
                    </div>';
                  echo '</div>';
                } else {
                  // Not a Free Trial. Simply a Lapsed Membership.
                  $m = $userMeta['mepr_membership_type'][0];
									echo '<!--';
									var_dump( $userMeta );
									echo '-->';
                  echo '<div>
                    <h1>Hi, ' . $userMeta['first_name'][0] . '</h1>
                    <h4>Your <strong>' . ucwords( $m ) . ' Membership</strong> has expired.</h4>
                    <p>To manage your membership, click the link below.</p>
                    <a class="dark button" href="' . bp_loggedin_user_domain() . 'mp-membership/mp-subscriptions/" id="mepr-account-subscriptions">Account Settings</a></span>
                    <p style="margin:0;">OR</p>
                    <p><a href="/memberships/' . $m . '-member/">Set up a new Yearly ' . ucwords( $m ) . ' Membership.</a>  |  <a href="/memberships/' . $m . '-member-quarterly/">Set up a new Quarterly ' . ucwords( $m ) . ' Membership.</a></p>';
                  echo '</div>';
                }

              } else { echo "We've encountered an unexpected problem with your Membership. Please contact support."; }

            echo '</div>';

            //
            // global $waApiClient;
            // global $accountUrl;
            // $url = $accountUrl . '/contacts/' . $wa_ID . '?getExtendedMembershipInfo=true';
            // $contact = $waApiClient->makeRequest($url);
            //
            // $membership = 						$contact['MembershipLevel']['Id'];
            // $enabled = 								$contact['MembershipEnabled'];
            // $extendedMembershipInfo = $contact['ExtendedMembershipInfo'];
            //
            //
            //
            // if( !$enabled ) {
            // 	foreach( $contact['FieldValues'] as $fieldArray ) {
            // 		switch( $fieldArray['SystemCode'] ) {
            //
            // 			case 'IsMember' :
            // 				$member = $fieldArray['Value'];
            // 				break;
            //
            // 			case 'IsSuspendedMember' :
            // 				$suspended = $fieldArray['Value'];
            // 				break;
            //
            // 			case 'RenewalDue' :
            // 				$renewal = $fieldArray['Value'];
            // 				break;
            //
            // 		}
            // 	}
            // }

          else:
            // For Non-Members
						echo '<!-- User is Not Logged in -->';

            echo '<h3 class="section-title">Membership Benefits and Services</h3>';
            echo '<div class="becomeamember">';
              echo '<div class="dealermember">';
                echo '<h3>Dealer Member</h3>';
                echo '<p>This Membership is tailored to Aircraft Dealers. See and Submit Members\' Off-Market Listings, Members\' Wanted Aircraft, Submit Aircraft listings and refer clients directly to GLADA\'s Hosted Listings Page, receive Industry Service Discounts, Network with Peers, and more.</p>
                <ul>
                  <li>Member Listings</li>
                  <li>Member Only Comps</li>
                  <li>GLADA Library with standardized forms and Industry Documents</li>
                  <li>Networking Opportunities</li>
                  <li>Get Email and Text Alerts on Members\'s Off-Market and Wanted Aircraft</li>
                  <li>GLADA Members\' Listings Sent to Retail Buyers</li>
                  <li>Industry Service Discounts</li>
                  <li>GLADA Events</li>
                  <li>Member Committees</li>
                </ul>';
                echo '<a href="/memberships/membership-application/" data-memb="dealer" class="reg button">Submit a Dealer Application</a>';
              echo '</div>';
              echo '<div style="margin-top:2em;" class="industrymember">';
                echo '<h3>Industry Member</h3>';
                echo '<p>Choose this Membership if you are an Industry professional.</p>
                <ul>
                  <li>View Dealer Member listings</li>
                  <li>Networking and Marketing opportunities</li>
                  <li>Member Email and Text Alerts</li>
                  <li>GLADA Events</li>
                  <li>Member Committees</li>
                </ul>';
                echo '<a href="/memberships/membership-application/" data-memb="industry" class="reg button">Submit an Industry Application</a>';
              echo '</div>';
            echo '</div>'; ?>

            <script>
              jQuery(document).ready(function($){
                $.ajaxSetup({cache:false});
                // We're gonna pre-select the proper membership once the form loads
                $( document ).ajaxComplete( function( event, xhr, settings ) {
                  var $membership = event.target.activeElement.attributes[1].nodeValue;
                  $('select[name="mepr_membership_type"]').val( $membership );
                });
                // Load the form!
                $(".reg").click(function(e){
                    e.preventDefault();
                    var $membershipClass = 'open-' + $(this).data( "memb" );
                    var $post_link = $(this).attr("href") + ' .the-content';

                    $('.hero').addClass('open');
                    $('.hero #members-img, .hero > .button').css( "display", "none");
                    $('.membership-box').attr('class', function(i, c){
                        return c.replace(/(^|\s)open-\S+/g, '');
                    });
                    $('.membership-box').addClass( $membershipClass );

                    $('.membership-box').html("<p>loading...<br></p><img style='width:25px;height:25px;margin:2em auto;' src='/wp-content/themes/Glad/images/ajax-loader.gif'>");
                    $('.membership-box').load( $post_link );
                    $('html, body').animate({
                        scrollTop: ($('.membership-box').offset().top)
                    },500);

                  return false;
                });
              });
            </script>

          <?php
          endif;

					wp_reset_query();

				echo '</div>';
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

wp_enqueue_script( 'editlistings', get_template_directory_uri() . '/js/editlistings.min.js', array('jquery'), '20201205', true);

get_footer();
