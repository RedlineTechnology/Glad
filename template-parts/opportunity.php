<?php

$user_id = get_the_author_meta('ID');
$company = get_user_meta($user_id, 'mepr_company', true);

$cat = get_the_category(); ?>

<div class="opportunity-heading">
  <h6 class="<?php echo $cat[0]->slug; ?>"><?php echo $cat[0]->name; ?></h6>
  <?php
  if ( $company ) {
    echo '<h6 class="company">' . $company . '</h6>';
  }
  ?>
</div>

<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
  <?php echo '<h2 id="post-' . get_the_ID() . '">' . get_the_title() . '</h2>'; ?>
</a><?php
echo '<p>' . the_content() . '</p>';

?>
