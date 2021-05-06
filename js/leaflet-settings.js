jQuery(function($){

	// GET LOCALIZED VARS
	var dir = themevars.template_directory;
	var userid = themevars.userid;
	var alllocations = themevars.locations;
	var marker = null;
	var setupMarker = null;

	// THIS IS AN OBJECT. WHYYY?
	// TODO FIGURE THIS OUT
	console.log( alllocations );

	// INSTANCIATE LEAFLET MAP
	var mymap = L.map('membermap').setView([41, -38], 3);
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'sk.eyJ1IjoiamFzb25zdWJlcnMiLCJhIjoiY2tlaW43OXU3MGxjbjJ6cGh4M21rdWR0ZiJ9.oV_Z2tiuL8vXqZucCG4kOg'
	}).addTo(mymap);

	// SET LOCATIONS
	$.each( alllocations, function( index, value ) {
		var markerid = value.id;
		var name = value.name;
		var link = value.link;
		var company = value.company;
		var logo = value.logo;
		var memblocations = JSON.parse( value.locations );

		$.each( memblocations, function( index, value) {
			var title = value.name;
			var latlng = value.latlng;
			if( latlng != "" ) {
				var removehtml = "";
				if( userid == markerid ) {
					removehtml = '<form action="#" method="POST" class="deletenode" enctype="multipart/form-data">' +
					'<input type="hidden" name="action" value="deletenode">' +
					'<input type="hidden" name="user_id" value="' + userid + '">' +
					'<input type="hidden" name="node" value=\'' + JSON.stringify(latlng) + '\'>' +
					'<button class="deletenode nostyle" value="deletenode">Remove</button>' +
				'</form>';
				}

				popup = L.popup();
				setupMarker = L.marker(latlng).addTo(mymap);
				// marker._myId = Math.floor( Math.abs( latlng.lat * 10 ) ) + Math.floor( Math.abs( latlng.lng * 100 ) );
				popup
						.setLatLng(latlng)
						.setContent(
							'<div class="logo"><img src="' + logo + '"></div>' +
							'<div class="info">' +
							'<span><a href="' + link  + '">' + name + '</a></span>' +
							'<br>' +
							'<span>' + company + '</span>' +
							'<br>' +
							'<span>' + title + '</span>' +
							'<br>' +
							'<!--<span>' + latlng.lat + ', ' + latlng.lng + '</span>-->' + removehtml +
							'</div>'
						);
				setupMarker.bindPopup(popup);
			}
		});
	});

	// INSTANCIATE GEOCODER - SEARCH FOR MARKER
	var geocoder = L.Control.geocoder({
	  defaultMarkGeocode: false
	})
	  .on('markgeocode', function(e) {
			var center = e.geocode.center;
			var name = e.geocode.name;
			var greenIcon = L.icon({
				iconUrl: dir + '/vendor/leaflet/images/marker-icon-green.png',
				iconRetinaUrl: dir + '/vendor/leaflet/images/marker-icon-green-2x.png',
				iconSize: [25, 41],
				iconAnchor: [12, 41],
				popupAnchor: [1, -34],
				tooltipAnchor: [16, -28],
				shadowUrl: dir + '/vendor/leaflet/images/marker-shadow.png',
				shadowSize:[41,41],
			});
			var marker = L.marker(center, {title: name, icon: greenIcon}).addTo(mymap).on('mouseover', customizePopup);
			mymap.panTo(center);
	  })
	  .addTo(mymap);

	// SET POPUP CONTENTS
	function customizePopup(e) {
		var popup = L.popup();
		var name = this.options.title;
		var latlng = this.getLatLng();

		popup
				.setLatLng( latlng )
				.setContent(
					'<div class="info">' +
						'<span>' + name + '</span>' +
						'<br>' +
						'<span>' + latlng.lat + ', ' + latlng.lng + '</span><br>' +
						'<form action="#" method="POST" class="membermap-form" id="membermap-form" enctype="multipart/form-data">' +
							'<input type="hidden" name="action" value="savelocation">' +
							'<input type="hidden" name="user_id" value="' + userid + '">' +
							'<input type="hidden" name="loc_name" value="' + name + '">' +
							'<input type="hidden" name="latlng" value=\'' + JSON.stringify(latlng) + '\'>' +
							'<button id="membermap-submit" value="savelocation">Save to My Locations</button>' +
						'</form>' +
					'</div>'
				);
		this.bindPopup(popup).openPopup();

		// SUBMIT FORM
		$('.membermap-form').submit( function() {
			$.ajax({
					url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
					type: 'POST',
					data: $(this).find(':input').filter( function(index, element) {
									return $(element).val() != '';
								}).serialize(),
					dataType: 'json',
					beforeSend: function( xhr ) {
						$('#membermap-submit').addClass('loading').text('Saving...');
					},
					success: function( data ) {
						$('#membermap-submit').removeClass('loading').text('SUCCESS!');
						mymap.removeLayer(marker);
						var newMarker = L.marker(latlng).addTo(mymap);
					}
			});
			return false;
		});
	}

	// CLICK ON MAP MARKER
	var popup = L.popup();
	var marker = {};

	function onMapClick(e) {
		if ( marker != undefined ) {
			mymap.removeLayer(marker);
		}

		var geocoder = L.Control.Geocoder.nominatim();

		geocoder.reverse(e.latlng, mymap.options.crs.scale(mymap.getZoom()), function(results) {
		  var r = results[0];
			var redIcon = L.icon({
				iconUrl: dir + '/vendor/leaflet/images/marker-icon-red.png',
				iconRetinaUrl: dir + '/vendor/leaflet/images/marker-icon-red-2x.png',
				iconSize: [25, 41],
				iconAnchor: [12, 41],
				popupAnchor: [1, -34],
				tooltipAnchor: [16, -28],
				shadowUrl: dir + '/vendor/leaflet/images/marker-shadow.png',
				shadowSize:[41,41],
			});

		  if (r) {
	      marker = L.marker(r.center, {title: r.name, icon: redIcon}).addTo(mymap).on('mouseover', customizePopup);
				// marker = L.marker(e.latlng).addTo(mymap).on('mouseup', customizePopup);
				// popup
				// 		.setLatLng(r.center)
				// 		.setContent(
				// 			'<span>' + r.name + '</span>'
				// 		);
				// marker.bindPopup(popup).openPopup();
		  }
		});

		// This is Duplicated Here from Above. Yeah, DRY, I know. But it works and I'm on a deadline.
		// SUBMIT FORM
		$('.membermap-form').submit( function() {
			$.ajax({
					url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
					type: 'POST',
					data: $(this).find(':input').filter( function(index, element) {
									return $(element).val() != '';
								}).serialize(),
					dataType: 'json',
					beforeSend: function( xhr ) {
						$('#membermap-submit').addClass('loading').text('Saving...');
					},
					success: function( data ) {
						$('#membermap-submit').removeClass('loading').text('SUCCESS!');
						mymap.removeLayer(marker);
						var newMarker = L.marker(latlng).addTo(mymap);
					}
			});
			return false;
		});
	}
	mymap.on('click', onMapClick);

	function onPopup(e) {
		popMarker = e.popup._source;

		// DELETE NODE FORM
		$('form.deletenode').submit( function() {
			$.ajax({
					url: 'https://www.glada.aero/wp-admin/admin-ajax.php',
					type: 'POST',
					data: $(this).find(':input').filter( function(index, element) {
									return $(element).val() != '';
								}).serialize(),
					dataType: 'json',
					beforeSend: function( xhr ) {
						$(this).find('button').addClass('loading').text('Removing...');
					},
					success: function( data ) {
						$(this).find('button').removeClass('loading').text('SUCCESS!');
						mymap.removeLayer(popMarker);
					}
			});
			return false;
		});
	}
	mymap.on('popupopen', onPopup);

});
