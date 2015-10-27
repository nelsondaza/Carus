<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Logout
	 */
	class Logout extends ServicesController {
		protected $scope = 'services';

		function index() {
			$this->data = array(
				'logout' => 'NOT NEEDED'
			);

			$this->session->unset_userdata('connect_create');
			if ( $this->authentication->is_signed_in() ) {
				// Run sign out routine
				$this->authentication->sign_out();
				$this->data = array(
					'logout' => 'DONE'
				);
			}
			$this->shapeResponse();
		}
	}

