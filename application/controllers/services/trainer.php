<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 * @property Facebook_lib           $facebook_lib
	 * @property Account_facebook_model $account_facebook_model
	 */
	class Trainer extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->model( array(
				'trainers_model'
			) );
		}

		function vote() {

			// Enable SSL?
			maintain_ssl($this->config->item("ssl_enabled"));

			$userId = (int)$this->input->get('code', TRUE);
			$securecode = $this->input->get('securecode', TRUE);

			$hash = $this->session->userdata('securecode');
			$done = $this->session->userdata($hash.$userId);

			if( $done ) {
				$this->data['error'] = array(
						'code' => 2,
						'type' => 'AuthLimitError',
						'msg' => lang( 'services_auth_error' )
				);
			}
			else if( $hash == $securecode ) {

				$trainer = $this->trainers_model->get_one_by_id($userId);

				// Create a3m account
				$this->data['data'] = array(
					'votes' => sprintf("%06d", 0),
					'msg'   => 'Voto no registrado correctamente.',
					'user'  => true
				);

				if ($trainer) {

					$this->trainers_model->update_by_id( $userId, array( 'votes' => $trainer['votes'] + 1 ) );
					$this->session->set_userdata($hash.$userId,'1');
					// Create a3m account
					$this->data['data'] = array(
						'votes' => sprintf("%06d", $trainer['votes'] + 1),
						'msg'   => 'Voto registrado correctamente.',
						'user'  => true
					);
				}
			}
			else {
				$this->data['error'] = array(
					'code' => 1,
					'type' => 'AuthError',
					'msg' => lang( 'services_auth_error' )
				);
			}

			$this->shapeResponse();
		}

		function map( ) {

			$this->trainers_model->db->where( 'locations !=', '' );
			$this->data['data'] = $this->trainers_model->get( );

			$this->shapeResponse();
		}

	}
