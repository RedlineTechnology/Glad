jQuery(function($){

		// Get ready.
		var initiate = true;

		// SORT COMP TABLE
		$(".sort_heading").click(function(e){
			e.preventDefault();
			if( initiate == true ) {

				var column = $(this);
				var columnName = $(this).attr('id');
				var sortOrder = $(this).attr('data-sort');

				$.ajax({
					url: query_params.ajaxurl,
					crossDomain: true,
					type: 'POST',
					data: {
						'action': 'sortcomps',
						'posts': query_params.posts,
						'column': columnName,
						'sort': sortOrder,
						'page': 1,
					},
					dataType : 'json', // super important
					beforeSend: function( xhr ){
						$(".table-wrapper").addClass('loading'); // some type of preloader
						initiate = false;
					},
					success: function( data ){
						// Set the sort order for next time
						if(sortOrder == 'asc') {
							column.attr('data-sort','desc');
						} else {
							column.attr('data-sort','asc');
						}
						$(".table-wrapper").removeClass('loading');
						$(".sort_heading").removeClass('active');

						column.addClass('active');
						// clear the data
						$("#comps_table li:not(:first)").remove();
						$("#comps_table").append(data.content);
						query_params.posts = data.posts;
						//var obj = $.parseJSON( data );
						// without setting 'dataType' to JSON in the Ajax call, you have to parse the JSON before you can act on its content

						// paginate
						query_params.current_page = data.page;
						query_params.max_page = data.max_page;
						$(".comp_paginate").removeClass('active');
						if( data.page > 1 ) {
							$(".comp_paginate#prev").addClass('active');
						}
						if( data.max_page > 1 && data.max_page != data.page ) {
							$(".comp_paginate#next").addClass('active');
						}
						initiate = true;
					}
				});
			}
		});

		$(".comp_paginate").click(function(e){
			e.preventDefault();
			//get data-nex-order value
			if( initiate == true ) {

				var direction = $(this).attr('id');

				$.ajax({
					url: query_params.ajaxurl,
					crossDomain: true,
					type: 'POST',
					data:{
						'action':'sortcomps',
						'posts': query_params.posts,
						'column': $(".sort_heading.active").attr('id'),
						'sort': $(".sort_heading.active").attr('data-sort'),
						'page': query_params.current_page,
						'dir': direction
					},
					dataType : 'json', // super important
					beforeSend: function( xhr ){
						$(".table-wrapper").addClass('loading');
						initiate = false;
					},
					success: function( data ){
						$(".table-wrapper").removeClass('loading');
						// Clear Table and Set New Content
						$("#comps_table li:not(:first)").remove();
						$("#comps_table").append(data.content);
						query_params.posts = data.posts;

						// Paginate
						query_params.current_page = data.page;
						query_params.max_page = data.max_page;
						$(".comp_paginate").removeClass('active');
						if( data.page > 1 ) {
							$(".comp_paginate#prev").addClass('active');
						}
						if( data.max_page > 1 && data.max_page != data.page ) {
							$(".comp_paginate#next").addClass('active');
						}
						initiate = true;
					}
				});
			}
		});

		// Open Lightbox
		$(document).on("click", '.comp_inspect', function(e) {
			e.preventDefault();

			var id = $(this).attr('id');

			$.ajax({
				url: query_params.ajaxurl,
				crossDomain: true,
				type: 'POST',
				data:{
					'action':'getcomp',
					'id':id
				},
				dataType : 'json', // super important
				beforeSend: function( xhr ){
					$(".table-wrapper").addClass('loading'); // some type of preloader
				},
				success: function( data ){
					$(".table-wrapper").removeClass('loading');
					$(".fullcomp-wrapper").addClass('loaded');
					$("#fullcomp").html(data.content);
				}
			});
		});

		// Close Lightboxes
		$(document).on("click", '#fullcomp .close', function(e) {
			e.preventDefault();
			$(".fullcomp-wrapper").removeClass('loaded');
		});
		$(document).on("click", function(e) {
			var $trigger = $("#fullcomp");
			if($trigger !== event.target && !$trigger.has(event.target).length) {
				if( $(".fullcomp-wrapper").hasClass('loaded') ) {
					$(".fullcomp-wrapper").removeClass('loaded');
				}
			}
		});

});
