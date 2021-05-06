jQuery(document).ready( function($){
  $.ajaxSetup({cache:false});

  // Submit the Data.
  $('#mobile-alert-form').submit( function() {

    $.ajax({
        url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
        type: 'POST',
        data: $(this).find(':input').filter( function(index, element) {
                return $(element).val() != '';
              }).serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
          $('#mobile-alert-submit').addClass('loading').text('Saving...');
        },
        success: function( data ) {
          $('#mobile-alert-submit').removeClass('loading').text('Save Successful. Page will Refresh.');

          setTimeout(function() {
              location.reload();
          }, 4000);
        }
    });
    return false;
  });

  // Submit the Data.
  $('#alert-form').submit( function() {

    $.ajax({
        url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
        type: 'POST',
        data: $(this).find(':input').filter( function(index, element) {
                return $(element).val() != '';
              }).serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
          $('#alert-form-submit').addClass('loading').text('Sending...');
        },
        success: function( data ) {
          $('#alert-form-submit').removeClass('loading').text('Sent!');

          setTimeout(function() {
              location.reload();
          }, 4000);
        }
    });
    return false;
  });

});
