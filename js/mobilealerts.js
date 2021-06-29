jQuery(document).ready( function($){
  $.ajaxSetup({cache:false});

  // Save Alert & SMS Settings
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

  // Submit a new Alert from the Alerts Sidebar
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

  var canSend = true;

  // Submit a new Alert from the Alerts Sidebar
  $('.alert-display').click(function(e){
    e.preventDefault();

    var $this = $(this);
        name = $(this).attr('id'),
        user_id = $('.dealer-alerts-wrapper').attr('id');

    if( canSend == true ) {
      $.ajax({
          url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
          type: 'POST',
          data : {
    				'action': 'togglesms', // the parameter for admin-ajax.php
    				'name' : name,
            'user' : user_id,
    			},
          dataType: 'json',
          beforeSend: function( xhr ) {
            $('.dealer-alerts-wrapper').addClass('loading');
            canSend = false;
          },
          success: function( data ) {
            $('.dealer-alerts-wrapper').removeClass('loading');
            $this.toggleClass('enabled');
            canSend = true;
          }
      });
    }

    return false;
  });

});
