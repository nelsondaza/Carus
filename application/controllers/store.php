<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Store extends GeneralController {


		function index( $id ) {

			$data = $this->auth( true );
			if( $id <= 0 )
				redirect('');

			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$data['store'] = $this->model->get_one_by_id( $id );

			$this->view( $data );
		}

	}