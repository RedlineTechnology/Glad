<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 6.0.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) :

	// echo '<!-- test';
	// $query = bp_ajax_querystring( 'members' ) . '&per_page=5';
	// var_dump( $query );
	// echo '-->';

	bp_nouveau_pagination( 'top' ); ?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php while ( bp_members() ) : bp_the_member();

		//$company = xprofile_get_field_data( 'Company Name', bp_get_member_user_id() ) ? : false;
		$company = bp_get_member_profile_data( 'field=Company Name' );
		// bp_member_profile_data( 'field=Company Name' );
		// $field_id = xprofile_get_field_id_from_name( $field_name );

		?>

		<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
			<div class="list-wrap">

				<div class="item-avatar">
					<a href="<?php bp_member_permalink(); ?>">
						<?php $cover_image_url = bp_attachments_get_attachment( 'url', array( 'item_id' => bp_get_member_user_id() ) ); ?>
						<div class="company_logo" style="background-image:url('<?php echo $cover_image_url;?>')"></div>

						<?php bp_member_avatar( bp_nouveau_avatar_args() ); ?>
					</a>
				</div>

				<div class="item">

					<div class="item-block">

						<?php
						if( $company ) { ?>
							<h2 class="list-title member-name">
								<a href="<?php bp_member_permalink(); ?>">
									<?php echo $company; ?>
								</a>
							</h2>
							<h1><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></h1> <?php
						} else { ?>
							<h2 class="list-title member-name">
								<a href="<?php bp_member_permalink(); ?>">
									<?php bp_member_name(); ?>
								</a>
							</h2> <?php
						}
						?>

						<?php if ( bp_nouveau_member_has_meta() ) : ?>
							<p class="item-meta last-activity">
								<?php bp_nouveau_member_meta(); ?>
							</p><!-- .item-meta -->
						<?php endif; ?>

						<?php if ( bp_nouveau_member_has_extra_content() ) : ?>
							<div class="item-extra-content">
								<?php bp_nouveau_member_extra_content() ; ?>
							</div><!-- .item-extra-content -->
						<?php endif ; ?>

						<?php
						bp_nouveau_members_loop_buttons(
							array(
								'container'      => 'ul',
								'button_element' => 'button',
							)
						);
						?>
					</div>

					<div class="listings-block">
						<?php $id = bp_get_member_user_id(); ?>

						<?php
						$args = array(
							'author'        =>  $id,
							'post_type'     =>  'opportunity',
							'orderby'       =>  'post_date',
							'order'         =>  'ASC',
							'post_status'   =>  'publish',
							'tag__not_in'   =>  array('29')
						);
						$opportunity_query = new wp_Query( $args );

						if( $opportunity_query->have_posts() ) :
							echo '<h4>Opportunities <i class="fas fa-chevron-down"></i></h4>';
							echo '<div class="opportunity_listings">';
							while( $opportunity_query->have_posts() ): $opportunity_query->the_post();
								$cat = get_the_category();
								echo '<div><a class="opp ' . $cat[0]->slug . '" href="#" data-href="' . get_permalink() . '">' . get_the_title() . '</a></div>';

							endwhile;
							echo '</div>';
						endif;

						// EMPLOYEES
					  $instanciate = array(
					    'name' => '',
					    'title' => '',
					    'email' => '',
					    'number' => '',
					    'ismember' => false,
					    'sms_enabled' => false
					  );
					  $employees = json_decode( get_user_meta($id, 'mepr_employees', true), true ) ?: array( $instanciate );

					  if( !empty( $employees ) && $employees[0]['name'] != '' ) : ?>
							<h4>Team <i class="fa fa-chevron-down"></i></h4>
					    <div class="employees_dropdown">
					      <ul>
					      <?php
					      foreach( $employees as $employee ) { ?>
					        <li class="employee">
					          <?php echo '<a href="' . bp_get_member_permalink() . 'employees/"><span class="name">' . $employee['name'] . '</span></a>'; ?>
					          <?php if( $employee['title'] ){ echo '<br><span class="title">' . $employee['title'] . '</span>'; } ?>
					        </li>
					      <?php
					      } ?>
					      </ul>
					    </div> <?php
					  endif; ?>
					</div>

					<?php if ( bp_get_member_latest_update() && ! bp_nouveau_loop_is_grid() ) : ?>
						<div class="user-update">
							<p class="update"> <?php bp_member_latest_update(); ?></p>
						</div>
					<?php endif; ?>

				</div><!-- // .item -->
			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<div class="opportunity-box" id="oppbox">
		<div class="wrapper">
			<div class="inner"></div>
			<i class="close fas fa-times"></i>
		</div>
	</div>

	<script>
		jQuery(document).ready(function($){
			// Load the form!
			$('.opp').click(function(e){
					$('.opportunity-box .inner').html("<div class='the-content'><p>loading...<br></p><img style='width:25px;height:25px;margin:2em auto;' src='/wp-content/themes/Glad/images/ajax-loader.gif'></div>");

					$('.opportunity-box').addClass( 'open' );

					var $post_link = $(this).data("href") + ' .the-content';
					$('.opportunity-box .inner').load( $post_link );

				return false;
			});
			$('.close').click(function(e){
				$('.opportunity-box').removeClass('open');
				$('.opportunity-box .inner').html('');
			});
			$(document).on('click', function(event) {
				if ( (!$(event.target).closest('.opportunity-box .inner').length) && (!$(event.target).closest('.close').length) ) {
					if ( $('.opportunity-box').hasClass( 'open' ) ) {
						$('.opportunity-box').removeClass('open');
					}
				}
			});
		});
	</script>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php
else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;

?>

<?php bp_nouveau_after_loop(); ?>
