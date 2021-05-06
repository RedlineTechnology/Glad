jQuery(document).ready(function($){
  var custom_uploader;
  $('.media-button').click(function(e) {
      e.preventDefault();
      var $formfieldID = $(this).next().attr("id"),
          $formfield = $("#"+$formfieldID).attr('name');
      //If the uploader object has already been created, reopen the dialog
      if (custom_uploader) {
          custom_uploader.open();
          return;
      }

      //Extend the wp.media object
      custom_uploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose Image',
          button: {
              text: 'Choose Image'
          },
          multiple: false
      });

      //When a file is selected, grab the URL and set it as the text field's value
      custom_uploader.on('select', function() {
          attachment = custom_uploader.state().get('selection').first().toJSON();
          $("#"+$formfieldID).val(attachment.url);
      });

      //Open the uploader dialog
      custom_uploader.open();
  });

  // Now we're going to add a simple little thing for front-end image uploading
  $('#brandingLogo').change(function() {
    $('#account_branding').submit();
    $('#account_branding .logo-wrapper').addClass('loading');
  });

});
