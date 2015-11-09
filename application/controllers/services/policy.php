<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 */
	class Policy extends ServicesController {
		protected $scope = 'common';

		function index( ) {
			$this->carus( );
		}

		function carus ( ) {
			$this->viewCarus( null );
		}

		function terms ( ) {
			$this->viewTerms( );
		}

		function privacy ( ) {
			$this->viewPrivacy( );
		}

	}
