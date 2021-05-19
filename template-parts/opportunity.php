<?php
$user_id = get_the_author_meta('ID');
$company = get_user_meta($user_id, 'mepr_company', true);
$newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $user_id ) ); ?>

<div class="opp-sidebar"> <?php
  $types = get_the_terms($post->ID, 'opptype');
  foreach( $types as $type ){
    echo '<i class="fas ' . $type->slug . '" type="' . $type->slug . '"></i>';
  }
  ?>
</div>

<div class="opp-main" id="post-<?php echo $post->ID; ?>"> <?php
  echo '<h4>' . get_the_title() . '</h4>';
  echo '<p>' . wp_trim_words( get_the_content(), 30, '... <span class="readmore">Click to Read More</span>' ) . '</p>';
  echo '<img src="' . $newlogo . '"/>'; ?>
  <!-- <a href="<?php //the_permalink() ?>" rel="bookmark" title="<?php //the_title_attribute(); ?>">
    click for more?
  </a> -->
</div>
