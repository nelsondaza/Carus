<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Policy extends GeneralController {
		private $data = array( );
		function __construct()
		{
			parent::__construct();

			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$this->data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$this->data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
			}

		}

		function index( ) {
			$this->carus( );
		}

		function carus ( ) {
			$this->viewCarus( $this->data );
		}

		function terms_of_service ( ) {
			$this->viewTerms( $this->data );
		}

		function privacy ( ) {
			$this->viewPrivacy( $this->data );
		}

	}
