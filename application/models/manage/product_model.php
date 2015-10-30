<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Nelson.Daza
 * Date: 29/10/2015
 * Time: 10:36 PM
 */

	require_once( APPPATH . "models/general_model.php" );

	class Product_model extends General_model {


		public function getLast( $q ) {
			$result = array();
			$this->db->like('name', $q);
			$this->db->order_by('creation', 'DESC');
			$this->db->from( $this->getTableName( ) );
			$this->db->limit( 10 );
			$query = $this->db->get();


			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
				$result = $data;
			}
			return $result;
		}

	}

