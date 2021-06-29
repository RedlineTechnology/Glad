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

				// Alerts Sidebar
				if( is_member(true) ):

					echo '<div class="alerts-sidebar">';
						get_template_part('template-parts/alerts');
					echo '</div>';

				endif;

				// Main Content
				echo '<div class="the-content">';

					// LOGGED IN PEEPS
					if( is_user_logged_in() ) :

						// instanciate things we'll want for logged-in users
						$current_user = wp_get_current_user();
						$userMeta = get_user_meta( $current_user->ID );
						$userObj = get_userdata( $current_user->ID );

						$roles = $current_user->roles;
						$m = $userMeta['mepr_membership_type'][0];

						$firstname = $current_user->user_firstname ?: $userMeta['first_name'][0];
						$company = $userMeta['mepr_company'][0];

						$account = 'Personal';
						$subaccount = get_user_meta( $current_user->ID, 'mpca_corporate_account_id', true ) ?: false;
						if( $subaccount ) {
							$account = 'Child';
							$corpaccount = MPCA_Corporate_Account::get_one( $subaccount );
							$parent = $corpaccount->user_id;
						}
						$corporate = MPCA_Corporate_Account::get_all_by_user_id( $current_user->ID );
						if( $corporate ) {
							$account = 'Corporate';
							$ca_obj = new MPCA_Corporate_Account();
					    $ca_obj->load_from_array($corporate[0]);

							$subaccounts = $ca_obj->sub_users();
							$sub_ids = array();
							foreach( $subaccounts as $user ) {
								$sub_ids[] = $user->ID;
							}
						}

						// MAIN GROUPS - MEMBERS
	          if( is_member(true) ):

	            // First Get the Author IDs (posts authored by user or owner)
	            $icanhaz = icanhaz();
	            // Check to see if we've authored anything
	            $args = array(
	              'post_type'			=> 'listing',
	              'author__in'    => $icanhaz,
	              'orderby'       => 'date',
	              'order'         => 'ASC',
	              'nopaging'			=> true,
								'tag__not_in'   => array('29')
	            );
	            $listing_query = new WP_Query( $args );
	            $listings = $listing_query->found_posts ?: 0;

	            // Have we created an Opportunity?
	            $args = array(
	              'post_type'			=> 'opportunity',
	              'author__in'    => $icanhaz,
	              'orderby'       => 'date',
	              'order'         => 'ASC',
	              'nopaging'			=> true,
								'tag__not_in'   => array('29')
	            );
	            $opportunity_query = new WP_Query( $args );
	            $opportunities = $opportunity_query->found_posts ?: 0;

	            // Have we submitted a Testimonial?
	            $args = array(
	              'post_type'			=> 'testimonials',
	              'author__in'    => $icanhaz
	            );
	            $test_query = new WP_Query( $args );
	            $testimonials = $test_query->found_posts ?: 0;

							// We only need these for the dealer summary since we're running bigger queries below. Don't do too much.
							if( is_dealer() ) {
								// Do we have any Comps?
								$args = array(
									'post_type'				=> 'comp',
									'author__in'    	=> $icanhaz,
									'tag__not_in'   	=> array('29')
								);
								$comp_query = new WP_Query( $args );
								$comps = $comp_query->found_posts ?: 0;

								// Do we have any Alerts?
								$args = array(
									'post_type'				=> 'alert',
									'author__in'    	=> $icanhaz
								);
								$alert_query = new WP_Query( $args );
								$alerts = $alert_query->found_posts ?: 0;
							}

							// secondary -- My Profile -- Account Summary ?>
							<section class="myprofile manage" id="myprofile">
								<h3>Hi, <?php echo $firstname . '<span><a href="' . bp_loggedin_user_domain() . 'profile/edit/">edit profile</a></span>'; ?></h3>
								<h4><span><?php echo ucwords($m) . ' Member, ' . $account . ' Account</span>' . ' for ' . $company; ?><a href="/members/member-map"><i class="fas fa-map"></i></a></h4>
								<?php
								if( $subaccount ) {
									echo '<p>Parent Account: ' . get_user_meta( $parent, 'nickname', true ) . '</p>';
								}
								if( $corporate ) {
									echo '<p>Child Account(s): ';
									$string = implode(', ', array_map( function($id) {
										return get_user_meta( $id, 'nickname', true );
									}, $sub_ids ));
									echo $string . '</p>';
								}
								?>
								<div class="bubbles">
									<ul>
										<?php if ( is_dealer() ) { echo '<li><span>' . $listings . '</span> Aircraft</li>'; } ?>
										<li><span><?php echo $opportunities; ?></span> Service Ads</li>
										<?php if ( is_dealer() ) {
											echo '<li><span>' . $comps . '</span> Comps</li>';
											echo '<li><span>' . $alerts . '</span> Alerts</li>';
										} ?>
									</ul>
								</div>
								<?php
								echo '<p>Download Membership Logo: <a href="' . get_stylesheet_directory_uri() . '/images/GLADA_Member_sm.png" download>Standard</a> -
		            <a href="' . get_stylesheet_directory_uri() . '/images/GLADA_Member_UseOnDark.png" download> Inverted</a></p>';
								?>
							</section> <?php

							// secondary -- My Listings -- Dealers-Only
	          	if( is_dealer(true) ): ?>
								<section class="mylistings manage" id="mylistings">
									<h3>My Listings</h3>
									<div class="listings">
										<div class="tooltip" name="myservices">
											<a href="#"><i class="fas fa-question-circle"></i></a>
											<div class="tooltip_content" name="myservices">
												<h3><i class="fas fa-lightbulb-on"></i> Did You Know?</h3>
												<p>Manage your For Sale Aircraft here in the <span>My Listings</span> section. Your listings will be displayed on GLADA's public <span>Listings</span> page.</p>
												<p>Create a new Listing by clicking on the <i class="fas fa-plus"></i> icon. Manage your Listings here on the Dashboard under <span>My Listings</span> by clicking on "<u>Edit Listing</u>." When a listing is no longer needed, click on the <i class="fas fa-times"></i> icon in the upper-right corner of the listing. You can choose to mark it as <span>sold</span>, temporarily <span>suspend</span> it, or <span>withdraw</span> it from the market.</p>
												<p>Listings marked as Sold will remain on the public <span>Listings</span> page along with your contact information. Suspended Listings will be removed from the public page and may still be managed here in your <span>Dashboard</span>. Otherwise, listings withdrawn from the market will be deleted from both locations and will no longer be accessible.</p>
											</div>
										</div>
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
	            <?php endif;

							// secondary -- My Opps -- All Members ?>
							<section class="myservices manage" id="myservices">
								<h3>My Services<?php if( is_dealer() ) { echo '<span><a href="' . bp_loggedin_user_domain() . 'profile/edit/group/2/">edit services list</a></span>'; }?></h3>
								<div class="services">
									<div class="tooltip" name="myservices">
										<a href="#"><i class="fas fa-question-circle"></i></a>
										<div class="tooltip_content" name="myservices">
											<h3><i class="fas fa-lightbulb-on"></i> Did You Know?</h3>
											<p>The <span>My Services</span> section is where you can create and manage Service Listings. These are designed to allow you to advertise your company's specific benefits and servies to other members, including offering discounts, hosting webinars, or simply describing a service that you want to highlight.</p>
											<p>Create a new Service Listing by clicking on the <i class="fas fa-plus"></i> icon. Once you've created a listing, it will be posted to the <span>Services</span> page, which you can access in the Sidebar from the Members Menu. You can manage your Service Listings here on the Dashboard under <span>My Services</span>.</p>
											<?php if( is_dealer() ) { ?><p>As a Dealer Member, you can list additional services that your company offers in the <span>Directory</span> as well as the Services page. To add Services to your Company Profile, click on "<u>edit services list</u>" next to <span>My Services</span> or find it in your profile under <span>Profile <i class="fas fa-chevron-right"></i> Edit <i class="fas fa-chevron-right"></i> Company</span>. When you have selected and saved your services, other members will be able to see them any time they search for a service on the Service Listings page.</p><?php } ?>
										</div>
									</div>
									<h4>Industry: <span><?php echo get_user_meta( $current_user->ID, 'mepr_industry_type', true ); ?></span></h4>
									<?php if( is_dealer() ) { ?><h4>Services: <span><?php echo implode(', ', array_keys( get_user_meta( $current_user->ID, 'mepr_services', true ) )); ?></span></h4><?php } ?>

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

	            <!-- Here's where the Magic Happens -->
	            <div class="edit-forms formbox"></div>

	            <?php
	            // secondary -- Comps -- Dealers Only
	            if( is_dealer(true) ): ?>

	              <div class="comps-wrapper">
	                <a class="addnew" href="/members/add-comp/">Add New</a>
	                <div class="table-wrapper">
	                  <h3 class="section-title">Comps</h3>
	                  <?php

	                  // Get Comps
	                  $args = array(
	                    'post_type'				=> 'comp',
	                    'orderby'       	=> 'order_clause',
											'meta_query'			=> array(
												'order_clause' 	=> array(
													'key' 		=> 'date_sold',
													'compare' => 'EXISTS',
													//'type' 		=> 'NUMERIC'
												)),
	                    'order'         	=> 'DESC',
	                    'posts_per_page' 	=> 10,
											'paged'						=> 1,
	                    'tag__not_in'   	=> array('29')
	                  );
	                  $comp_query = new WP_Query( $args );

	                  if( $comp_query->have_posts() ) {
	                    echo '<ul id="comps_table">';
	                      echo '<li class="comp_column_header">
	                        <div class="comp_column_1"><a href="#" class="sort_heading" id="year_mfr" data-sort="desc">Year/Model</a></div>
	                        <div class="comp_column_2"><a href="#" class="sort_heading" id="airframe_time" data-sort="desc">Hours</a></div>
	                        <div class="comp_column_3"><a href="#" class="sort_heading" id="days_mkt" data-sort="desc">Days on Mkt</a></div>
	                        <div class="comp_column_4"><a href="#" class="sort_heading active" id="date_sold" data-sort="desc">Date Sold</a></div>
	                        <div class="comp_column_5"><a href="#" class="sort_heading" id="price_ask" data-sort="desc">Asking Price</a></div>
	                        <div class="comp_column_6"><a href="#" class="sort_heading" id="price_sell" data-sort="desc">Selling Price</a></div>
	                        </li>';


	                        while( $comp_query->have_posts() ): $comp_query->the_post();
	                          get_template_part('template-parts/comp');
	                        endwhile;

	                    echo '</ul>';
	                  } else {
	                    echo '<p>There has been an error retrieving this data. Please try again later.</p>';
	                  }

										$active = ( $comp_query->max_num_pages > 1 ) ? ' active' : '';

	                  ?>
	                </div>
	                <div class="paginate">
	                    <a href="#" class="comp_paginate" id="prev">prev</a>
	                    <a href="#" class="comp_paginate<?php echo $active; ?>" id="next">next</a>
	                </div>
	              </div>

	              <div class="fullcomp-wrapper">
	                <div id="fullcomp">

	                </div>
	              </div>

	              <?php

								wp_register_script( 'comps', get_stylesheet_directory_uri() . '/js/comps.min.js', array('jquery'), '20210629', true );
								// we have to pass parameters to comps.js script but we can get the parameters values only in PHP
								wp_localize_script( 'comps', 'query_params', array(
									'ajaxurl' 			=> site_url() . '/wp-admin/admin-ajax.php',
									'posts' 				=> json_encode( $comp_query->query_vars ),
									'current_page' 	=> 1,
									'max_page' 			=> $comp_query->max_num_pages
								) );
								wp_enqueue_script( 'comps' );

	            endif; // Comps
	            ?>

	            <div class="morelinks calendar">
	              <h3 class="section-title">Events</h3>
	              <?php echo do_shortcode('[add_eventon_list number_of_months="12" event_count="4" hide_past="yes" ux_val="3" hide_empty_months="yes" ft_event_priority="yes" tiles="no" hide_month_headers="yes" tile_height="400" ]'); ?>
	            </div>

							<?php
							// secondary -- Member Logo & Testimonials -- Exclude Free Trials
							if( is_member() ): ?>

		            <?php if( !$testimonials ) { ?>
		              <div class="testimonialform">
		                <p>Have a GLADA success story? We'd love to hear it!</p>
		                <?php echo do_shortcode('[wpforms id="919"]'); ?>
		              </div>
		            <?php }

							endif;

						// MAIN GROUPS - APPLICANTS
	          elseif( is_applicant() ):

							$url = 'memberships/' . $m . '-member/';

	            if( !in_array('applicant', $roles) || $m == 'industry') { ?>

	              <div class="approved">
	                <h3>Congratulations, <?php echo $firstname; ?>!</h3>
	                <p>Your <?php echo ucfirst($m); ?> Member application has been approved. To submit a payment and complete your Membership, <a href="/<?php echo $url; ?>"> Click Here </a>.</p>
	              </div>

	            <?php } else { ?>

	              <div class="under-review">
	                <h3>Hi, <?php echo $firstname; ?></h3>
	                <p>Thank you for submitting an Application.  The Board will review your application and respond to you within 7 business days.</p>
	                <a class="button" href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a>
	              </div>

	            <?php }

						// MAIN GROUPS - INACTIVE MEMBERS, FREE TRIALS
	          else:

	            $member = new MeprUser( $current_user->ID );
	            $sub_ids    = $member->current_and_prior_subscriptions();
	            $activesubs = $member->active_product_subscriptions('ids');

	            echo '<div class="reactivate-wrapper">
	              <div class="reactivate">
	                <img class="reactivate-glada" src="' . get_stylesheet_directory_uri() . '/images/GLADA_logo_sm.png' . '" />' . '<span>+</span>' . '<img class="reactivate-logo" src="' . get_company_logo( $current_user->ID ) . '" />
	              </div>';

	              if( in_array('1269', $activesubs )) {
	                // Referral
	                echo '<div>
	                  <h1>Hi, ' . $firstname . '</h1>
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
	                    <h1>Thank You, ' . $firstname . '</h1>
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
	                  echo '<div>
	                    <h1>Hi, ' . $firstname . '</h1>
	                    <h4>Your <strong>' . ucwords( $m ) . ' Membership</strong> has expired.</h4>
	                    <p>To manage your membership, click the link below.</p>
	                    <a class="dark button" href="' . bp_loggedin_user_domain() . 'mp-membership/mp-subscriptions/" id="mepr-account-subscriptions">Account Settings</a></span>
	                    <p style="margin:0;">OR</p>
	                    <p><a href="/memberships/' . $m . '-member/">Set up a new Yearly ' . ucwords( $m ) . ' Membership.</a>  |  <a href="/memberships/' . $m . '-member-quarterly/">Set up a new Quarterly ' . ucwords( $m ) . ' Membership.</a></p>';
	                  echo '</div>';
	                }

	              } else { echo "We've encountered an unexpected problem with your Membership. Please contact support."; }

	            echo '</div>';

	          endif;

					// LOGGED OUT PEEPS - PUBLIC
					else :

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

				// end "the-content"
				echo '</div>';
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

wp_enqueue_script( 'editlistings', get_template_directory_uri() . '/js/editlistings.min.js', array('jquery'), '20210521', true);

get_footer();
