
<?php echo '<div class="mobile-form">';
        echo '<div id="mobile-alert-formbox" class="formbox">';

        $sms_enabled = get_user_meta($user_id, 'mepr_sms_enabled', true); ?>

        <form action="#" method="POST" id="mobile-alert-form" enctype="multipart/form-data">

          <input type="hidden" name="action" value="updatemobilesettings">
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />

          <h3>SMS Alert Settings</h3>
          <div>
            <input type="checkbox" id="sms_enabled" name="sms_enabled" <?php if( $sms_enabled ){ echo 'checked="checked"'; }; ?>>
            <label for="post_title">Enable Alerts</label>
          </div>

          <h6>Send Alerts to:</h6>
          <div class="mynumber">
              <input type="text" name="mobile" id="mobile" class="regular-text" placeholder="<?php echo get_user_meta($user_id, 'mepr_mobile', true); ?>" value="<?php echo get_user_meta($user_id, 'mepr_sms_main', true) ? formatPhoneNumber( get_user_meta($user_id, 'mepr_sms_main', true) ) : ''; ?>">
          </div>
          <h6>Additional Numbers:</h6>
          <?php

          $sms_numbers = get_user_meta($user_id, 'mepr_sms_numbers', true);
          $numberCount = count($sms_numbers); //what we got, yo?

          $i = 0;
          while($i <= $numberCount ) { ?>

            <div class="nameandnumber" id="<?php echo 'sms_numbers_' . $i . '_wrapper'; ?>">
              <input type="text" name="<?php echo 'sms_add_name_' . $i; ?>" id="<?php echo 'sms_add_name_' . $i; ?>" class="regular-text" placeholder="Name" value="<?php echo ( $sms_numbers[$i]!=''?$sms_numbers[$i][0]:'' ); ?>">
              <input type="text" name="<?php echo 'sms_add_number_' . $i; ?>" id="<?php echo 'sms_add_number_' . $i; ?>" class="regular-text" placeholder="Mobile Number" value="<?php echo ( $sms_numbers[$i]!=''?formatPhoneNumber($sms_numbers[$i][1]):'' ); ?>">
                <div>
                  <a class="removenumber" style="display: <?php echo ($sms_numbers[$i]!=''?'block':'none'); ?>" onclick="sms_remove_number('<?php echo $i; ?>');"><i class="fas fa-minus"></i> Remove</a>
                <?php echo ( $sms_numbers[$i]!=''?'':'<a class="addnumber" id="sms_add_number" onclick="sms_add_number(\'' . $i . '\');"><i class="fas fa-plus"></i> Add a Number</a>' ); ?>
              </div>
              <input type="hidden" name="<?php echo 'sms_numbers[' . $i . ']'; ?>" id="<?php echo 'sms_numbers[' . $i . ']'; ?>" value="<?php echo $sms_numbers[$i]; ?>" />
            </div> <?php

            $i++;
          } ?>

          <button id="mobile-alert-submit" value="updatemobilesettings">Save Settings</button>
          <a href="#" class="closeform">Cancel</a>
        </form>

        <?php echo '</div>'; /* end main formbox */

echo '</div>'; /* end forms */
?>

<script>
  function sms_add_number(key){

      var $wrapper = jQuery('#sms_numbers_'+key+'_wrapper');
      $wrapper.find('.removenumber').show();
      $wrapper.find('.addnumber').remove();

      key++;

      $wrapper.after('<div class="nameandnumber" id="sms_numbers_'+key+'_wrapper"><input type="text" name="sms_add_name_'+key+'" id="sms_add_name_'+key+'" class="regular-text" placeholder="Name"><input type="text" name="sms_add_number_'+key+'" id="sms_add_number_'+key+'" class="regular-text" placeholder="Mobile Number"><div><a class="removenumber" style="display:none;" onclick="sms_remove_number(\''+key+'\')"><i class="fas fa-minus"></i> Remove</a><a class="addnumber" id="sms_add_number" onclick="sms_add_number(\''+key+'\')"><i class="fas fa-plus"></i> Add a Number</a></div><input type="hidden" name="sms_numbers['+key+']" id="sms_numbers['+key+']" value="" /></div>');

      return false;
  }
  function sms_remove_number(key){
      var $wrapper = jQuery('#sms_numbers_'+key+'_wrapper');
      $wrapper.find('input').val('');
      $wrapper.hide();
      return false;
  }
</script>

<script>
 jQuery(document).ready(function($){
    $.ajaxSetup({cache:false});
  });
</script>
<?php
