<?php
  /**
  * The Main Blog Template - Index Fallback
  *
  * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
  *
  * @package _glad
  */

  get_header();

	wp_reset_postdata();
	wp_reset_query();
?>

 <div id="primary" class="content-area">
   <main id="main" class="site-main">

	 <?php // Now let's check tags and stuff
	   $cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	   $tag = isset($_GET['tag']) ? $_GET['tag'] : null;

	   // Create query arguments
	   $args = array(
	     'post_type' => 'post',
	     'post_status' => 'publish',
			 'paged' => true,
	     'posts_per_page' => 10,
	     'post__not_in' => $skipIDs,
	   );
	   // Set a category argument if we have it
	   if( $cat ){
	     $args['category_name'] = $cat;
	     $term = get_term_by('slug', $cat, 'category');
	   }
	   // Set a tag arguent if we have it
	   if( $tag ){
	     $args['tag'] = $tag;
	     $term = get_term_by('slug', $tag, 'post_tag');
	   }
     if( $term ) {
       $title = '<div><h1>' . strtoupper( $term->name ) . '</h1></div>';
     } else {
       $title = '<div><h1>News</h1></div>';
     }

   // Now the magic
   $wp_query = new WP_Query( $args );

   if ( $wp_query->have_posts() ) {
     $first_post = $wp_query->posts[0];
     $header_img = has_post_thumbnail( $first_post->ID ) ? wp_get_attachment_url( get_post_thumbnail_id( $first_post, 'full')) : get_stylesheet_directory_uri() . '/images/mplex_header.jpg';

     echo '<div class="hero section" style="background-image: url(' . $header_img . ')">' .
       '<div class="filter"></div><div class="content-container">' .
         '<div><h1 class="page-title">' . $title . '</h1></div>' .
       '</div></div>';
   } ?>

   <section class="archive-listing section">

     <?php if ( $wp_query->have_posts() ) :

       /* Start the Loop */
       while ( $wp_query->have_posts() ) :
         the_post();

				 $header_img =  wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') ); ?>
	       <article data-thumb="<?php echo $header_img ?>">
	         <a href="<?php the_permalink() ?>">
	           <div class="featured-img" style="background-image:url('<?php echo $header_img ?>');"></div>
	           <h2><span><?php the_title(); ?></span></h2>
	         </a>
	       </article>

       <?php endwhile;

       the_posts_navigation();

     else :

       echo 'Looks like there\'s nothing here. Why don\'t you try searching?';

     endif;
     ?>

   </section>

   </main><!-- #main -->
 </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
