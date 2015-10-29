<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 * @property Facebook_lib           $facebook_lib
	 * @property Account_facebook_model $account_facebook_model
	 */
	class Login extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->library( array(
				'account/facebook_lib',
			    'email'
			) );
			$this->load->model( array(
				'account/account_facebook_model'
			) );
			$this->load->language( array(
				'account/account_linked',
			    'account/sign_in',
				'account/connect_third_party'
			) );
		}

		function index() {

			// Enable SSL?
			maintain_ssl($this->config->item("ssl_enabled"));

			// Get user by username / email
			if ( !($user = $this->account_model->get_by_username_email( $this->input->post( 'email', true ) ) ) ) {
				// Username / email doesn't exist
				$this->data['error'] = array(
					'code' => 10,
					'type' => 'NotFoundError',
					'msg'  => lang( 'sign_in_username_email_does_not_exist' )
				);
			}
			else {
				// Check password
				if ( !$this->authentication->check_password( $user->password, $this->input->post( 'password', true ) ) ) {
					// Increment sign in failed attempts
					//$this->session->set_userdata( 'sign_in_failed_attempts', (int) $this->session->userdata( 'sign_in_failed_attempts' ) + 1 );
					$this->data['error'] = array(
						'code' => 20,
						'type' => 'AuthError',
						'msg'  => lang( 'sign_in_combination_incorrect' )
					);
				}
				else {
					// Clear sign in fail counter
					$this->session->unset_userdata( 'sign_in_failed_attempts' );
					// Run sign in routine
					$this->session->set_userdata('account_id', $user->id);
					$this->account_model->update_last_signed_in_datetime($user->id);

					$account_details = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
					$this->data['data']['user']['fullname'] = $account_details->fullname;
					$this->data['data']['user']['firstname'] = $account_details->firstname;
					$this->data['data']['user']['lastname'] = $account_details->lastname;
					$this->data['data']['user']['gender'] = $account_details->gender;
					$this->data['data']['user']['picture'] = $account_details->picture;

				}
			}

			$this->shapeResponse();
		}

		function facebook() {

			// Check if user is signed in on facebook
			if ( $this->facebook_lib->user ) {
				// Check if user has connect facebook to a3m
				if ( $user = $this->account_facebook_model->get_by_facebook_id( $this->facebook_lib->user['id'] ) ) {
					// Check if user is not signed in on a3m
					if ( ! $this->authentication->is_signed_in() ) {
						// Run sign in routine
						// $this->authentication->sign_in( $user->account_id );
						//$remember ? $this->CI->session->cookie_monster( true ) : $this->CI->session->cookie_monster( false );
						$this->session->set_userdata( 'account_id', $user->account_id );
						$this->account_model->update_last_signed_in_datetime( $user->account_id );
					}

					$msg = null;
					if ( $user->account_id === $this->session->userdata( 'account_id' ) ) {
						$msg = sprintf( lang( 'linked_linked_with_this_account' ), lang( 'connect_facebook' ) );
					}
					else {
						$msg = sprintf( lang( 'linked_linked_with_another_account' ), lang( 'connect_facebook' ) );
					}

					$this->data['data'] = array(
						'place' => 'in,found',
						'msg'   => $msg,
						'user'  => (array)$user
					);

					$account_details = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
					$this->data['data']['user']['fullname'] = $account_details->fullname;
					$this->data['data']['user']['firstname'] = $account_details->firstname;
					$this->data['data']['user']['lastname'] = $account_details->lastname;
					$this->data['data']['user']['gender'] = $account_details->gender;
					$this->data['data']['user']['picture'] = $account_details->picture;

				}
				// The user has not connect facebook to a3m
				else {
					// Check if user is signed in on a3m
					if ( !$this->authentication->is_signed_in() ) {

						$user = array(
							'fullname'  => $this->facebook_lib->user['name'],
							'firstname' => $this->facebook_lib->user['first_name'],
							'lastname'  => $this->facebook_lib->user['last_name'],
							'gender'    => $this->facebook_lib->user['gender'],
							'picture'   => 'http://graph.facebook.com/' . $this->facebook_lib->user['id'] . '/picture/?type=large'
						);
						// Store user's facebook data in session
						$this->session->set_userdata( 'connect_create', array(
							array(
								'provider'    => 'facebook',
								'provider_id' => $this->facebook_lib->user['id']
							),
							$user
						) );

						// Create a3m account
						$this->data['data'] = array(
							'place' => 'out,create',
							'msg'   => 'register',
							'user'  => $user
						);
					}
					else {
						// Connect facebook to a3m
						$this->account_facebook_model->insert( $this->session->userdata( 'account_id' ), $this->facebook_lib->user['id'] );
						$user = $this->account_facebook_model->get_by_facebook_id( $this->facebook_lib->user['id'] );

						$this->data['data'] = array(
							'place' => 'out,found',
							'msg'   => sprintf( lang( 'linked_linked_with_your_account' ), lang( 'connect_facebook' ) ),
							'user'  => $user
						);
					}
				}
			}
			// Check if user is signed in on facebook
			else {
				$this->data['error'] = array(
					'code' => 20,
					'type' => 'ConnectionError',
					'msg'  => lang( 'services_access_denied' )
				);
			}

			$this->shapeResponse();
		}

		function forgot( ) {
			$email = (  $this->input->get( 'email', true ) ? $this->input->get( 'email', true ) : null );
			$account = $this->account_model->get_by_email( $email );

			if( $account )  {
				$account_details = $this->account_details_model->get_by_account_id( $account->id );

				$this->data['data'] = array(
					'place' => 'forgot,found',
					'msg'  => sprintf( lang( 'services_user_found' ), $email ),
					'user'  => array()
				);
				$this->data['data']['user']['email'] = $account->email;
				$this->data['data']['user']['fullname'] = $account_details->fullname;
				$this->data['data']['user']['firstname'] = $account_details->firstname;
				$this->data['data']['user']['lastname'] = $account_details->lastname;
				$this->data['data']['user']['picture'] = $account_details->picture;

				$newPass = substr( str_shuffle( "ABCDEFGHJKMNPQRSTUVWXYZ123456789" ), 0, 6 );
				$this->account_model->update_password( $account->id, $newPass );

				$this->data['data']['user']['pass'] = $newPass;

				$html = file_get_contents( FCPATH . 'img/mailing/clave.html' );
				$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );
				$html = str_replace( array(
					'__NOMBRE__',
					'__CLAVE__' ), array(
					( $account_details->firstname ? $account_details->firstname : $account_details->fullname ),
					$newPass
				), $html );

				$this->email->to( $email );// change it to yours
				$this->email->from('no-reply@nelsondaza.com', 'Carus');
				$this->email->subject( 'Petición de cambio de contraseña ' );
				$this->email->message( $html );
				$this->email->send();

			}
			else {
				$this->data['error'] = array(
					'code' => 10,
					'type' => 'NotFoundError',
					'msg'  => sprintf( lang( 'services_user_not_found' ), $email )
				);
			}
			$this->shapeResponse();
		}
	}
