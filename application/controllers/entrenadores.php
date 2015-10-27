<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Entrenadores extends GeneralController {
		protected $scope = '';

		function index() {

			$this->load->model( 'trainers_model' );
			$data = array(
				'trainers' => $this->trainers_model->get_order_by_name()
			);

			$hash = sha1( time( ) . 'hashcodeid' );
			$this->session->set_userdata('securecode', $hash);
			$data['hash'] = $hash;

			$this->view( $data );
		}

	}
