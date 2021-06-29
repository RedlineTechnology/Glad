<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @since 3.0.0
 * @version 3.0.0
 */
?>

<div id="cover-image-container">
	<div id="header-cover-image"></div>

	<div id="item-header-cover-image">
		<div id="item-header-avatar">
			<a href="<?php bp_displayed_user_link(); ?>">

				<?php bp_displayed_user_avatar( 'type=full' ); ?>

			</a>
		</div><!-- #item-header-avatar -->

		<div id="item-header-content">

			<?php $cover_image_url = bp_attachments_get_attachment( 'url', array( 'item_id' => bp_displayed_user_id() ) ); ?>
			<img class="little_logo" src="<?php echo $cover_image_url;?>" />


			<?php
				$company = xprofile_get_field_data( 'Company Name' );
				if ( $company ){
					echo '<h1 style="margin:0;">' . $company . '</h1>';
				}
				echo '<h3>' . bp_core_get_user_displayname( bp_displayed_user_id() ) . '</h3>';
			?>

			<?php
			bp_nouveau_member_header_buttons(
				array(
					'container'         => 'ul',
					'button_element'    => 'button',
					'container_classes' => array( 'member-header-actions' ),
				)
			);
			?>

			<?php bp_nouveau_member_hook( 'before', 'header_meta' ); ?>

			<?php if ( current_user_can('manage_options') && bp_nouveau_member_has_meta() ) : ?>
				<div class="item-meta">

					<?php bp_nouveau_member_meta(); ?>

				</div><!-- #item-meta -->
			<?php endif; ?>

		</div><!-- #item-header-content -->

	</div><!-- #item-header-cover-image -->
</div><!-- #cover-image-container -->
