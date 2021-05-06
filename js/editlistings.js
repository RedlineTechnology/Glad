jQuery(document).ready( function($){
  $.ajaxSetup({cache:false});

  // SINGLE PAGES
  // Bring up the Form we need.
  $('body.single .edit').on('click', function(e) {
    e.preventDefault();

    var $formbox = '#' + $(this).data('form');
    $( $formbox ).addClass('active');

    return false;
  });
  // Submit the Data. FOR SINGLE PAGES ONLY
  $('body.single #edit-listing-form, body.single #edit-marketstatus-form').submit( function() {

    $.ajax({
        url: 'https://glada.aero/wp-admin/admin-ajax.php',
        type: 'POST',
        data: $(this).find(':input').filter( function(index, element) {
                return $(element).val() != '';
              }).serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
          $('#edit-listing-submit, #edit-marketstatus-submit').addClass('loading').text('Sending...');
        },
        success: function( data ) {
          $('.formbox').html('<div><h1>Success!</h1><p>Your listing has been updated.<br>The page will automatically refresh in 5 seconds.</p></div>');

          setTimeout(function() {
              location.reload();
          }, 4000);
        }
    });
    return false;
  });

  // Delete the Data. FOR SINGLE PAGES ONLY
  // We're not actually deleting anything. We're adding a tag and then never displaying
  // things with that tag.
  $('body.single #delete-form').submit( function() {

    $.ajax({
        url: 'https://glada.aero/wp-admin/admin-ajax.php',
        type: 'POST',
        data: $('#delete-form :input').filter( function(index, element) {
                return $(element).val() != '';
              }).serialize(),
        dataType: 'json',
        beforeSend: function( xhr ) {
          $('#delete-form-submit').addClass('loading').text('Deleting...');
        },
        success: function( data ) {
          $('.formbox').html('<div><h1>Success!</h1><p>Your listing has been removed.<br>Redirecting in 5 seconds...</p></div>');

          setTimeout(function() {
              window.location.href = "/members";
          }, 4000);
        }
    });
    return false;
  });

  // ARCHIVE PAGES
  // Load the Form we need, do things on callback.
  $('body.page .edit, body.page .status').on('click', function(e) {
    e.preventDefault();

    var $url = $(this).attr('href'),
        $formbox = '#' + $(this).data('form');
    var $form = $url + ' ' + $formbox;

    // console.log('Debug: ' + $form);

    $('.edit-forms').load( $form, function() {
      // CALLBACK. AFTER THE THING LOADS, WE NEED THESE THINGS
      $( $formbox ).parent().addClass('active');

      // Close all the Forms
      $('.closeform').on('click', function(e) {
        e.preventDefault();
        $('.formbox').removeClass('active');
        $('.edit-forms').removeClass('active');
      });

      // Submit the Data. We're not on a Single Page here.
      $('#edit-listing-form, #edit-marketstatus-form').submit( function() {

        // Get these for the Update Callback
        $id = $(this).find('input[name="post_id"]').val();
        $status = $(this).find('#marketstatus').children("option:selected").val();
        $statusname = $(this).find('#marketstatus').children("option:selected").text();

        // console.log( 'id: ' + $id + ' status: ' + $status + ' statusname: ' + $statusname );

        $.ajax({
            url: 'https://glada.aero/wp-admin/admin-ajax.php',
            type: 'POST',
            data: $(this).find(':input').filter( function(index, element) {
                    return $(element).val() != '';
                  }).serialize(),
            dataType: 'json',
            beforeSend: function( xhr ) {
              $('#edit-listing-submit, #edit-marketstatus-submit').addClass('loading').text('Sending...');
            },
            success: function( data ) {
              $('.formbox').html('<div><h1>Success!</h1><p>Your listing has been updated.</p></div>');

              $('.listings ul').find("li[data-post='" + $id + "'] .status").attr('data-status', $status).text( $statusname );

              setTimeout(function() {
                  $('.formbox').removeClass('active');
                  $('.edit-forms').removeClass('active').empty();
              }, 2000);
            }
        });
        return false;
      });

      // Delete the Data.
      $('#delete-form').submit( function() {

        $post = $('#delete-form input[name=post_id]').val();

        $('.mylistings').find('li[data-post="' + $post + '"]').remove();

        $.ajax({
            url: 'https://glada.aero/wp-admin/admin-ajax.php',
            type: 'POST',
            data: $('#delete-form :input').filter( function(index, element) {
                    return $(element).val() != '';
                  }).serialize(),
            dataType: 'json',
            beforeSend: function( xhr ) {
              $('#delete-form-submit').addClass('loading').text('Deleting...');
            },
            success: function( data ) {
              $('.formbox').html('<div><h1>Success!</h1><p>Your listing has been successfully removed.</p></div>');

              setTimeout(function() {
                $('.formbox').removeClass('active');
                $('.edit-forms').removeClass('active').empty();
              }, 2000);
            }
        });
        return false;
      });


    });

    return false;
  });

  // Close all the Forms
  $('.closeform').on('click', function(e) {
    e.preventDefault();

    $('.formbox').removeClass('active');
    $('.edit-forms').removeClass('active');

    // $test = $('#edit-listing-form :input').filter( function(index, element) {
    //         return $(element).val() != '';
    //       }).serialize();
    // console.log( $test );
  });

  // Change Uploaded File button to Filename
  $( '.fancyfileinput' ).each( function() {

		var $input = $(this),
        $label	 = $input.next( 'label' ),
			  labelVal = $label.html();

		$input.on( 'change', function(e) {

      var fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				$label.find( 'span' ).html( fileName );
			else
				$label.html( labelVal );
		});

		// Firefox bug fix
		$input
		.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
		.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
	});

  // Replicating this inside of an ajaxComplete so that we can maybe do things
  $(document).ajaxComplete( function() {
    // Change Uploaded File button to Filename
    $( '.fancyfileinput' ).each( function() {

      var $input = $(this),
          $label	 = $input.next( 'label' ),
          labelVal = $label.html();

      $input.on( 'change', function(e) {

        var fileName = e.target.value.split( '\\' ).pop();

        if( fileName )
          $label.find( 'span' ).html( fileName );
        else
          $label.html( labelVal );
      });

      // Firefox bug fix
      $input
      .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
      .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
    });

  });

});
