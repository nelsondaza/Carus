<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 * @property Facebook_lib           $facebook_lib
	 * @property Account_facebook_model $account_facebook_model
	 */
	class Register extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->library( array(
			    'email'
			) );
			$this->load->model( array(
				'account/account_facebook_model'
			) );
		}

		function index() {

			// Enable SSL?
			maintain_ssl($this->config->item("ssl_enabled"));


			$newUser = array( );
			$newUser['fullname'] = trim( $this->input->post('name', TRUE) );
			$newUser['firstname'] = ucwords( strtolower( trim( $this->input->post('name', TRUE) ) ) );
			$newUser['lastname'] = trim ( strpos($newUser['firstname'], ' ') !== false ? substr( $newUser['firstname'], strpos($newUser['firstname'], ' ') ) : '' );
			$newUser['firstname'] = trim ( strpos($newUser['firstname'], ' ') !== false ? substr( $newUser['firstname'], 0, strpos($newUser['firstname'], ' ') ) : $newUser['firstname'] );
			$newUser['gender'] = ( strtoupper( trim( $this->input->post( 'gender', TRUE ) ) ) == "F" ? "F" : "M" );
			$newUser['email'] = strtolower( trim( $this->input->post('email', TRUE) ) );
			$newUser['terms'] = ( (int)$this->input->post('terms', TRUE) > 0 ? 1 : 0 );

			if ( $this->username_check( $newUser['email'] ) ) {
				$this->data['error'] = array(
					'code' => 10,
					'type' => 'UserFoundError',
					'msg'  => 'El correo ya se encuentra registrado.',
					'scope' => 'email'
				);
			}
			else if ( $this->email_check( $newUser['email'] ) ) {
				$this->data['error'] = array(
					'code' => 11,
					'type' => 'EmailFoundError',
					'msg'  => 'El correo ya se encuentra registrado.',
					'scope' => 'email'
				);
			}
			else if ( !$newUser['terms'] ) {
				$this->data['error'] = array(
					'code' => 30,
					'type' => 'TermsError',
					'msg'  => 'Debes aceptar los términos de uso.',
					'scope' => 'terms'
				);
			}
			else {
				// Create user
				$user_id = $this->account_model->create( $newUser['email'], $newUser['email'] );
				$this->account_model->update_password( $user_id, ( $this->input->post('password', TRUE) ? $this->input->post('password', TRUE) : $newUser['email'] . $newUser['firstname'] ) );

				$email = $newUser['email'];
				// Add user details
				unset( $newUser['email'], $newUser['provider'] );
				$this->account_details_model->update( $user_id, $newUser );

				// Clear sign in fail counter
				$this->session->unset_userdata( 'sign_in_failed_attempts' );
				// Run sign in routine
				$this->session->set_userdata('account_id', $user_id);
				$this->account_model->update_last_signed_in_datetime($user_id);

				$account_details = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );

				/*
				$html = file_get_contents( FCPATH . 'resources/mailing/registro.html' );

				$this->email->to( $email );// change it to yours
				$this->email->bcc( 'nelson.daza@gmail.com' );// change it to yours
				$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
				$this->email->subject( '¡CARUS TE DA LA BIENVENIDA!' );
				$this->email->message( $html );
				$this->email->send();
				*/

				// Create a3m account
				$this->data['data'] = array(
					'place' => 'register.create',
					'msg'   => 'Usuario registrado correctamente.',
					'user'  => array(
						'fullname' => $account_details->fullname,
						'firstname' => $account_details->firstname,
						'lastname' => $account_details->lastname,
						'gender' => $account_details->gender,
						'picture' => $account_details->picture
					)
				);
			}

			$this->shapeResponse();
		}

		function send() {

			return;

			set_time_limit( -1 );

			$accounts = $this->account_model->get();
			$html = file_get_contents( FCPATH . 'resources/mailing/registro.html' );

			foreach( $accounts as $account ) {
				echo "<br>" . $account->email;
				flush();
				$this->email->to( $account->email );// change it to yours
				$this->email->to( 'nelson.daza@gmail.co' );// change it to yours
				$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
				$this->email->subject( '¡CARUS TE DA LA BIENVENIDA!' );
				$this->email->message( $html );
				$this->email->send();
			}

		}

		/**
		 * Check if a username exist
		 *
		 * @access public
		 * @param string
		 * @return bool
		 */
		function username_check($username)
		{
			return $this->account_model->get_by_username($username) ? TRUE : FALSE;
		}

		/**
		 * Check if an email exist
		 *
		 * @access public
		 * @param string
		 * @return bool
		 */
		function email_check($email)
		{
			return $this->account_model->get_by_email($email) ? TRUE : FALSE;
		}

	}
