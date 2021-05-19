jQuery(function($){

	/*
	 * Load More
	 */
	$('#loadmore').click(function(){
		$.ajax({
			url : query_params.ajaxurl, // AJAX handler
			data : {
				'action': 'loadmore', // the parameter for admin-ajax.php
				'query': query_params.posts, // loop parameters passed by wp_localize_script()
				'page' : query_params.current_page // current page
			},
			type : 'POST',
			beforeSend : function ( xhr ) {
				$('#loadmore').text('Loading...'); // some type of preloader
			},
			success : function( posts ){
				if( posts ) {

					$('#loadmore').text( 'More Listings' );
					$('#response').append( posts ); // insert new posts
					query_params.current_page++;

					if ( query_params.current_page == query_params.max_page )
						$('#loadmore').hide(); // if last page, HIDE the button

				} else {
					$('#loadmore').text( 'More Listings' );
					$('#loadmore').hide(); // if no data, HIDE the button as well
				}
			}
		});
		return false;
	});

	var canBeLoaded = false,
			bottomOffset = 700;
	if( $('body.post-type-archive').length ) {
		canBeLoaded = true;
	}

	$('#page-wrapper').scroll(function(){
		var data = {
			'action': 'loadmore',
			'query': query_params.posts,
			'page' : query_params.current_page
		};
		if( $('#page-wrapper').scrollTop() > ( $('#response').height() - bottomOffset ) && canBeLoaded == true ){
			console.log('made it to the thing!');
			$.ajax({
				url : query_params.ajaxurl,
				data:data,
				type:'POST',
				beforeSend: function( xhr ){
					$('#loadmore').text('Loading...').hide(); // some type of preloader
					$('.loaderwrapper').show();
					// you see, the AJAX call is in process, we shouldn't run it again until complete
					canBeLoaded = false;
				},
				success:function( posts ){
					if( posts ) {
						$('#loadmore').text( 'Show More' ).show();
						$('.loaderwrapper').hide();
						$('#response').append( posts ); // insert new posts
						query_params.current_page++;
						canBeLoaded = true; // the ajax is completed, now we can run it again

						if ( query_params.current_page == query_params.max_page )
							$('#loadmore').hide(); // if last page, HIDE the button

					} else {
						$('#loadmore').text( 'Show More' ).hide(); // if no data, HIDE the button as well
						$('.loaderwrapper').hide();
					}
				}
			});
		}
	});


	/*
	 * Filter
	 */
	$('#filter').submit(function(){
		$.ajax({
			url : query_params.ajaxurl,
			data : $('#filter').serialize().replace(/&?[^=]+=&|&[^=]+=$/g,''), // form data, removing null values
			dataType : 'json', // this data type allows us to receive objects from the server
			type : $('#filter').attr('method'), // POST
			beforeSend : function(xhr){
				$('#filter').find('button').text('Processing...'); // changing the button label
				$('#response').html( '<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>' )
			},
			success : function( data ){
				// when filter applied:
				// set the current page to 1
				query_params.current_page = 1;
				// set the new query parameters
				query_params.posts = data.posts;
				// set the new max page parameter
				query_params.max_page = data.max_page;

				$('#filter').find('button').text('Update'); // change the button label back
				$('#response').html(data.content); // the thing
				$('#response').addClass('ajaxed'); // add this class so we can style based on filtered or not
				// hide load more button, if there are not enough posts for the second page
				if ( data.max_page < 2 ) {
					$('#loadmore').hide();
				} else {
					$('#loadmore').show();
				}
			}
		});
		return false;
	});

	/*
	 * This is the OPPORTUNITY SIDEBAR ICON click handler. Nearly identical to the Search function. Look into consolidating
	 */
	$(document).on('click','.opp-sidebar i',function(){

		$.ajax({
			url : query_params.ajaxurl, // AJAX handler
			type : $('#searchform').attr('method'),
			dataType : 'json',
			data : {
				'action': 'search',
				'searchfield': $(this).attr('type'), // we'll be spoofing a search for this category
				'posts': query_params.posts
			},
			beforeSend : function(xhr){
				$( query_params.output ).html( '<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>' )
			},
			success : function( data ){
				$( query_params.output ).html(data.content); // the thing
				$( query_params.output ).addClass('ajaxed'); // add this class so we can style based on filtered or not
				$('#loadmore').hide();
			}
		});
		return false;
	});

	$(document).on('click','.opp-main',function(){

		var box = $(this);
		var post = $(this).attr('id');

		$.ajax({
			url : query_params.ajaxurl, // AJAX handler
			type : 'POST',
			dataType : 'json',
			data : {
				'action': 'expandpost',
				'post': post
			},
			beforeSend : function(xhr){
				$( box ).addClass('loading');
			},
			success : function( data ){
				$( '#postbox' ).html(data.content); // the thing
				$( '#postbox' ).addClass('active');
				$( box ).removeClass('loading');
        $("#page-wrapper").toggleClass( "noscroll" );
			}
		});
		return false;
	});

	$(document).on('click','.closebox',function(e){
		e.preventDefault();
		$( '#postbox' ).removeClass('active'),
		$("#page-wrapper").toggleClass( "noscroll" )
	});
	$(document).on('click',function(e){
		if ( (!$(e.target).closest('#postbox .inner').length) && (!$(e.target).closest('.closebox').length) ) {
			if ( $( '#postbox' ).hasClass( 'active' ) ) {
				$( '#postbox' ).removeClass( 'active' ),
        $("#page-wrapper").toggleClass( "noscroll" )
			}
		}
	});

});

// add scroll back
