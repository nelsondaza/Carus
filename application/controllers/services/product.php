<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 */
	class Product extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->model( array(
				'manage/product_model'
			) );
		}

		function index() {
			$this->data['error'] = array(
				'code' => 10,
				'type' => 'AuthError',
				'msg'  => lang( 'services_access_denied' )
			);
			$this->shapeResponse();
		}

		function add( ) {

			if ( !$this->authentication->is_signed_in() ) {
				// Run sign out routine
				$this->data['error'] = array(
					'code' => 10,
					'type' => 'AuthError',
					'msg'  => lang( 'services_access_denied' )
				);
			}
			else {
				// Create/Update
				$attributes = array();

				$attributes['name'] = ( $this->input->post( 'name', true ) ? $this->input->post( 'name', true ) : null );
				$attributes['size'] = ( $this->input->post( 'size', true ) ? $this->input->post( 'size', true ) : null );
				$attributes['id_account'] = $this->session->userdata( 'account_id' );;

				$price = ( $this->input->post( 'price', true ) ? $this->input->post( 'price', true ) : null );
				$brand = ( $this->input->post( 'brand', true ) ? $this->input->post( 'brand', true ) : null );

				$id = $this->product_model->insert( $attributes );
				$this->data = $this->product_model->get_one_by_id( $id );

			}
			$this->shapeResponse();
		}

		function search( ) {

			$this->data['data'] = $this->product_model->getLast( $this->input->get( 'q', true ) ? $this->input->get( 'q', true ) : null );
			$this->shapeResponse();

		}
	}
