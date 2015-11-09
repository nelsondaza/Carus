<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Product_model $product_model
	 */
	class Products extends GeneralController {
		function __construct()
		{
			parent::__construct();

			$this->load->model(array('manage/product_model'));

		}

		function index( $page = 0 ) {

			$data = $this->auth( true );

			$itemsPerPage = 5;
			$totalItems = $this->product_model->countByIdAccount( $this->session->userdata( 'account_id' ) );
			$pages = ceil( $totalItems / $itemsPerPage );

			if( $page > 0 )
				$page --;
			$page = max( ( $page % $pages ), 0 );


			$data['products'] = $this->product_model->getByIdAccount( $this->session->userdata( 'account_id' ), $itemsPerPage, $page * $itemsPerPage );
			$data['page'] = $page + 1;
			$data['pages'] = $pages;


			$this->view( $data );
		}

	}
