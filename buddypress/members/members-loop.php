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

						<?php
						$services = get_user_meta(bp_get_member_user_id(), 'mepr_services', true);
						if( isset($services) && !empty($services) ) {
							echo '<ul class="services">';
							foreach( $services as $service => $on ) {
								echo '<li>' . ucwords( $service ) . '</li>';
							}
							echo '</ul>';
						}
						?>

						<?php if ( current_user_can('manage_options') && bp_nouveau_member_has_meta() ) : ?>
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
							echo '<h4>Services Listings <i class="fas fa-chevron-down"></i></h4>';
							echo '<div class="opportunity_listings">';
							while( $opportunity_query->have_posts() ): $opportunity_query->the_post();
								echo '<div><a class="opp-main" id="post-' . $post->ID . '" href="#">' . get_the_title() . '</a></div>';
							endwhile;
							echo '</div>';
						endif;
					?>
					</div>

					<div class="listings-block">
						<?php $id = bp_get_member_user_id();
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

	<?php
	bp_nouveau_pagination( 'bottom' );

else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;

bp_nouveau_after_loop();

?><!-- dynamic receptacle for post content -->
<div id="postbox"></div>
<?php // For whatever reason this refuses to enqueue a script. Fuck it, just gonna copy it here. ?>
<script type="text/javascript">
jQuery(function($){
	$(document).on('click','.opp-main',function(){
		var box = $(this);
		var post = $(this).attr('id');

		$.ajax({
			url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'expandpost',
				'post': post
			},
			beforeSend: function(xhr){
				$( box ).addClass('loading');
			},
			success: function( data ){
				$( '#postbox' ).html(data.content); // the thing
				$( '#postbox' ).addClass('active');
				$( box ).removeClass('loading');
				$("#page-wrapper").toggleClass( "noscroll" );
			}
		});
		return false;
	});

	$(document).on('click','.closebox',function(e){
		e.preventDefault();
		$( '#postbox' ).removeClass('active'),
		$("#page-wrapper").toggleClass( "noscroll" )
	});
	$(document).on('click',function(e){
		if ( (!$(e.target).closest('#postbox .inner').length) && (!$(e.target).closest('.closebox').length) ) {
			if ( $( '#postbox' ).hasClass( 'active' ) ) {
				$( '#postbox' ).removeClass( 'active' ),
				$("#page-wrapper").toggleClass( "noscroll" )
			}
		}
	});
});
</script>
