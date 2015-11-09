
(jQuery || $)(function(){
//Style Map
	var styleMap = [
		{
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

	// login
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

	// reset
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

			var markerSelected = null;
			var manMarkerTimeout = null;
			var $storeMenu = $('#stores-menu');

			var map = new google.maps.Map(document.getElementById('stores-map-canvas'), mapOptions);
			var manMarker = new google.maps.Marker({
				map: map,
				icon: base_url + 'resources/img/marker_man.png'
			});
			manMarker.bindTo('position', map, 'center');

			$storeMenu.find('.nav').show().slideUp(0);

			function storeNew( ) {
				var $holder = $('#store-menu-create');
				$holder.siblings('.nav').stop().slideUp( );
				$holder.stop().slideDown( );
			}
			function storeSelect( point ) {
				var $holder = $('#store-menu-select');
				$holder.siblings('.nav').stop().slideUp( );
				$holder.find('.black.inverted.label span').text(point.title);
				$('#store_selected').val(point.store);
				$holder.stop().slideDown( );
			}
			function storeNone( ) {
				$storeMenu.find('.nav').stop().slideUp( );
			}

			$storeMenu.find('.close').click(function() {
				storeNone();
			});
			$("#new_store_add").click(function() {
				var $name = $('#new_store_name');
				if( !$name.val() ) {
					$(this).parent().addClass('error');
					$name.focus();
					return;
				}
				else {
					$(this).parent().removeClass('error');
				}

				var marker = $(this).closest('.nav').data('marker');
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
						$name.val('');
						document.location.href = base_url + 'store/' + data.data.id;
					}
					else {
						alert(data.error.msg);
					}
				})
				.fail(function( jqXHR, textStatus ) {
					;
				});
			});
			$("#store_selected").click(function() {
				document.location.href = base_url + 'store/' + $(this).val();
			});

			google.maps.event.addListener(manMarker, 'click', (function(marker) {
				return function() {
					clearTimeout(manMarkerTimeout);
					storeNew( );
				};
			})(manMarker));
			google.maps.event.addListener(map, "dragend", function() {
				manMarkerTimeout = setTimeout(function(){
					google.maps.event.trigger( manMarker, 'click' );
				}, 3000 );
			});
			google.maps.event.addListener(map, "dragstart", function(){
				clearTimeout(manMarkerTimeout);
				storeNone( );
			});

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
					title: place.title
				});

				place.marker = marker;
				google.maps.event.addListener(marker, 'click', (function(marker,point) {
					return function() {
						clearTimeout(manMarkerTimeout);
						markerSelected = marker;
						map.setCenter(marker.getPosition());
						storeSelect( point );
					};
				})(marker, place));
			}

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

	// store
	(function(){

		var $map = $('#products-map-canvas');
		if( $map.length == 0 )
			return;

//Locations GPS
		var initialLocation	= new google.maps.LatLng(storePoint.lat,storePoint.lng);

//Map Options
		var mapOptions = {
			zoom: 19,
			center: initialLocation,
			styles: styleMap,
			streetViewControl: false,
			disableDefaultUI: true
		};


// Lugares
		var places = [];
// Meses
		var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

		function gotoSoreLocation( map ) {
			map.setCenter(initialLocation);
		}
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

			var markerSelected = null;
			var manMarkerTimeout = null;
			var $productMenu = $('#products-menu');

			var map = new google.maps.Map(document.getElementById('products-map-canvas'), mapOptions);
			var manMarker = new google.maps.Marker({
				map: map,
				icon: base_url + 'resources/img/marker_man.png'
			});
			manMarker.bindTo('position', map, 'center');

			var storeMarker = new google.maps.Marker({
				position: new google.maps.LatLng(storePoint.lat,storePoint.lng),
				map: map,
				icon: base_url + 'resources/img/marker_store.png',
			});

			$productMenu.find('.nav').show().slideUp(0);

			function productNew( ) {
				var $holder = $('#product-menu-create');
				$holder.siblings('.nav').stop().slideUp( );
				$holder.stop().slideDown( );
			}
			function productSelect( point ) {
				var $holder = $('#product-menu-select');
				$holder.siblings('.nav').stop().slideUp( );
				$holder.find('.black.inverted.label span').text(point.title);
				$('#product_selected').val(point.product);
				$holder.stop().slideDown( );
			}
			function productNone( ) {
				$productMenu.find('.nav').stop().slideUp( );
			}

			$productMenu.find('.close').click(function() {
				productNone();
			});
			$("#new_product_add").click(function() {
				var $name = $('#new_product_name');
				if( !$name.val() ) {
					$(this).parent().addClass('error');
					$name.focus();
					return;
				}
				else {
					$(this).parent().removeClass('error');
				}

				var marker = $(this).closest('.nav').data('marker');
				$.ajax({
					type: "POST",
					url: base_url + 'services/product/add',
					data: {
						name: $name.val( ),
						latitude: manMarker.getPosition().lat(),
						longitude: manMarker.getPosition().lng()
					},
					dataType: 'json'
				})
				.done(function(data){
					if(!data.error) {
						$name.val('');
						document.location.href = base_url + 'product/' + data.data.id;
					}
					else {
						alert(data.error.msg);
					}
				})
				.fail(function( jqXHR, textStatus ) {
					;
				});
			});
			$("#product_selected").click(function() {
				document.location.href = base_url + 'product/' + $(this).val();
			});

			google.maps.event.addListener(manMarker, 'click', (function(marker) {
				return function() {
					clearTimeout(manMarkerTimeout);
					productNew( );
				};
			})(manMarker));
			google.maps.event.addListener(map, "dragend", function() {
				manMarkerTimeout = setTimeout(function(){
					google.maps.event.trigger( manMarker, 'click' );
				}, 3000 );
			});
			google.maps.event.addListener(map, "dragstart", function(){
				clearTimeout(manMarkerTimeout);
				productNone( );
			});

			gotoSoreLocation( map );
			$('#current_location').click(function(event){
				event.preventDefault();
				gotoCurrentLocation( map );
			});
			$('#product_search').find('.teal.label').click(function(event){
				event.preventDefault();
				gotoSoreLocation( map );
			});


			for( var index in places ) {
				var place = places[index];
				var marker = new google.maps.Marker({
					position: place.latlog,
					map: map,
					icon: base_url + 'resources/img/marker_product.png',
					title: place.title
				});

				place.marker = marker;
				google.maps.event.addListener(marker, 'click', (function(marker,point) {
					return function() {
						clearTimeout(manMarkerTimeout);
						markerSelected = marker;
						map.setCenter(marker.getPosition());
						productSelect( point );
					};
				})(marker, place));
			}

		}

		function initMap( ) {
			initialize( );
			return;
			$.getJSON('/services/product/map',{},function(data){
				places = [];
				$.each( data.data, function(index,item){
					try {
						places.push(
							{
								product: item.id,
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

		function productNew( ) {
			var $holder = $('#product-create');
			$holder.siblings('.nav').stop().slideUp( );
			$holder.stop().slideDown( );
			$('#product-create').find('input[name="name"]').val( $('#product_search').search('get value')).focus();
		}
		function productSelect( product ) {
			var $holder = $('#product-select');
			$holder.siblings('.nav').stop().slideUp( );
			$holder.find('.header').text( product.title );
			$('#product_new_price_add').data('product',product);
			$holder.stop().slideDown( );

			var $list = $holder.find('.list:first');
			$list.empty();

			$.getJSON('/services/product/price_list',{
				id: product.id,
				latitude: storePoint.lat,
				longitude: storePoint.lng
			},function(data){
				$.each( data.data, function(index,item){
					$list.append([
					'<div class="result">',
						'<div class="price">' + item.price + '</div>',
						'<div class="title">' + item.title + '</div>',
						'<div class="description">' + item.description + '</div>',
					'</div>'
					].join(''));
				});
			});

		}
		function productNone( ) {
			$('#product_content').find('.nav').stop().slideUp( );
		}

		$('#product_content').find('.nav').show().slideUp(0);
		$('#product_content').find('.close').click(function() {
			productNone();
		});

		$('#product_search').search({
			apiSettings: {
				url: base_url + 'services/product/search?q={query}&latitude=' + storePoint.lat + '&longitude=' + storePoint.lng
			},
			fields: {
				results : 'data',
				title   : 'title',
				description: 'description',
				price: 'price',
				action: 'action',
				actionText: 'actionText'
			},
			searchFields: [
				'name',
				'brand',
				'size'
			],
			searchDelay: 300,
			minCharacters : 3,
			onSelect: function(result, response) {
				productSelect( result );
				$('#product_search').search('set value','');
			},
			error : {
				source      : 'No se puede realizar la búsqueda.',
				noResults   : 'No se encontraron productos. <button class="ui green mini button"> NUEVO</button>',
				logging     : 'Error en el log, saliendo.',
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
			event.preventDefault();
			$('#product_search').search('hide results');
			productNew();
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
					$form.removeClass('loading');
					if(!data.error) {
						productSelect( data.data );
					}
					else {
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

		$('#product_new_price_add').click(function () {
			var $self = $(this);
			$self.addClass('loading');
			$.ajax({
				type: "POST",
				url: base_url + 'services/product/price',
				data: {
					price: $('#product_new_price').val(),
					id_store: storePoint.id,
					id_product: $self.data('product').id
				},
				dataType: 'json'
			})
			.done(function(data){
				$self.removeClass('loading');
				if(!data.error) {
					productSelect( data.data );
				}
			});
		});


	})();

});

/*
[{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"},{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"lightness":"0"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.province","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"lightness":"25"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"lightness":"40"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"100"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"color":"#ffffff"},{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"lightness":"0"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"lightness":"0"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"},{"lightness":"27"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":"45"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"lightness":"-5"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"},{"weight":2.92},{"lightness":33}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":-16}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#afdbed"},{"lightness":35}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#454545"},{"lightness":53}]}]
	*/


/*
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
* al buscar un productos se debe filtrar así:
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

/*

 textos
 calculo de distancia
 opción de eliminar producto



 **/