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
				'manage/product_model',
				'manage/price_model',
				'manage/brand_model',
			) );
			$this->load->library('user_agent');
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

				$brand_name = ( $this->input->post( 'brand', true ) ? trim( $this->input->post( 'brand', true ) ) : null );
				$brand_key = $this->toKey( $brand_name );
				$brand = null;
				if( $brand_key ) {
					$brand = $this->brand_model->get_one_by_key( $brand_key );
					if( !$brand ) {
						$id_brand = $this->brand_model->insert( array(
							'name' => ucwords( strtolower( $brand_name ) ),
							'key' => $brand_key
						) );
						$brand = $this->brand_model->get_one_by_id( $id_brand );
					}
				}

				// Create/Update Product
				$attributes = array();
				$attributes['name'] = ( $this->input->post( 'name', true ) ? ucwords( strtolower( trim( $this->input->post( 'name', true ) ) ) ) : null );
				$attributes['size'] = ( $this->input->post( 'size', true ) ? trim( $this->input->post( 'size', true ) ) : null );
				$attributes['id_account'] = $this->session->userdata( 'account_id' );
				$attributes['id_brand'] = ( $brand ? $brand['id'] : null );
				$attributes['key'] = $this->toKey( $attributes['name'] . '-' . $attributes['size'] . ( $brand ? '-' . $brand['name'] : '' ) );
				$product = null;
				if( $attributes['key'] ) {
					$product = $this->product_model->get_one_by_key( $attributes['key'] );
					if( !$product ) {
						$id_product = $this->product_model->insert( $attributes );
						$product = $this->product_model->get_one_by_id( $id_product );
					}
				}

				if( $product ) {

					$price = array();
					$price['value'] = ( $this->input->post( 'price', true ) ? trim( $this->input->post( 'price', true ) ) : null );
					$price['id_store'] = ( $this->input->post( 'id_store', true ) ? $this->input->post( 'id_store', true ) : null );
					$price['id_account'] = $attributes['id_account'];
					$price['id_product'] = $product['id'];
					$price['user_agent'] = $this->agent->agent_string();
					$this->price_model->insert( $price );

					$this->data = $product;
				}
				else {
					$this->data['error'] = array(
						'code' => 20,
						'type' => 'ProductError',
						'msg'  => 'El producto no se ha regsitrado.'
					);
				}

			}
			$this->shapeResponse();
		}

		function search( ) {

			$this->data['data'] = $this->product_model->getLast( $this->input->get( 'q', true ) ? $this->input->get( 'q', true ) : null );
			foreach( $this->data['data'] as &$product ) {
				unset( $product['id_account'], $product['id_brand'], $product['id_store'], $product['key'] );
				$product['price'] = '$' . $product['price'];
				$product['title'] = $product['name'] . ( $product['size'] ? ' ~ ' . $product['size'] : '' ) . ( $product['brand'] ? ' [' . $product['brand'] . '] ' : '' );
				$product['description'] = ( $product['store'] ? '@' . $product['store'] : '' ) . ( $product['price_creation'] ? ' ' . $this->toPastHumanDate( $product['price_creation'] ) : '' );
			}
			$this->shapeResponse();
		}
	}
