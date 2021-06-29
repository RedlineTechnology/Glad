<?php
/**
 * BP Nouveau Component's directory nav template.
 *
 * @since 3.0.0
 * @version 3.0.0
 */
?>

<nav class="<?php bp_nouveau_directory_type_navs_class(); ?>" role="navigation" aria-label="<?php esc_attr_e( 'Directory menu', 'buddypress' ); ?>">

	<?php if ( bp_nouveau_has_nav( array( 'object' => 'directory' ) ) ) : ?>

		<ul class="component-navigation <?php bp_nouveau_directory_list_class(); ?>">

			<?php
			while ( bp_nouveau_nav_items() ) :
				bp_nouveau_nav_item();
			?>

				<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>" <?php bp_nouveau_nav_scope(); ?> data-bp-object="<?php bp_nouveau_directory_nav_object(); ?>">
					<a href="<?php bp_nouveau_nav_link(); ?>">
						<?php bp_nouveau_nav_link_text(); ?>

						<?php // if ( bp_nouveau_nav_has_count() ) : ?>
							<!-- <span class="count">
							<?php // bp_nouveau_nav_count(); ?>
						</span> -->
						<?php // endif; ?>
					</a>
				</li>

			<?php endwhile; ?>

			<li>
				<a class="print" target="_blank" href="https://www.glada.aero/members/print-directory/"><i class="fas fa-print"></i> Printable List <span class="spinner"><img src="<?php echo get_stylesheet_directory_uri() . '/images/ajax-loader.gif'; ?>"></span></a>
			</li>

		</ul><!-- .component-navigation -->

	<?php endif; ?>

</nav><!-- .bp-navs -->

<script type="text/javascript">
jQuery(document).ready(function($){
	$(".print").click(function(e){
			e.preventDefault();

			$(this).addClass('loading');

			var $post_link = $(this).attr("href") + ' .printable';

			$('<iframe>', {
				name: 'myiframe',
				class: 'printFrame',
				id: 'printMe'
			})
			.appendTo('body')
			.contents().find('body')
			.load( $post_link, function() {

				setTimeout(() => {
					window.frames['myiframe'].focus();
					window.frames['myiframe'].print();
					$(".print").removeClass('loading');
				}, 1000);

				setTimeout(() => { $("#printMe").remove(); }, 1000);
			} );

		return false;
	});
});
</script>
