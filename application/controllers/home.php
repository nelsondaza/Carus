<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Home extends GeneralController {

		function index() {

			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->view( $data );
		}

		function productos() {

			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->viewProductos( $data );
		}

		function terminos() {

			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->viewTerminos( $data );
		}

		function politicas() {

			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->viewPoliticas( $data );
		}

		function mecanica() {
			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->viewMecanica( $data );
		}

		function rutinas() {

			$data = array();
			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
		    }

			$this->viewRutinas( $data );
		}

		function clases() {

			$data = array();
			$data['appointments'] = array( );

			if( $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) ) ) {
				// Retrieve sign in user
				$data['account']  = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
				$data['account_details']  = $this->account_details_model->get_by_account_id( $this->session->userdata( 'account_id' ) );
				$appointments  = $this->appointments_model->get_by_id_account_and_active( $this->session->userdata( 'account_id' ), 1 );

				foreach( $appointments as $appointment )
					$data['appointments'][$appointment['id_class']] = true;

			}

			$data['clases'] = $this->classes_model->getActiveList();

			$this->viewClases( $data );
		}

		function home2(){

			$query = $this->db->query("" . "
				SELECT resultado.*
				FROM  (
                    (
                        SELECT image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video
                        FROM hashtagim
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT  media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, media as video
                        FROM tweets
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser, avatar as avatar, videoId as post, thumbnailsHigh as video
                        FROM youtubehashtag
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                ) AS resultado
                ORDER BY RAND()
                LIMIT 4
            ");

			$list = $query->result_array();

			$query = $this->db->query("
				SELECT *
				FROM trainers
                ORDER BY RAND()
                LIMIT 4
            ");

			$trainers = $query->result_array();
			$this->viewHome2( array(
				'list' => $list,
				'trainers' => $trainers
			) );
		}

		function home3( ) {

			$query = $this->db->query("" . "
				SELECT resultado.*
				FROM  (
                    (
                        SELECT image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video
                        FROM hashtagim
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT  media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, media as video
                        FROM tweets
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser, avatar as avatar, videoId as post, thumbnailsHigh as video
                        FROM youtubehashtag
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                ) AS resultado
                ORDER BY RAND()
                LIMIT 4
            ");

			$list = $query->result_array();

			$query = $this->db->query("
				SELECT *
				FROM trainers
                ORDER BY RAND()
                LIMIT 4
            ");

			$trainers = $query->result_array();
			$this->viewHome3( array(
				'list' => $list,
				'trainers' => $trainers
			) );
		}
		function home4( ) {

			$query = $this->db->query("" . "
				SELECT resultado.*
				FROM  (
                    (
                        SELECT image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video
                        FROM hashtagim
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT  media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, media as video
                        FROM tweets
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                    UNION
                    (
                        SELECT thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser, avatar as avatar, videoId as post, thumbnailsHigh as video
                        FROM youtubehashtag
                        #WHERE hide = 0
                        ORDER BY RAND()
                        LIMIT 2
                    )
                ) AS resultado
                ORDER BY RAND()
                LIMIT 4
            ");

			$list = $query->result_array();

			$query = $this->db->query("
				SELECT *
				FROM trainers
                ORDER BY RAND()
                LIMIT 4
            ");

			$trainers = $query->result_array();
			$this->viewHome4( array(
				'list' => $list,
				'trainers' => $trainers
			) );
		}
	}
