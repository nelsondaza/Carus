<?php

	require_once( APPPATH . "controllers/general_controller.php" );

	/**
	 * Class Home
	 *
	 * @property Classes_model $classes_model
	 */
	class Minuto_a_minuto extends GeneralController {
		protected $scope = '';

		function index( $page = 0, $selectedPost = null ) {

			$this->load->model( 'trainers_model' );

			$limit = 8;
			$total = $this->countPosts( );
			$page = max( (int)$page, 1 ) - 1;

			$data = array(
				'posts' => $this->getPosts( $page * $limit, $limit ),
				'page' => $page + 1,
				'pages' => ceil( $total / $limit )
			);

			if( $selectedPost ) {
				array_unshift($data['posts'], $selectedPost);
				$data['selected'] = true;
			}

			if( $page == 0 ) {
				$hash = sha1( time( ) . 'hashcodeid' );
				$this->session->set_userdata('securecode', $hash);
				$data['hash'] = $hash;
			}

			$this->view( $data );
		}

		function post( $type, $id ) {

			$this->index(0,$this->getPost( $type, $id ));

		}

		function getPosts( $start = 0, $limit = 10 ) {

/*
			SELECT posts.*, (
			SELECT trainers.name
					FROM trainers
					WHERE LOWER(TRIM(tw)) LIKE posts.arroba
			OR LOWER(TRIM(fb)) LIKE posts.arroba
			OR LOWER(TRIM(`in`)) LIKE posts.arroba
					LIMIT 1
				) AS name
				FROM (
*/

				$query = $this->db->query("" . "
				SELECT resultado.*
				FROM  (
                    (
                        SELECT idMessage as id, image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video, shares
                        FROM hashtagim
                        #WHERE hide = 0
                    )
                    UNION
                    (
                        SELECT tweet_id as id, media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, '' as video, shares
                        FROM tweets
                        #WHERE hide = 0
                    )
                    UNION
                    (
                        SELECT idYoutube as id, thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser as name, avatar as avatar, videoId as post, '' as video, shares
                        FROM youtubehashtag
                        #WHERE hide = 0
                    )
                ) AS resultado
                ORDER BY fecha DESC
                LIMIT " . $limit . "
                OFFSET " . $start . "
            ");

			return $query->result_array();

		}

		function getPost( $type, $id ) {

			$query = null;
			switch( $type ) {
				case 'instagram':
					$query = $this->db->query("" . "
                        SELECT idMessage as id, image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video, shares
                        FROM hashtagim
                        WHERE idMessage = " . $this->db->escape($id) . "
                        #WHERE hide = 0
                        LIMIT 1
		            ");
					break;
				case 'twitter':
					$query = $this->db->query("" . "
                        SELECT tweet_id as id, media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, media as video, shares
                        FROM tweets
                        WHERE tweet_id = " . $this->db->escape($id) . "
                        #WHERE hide = 0
                        LIMIT 1
		            ");
					break;
				case 'youtube':
					$query = $this->db->query("" . "
                        SELECT idYoutube as id, thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser as name, avatar as avatar, videoId as post, thumbnailsHigh as video, shares
                        FROM youtubehashtag
                        WHERE idYoutube = " . $this->db->escape($id) . "
                        #WHERE hide = 0
                        LIMIT 1
		            ");
					break;
			}

			if( $query ) {
				//echo $this->db->last_query();
				return $query->row_array();
			}
			return null;
		}

		function countPosts( ) {

			$query = $this->db->query("" . "
				SELECT COUNT(*) AS total
				FROM  (
                    (
                        SELECT image as image, message as descr, fecha as fecha, 'ins' as ty, username as arroba, fullName as name, profileImage as avatar, idMessage as post, videoLink as video
                        FROM hashtagim
                        #WHERE hide = 0
                    )
                    UNION
                    (
                        SELECT  media as image, tweet_text as descr, fecha as fecha, 'twt' as ty, screen_name as arroba, name as name, profile_image_url as avatar, tweet_id as post, media as video
                        FROM tweets
                        #WHERE hide = 0
                    )
                    UNION
                    (
                        SELECT thumbnailsHigh as image, description as descr, fecha as fecha, 'you' as ty, nameUser as arroba, nameUser as name, avatar as avatar, videoId as post, thumbnailsHigh as video
                        FROM youtubehashtag
                        #WHERE hide = 0
                    )
                ) AS resultado
            ");

            $total = $query->row_array();
			return $total['total'];
		}

		function share( $type, $id ) {

			$data = array(
				'type' => $type,
				'post' => $this->getPost( $type, $id )
			);

			$this->viewShare( $data );

		}
	}
