<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Store extends GeneralController {
		function __construct()
		{
			parent::__construct();

			$this->load->model(array('manage/store_model'));

		}
		function index( $id = 0 ) {

			$data = $this->auth( true );
			if( (int)$id <= 0 )
				redirect('');

			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$data['store'] = $this->store_model->get_one_by_id( (int)$id );

			$this->view( $data );
		}

	}
