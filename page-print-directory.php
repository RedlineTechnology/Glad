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

 get_header(); ?>

 <div class="printable">

   <!-- this style tag is here because we're going to load this page via jQuery AJAX which will strip everything from the head -->
   <style>
   @media screen, print {
     h3, h4, h5 { margin: 0 0 5px 0; }
     .printable #members-list {
       list-style: none;
       margin: 0 0 10px 0; }
       .printable #members-list > li {
         padding-bottom: 10px;
         border-bottom: 1px solid #ddd;
         margin-bottom: 10px; }
       .printable #members-list .item-wrapper {
         display: flex;
         align-items: center; }
         .printable #members-list .item-wrapper .logo {
           width: 100px; }
         .printable #members-list .item-wrapper .logo, .printable #members-list .item-wrapper img {
           margin: 0 10px;
           max-height: 60px;
           max-width: 100px; }
         .printable #members-list .item-wrapper .info {
           margin-left: 10px;
           border-left: 2px solid #888;
           padding-left: 10px; }
           .printable #members-list .item-wrapper .info > div {
             padding-top: 10px; }
           .printable #members-list .item-wrapper .info ul {
             margin: 0 10px;
             padding: 0;
             list-style: none; }
             .printable #members-list .item-wrapper .info ul li {
               padding-bottom: 5px; }
           .printable #members-list .item-wrapper .info .printable_member h3, .printable #members-list .item-wrapper .info .printable_member h4 {
             display: inline-block;
             margin-bottom: 0; }
           .printable #members-list .item-wrapper .info .printable_member h4 {
             color: #888;
             margin-left: 10px; }
           .printable #members-list .item-wrapper .info .printable_member p {
             margin: 0; }
           .printable #members-list .item-wrapper .info .printable_employees .name {
             font-family: haboro-soft-condensed, sans-serif;
             text-transform: uppercase;
             font-weight: 500;
             font-style: normal;
             -webkit-font-smoothing: antialiased; } }
   </style>

    <?php bp_nouveau_before_loop();

    if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

    	<ul id="members-list">

    	<?php while ( bp_members() ) : bp_the_member();

    		//$company = xprofile_get_field_data( 'Company Name', bp_get_member_user_id() ) ? : false;
    		$company = bp_get_member_profile_data( 'field=Company Name' );
    		// bp_member_profile_data( 'field=Company Name' );
    		// $field_id = xprofile_get_field_id_from_name( $field_name );

        $city = get_user_meta( bp_get_member_user_id(), 'mepr-address-city', true);
        $state = get_user_meta( bp_get_member_user_id(), 'mepr-address-state', true);
        $country = get_user_meta( bp_get_member_user_id(), 'mepr-address-country', true);

    		?>

    		<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
    			<div class="item-wrapper">
            <div class="logo">
  						<?php $cover_image_url = bp_attachments_get_attachment( 'url', array( 'item_id' => bp_get_member_user_id() ) ); ?>
  						<img src="<?php echo $cover_image_url;?>" />
    				</div>
    				<div class="info">
    					<div class="printable_member">

  							<h3>
  								<?php
                  bp_member_name();
                  if( $company ) {
                    echo ' <h4> ' . $company . '</h4>';
                  }
                  ?>
  							</h3>
                <?php
                  if( !empty( $city ) ) {
                    echo '<p>' . $city . ', ' . $state . ', ' . $country . '</p>';
                  }
                ?>

    					</div>

              <?php
                // printable_employees( bp_get_member_user_id() );
               ?>

    					<!-- <div class="printable_listings"> -->
    						<?php
                // $id = bp_get_member_user_id();
    						// $args = array(
    						// 	'author'        =>  $id,
    						// 	'post_type'     =>  'opportunity',
    						// 	'orderby'       =>  'post_date',
    						// 	'order'         =>  'ASC',
    						// 	'post_status'   =>  'publish',
    						// 	'tag__not_in'   =>  array('29')
    						// );
    						// $opportunity_query = new wp_Query( $args );
                //
    						// if( $opportunity_query->have_posts() ) :
    						// 	echo '<h4>Opportunities</h4>';
    						// 	echo '<ul>';
    						// 	while( $opportunity_query->have_posts() ): $opportunity_query->the_post();
    						// 		echo '<li>' . get_the_title() . '</li>';
    						// 	endwhile;
    						// 	echo '</ul>';
    						// endif;
    						?>
    					<!-- </div> -->

    				</div><!-- // .item -->
    			</div>
    		</li>

    	<?php endwhile; ?>

    	</ul>

    <?php
    else :

    	bp_nouveau_user_feedback( 'members-loop-none' );

    endif;

    ?>

    <?php bp_nouveau_after_loop(); ?>

  </div><!-- #primary -->

  <?php

  get_footer();
