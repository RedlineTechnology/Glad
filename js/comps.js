jQuery(function($){

		// Get ready.
		var initiate = true;

		// SORT COMP TABLE
		$(".sort_heading").click(function(e){
			e.preventDefault();
			//get data-nex-order value
			if( initiate == true ) {
				var column = $(this);
				var sortOrder = column.attr('data-sort');
				var columnName = column.attr('id');

				$.ajax({
					url: 'https://glada.aero/wp-admin/admin-ajax.php',
					crossDomain: true,
					type: 'POST',
					data:{'action':'sortcomps','column':columnName,'sort':sortOrder},
					dataType : 'json', // super important
					beforeSend: function( xhr ){
						$(".table-wrapper").addClass('loading'); // some type of preloader
						initiate = false;
					},
					success: function( data ){
						if(sortOrder == 'asc') {
							column.attr('data-sort','desc');
						} else {
							column.attr('data-sort','asc');
						}
						$(".table-wrapper").removeClass('loading');
						$(".sort_heading").removeClass('active');
						column.addClass('active');
						$("#comps_table li:not(:first)").remove();
						//var obj = $.parseJSON( data );
						// without setting 'dataType' to JSON in the Ajax call, you have to parse the JSON before you can act on its content
						$("#comps_table").append(data.content);

						// paginate
						$(".comp_paginate").attr('data-page',data.page);
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
				var arrow = $(this);
				var direction = arrow.attr('id');
				var page = arrow.attr('data-page');

				var column = $(".sort_heading.active");
				if( column.length > 1 ) {
				 var columnName = 'default';
				 var sortOrder = 'asc';
			 } else {
				 var sortOrder = column.attr('data-sort');
	 			 var columnName = column.attr('id');
			 }

				$.ajax({
					url: 'https://glada.aero/wp-admin/admin-ajax.php',
					crossDomain: true,
					type: 'POST',
					data:{'action':'sortcomps','column':columnName,'sort':sortOrder,'page':page,'dir':direction},
					dataType : 'json', // super important
					beforeSend: function( xhr ){
						$(".table-wrapper").addClass('loading'); // some type of preloader
						initiate = false;
					},
					success: function( data ){
						$(".table-wrapper").removeClass('loading');
						$("#comps_table li:not(:first)").remove();
						$("#comps_table").append(data.content);

						// paginate
						$(".comp_paginate").attr('data-page',data.page);
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

		$(document).on("click", '.comp_inspect', function(e) {
			e.preventDefault();

			var id = $(this).attr('id');

			$.ajax({
				url: 'https://glada.aero/wp-admin/admin-ajax.php',
				crossDomain: true,
				type: 'POST',
				data:{'action':'getcomp','id':id},
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

		// $("#fullcomp .close").click(function(e) {
		// 	e.preventDefault();
		//
		// 	$("#fullcomp").removeClass('loaded');
		// });

});
