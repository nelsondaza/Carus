<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Nelson.Daza
 * Date: 29/10/2015
 * Time: 10:36 PM
 */

	require_once( APPPATH . "models/general_model.php" );

	class Product_model extends General_model {

		/**
		 * Function called before do a get action
		 * @param $arguments
		 */
		public function onBeforeGet( $arguments ) {
		}

		/**
		 * Search products
		 * @param       $q          String to search for
		 * @param       $latitude
		 * @param       $longitude
		 * @param int   $distance   Distance in meters
		 *
		 * @return mixed
		 */
		public function getLast( $q, $latitude, $longitude, $distance = 1000 ) {

			$this->db->select( $this->tableName . '.*,
				brand.name AS brand,
				price.value AS price,
				price.creation AS price_creation,
				store.name AS store,
				store.id AS id_store,
				store.latitude AS store_latitude,
				store.longitude AS store_longitude,
				ROUND(
					6372.797560856 * 2000 * ASIN(
						SQRT(
							POWER(
								SIN(
									(store.latitude - abs(' . $latitude . ')) * pi()/180 / 2
								)
								,2
							)
							+ COS(
								store.latitude * pi()/180
							)
							* COS(
								abs(' . $latitude . ') * pi()/180
							)
							* POWER(
								SIN(
									(store.longitude - ' . $longitude . ') * pi()/180 / 2
								)
								,2
							)
						)
					)
				) AS distance
				', false
			);
			$this->db->join( 'brand', $this->tableName . '.id_brand = brand.id', 'LEFT' );
			$this->db->join( 'price', $this->tableName . '.id = price.id_product', 'LEFT' );
			$this->db->join( 'store', 'store.id = price.id_store', 'LEFT' );

			if( $distance > 0 )
				$this->db->having('distance <=', $distance );

			$this->db->like('product.name', $q);

			$this->db->group_by( 'store.id' );
			$this->db->order_by( 'distance', 'ASC');
			$this->db->order_by( 'price.value', 'DESC');
			$this->db->order_by( 'price_creation', 'DESC');
			$this->db->limit( 5 );
			return $this->db->get( $this->getTableName( ) )->result_array( );
		}

		public function getLastPrices( $id, $latitude, $longitude ) {

			$this->db->select( $this->tableName . '.*,
				brand.name AS brand,
				price.value AS price,
				price.creation AS price_creation,
				store.name AS store,
				store.id AS id_store,
				store.latitude AS store_latitude,
				store.longitude AS store_longitude,
				ROUND(
					6372.797560856 * 2000 * ASIN(
						SQRT(
							POWER(
								SIN(
									(store.latitude - abs(' . $latitude . ')) * pi()/180 / 2
								)
								,2
							)
							+ COS(
								store.latitude * pi()/180
							)
							* COS(
								abs(' . $latitude . ') * pi()/180
							)
							* POWER(
								SIN(
									(store.longitude - ' . $longitude . ') * pi()/180 / 2
								)
								,2
							)
						)
					)
				) AS distance
				', false
			);
			$this->db->join( 'brand', $this->tableName . '.id_brand = brand.id', 'LEFT' );
			$this->db->join( 'price', $this->tableName . '.id = price.id_product', 'LEFT' );
			$this->db->join( 'store', 'store.id = price.id_store', 'LEFT' );

			$this->db->where('product.id', $id);
			$this->db->group_by( 'store.id' );
			$this->db->order_by( 'price_creation', 'DESC');
			$this->db->order_by( 'price.value', 'DESC');
			$this->db->order_by( 'distance', 'ASC');
			$this->db->limit( 5 );
			return $this->db->get( $this->getTableName( ) )->result_array( );
		}

		public function getByIdAccount( $id, $limit = 5, $offset = 0 ) {

			$this->db->select( $this->tableName . '.*,
				brand.name AS brand,
				price.value AS price,
				price.creation AS price_creation,
				store.name AS store,
				store.id AS id_store,
				', false
			);
			$this->db->join( 'brand', $this->tableName . '.id_brand = brand.id', 'LEFT' );
			$this->db->join( 'price', $this->tableName . '.id = price.id_product', 'LEFT' );
			$this->db->join( 'store', 'store.id = price.id_store', 'LEFT' );

			$this->db->where( 'price.id_account', $id );
			$this->db->group_by( array( 'store.id', 'product.id' ) );
			$this->db->order_by( 'price_creation', 'DESC');
			$this->db->limit( $limit );
			$this->db->offset( $offset );
			return $this->db->get( $this->getTableName( ) )->result_array( );
		}

		public function countByIdAccount( $id  ) {

			$this->db->select( '
				COUNT(*) AS total
				FROM (
					SELECT price.id
					FROM price
					WHERE id_account = ' . (int)$id . '
					GROUP BY price.id_store, price.id_product
				) AS counter
				', false
			);

			$result = $this->db->get( )->row_array( );
			return ( isset( $result['total'] ) ? (int)$result['total'] : 0 );
		}
	}

