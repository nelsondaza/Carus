<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 */
	class Store extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->helper( array(
				'text'
			));
			$this->load->model( array(
				'manage/store_model'
			));
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
				$attributes['latitude'] = ( $this->input->post( 'latitude', true ) ? $this->input->post( 'latitude', true ) : null );
				$attributes['longitude'] = ( $this->input->post( 'longitude', true ) ? $this->input->post( 'longitude', true ) : null );
				$attributes['id_account'] = $this->session->userdata( 'account_id' );;
				$attributes['key'] = preg_replace( '/([^a-z0-9])/i', '-', trim( convert_accented_characters( $attributes['name'] ) ) );

				if( !trim( preg_replace( '/([^a-z0-9])/', '', strtolower( convert_accented_characters( $attributes['name'] ) ) ) ) ) {
					$this->data['error'] = array(
						'code' => 20,
						'type' => 'NoNameError',
						'msg'  => 'Nombre incorrecto: ' . convert_accented_characters( $attributes['name'] )
					);
				}
				else {
					$id = $this->store_model->insert( $attributes );
					$this->data = $this->store_model->get_one_by_id( $id );
				}
			}
			$this->shapeResponse();
		}

		function map( ) {
			$this->data['data'] = $this->store_model->get( );
			$this->shapeResponse();
		}
	}
