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

		public function getLast( $q ) {

			$this->db->select( $this->tableName . '.*,
				brand.name AS brand,
				price.value AS price,
				price.creation AS price_creation,
				store.name AS store,
				store.id AS id_store
				'
			);
			$this->db->join( 'brand', $this->tableName . '.id_brand = brand.id', 'LEFT' );
			$this->db->join( 'price', $this->tableName . '.id = price.id_product', 'LEFT' );
			$this->db->join( 'store', 'store.id = price.id_store', 'LEFT' );

			$this->db->like('product.name', $q);
			$this->db->group_by( 'product.id' );
			$this->db->order_by( 'price_creation', 'DESC');
			$this->db->order_by( 'product.creation', 'DESC');
			$this->db->limit( 5 );
			return $this->db->get( $this->getTableName( ) )->result_array( );
		}

	}

