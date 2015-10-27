<?php

	require_once( APPPATH . "controllers/services_controller.php" );

	/**
	 * Class Reports
	 *
	 * @property Facebook_lib           $facebook_lib
	 * @property Account_facebook_model $account_facebook_model
	 */
	class Post extends ServicesController {
		protected $scope = 'services';

		function __construct() {
			parent::__construct();

			// Load the necessary stuff...
			$this->load->model( array(
				'tweetsmodel',
				'youtubemodel',
				'hashtagimmodel'
			) );
		}

		function share() {

			// Enable SSL?
			maintain_ssl($this->config->item("ssl_enabled"));

			$id = $this->input->get('id', TRUE);
			$type = $this->input->get('type', TRUE);
			$securecode = $this->input->get('securecode', TRUE);

			$hash = $this->session->userdata('securecode');
			$done = $this->session->userdata($hash.$type.$id);

			if( $done ) {
				$this->data['error'] = array(
					'code' => 2,
					'type' => 'AuthLimitError',
					'msg' => lang( 'services_auth_error' )
				);
			}
			else if( $hash == $securecode ) {

				$model = null;
				$field = null;

				if( $type == 'twitter' ) {
					$model = $this->tweetsmodel;
					$field = 'tweet_id';
				}
				else if( $type == 'instagram' ) {
					$model = $this->hashtagimmodel;
					$field = 'idMessage';
				}
				else if( $type == 'youtubemodel' ) {
					$model = $this->youtubemodel;
					$field = 'idYoutube';
				}

				// Create a3m account
				$this->data['data'] = array(
					'shares' => sprintf( "%06d", 0 ),
					'msg'   => 'No registrado correctamente.',
					'user'  => true
				);

				if( $model ) {

					$function = 'get_one_by_' . $field;
					$object = $model->$function( $id );

					if( $object ) {

						$function = 'update_by_' . $field;
						$model->$function( $id, array( 'shares' => $object['shares'] + 1 ) );

						$this->session->set_userdata($hash.$type.$id,'1');

						$this->data['data'] = array(
							'shares' => sprintf( "%06d", $object['shares'] + 1 ),
							'msg'   => 'Registo correcto.',
							'user'  => true
						);
					}
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

	}
