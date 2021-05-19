/*
 * Filter
 */
jQuery(document).ready( function($){

  var input = query_params.input;
  var posts = query_params.posts;
  var output = query_params.output;
  var secondary = query_params.secondary;

  var timer;
  $( input ).keyup(function(){

    var search = $(this).val();

    clearTimeout(timer);
    timer = setTimeout(function(search) {

      if( search != "" ){

        var data = $('#searchform').serializeArray();
        data.push({ name: "posts", value: posts });

        $.ajax({
          url : query_params.ajaxurl,
          type : $('#searchform').attr('method'),
          data : data,
          dataType : 'json',
          beforeSend : function(xhr){
            $( output ).html( '<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>' );
          },
          success : function( data ){
            $( output ).html(data.content); // the thing
            $( output ).addClass('ajaxed'); // add this class so we can style based on filtered or not

            if( secondary && data.secondary ) {
              $( secondary ).html( data.secondary );
            }

            $('#loadmore').hide();
          }
        });

      }

    }, 300);

  });

});
