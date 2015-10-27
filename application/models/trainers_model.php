<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once("general_model.php");

	class Trainers_model extends General_model {
		protected $tableName = 'trainers';


		public function getTwitterAccounts( ) {
			$query = $this->db->query("" . "
				SELECT tw
				FROM trainers
				WHERE tw IS NOT NULL
				AND TRIM(tw) != ''
            ");

			$result = $query->result_array();

			$list = array();
			foreach( $result as $elem )
				$list[] = $elem['tw'];

			return $list;
		}

		public function getInstagramAccounts( ) {
			$query = $this->db->query("" . "
				SELECT `in`
				FROM trainers
				WHERE `in` IS NOT NULL
				AND TRIM(`in`) != ''
            ");

			$result = $query->result_array();

			$list = array();
			foreach( $result as $elem )
				$list[] = $elem['in'];

			return $list;
		}

	}
