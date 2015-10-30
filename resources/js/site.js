(jQuery || $)(function(){

	// Login
	(function(){
		$('#home-form').form({
			fields: {
				name: {
					identifier: 'email',
					rules: [
						{
							type: 'email',
							prompt: 'Ingresa un e-mail válido.'
						}
					]
				},
				password: {
					identifier: 'password',
					rules: [
						{
							type: 'minLength[4]',
							prompt: 'La clave es muy corta.'
						}
					]
				},
				terms: {
					identifier: 'terms',
					rules: [
						{
							type: 'checked',
							prompt: 'Acepta los términos de uso.'
						}
					]
				}
			},
			onSuccess: function () {

				$form  = $(this);
				$form.addClass('loading');

				$.ajax({
					type: "POST",
					url: base_url + 'services/login',
					data: $form.serialize(),
					dataType: 'json'
				})
				.done(function(data){
					if(!data.error) {
						document.location.href = base_url;
					}
					else{
						$form.removeClass('loading');
						$form.form('add errors', [data.error.msg]);
						$form.find('.ui.error.message').show();
					}
				})
				.fail(function( jqXHR, textStatus ) {
						$form.removeClass('loading');
						$form.form('add errors',['Error']);
						$form.find('.ui.error.message').show();
					}
				);
				return false;
			}
		});

	})();

	// logout
	(function(){
		$('#user-logout').click(function(){
			$.ajax({
				type: "POST",
				url: base_url + 'services/logout',
				dataType: 'json'
			})
			.done(function(data){
				document.location.href = base_url;
			})
			.fail(function( jqXHR, textStatus ) {
				document.location.href = base_url;
			});
		});
	})();

	// stores
	(function(){

		var $map = $('#stores-map-canvas');
		if( $map.length == 0 )
			return;

		var CustomWindow = function(){
			this.container = $('<div class="map-info-window"></div>');
			this.layer = null;
			this.marker = null;
			this.position = null;
		};
		/**
		 * Inherit from OverlayView
		 * @type {google.maps.OverlayView}
		 */
		CustomWindow.prototype = new google.maps.OverlayView();
		/**
		 * Called when this overlay is set to a map via this.setMap. Get the appropriate map pane
		 * to add the window to, append the container, bind to close element.
		 * @see CustomWindow.open
		 */
		CustomWindow.prototype.onAdd = function(){
			this.layer = $(this.getPanes().floatPane);
			this.layer.append(this.container);
			var self = this;
			this.container.find('.map-info-close').on('click', function(){
				// Close info window on click
				self.close();
			});
		};
		/**
		 * Called after onAdd, and every time the map is moved, zoomed, or anything else that
		 * would effect positions, to redraw this overlay.
		 */
		CustomWindow.prototype.draw = function(){
			var scaledSize = {width:84,height:78};
			var markerIcon = this.marker.getIcon(),
					cHeight = this.container.outerHeight() + scaledSize.height + 10,
					cWidth = this.container.width() / 2 + scaledSize.width / 2;
			this.position = this.getProjection().fromLatLngToDivPixel(this.marker.getPosition());
			this.container.css({
				'top':this.position.y - cHeight,
				'left':this.position.x - cWidth
			});
		};
		/**
		 * Called when this overlay has its map set to null.
		 * @see CustomWindow.close
		 */
		CustomWindow.prototype.onRemove = function(){
			this.container.remove();
		};
		/**
		 * Sets the contents of this overlay.
		 * @param {string} html
		 */
		CustomWindow.prototype.setContent = function(html){
			this.container.html(html);
		};
		/**
		 * Sets the map and relevant marker for this overlay.
		 * @param {google.maps.Map} map
		 * @param {google.maps.Marker} marker
		 */
		CustomWindow.prototype.open = function(map, marker){
			this.marker = marker;
			this.setMap(map);
		};
		/**
		 * Close this overlay by setting its map to null.
		 */
		CustomWindow.prototype.close = function(){
			this.setMap(null);
		};


//Style Map
		var styleMap = [{
			"featureType": "landscape",
			"elementType": "labels",
			"stylers": [{"visibility": "off"}]
		}, {
			"featureType": "administrative",
			"elementType": "all",
			"stylers": [{"visibility": "simplified"}, {"lightness": "0"}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry",
			"stylers": [{"lightness": "0"}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry.stroke",
			"stylers": [{"lightness": "0"}]
		}, {
			"featureType": "administrative",
			"elementType": "labels",
			"stylers": [{"lightness": "0"}]
		}, {
			"featureType": "administrative",
			"elementType": "labels.text.fill",
			"stylers": [{"color": "#444444"}]
		}, {
			"featureType": "administrative.province",
			"elementType": "labels",
			"stylers": [{"lightness": "40"}]
		}, {
			"featureType": "administrative.locality",
			"elementType": "labels",
			"stylers": [{"lightness": "25"}]
		}, {
			"featureType": "administrative.neighborhood",
			"elementType": "labels",
			"stylers": [{"lightness": "40"}]
		}, {
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [{"color": "#f2f2f2"}]
		}, {
			"featureType": "landscape.man_made",
			"elementType": "all",
			"stylers": [{"lightness": "100"}]
		}, {
			"featureType": "landscape.natural",
			"elementType": "all",
			"stylers": [{"color": "#ffffff"}, {"lightness": "0"}]
		}, {
			"featureType": "landscape.natural.landcover",
			"elementType": "all",
			"stylers": [{"lightness": "0"}]
		}, {
			"featureType": "landscape.natural.landcover",
			"elementType": "geometry.fill",
			"stylers": [{"lightness": "0"}]
		}, {
			"featureType": "poi.park",
			"elementType": "all",
			"stylers": [{"visibility": "on"}, {"lightness": "27"}]
		}, {
			"featureType": "road",
			"elementType": "all",
			"stylers": [{"saturation": -100}, {"lightness": "45"}]
		}, {
			"featureType": "road",
			"elementType": "geometry.stroke",
			"stylers": [{"lightness": "-5"}]
		}, {
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [{"visibility": "simplified"}, {"weight": 2.92}, {"lightness": 33}]
		}, {
			"featureType": "road.highway",
			"elementType": "geometry.fill",
			"stylers": [{"lightness": -16}]
		}, {
			"featureType": "water",
			"elementType": "all",
			"stylers": [{"visibility": "on"}, {"color": "#afdbed"}, {"lightness": 35}]
		}, {
			"featureType": "road.arterial",
			"elementType": "geometry.stroke",
			"stylers": [{"visibility": "on"}, {"color": "#454545"}, {"lightness": 53}]
		}, {
			"featureType": "poi",
			"elementType": "labels",
			"stylers": [{"visibility": "off"}]
		}];

//Locations GPS
		var initialLocation	= new google.maps.LatLng(4.6216914,-74.0643938);

//Map Options
		var mapOptions = {
			zoom: 16,
			center: initialLocation,
			styles: styleMap,
			streetViewControl: false,
			disableDefaultUI: true
		};

// Lugares
		var places = [];

// Meses
		var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

		function gotoCurrentLocation( map ) {
			// Try W3C Geolocation (Preferred)
			var browserSupportFlag = true;
			if(navigator.geolocation) {
				browserSupportFlag = true;
				navigator.geolocation.getCurrentPosition(function(position) {
					map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude));
				}, function() {
					handleNoGeolocation(browserSupportFlag);
				});
			}
			// Browser doesn't support Geolocation
			else {
				browserSupportFlag = false;
				handleNoGeolocation(browserSupportFlag);
			}

			function handleNoGeolocation(errorFlag) {
				if (errorFlag == true) {
					alert("Geolocation service failed.");
				} else {
					alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
				}
				map.setCenter(initialLocation);
			}
		}

		function initialize( ) {

			var $placesList = $('#places');
			var $resultsList = $('#results .list');
			var markerSelected = null;
			//var infowindow = new google.maps.InfoWindow();
			var infowindow = new CustomWindow();
			var manMarkerTimeout = null;

			var map = new google.maps.Map(document.getElementById('stores-map-canvas'), mapOptions);

			var manMarker = new google.maps.Marker({
				map: map,
				icon: base_url + 'resources/img/marker_man.png'
			});
			manMarker.bindTo('position', map, 'center');

			google.maps.event.addListener(manMarker, 'click', (function(marker) {
				return function() {
					clearTimeout(manMarkerTimeout);
					infowindow.setContent('' +
						'<div class="map-info-close"><i class="icon inverted remove"></i></div>' +
							'<div class="content-marker">' +
								'<h3 class="content-title">Nuevo Establecimiento</h3>' +
								'<div class="content-body">' +
									'<div class="left">' +
										'<div class="ui mini action input">' +
											'<input type="text" value="" placeholder="Nombre" id="new_store_name">' +
											'<button class="ui teal mini right labeled icon button" id="new_store_add">' +
												'<i class="checkmark icon"></i>' +
												'Crear' +
											'</button>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div class="map-info-arrow"></div>'
					);
					infowindow.open(map, marker);
					google.maps.event.addListener(map, "dragstart", function(){ infowindow.close() } );
					map.setCenter(marker.getPosition());
				};
			})(manMarker));


			$( "#stores-map-canvas" ).on( "click", "#new_store_add", function() {

				var $name = $('#new_store_name');
				if( !$name.val() ) {
					$('.map-info-window .action.input').addClass('error');
					$name.focus();
					return;
				}
				else {
					$('.map-info-window .action.input').removeClass('error');
				}

				$.ajax({
						type: "POST",
						url: base_url + 'services/store/add',
						data: {
							name: $name.val( ),
							latitude: manMarker.getPosition().lat(),
							longitude: manMarker.getPosition().lng()
						},
						dataType: 'json'
					})
					.done(function(data){
						if(!data.error) {
							document.location.href = base_url + 'store/' + data.data.id;
						}
						else {
							alert(data.error.msg);
						}
					})
					.fail(function( jqXHR, textStatus ) {
						}
					);
			});

			google.maps.event.addListener(map, "dragend", function() {
				manMarkerTimeout = setTimeout(function(){
					google.maps.event.trigger( manMarker, 'click' );
				}, 3000 );
			});
			google.maps.event.addListener(map, "dragstart", function(){
				clearTimeout(manMarkerTimeout);
			});

			/*
			(new google.maps.Marker({
				map: map,
				icon: base_url + 'resources/img/marker_store.png'
			})).bindTo('position', map, 'center');


			(new google.maps.Marker({
				map: map,
				icon: base_url + 'resources/img/marker_pin2.png'
			})).bindTo('position', map, 'center');
			*/


			gotoCurrentLocation( map );
			$('#current_location').click(function(event){
				event.preventDefault();
				gotoCurrentLocation( map );
			});


			for( var index in places ) {
				var place = places[index];
				var marker = new google.maps.Marker({
					position: place.latlog,
					map: map,
					icon: base_url + 'resources/img/marker_store.png',
					title: place.title,
				});

				place.marker = marker;
				google.maps.event.addListener(marker, 'click', (function(marker,point) {
					return function() {
						clearTimeout(manMarkerTimeout);
						infowindow.setContent('' +
								'<div class="map-info-close"><i class="icon inverted remove"></i></div>' +
									'<div class="content-marker">' +
										'<h3 class="content-title">' + point.title + '</h3><br>' +
										'<button class="ui teal mini button" id="store_select" value="' + point.store  + '"><i class="sign in icon"></i> Seleccionar</button>' +
									'</div>' +
								'</div>' +
								'<div class="map-info-arrow"></div>'
						);
						infowindow.open(map, marker);
						markerSelected = marker;
						map.setCenter(marker.getPosition());
						google.maps.event.addListener(map, "dragstart", function(){ infowindow.close() } );
					};
				})(marker, place));
			}

			$( "#stores-map-canvas" ).on( "click", "#store_select", function() {
				document.location.href = base_url + 'store/' + $('#store_select').val();
			});

		}

		function initMap( ) {

			$.getJSON('/services/store/map',{},function(data){
				places = [];
				$.each( data.data, function(index,item){
					try {
						places.push(
							{
								store: item.id,
								title: item.name,
								latlog: new google.maps.LatLng(item.latitude,item.longitude)
							}
						);
					}
					catch( e ) {
						;
					}
				});
				initialize( );
			});
		}

		google.maps.event.addDomListener(window, 'load', initMap);

	})();

	// menu
	(function(){
		$('#mainMenu .button:first')
			.popup({
				popup : $('#mainMenu .popup:first'),
				on    : 'click',
				offset : 5,
				delay: {
					show: 300,
					hide: 800
				}
			})
		;
	})();
});

/*
[{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"},{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.province","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"lightness":"25"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"100"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"color":"#ffffff"},{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"lightness":"0"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"},{"lightness":"27"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":"45"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"lightness":"-5"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"},{"weight":2.92},{"lightness":33}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":-16}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#afdbed"},{"lightness":35}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#454545"},{"lightness":53}]}]
	*/