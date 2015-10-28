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
			$newUser['firstname'] = strtoupper( trim( $this->input->post('nombres', TRUE) ) );
			$newUser['lastname'] = strtoupper( trim( $this->input->post('apellidos', TRUE) ) );
			$newUser['fullname'] = $newUser['firstname'] . ' ' . $newUser['lastname'];

			$newUser['dateofbirth'] = (int)$this->input->post('anio', TRUE) . '-' . (int)$this->input->post('mes', TRUE) . '-' . (int)$this->input->post('dia', TRUE);
			$newUser['gender'] = ( strtoupper( trim( $this->input->post( 'genero', TRUE ) ) ) == "F" ? "F" : "M" );
			$newUser['email'] = $this->input->post('email', TRUE);
			$newUser['doc_type'] = $this->input->post('doc_type', TRUE);
			$newUser['doc_num'] = $this->input->post('doc_num', TRUE);
			$newUser['telefono'] = $this->input->post('telefono', TRUE);
			$newUser['ciudad'] = $this->input->post('ciudad', TRUE);
			$newUser['link_facebook'] = $this->input->post('link_facebook', TRUE);
			$newUser['link_twitter'] = $this->input->post('link_twitter', TRUE);
			$newUser['link_instagram'] = $this->input->post('link_instagram', TRUE);
			$newUser['certificados_tiene'] = ( (int)$this->input->post('certificados_tiene', TRUE) > 0 ? 1 : 0 );
			$newUser['certificados'] = $this->input->post('certificados', TRUE);
			$newUser['entrenamientos'] = $this->input->post('entrenamientos', TRUE);
			$newUser['patrocinios_tiene'] = ( (int)$this->input->post('patrocinios_tiene', TRUE) > 0 ? 1 : 0 );
			$newUser['patrocinios'] = $this->input->post('patrocinios', TRUE);
			$newUser['parques'] = $this->input->post('parques', TRUE);
			$newUser['terminos_acepta'] = ( (int)$this->input->post('terminos_acepta', TRUE) > 0 ? 1 : 0 );
			$newUser['autoriza_datos'] = ( (int)$this->input->post('autoriza_datos', TRUE) > 0 ? 1 : 0 );

			if( (int)$this->input->post( 'anio', TRUE ) <= 1900 || !checkdate( (int)$this->input->post('mes', TRUE), (int)$this->input->post('dia', TRUE), (int)$this->input->post( 'anio', TRUE ) ) ) {
				$this->data['error'] = array(
					'code' => 20,
					'type' => 'DateError',
					'msg'  => 'Fecha de nacimiento incorrecta.',
					'scope' => 'anio'
				);

			}
			else if ( $this->username_check($newUser['email']) ) {
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
			else if ( !$newUser['terminos_acepta'] ) {
				$this->data['error'] = array(
					'code' => 30,
					'type' => 'TermsError',
					'msg'  => 'Se debe aceptar los términos.',
					'scope' => 'terminos_acepta'
				);
			}
			else {
				// Create user
				$user_id = $this->account_model->create( $newUser['email'], $newUser['email'] );
				$this->account_model->update_password( $user_id, $newUser['telefono'] . $newUser['email'] );

				$email = $newUser['email'];
				// Add user details
				unset( $newUser['email'], $newUser['provider'] );
				$this->account_details_model->update( $user_id, $newUser );

				$html = file_get_contents( FCPATH . 'resources/mailing/registro.html' );

				$this->email->to( $email );// change it to yours
				$this->email->bcc( 'nelson.daza@imagendigital.co' );// change it to yours
				$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
				$this->email->subject( '¡FELICITACIONES!' );
				$this->email->message( $html );
				$this->email->send();

				// Create a3m account
				$this->data['data'] = array(
					'place' => 'register.create',
					'msg'   => 'Usuario registrado correctamente.',
					'user'  => true
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
				$this->email->to( 'nelson.daza@imagendigital.co' );// change it to yours
				$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
				$this->email->subject( '¡FELICITACIONES! ' );
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
