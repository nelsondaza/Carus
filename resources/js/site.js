
(jQuery || $)(function(){

	/*
	function hideAddressBar()
	{
		if(!window.location.hash)
		{
			if(document.height <= window.outerHeight + 10)
			{
				alert( document.body.style.height +' ' + (window.outerHeight + 50) +'px');
				document.body.style.height = (window.outerHeight + 50) +'px';

				setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
			}
			else
			{
				setTimeout( function(){ window.scrollTo(0, 1); }, 0 );
			}
		}
	}
	hideAddressBar();
	window.addEventListener("orientationchange", hideAddressBar );
	*/


	// menu
	(function(){
		$('#user-login').click(function(){
			$(this).addClass('active').siblings('button').removeClass('active');
			$('#login-form').removeClass('hidden').show().siblings('form').hide();
		});
		$('#user-register').click(function(){
			$(this).addClass('active').siblings('button').removeClass('active');
			$('#register-form').removeClass('hidden').show().siblings('form').hide();
		});
		$('.password-reset').click(function(event){
			event.preventDefault();
			$('#user-login,#user-register').removeClass('active');
			$('#password-form').removeClass('hidden').show().siblings('form').hide();
		});
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

		$('#mainMenu .button:first').popup({
			popup : $('#mainMenu .popup:first'),
			on    : 'click',
			offset : 5,
			delay: {
				show: 300,
				hide: 800
			}
		});

	})();

	// Login
	(function(){
		$('#login-form').form({
			fields: {
				email: {
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

	// Reset
	(function(){
		$('#password-form').form({
			fields: {
				email: {
					identifier: 'email',
					rules: [
						{
							type: 'email',
							prompt: 'Ingresa un e-mail válido.'
						}
					]
				}
			},
			onSuccess: function () {

				$form  = $(this);
				$form.addClass('loading');

				$.ajax({
					type: "POST",
					url: base_url + 'services/login/forgot',
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

	// register
	(function(){
		$('#register-form').form({
			fields: {
				name: {
					identifier: 'name',
					rules: [
						{
							type: 'minLength[4]',
							prompt: 'Ingresa un nombre válido.'
						}
					]
				},
				gender: {
					identifier: 'gender',
					rules: [
						{
							type: 'empty',
							prompt: 'Debes seleccionar un género.'
						}
					]
				},
				email: {
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
					url: base_url + 'services/register',
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



	// stores
	(function(){

		var $map = $('#stores-map-canvas');
		if( $map.length == 0 )
			return;

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


// Meses
		var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

		function gotoCurrentLocation( map ) {
			var $locationButton = $('#current_location');
			var popupTimeout = null;
			showLocationPopup('Ubicando...','yellow');

			// Try W3C Geolocation (Preferred)
			var browserSupportFlag = true;
			if(navigator.geolocation) {
				browserSupportFlag = true;
				navigator.geolocation.getCurrentPosition(function(position) {
					showLocationPopup('¡Encontrado!','green');
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
					showLocationPopup('El servicio de ubicación no está activo', 'orange');
				} else {
					showLocationPopup('Tu navegador no permite Geolocalización.', 'red');
				}
				map.setCenter(initialLocation);
			}

			function showLocationPopup( msg, style ) {

				clearTimeout( popupTimeout );

				$locationButton.removeClass('yellow red orange green').addClass(style);
				if( $locationButton.popup('exists') ) {
					$locationButton.popup('destroy');
				}

				if( msg ) {
					$locationButton.popup({
						on: 'manual',
						variation: 'mini',
						addTouchEvents:	true,
						html: msg
					});
					$locationButton.popup('show');
					popupTimeout = setTimeout(function(){
						$locationButton.popup('destroy');
					}, 2000)
				}
			}
		}

		function initialize( ) {

			var $placesList = $('#places');
			var $resultsList = $('#results .list');
			var markerSelected = null;
			var infowindow = new google.maps.InfoWindow();
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

	// producto
	(function(){
		$('#product_search').search({
			apiSettings: {
				url: base_url + 'services/product/search?q={query}'
			},
			fields: {
				results : 'data',
				title   : 'name'
			},
			minCharacters : 3,
			onSelect: function(result , response) {
				console.debug( result, response );
			},
			error : {
				source      : 'No se puede realizar la búsqueda.',
				noResults   : 'No se encontraron coincidencias. <button class="ui green mini button"> NUEVO</button>',
				logging     : 'Error el log de errores, saliendo.',
				noTemplate  : 'No se especificó un nombre de plantilla válido.',
				serverError : 'Hay un problema al realizar la petición.',
				maxResults  : 'El resultado debe ser un arreglo.',
				method      : 'El método llamado no está definido.'
			},
			templates2 : {
				escape: function(string) {
					// returns escaped string for injected results
				},
				message: function(message, type) {
					// returns html for message with given message and type
				},
				category: function(response) {
					// returns results html for category results
				},
				standard: function(response) {
					// returns results html for standard results
				}
			}
		});
		$('#product_search').on('click','.description .green.button',function(event){

		});

		$('#product-form').form({
			fields: {
				name: {
					identifier: 'name',
					rules: [
						{
							type: 'minLength[3]',
							prompt: 'Ingresa un nombre válido.'
						}
					]
				},
				price: {
					identifier: 'price',
					rules: [
						{
							type: 'number',
							prompt: 'El precio es incorrecto'
						},
						{
							type: 'empty',
							prompt: 'El precio es incorrecto'
						}
					]
				}
			},
			onSuccess: function () {

				$form  = $(this);
				$form.addClass('loading');

				$.ajax({
							type: "POST",
							url: base_url + 'services/product/add',
							data: $form.serialize(),
							dataType: 'json'
						})
						.done(function(data){
							if(!data.error) {
								alert('select Product');
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
});

/*
[{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"},{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.province","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"lightness":"25"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"100"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"color":"#ffffff"},{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"lightness":"0"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"},{"lightness":"27"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":"45"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"lightness":"-5"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"},{"weight":2.92},{"lightness":33}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":-16}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#afdbed"},{"lightness":35}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#454545"},{"lightness":53}]}]
	*/


/*
* buscar en todo el nombre la parte de texto
* ç
*
* resultado de comparacion de precios.
* tiendas más cercanas a unos metros de distancia. (200mts)
* cercanos a 200mts ... si hay no se muestran más
* si no, el más cerca a 300mts.
*
*
* en el buscador mostrar resultados en mapa.
*
* detalle de producto al buscar.
* eliminar precio.
* actualizar precio.
*
* Reporte de productos comprados, paginado, de a 5, con fecha precio y tienda.
*
*
* al buscar un productos se de be filtrar así:
*
* Precio menor.
* FEcha de ingreso del precio.
* distancia a la ubicación actual.
* limitado a 5.
*
*
*
* ADMINIOSTRACION
*
* cuantas veces se ha logueado un usuario.
* estadísticas de cambios de precio.
* actividad de los usuairos.
*
*
* video de 10-15 min
* mostrando todo el programa.
* modelo de tablas y técnico para mostrar.
*
*
* */