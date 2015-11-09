<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Stores
	 */
	class Store extends GeneralController {
		protected $scope = 'manage';

		/**
		 * List Stores
		 */
		function index() {

			$data = $this->auth( 'manage/stores', array(
				'retrieve_stores' => 'account/account_profile'
			) );

			$data['stores'] = $this->model->get_order_by_name();

			$this->view( $data );
		}

		/**
		 * Manage Stores
		 * @param null|int $id
		 */
		function save( $id = null ) {
			// Keep track if this is a new object
			$is_new = !$id;

			$data = $this->auth( 'manage/stores',
				(
					$is_new
					? array( 'create_stores' => 'manage/stores' )
					: array( 'update_stores' => 'manage/stores' )
				)
			);

			// Set action type (create or update)
			$data['action'] = 'create';

			// Get the object
			if ( ! $is_new ) {
				$data['store'] = $this->model->get_one_by_id( $id );
				$data['action'] = 'update';
			}
			$data['clients'] = $this->clients_model->getActiveList( );

			// Setup form validation
			$this->form_validation->set_rules(
				array(
					array(
						'field' => 'stores_field_name',
						'label' => 'lang:stores_field_name',
						'rules' => 'trim|required|max_length[80]'
					),
					array(
						'field' => 'stores_field_id_client',
						'label' => 'lang:stores_field_id_client',
						'rules' => 'numeric|required'
					),
					array(
						'field' => 'stores_field_description',
						'label' => 'lang:stores_field_description_error',
						'rules' => 'trim|optional|max_length[160]'
					)
				) );

			// Run form validation
			if ( $this->form_validation->run() ) {
				$name_taken = $this->name_check( $this->input->post( 'stores_field_name', true ) );

				if ( ( !$is_new && strtolower( $this->input->post( 'stores_field_name', true ) ) != strtolower( $data['store']['name'] ) && $name_taken ) || ( $is_new && $name_taken ) ) {
					$data['stores_field_name_error'] = lang( 'stores_field_name_taken' );
				}
				else {
					// Create/Update
					$attributes = array();

					$attributes['name'] = $this->input->post( 'stores_field_name', true ) ? $this->input->post( 'stores_field_name', true ) : null;
					$attributes['description'] = $this->input->post( 'stores_field_description', true ) ? $this->input->post( 'stores_field_description', true ) : null;
					$attributes['id_client'] = $this->input->post( 'stores_field_id_client', true ) ? $this->input->post( 'stores_field_id_client', true ) : null;
					if( $is_new )
						$id = $this->model->insert( $attributes );
					else
						$this->model->update_by_id( $id, $attributes );

					// Check if the permission should be disabled
					if ( $this->authorization->is_permitted( 'delete_stores' ) ) {
						if ( $this->input->post( 'deactivate', true ) ) {
							$this->model->update_by_id( $id, array( 'active' => 0 ) );
							$data['store']['active'] = 0;
						} elseif ( $this->input->post( 'activate', true ) ) {
							$this->model->update_by_id( $id, array( 'active' => 1 ) );
							$data['store']['active'] = 1;
						}
					}

					// If user has uploaded a file
					if ( isset( $_FILES['stores_field_logo'] ) && $_FILES['stores_field_logo']['error'] != 4 ) {
						// Load file uploading library - http://codeigniter.com/user_guide/libraries/file_uploading.html
						$this->load->library( 'upload', array(
							'overwrite'     => true,
							'upload_path'   => FCPATH . RES_DIR . '/store/profile',
							'allowed_types' => 'jpg|png|gif',
							'max_size'      => '800' // kilobytes
						) );

						/// Try to upload the file
						if ( !$this->upload->do_upload( 'stores_field_logo' ) ) {
							$data['stores_field_logo_error'] = $this->upload->display_errors( '', '' );
						} else {
							// Get uploaded picture data
							$picture = $this->upload->data();

							// Create picture thumbnail - http://codeigniter.com/user_guide/libraries/image_lib.html
							$this->load->library( 'image_lib' );
							$this->image_lib->clear();
							$this->image_lib->initialize( array( 'image_library'  => 'gd2',
							                                     'source_image'   => FCPATH . RES_DIR . '/store/profile/' . $picture['file_name'],
							                                     'new_image'      => FCPATH . RES_DIR . '/store/profile/pic_' . md5( 'store' . $id ) . $picture['file_ext'],
							                                     'maintain_ratio' => false,
							                                     'quality'        => '80%',
							                                     'width'          => 100,
							                                     'height'         => 100
							                              ) );

							// Try resizing the picture
							if ( ! $this->image_lib->resize() ) {
								$data['stores_field_logo_error'] = $this->image_lib->display_errors();
							} else {
								$data['store']['logo'] = 'pic_' . md5( 'store' . $id ) . $picture['file_ext'];
								$this->model->update_by_id( $id, array( 'logo' => $data['store']['logo'] ) );
							}

							// Delete original uploaded file
							unlink( FCPATH . RES_DIR . '/store/profile/' . $picture['file_name'] );
						}
					}
				}

				if( $is_new )
					redirect( 'manage/stores/save/' . $id );

				$data['action_info'] = ( $is_new ? lang('stores_created') : lang('stores_updated') );

			}
			$this->viewSave( $data );
		}

		/**
		 * Removes an image
		 * @param null|int $id
		 */
		function remove_image( $id = null ) {
			$data = $this->auth( 'manage/stores',
				array( 'update_stores' => 'manage/stores' )
			);

			$data['store'] = $this->model->get_one_by_id( $id );

			unlink( FCPATH . RES_DIR . '/store/profile/' . $data['store']['logo'] ); // delete previous picture
			$this->model->update_by_id( $id, array( 'logo' => null ) );

			redirect( 'manage/stores/save/' . $id );
		}

		/**
		 * Check the name
		 * @param $name
		 *
		 * @return bool
		 */
		function name_check( $name ) {
			//$name = preg_replace( '/([^a-zA-z0-9])/', '', strtolower( $name ) );
			return $this->model->count_by_name( $name ) > 0;
		}
	}
