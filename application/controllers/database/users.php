<?php
	/**
	 * Created by PhpStorm.
	 * User: nelson.daza
	 * Date: 08/07/2015
	 * Time: 04:07 PM
	 */

	require_once( APPPATH . "controllers/general_controller.php" );

	class Users extends GeneralController {
		protected $scope = 'database';

		/**
		 * List Classes
		 */
		function index() {

			$data = $this->auth( 'database/users', array(

			) );
			//$data['users'] = $this->model->get_order_by_city_desc_and_place_asc_and_start_date_desc();
			$this->view( $data );
		}

	}

