/*
 * Search, Load, Filter
 */
jQuery(document).ready( function($){

  var input = query_params.input;
  var posts = query_params.posts;
  var output = query_params.output;
  var secondary = query_params.secondary;
  var posttype = JSON.parse(posts).post_type;

  function searchforthings( data ) {
    $.ajax({
      url : query_params.ajaxurl,
      type : $('#searchform').attr('method'),
      data : data,
      dataType : 'json',
      beforeSend : function(xhr){
        $( output ).html( '<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>' );
      },
      success : function( data ){
        // set new pageination data
        query_params.current_page = 1;
        query_params.posts = data.posts;
        query_params.max_page = data.max_page;
        query_params.manual = data.manual;

        $( output ).html(data.content); // the thing
        $( output ).addClass('ajaxed'); // add this class so we can style based on filtered or not

        if( secondary && data.secondary ) {
          $( secondary ).html( data.secondary );
        }
      }
    });
  }

  // SEARCH
  var timer;
  $( input ).keyup(function(){
    var search = $(this).val();

    clearTimeout(timer);
    timer = setTimeout(function(search) {

      if( search != "" ){
        var data = $('#searchform').serializeArray();
        data.push({ name: "posts", value: posts });

        searchforthings( data );
      }

    }, 300);

  });

  // let's set up autocomplete for the listing search
  if( posttype == 'listing' ) {
    autocomplete(document.getElementById("searchfield"), makes);
    $(document).on('click','.autocomplete-items div',function(){
      var data = $('#searchform').serializeArray();
      // We've serialized, but the form probably hasn't updated the autofill term yet, so let's do that ourselves
      var search = $(this).find('input').attr('value').replace(/ .*/,'');
      // Some of the Autofills are super long and we're never going to find anything, so I'm just taking the first word of the autocomplete. Sue me
      for (var item in data) {
        if (data[item].name == 'searchfield') {
          data[item].value = search;
        }
      }
      data.push({ name: "posts", value: posts });
      // Now do the thing
      searchforthings( data );
    });
  }

  // Sidebar Icon Handler
  $(document).on('click','.opp-sidebar i',function(){

    var data = {
      'action': 'listingsearch',
      'searchfield': $(this).attr('type'), // we'll be spoofing a search for this category
      'posts': posts
    }

    searchforthings( data );
    return false;
  });

  // Expand Listings
  $(document).on('click','.list-item-listing',function(){
    $(this).toggleClass('expanded');
  });

  // Load Opp Data into Lightbox
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

  // CLOSE LIGHTBOXES
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

  // LOAD ON SCROLL
  var canBeLoaded = false,
      bottomOffset = 700;
  if( $('body.post-type-archive').length ) {
    canBeLoaded = true;
  } // only initiate on archive pages

  $('#page-wrapper').scroll(function(){
    var data = {
      'action': 'loadmore',
      'posts': query_params.posts,
      'page': query_params.current_page,
      'manual': query_params.manual,
    };
    if( $('#page-wrapper').scrollTop() > ( $( output ).height() - bottomOffset ) && canBeLoaded == true ){
      console.log('made it to the thing!');
      $.ajax({
        url : query_params.ajaxurl,
        data: data,
        type: 'POST',
        beforeSend: function( xhr ){
          $('.loaderwrapper').show();
          // prevent duplicate calls
          canBeLoaded = false;
        },
        success:function( posts ){
          if( posts ) {
            $('.loaderwrapper').hide();
            $( output ).append( posts ); // insert new posts
            query_params.current_page++;
            canBeLoaded = true; // the ajax is completed, now we can run it again
          } else {
            $('.loaderwrapper').hide();
          }
        }
      });
    }
  });

  // Filter
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
				$( output ).html( '<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>' )
			},
			success : function( data ){
				// set new pageination data
				query_params.current_page = 1;
				query_params.posts = data.posts;
				query_params.max_page = data.max_page;
        query_params.manual = false;

				$('#filter').find('button').text('Update'); // change the button label back
				$( output ).html(data.content); // the thing
				$( output ).addClass('ajaxed'); // add this class so we can style based on filtered or not
			}
		});
		return false;
	});

});
