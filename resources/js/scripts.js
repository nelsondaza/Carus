/**
 * Created by nelson.daza on 30/01/2015.
 *
 */

// Avoid `console` errors in browsers that lack a console.
(function() {
	var method;
	var noop = function () {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});

	while (length--) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());

function userLoggedIn( ) {
	console.debug( 'IN' );
}

function userLoggedOut( ) {
	console.debug( 'OUT' );
}

function FBManage( config ) {

	var configDefault = {
		appId: null,        // Facebook App Id
		scope: '',          // Facebook scope required for the app
		onResponse: null,   // Function Called after Facebook LoginStatus response (If it returns a value different from false default action will be avoided)
		onLogout: null,     // Function Called after Facebook Logout
		onLogin: null,      // Function Called after Facebook Login response
		onAccounts: null    // Function Called after Facebook Accounts response
	};

	var user = null;
	var accounts = null;
	var self = this;
	var active = false;

	this.getUser = function ( ) {
		return user;
	};

	this.logout = function ( forceFBLogout ) {
		user = null;
		if( forceFBLogout && FB.getAccessToken() ) {
			FB.logout( function( ) {
				if( config.onLogout )
					config.onLogout( );
			});
		}
		else {
			if( config.onLogout )
				config.onLogout( );
		}
	};

	this.login = function ( ) {
		if( !active )   {
			FB.Event.subscribe('auth.authResponseChange', setResponse );
			active = true;
		}
		if( !FB.getAccessToken() || !user ) {
			FB.login(function (response) {
				// this.authResponseChange will handle it
			}, {
				scope: config.scope,
				auth_type: 'rerequest'
			});
		}
	};

	function setResponse( response ) {

		console.debug('response', response);
		user = null;
		accounts = null;

		if( config.onResponse && config.onResponse( response ) ) {
			if ( response.status === 'connected' )
				loadFBUserInfo( );
			return;
		}

		if ( response.status === 'connected' ) {
			loadFBUserInfo( );
		}
		else if ( response.status === 'not_authorized' ) {
			;
		}
		else { // response.status === 'unknown'
			self.logout( );
		}
	}

	function loadFBUserInfo( ) {
		FB.api('/me', function (response) {
			if (response && response.id) {
				user = response;
				if( config.onLogin ) {
					config.onLogin( response );
				}
			}
		});
	}

	window.fbAsyncInit = function () {
		// Executed when the SDK is loaded
		FB = FB || {
			init:function(){},
			getLoginStatus:function(){},
			getAccessToken:function(){},
			logout:function(){},
			login:function(){},
			Event:{
				subscribe:function(){}
			}
		};

		FB.init({
			// App ID
			appId: config.appId,
			// Adding a Channel File improves the performance of the javascript SDK, by addressing issues with cross-domain communication in certain browsers.
			channelUrl: 'channel.html',
			// Check the authentication status at the start up of the app
			status: true,
			// Enable cookies to allow the server to access the session
			cookie: true,
			// Parse XFBML
			xfbml: true,
			// FB API Version
			version    : 'v2.2'
		});

	};

	(function(d){
		// load the Facebook javascript SDK
		var js,
			id = 'facebook-jssdk',
			ref = d.getElementsByTagName('script')[0];

		if (d.getElementById(id))
			return;

		js = d.createElement('script');
		js.id = id;
		js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";

		ref.parentNode.insertBefore(js, ref);

	}(document));

}

$(function(){

	// Menú
	var $mainMenu = $('#mainMenu');
	console.debug( $mainMenu.length );
	if( $mainMenu.length > 0 ) {
		$mainMenu.find('a.menuOption').each(function(index, option){
			$(option).mouseenter(function(){
				$(this).find('.menuLabel').stop().animate({
					'width': 159
				}, 200);
			}).mouseleave(function(){
				$(this).find('.menuLabel').stop().animate({
					'width': 0
				}, 600);
			});
		});
	}

	var fbm = new FBManage({
		appId: '885380281483019',
		scope: 'public_profile,email',
		onLogout: function( ) {
			userLoggedOut( );
			$('.boxFold .loginGeneral').slideDown();
			$('.boxFold .userLoggedIn').slideUp();
			$('.userHeader').slideUp();
			$('#userLoggedMO').hide();
			$('#userRegisterMO').show();
		},
		onLogin: function( user ) {
			console.debug( user );
			console.debug( '/services/login/facebook' );
			$('.lz-access:first').css('opacity',.4);
			$.getJSON('/services/login/facebook', {
				'time': new Date().getTime()
			}, function ( response ) {
				console.debug( response.data );
				$('.lz-access:first').css('opacity',1);

				if( response.data.place == 'out,create' ) {
					alert( 'No registrado.' );
				}
				else if( response.data.place == 'out,found' ) {
					alert( 'Encontrado' );
				}
				else if( response.data.place == 'in,found' ) {
					var name = ( response.data.user.fullname ? response.data.user.fullname : response.data.user.firstname + ' ' + response.data.user.lastname );
					$('.boxFold .loginGeneral').slideUp();
					$('.boxFold .userLoggedIn .topBox h1').text( name );
					$('.boxFold .userLoggedIn').slideDown();
					$('.userHeader .user').text( name );
					$('.userHeader').slideDown();
					$('#userLoggedMO').show();
					$('#userRegisterMO').hide();
				}
			});
			//userLoggedIn( );
		}
	});

	$('.logos a.fb').click(function(event){
		event.preventDefault();
		console.debug( fbm.login );
		fbm.login();
	});

	$('.userHeader a:first, #userLoggedMO a').click(function(event){
		event.preventDefault();
		$.getJSON('/services/logout', {
			'time': new Date().getTime()
		}, function ( response ) {
			fbm.logout();
		});
	});

	// Forgot
	var $visibleBeforeForgot = null;
	$('.boxFold .forgotPassword a:first').click(function(event){
		event.preventDefault();
		$visibleBeforeForgot = $('.boxFold>div:visible:not(.bottomBox)');
		$visibleBeforeForgot.slideUp();
		$('.boxFold .forgetPass .error').hide();
		$('.boxFold .forgetPass').slideDown();
	});
	$('.boxFold .forgetPass .close a:first').click(function(event){
		event.preventDefault();
		$('.boxFold .forgetPass').slideUp();
		$visibleBeforeForgot.slideDown();
	});
	$('.boxFold .forgetPassError .close a').click(function(event){
		event.preventDefault();
		$('.boxFold>div:visible:not(.bottomBox)').slideUp( );
		$('.boxFold .forgetPass').slideDown();
	});
	$('.boxFold .forgetPassError .ingresar a').click(function(event){
		event.preventDefault();
		$('.boxFold>div:visible:not(.bottomBox)').slideUp( );
		$('.boxFold .loginGeneral').slideDown();
	});
	$('.boxFold .forgetPassSent a').click(function(event){
		event.preventDefault();
		$('.boxFold>div:visible:not(.bottomBox)').slideUp( );
		$('.boxFold .loginGeneral').slideDown();
	});

	$('#formForgetPass input.loginButton').click(function(event){
		event.preventDefault();

		var email = $('#userEmailSend').val();
		$.getJSON('/services/login/forgot', {
			'time': new Date().getTime(),
			'email': email
		}, function ( response ) {

			console.debug( response );
			if( response.error && response.error.code ) {
				$('.boxFold>div:visible:not(.bottomBox)').slideUp( );
				$('.boxFold .forgetPassError').slideDown();
			}
			else {
				$('.boxFold>div:visible:not(.bottomBox)').slideUp( );
				$('.boxFold .forgetPassSent').slideDown();
			}

		});
	});

});


