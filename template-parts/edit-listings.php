
<?php echo '<div class="edit-forms">';

        echo '<div id="edit-listing-formbox" class="formbox">'; ?>

        <form action="#" method="POST" id="edit-listing-form" enctype="multipart/form-data">

          <input type="hidden" name="action" value="updatelisting">
          <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />

          <h3>Edit Listing</h3>
          <div>
            <label for="post_title">Listing Headline</label>
            <input type="text" id="post_title" name="post_title" placeholder="<?php echo $title; ?>">
          </div>

          <div class="select">
            <label for="marketstatus">Market Status</label>
            <select id="marketstatus" name="marketstatus" data-selected=<?php echo $status[0]->term_id; ?>>
              <option value="7" <?php selected( $status[0]->term_id, '7' ); ?>>For Lease</option>
              <option value="6" <?php selected( $status[0]->term_id, '6' ); ?>>For Sale</option>
              <option value="5" <?php selected( $status[0]->term_id, '5' ); ?>>Sold</option>
              <option value="8" <?php selected( $status[0]->term_id, '8' ); ?>>Under Contract</option>
            </select>
          </div>

          <div class="select">
            <label for="aircraft">Aircraft Type</label>
            <select id="aircraft" name="aircraft" data-selected=<?php echo $type[0]->term_id; ?>>
              <option value="3" <?php selected( $type[0]->term_id, '3' ); ?>>Business Jet</option>
              <option value="2" <?php selected( $type[0]->term_id, '2' ); ?>>Helicopter</option>
              <option value="15" <?php selected( $type[0]->term_id, '15' ); ?>>Multi-Engine Piston</option>
              <option value="14" <?php selected( $type[0]->term_id, '14' ); ?>>Single-Engine Piston</option>
              <option value="4" <?php selected( $type[0]->term_id, '4' ); ?>>Turboprop</option>
            </select>
          </div>

          <div>
            <label for="year">Model Year</label>
            <input type="text" name="year" id="year" class="regular-text" placeholder="<?php echo $year; ?>">
          </div>

          <div>
            <label for="make">Make</label>
            <input type="text" name="make" id="make" class="regular-text" placeholder="<?php echo $make; ?>">
          </div>

          <div>
            <label for="model">Model</label>
            <input type="text" name="model" id="model" class="regular-text" placeholder="<?php echo $model; ?>">
          </div>

          <div>
            <label for="serialnumber">Serial Number</label>
            <input type="text" name="serialnumber" id="serialnumber" class="regular-text" placeholder="<?php echo $sn; ?>">
          </div>

          <div>
            <label for="registration">Registration</label>
            <input type="text" name="registration" id="registration" class="regular-text" placeholder="<?php echo $reg; ?>">
          </div>

          <div class="select">
            <label for="aftt">Total Time</label>
            <select name="aftt" id="aftt">
              <option value="aftt" <?php selected( $aftt, 'aftt' ); ?>>Aircraft Frame Total Time</option>
              <option value="ttsn" <?php selected( $aftt, 'ttsn' ); ?>>Total Time Since New</option>
              <option value="tsoh" <?php selected( $aftt, 'tsoh' ); ?>>Time Since Overhaul</option>
            </select>
          </div>

          <div>
            <label for="aftt-number">Hours</label>
            <input type="text" name="aftt_number" id="aftt_number" class="regular-text" placeholder="<?php echo $aftt_hrs; ?>">
          </div>

          <div>
            <label for="landings">Landings</label>
            <input type="text" name="landings" id="landings" class="regular-text" placeholder="<?php echo $lndgs; ?>">
          </div>

          <!-- <label for="featured_image">Featured Image</label>
          <input type="file" id="featured_image" data-rule-extension="jpg,jpeg,png,gif" data-rule-maxsize="8388608" name="featured_image"> -->

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

          <div>
            <label for="url">Link URL</label>
            <input type="url" name="url" id="url" class="regular-text" placeholder="<?php echo $url; ?>">
          </div>

          <button id="edit-listing-submit" value="updatelisting">Save Changes</button>
          <a href="#" class="closeform">Cancel</a>
        </form>

        <?php echo '</div>'; /* end main formbox */

        echo '<div id="edit-marketstatus-formbox" class="formbox">'; ?>

          <form action="#" method="POST" id="edit-marketstatus-form" enctype="multipart/form-data">
            <input type="hidden" name="action" value="updatelisting">
            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />

            <h3>Change Market Status</h3>
            <div class="select">
              <label for="marketstatus">Select One:</label>
              <select id="marketstatus" name="marketstatus" data-selected=<?php echo $status[0]->term_id; ?>>
                <option value="7" <?php selected( $status[0]->term_id, '7' ); ?>>For Lease</option>
                <option value="6" <?php selected( $status[0]->term_id, '6' ); ?>>For Sale</option>
                <option value="5" <?php selected( $status[0]->term_id, '5' ); ?>>Sold</option>
                <option value="8" <?php selected( $status[0]->term_id, '8' ); ?>>Under Contract</option>
                <option value="30" <?php selected( $status[0]->term_id, '30' ); ?>>Off Market</option>
              </select>
            </div>
            <p class="info">* Under Contract and Off-Market aircraft will be hidden on the Listings page. Off-Market aircraft here will not appear to other GLADA members. To create an Opportunity for an Off-Market aircraft visible to other members, <a href="/members/submit-opportunity/">Click Here</a>.</p>

            <button id="edit-marketstatus-submit" value="updatelisting">Update Status</button>
            <a href="#" class="closeform">Cancel</a>
          </form>

        <?php echo '</div>'; /* end market status formbox */

        echo '<div id="upload-specsheet-formbox" class="formbox">'; ?>

          <form name="specsheet_form" id="spechsheet_form" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
            <input type="hidden" name="action" value="upload_specsheet" />

            <h3>Specsheet</h3>
            <div>
              <input class="fancyfileinput" type="file" id="pdf" name="pdf" multiple="false" />
              <label for="pdf"><span>Choose a File</span></label>
            </div>

            <input id="uploadpdf" type="submit" name="uploadpdf" value="Upload" />
            <a href="#" class="closeform">Cancel</a>
          </form>

        <?php echo '</div>'; /* end specsheet formbox */

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

            <h3>Delete Listing</h3>

            <button id="delete-form-submit" value="updatelisting">Confirm Deletion</button>
            <a href="#" class="closeform">Cancel</a>
          </form>

        <?php echo '</div>'; /* end DELETE (remove) formbox */

echo '</div>'; /* end forms */
