<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Registro extends GeneralController {

		function __construct() {
			parent::__construct();

			$this->load->library( array(
				'email'
			) );

			$this->load->model(array('account/account_facebook_model', 'account/account_google_model', 'account/account_twitter_model', 'account/account_openid_model'));
			$this->load->language(array('account/connect_third_party'));
		}

		function testMail( ) {

			$html = file_get_contents( FCPATH . 'img/mailing/bienvenido.html' );
			$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

			$this->email->to( 'nelson.daza@gmail.com' );// change it to yours
			$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
			$this->email->subject( '¡Bienvenida!' );
			$this->email->set_mailtype('html');
			$this->email->message( $html );

			var_dump( $this->email->send() );

			$html = file_get_contents( FCPATH . 'img/mailing/inscrita.html' );
			$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

			$this->email->to( 'nelson.daza@gmail.com' );// change it to yours
			$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
			$this->email->subject( '¡Inscrita!' );
			$this->email->message( $html );

			var_dump( $this->email->send() );

			$html = file_get_contents( FCPATH . 'img/mailing/clave.html' );
			$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

			$this->email->to( 'nelson.daza@gmail.com' );// change it to yours
			$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
			$this->email->subject( '¡Clave!' );
			$this->email->message( $html );

			var_dump( $this->email->send() );

			$html = file_get_contents( FCPATH . 'img/mailing/recuerda.html' );
			$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

			$this->email->to( 'nelson.daza@gmail.com' );// change it to yours
			$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
			$this->email->subject( '¡Recuerda!' );
			$this->email->message( $html );

			var_dump( $this->email->send() );

		}

		function index()
		{
			// Enable SSL?
			maintain_ssl($this->config->item("ssl_enabled"));

			$newUser = array( );

			if ( $this->authentication->is_signed_in()) {
				// Run sign in routine
				redirect('');
			}

			$data = array( );
			$data['connect_create'] = $this->session->userdata('connect_create');
			$newUser['fullname'] = '';
			$newUser['firstname'] = '';
			$newUser['lastname'] = '';
			$newUser['dateofbirth'] = '';
			$newUser['gender'] = 'f';
			$newUser['ciudad'] = '';
			$newUser['email'] = '';
			$newUser['telefono'] = '';
			$newUser['provider'] = '';

			if( !$this->input->post( ) && $data['connect_create'] && isset( $data['connect_create'][1] ) ) {
				$newUser['fullname'] = $data['connect_create'][1]['fullname'];
				$newUser['firstname'] = $data['connect_create'][1]['firstname'];
				$newUser['lastname'] = $data['connect_create'][1]['lastname'];
				$newUser['gender'] = ( $data['connect_create'][1]['gender'] == 'm' || $data['connect_create'][1]['gender'] == 'male' ? 'm' : 'f' );
				$newUser['provider'] = substr( str_shuffle( "ABCDEFGHJKMNPQRSTUVWXYZ123456789" ), 0, 6 );
			}
			$data['user'] = $newUser;

			if( $this->input->post( ) ) {

				$newUser['fullname'] = $this->input->post('nombres', TRUE) . ' ' . $this->input->post('apellidos', TRUE);
				$newUser['firstname'] = $this->input->post('nombres', TRUE);
				$newUser['lastname'] = $this->input->post('apellidos', TRUE);
				$newUser['dateofbirth'] = $this->input->post('anio', TRUE) . ' ' . $this->input->post('mes', TRUE) . ' ' . $this->input->post('dia', TRUE);
				$newUser['gender'] = $this->input->post('genero', TRUE);
				$newUser['ciudad'] = $this->input->post('ciudad', TRUE);
				$newUser['telefono'] = $this->input->post('telefono', TRUE);
				$newUser['email'] = $this->input->post('email', TRUE);

				$data['user'] = $newUser;

				// Setup form validation
				$this->form_validation->set_error_delimiters('', '');
				$this->form_validation->set_rules( array(
					array(
						'field' => 'email',
						'label' => 'E-mail errado',
						'rules' => 'trim|required|valid_email|max_length[160]'
					)
				) );

				// Run form validation
				if ($this->form_validation->run())
				{
					// Check if username already exist
					if ($this->username_check($this->input->post('email', TRUE)) === TRUE)
					{
						$data['email_error'] = lang('connect_create_email_exist');
					}
					// Check if email already exist
					elseif ($this->email_check($this->input->post('email'), TRUE) === TRUE)
					{
						$data['email_error'] = lang('connect_create_email_exist');
					}
					else
					{
						// Destroy 'connect_create' session data
						$this->session->unset_userdata('connect_create');

						// Create user
						$user_id = $this->account_model->create($this->input->post('email', TRUE), $this->input->post('email', TRUE));

						// Add user details
						$this->account_details_model->update($user_id, $data['connect_create'][1]);

						unset( $newUser['email'], $newUser['provider'] );

						$this->account_details_model->update($user_id, $newUser);
						$this->account_model->update_password( $user_id, $this->input->post('pass', TRUE) );

						// Connect third party account to user
						switch ($data['connect_create'][0]['provider'])
						{
							case 'facebook':
								$this->account_facebook_model->insert($user_id, $data['connect_create'][0]['provider_id']);
								break;
							case 'google':
								$this->account_google_model->insert($user_id, $data['connect_create'][0]['provider_id']);
								break;
							case 'twitter':
								$this->account_twitter_model->insert($user_id, $data['connect_create'][0]['provider_id'], $data['connect_create'][0]['token'], $data['connect_create'][0]['secret']);
								break;
							case 'openid':
								$this->account_openid_model->insert($data['connect_create'][0]['provider_id'], $user_id);
								break;
						}

						// Run sign in routine

						$remember = false;
						$remember ? $this->session->cookie_monster(TRUE) : $this->session->cookie_monster(FALSE);

						$this->session->set_userdata('account_id', $user_id);
						$this->account_model->update_last_signed_in_datetime($user_id);

						$html = file_get_contents( FCPATH . 'img/mailing/bienvenido.html' );
						$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

						$this->email->to( $this->input->post('email', TRUE) );// change it to yours
						$this->email->bcc( 'nelson.daza@usa.com' );// change it to yours
						$this->email->bcc( 'nelson.daza@outlook.com' );// change it to yours
						$this->email->bcc( 'nelson.daza@imagendigital.com' );// change it to yours
						$this->email->from( 'no-reply@nelsondaza.com', 'Carus' );
						$this->email->subject( '¡Bienvenida!' );
						$this->email->message( $html );

						$this->email->send();

						// Redirect signed in user with session redirect
						if ($redirect = $this->session->userdata('sign_in_redirect'))
						{
							$this->session->unset_userdata('sign_in_redirect');
							redirect( $redirect );
						}
						// Redirect signed in user with GET continue
						elseif ($this->input->get('continue'))
						{
							redirect($this->input->get('continue'));
						}

						redirect('registro/correcto');
					}
				}
			}

			$this->load->view('registro', $data);
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

		function inicio() {
			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
			}

			$this->viewInicio( $data );
		}

		function correcto() {
			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }
			$this->viewCorrecto( $data );
		}
	}
