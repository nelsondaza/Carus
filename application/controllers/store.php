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

			$data['store'] = $this->store_model->get_one_by_id( (int)$id );

			$this->view( $data );
		}

	}
