jQuery(document).ready(function($){
  $.ajaxSetup({cache:false});
  // Submit the Data.
  $('#employee-form').submit( function() {

    $.ajax({
        url: 'https://glada.aero/wp-admin/admin-ajax.php',
        type: 'POST',
        data: $(this).find(':input').filter( function(index, element) {
                return $(element).val() != '';
              }).serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
          $('#employee-submit').addClass('loading').text('Saving...');
        },
        success: function( data ) {
          $('#employee-submit').removeClass('loading').text('Save Complete');

          // setTimeout(function() {
          //     location.reload();
          // }, 4000);
        }
    });
    return false;
  });
});
