<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 */
	class Appointment extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->library( array(
			    'email'
			) );
			$this->load->model( array(
				'manage/classes_model',
				'manage/appointments_model'
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

				$attributes['id_class'] = ( $this->input->get( 'id', true ) ? $this->input->get( 'id', true ) : null );
				$attributes['id_account'] = $this->session->userdata( 'account_id' );;
				$found = $this->appointments_model->count_by_id_class_and_id_account( $attributes['id_class'], $attributes['id_account'] );

				if( $found ) {
					$this->data['error'] = array(
						'code' => 20,
						'type' => 'DuplicateError',
						'msg'  => 'Ya estás registrada en esta clase'
					);
				}
				else {

					$found = $this->appointments_model->count_by_id_class_and_id_account( $attributes['id_class'], $attributes['id_account'] );

					if( $found ) {
						$this->data['error'] = array(
							'code' => 20,
							'type' => 'DuplicateError',
							'msg'  => 'Ya estás registrada en esta clase'
						);
					}
					else {
						$hubClass = $this->classes_model->get_one_by_id( $attributes['id_class'] );
						if ( ! $hubClass ) {
							$this->data['error'] = array(
								'code' => 30,
								'type' => 'NotFoundError',
								'msg'  => sprintf( lang( 'services_object_not_found' ), 'Clase' )
							);
						}
						else {
							$oClass = $this->appointments_model->getOverlappedClass( $attributes['id_account'], $hubClass['start_date'] );

							if ( $oClass ) {
								$this->data['error'] = array(
									'code' => 60,
									'type' => 'DuplicateError',
									'msg'  => 'Tienes otra clase a la misma hora: ' . $oClass['class_name'] . ': ' . $oClass['class_city'] . ' - ' . $oClass['class_place']
								);
							}
							else {
								$id              = $this->appointments_model->insert( $attributes );
								$quota_available = (int) $hubClass['quota'] - (int) $this->appointments_model->count_by_id_class_and_active( $attributes['id_class'], 1 );
								$this->classes_model->update_by_id( $attributes['id_class'], array( 'quota_available' => $quota_available ) );
								$this->data = $this->appointments_model->get_one_by_id( $id );

								$account         = $this->account_model->get_by_id( $attributes['id_account'] );
								$account_details = $this->account_details_model->get_by_account_id( $account->id );

								$html = file_get_contents( FCPATH . 'img/mailing/inscrita.html' );
								$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );
								$html = str_replace( array(
									'__NOMBRE__',
									'__CLASE__',
									'__FECHA__',
									'__LUGAR__',
								), array(
									( $account_details->firstname ? $account_details->firstname : $account_details->fullname ),
									'YA ESTÁS INSCRITA A LA CLASE: <b>' . $this->data['class_name'] . '</b>',
									date( "Y-m-d h:i a", strtotime( $this->data['class_start_date'] ) ),
									$this->data['class_place']
								), $html );

								$this->email->to( $account->email );// change it to yours
								$this->email->from( 'no-reply@reebokcardioultra.com', 'Reebok Cardio Ultra' );
								$this->email->subject( 'Inscripción de clase' );
								$this->email->message( $html );
								$this->email->send();
							}
						}
					}
				}
			}
			$this->shapeResponse();
		}
		function cancel( ) {

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

				$attributes['id_class'] = ( $this->input->get( 'id', true ) ? $this->input->get( 'id', true ) : null );
				$attributes['id_account'] = $this->session->userdata( 'account_id' );;
				$found = $this->appointments_model->count_by_id_class_and_id_account( $attributes['id_class'], $attributes['id_account'] );

				if( !$found ) {
					$this->data['error'] = array(
						'code' => 20,
						'type' => 'NotFoundError',
						'msg'  => 'No estás registrada en esta clase'
					);
				}
				else {

					$this->appointments_model->delete_by_id_class_and_id_account( $attributes['id_class'], $attributes['id_account'] );
					$this->data = 'OK';
				}
			}

			$this->shapeResponse();
		}

		function sendRemember( ) {


			$list = $this->appointments_model->getAppointmentsAt( date( 'Y-m-d', strtotime( '+1 DAY' ) ) );

			foreach( $list as $account ) {

				echo "\n" . $account['firstname'] . ' ' . $account['account_email'] . ': ' . $account['class_start_date'] . ' - ' . $account['class_place'];

				$html = file_get_contents( FCPATH . 'img/mailing/recuerda.html' );
				$html = preg_replace( "/(['\"]?)img\\//", '$1' . base_url() . 'img/mailing/img/', $html );

				$html = str_replace( array(
					'__NOMBRE__',
					'__CITA__'
				), array(
					$account['firstname'],
					'del ' . $account['class_place'] . ' a las ' . date( "h:i a", strtotime( $account['class_start_date'] ) ) . ', para vivir una experiencia cardio.',
				), $html );


				$this->email->to( $account['account_email'] );// change it to yours
				$this->email->bcc( 'nelson.daza@imagendigital.co' );// change it to yours
				$this->email->from( 'no-reply@reebokcardioultra.com', 'Reebok Cardio Ultra' );
				$this->email->subject( '¡Recuerda tu cita!' );
				$this->email->message( $html );

				if( $this->email->send() )
					$this->appointments_model->update_by_id( $account['id'], array( 'send_date' => date('Y-m-d H:i:s') ) );

			}
		}
	}
