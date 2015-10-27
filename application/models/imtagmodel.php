<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("general_model.php");

class imtagModel extends General_model {
	protected $tableName = 'imtag';

	public function addImTag($imTag){
		$id = 0;
		try {
			$this->db->where('idHashTagIM', $imTag['idHashTagIM']);
			$this->db->where('tag', $imTag['tag']);
			$this->db->where('tagSchool', $imTag['tagSchool']);
			$query = $this->db->get('imtag');
			if ($query->num_rows() <= 0) {
				if ($this->db->insert('imtag', $imTag)) {
					$id = $this->db->insert_id();
				}
			}
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> imtagModel Method -> addImTag -> Exception '.$e);
		}
		return $id;
	}

}