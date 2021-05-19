
<?php echo '<div class="edit-forms">';

        echo '<div id="edit-listing-formbox" class="formbox">'; ?>

        <form action="#" method="POST" id="edit-listing-form" enctype="multipart/form-data">

          <input type="hidden" name="action" value="updatelisting">
          <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />

          <h3>Edit Post</h3>
          <div>
            <label for="post_title">Title</label>
            <input type="text" id="post_title" name="post_title" value="<?php echo $title; ?>">
          </div>

          <?php

          $types = get_terms( array(
            'taxonomy' => 'opptype',
            'hide_empty' => false,
          ));

          $checkboxes = '<fieldset class="checkboxgroup">';
          $checkboxes .= '<legend>Service Categories<span> Choose all that apply</span></legend>';
          foreach( $types as $type ) {
            $checked = in_array( $type->slug, $checkedterms ) ? 'checked="checked"' : '';
            $checkboxes .= '<label for="' . $type->taxonomy . '">
              <input ' . $checked . ' type="checkbox" id="' . $type->slug . '" name="' . $type->taxonomy . '[]" value="' . $type->slug . '"> ' . $type->name . '</label>';
          }
          $checkboxes .= '</fieldset>';

          echo $checkboxes; ?>

          <div class="vertical">
            <label for="details">Details</label>
            <textarea name="details" id="details" class="regular-text" placeholder=""><?php echo $details ?></textarea>
            <?php
            // $settings = array(
            //   'wpautop' => false,
            //   'media_buttons' => false,
            //   'teeny' => true
            // )
            // wp_editor( $details, 'details', $settings );
            ?>
          </div>

          <div>
            <label for "url">URL</label>
            <input type="text" id="oppurl" name="url" value="<?php echo $url; ?>">
          </div>

          <h3>Contact Details</h3>
          <div>
            <label for="contactname">Contact Name</label>
            <input type="text" name="contactname" id="contactname" class="regular-text" placeholder="<?php echo $name; ?>">
          </div>

          <div>
            <label for="contactnumber">Contact Phone Number</label>
            <input type="tel" name="contactnumber" id="contactnumber" class="regular-text" placeholder="<?php echo $phone; ?>">
          </div>

          <div>
            <label for="contactemail">Contact Email</label>
            <input type="email" name="contactemail" id="contactemail" class="regular-text" placeholder="<?php echo $email; ?>">
          </div>

          <button id="edit-listing-submit" value="updatelisting">Save Changes</button>
          <a href="#" class="closeform">Cancel</a>
        </form>

        <?php echo '</div>'; /* end main formbox */

        echo '<div id="upload-featuredimage-formbox" class="formbox">'; ?>

          <form name="featuredimage_form" id="featuredimage_form" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
            <input type="hidden" name="action" value="upload_featuredimage" />

            <h3>Featured Image</h3>
            <div>
              <input class="fancyfileinput" type="file" id="featured_image" name="featured_image" multiple="false" />
              <label for="featured_image"><span>Upload New Featured Image</span></label>
            </div>

            <input id="uploadimage" type="submit" name="uploadimage" value="Upload" />
            <a href="#" class="closeform">Cancel</a>
          </form>

        <?php echo '</div>'; /* end featured image formbox */

        echo '<div id="delete-listing-formbox" class="formbox">'; ?>

          <form action="#" method="POST" id="delete-form" enctype="multipart/form-data">

            <input type="hidden" name="action" value="updatelisting">
            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
            <input type="hidden" id="delete_post" name="delete_post" value="29" />

            <h3>Remove Post</h3>

            <button id="delete-form-submit" value="updatelisting">Yes, Delete it</button>
            <a href="#" class="closeform">Cancel</a>
          </form>

        <?php echo '</div>'; /* end DELETE (remove) formbox */

echo '</div>'; /* end forms */
