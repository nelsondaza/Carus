<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class configurationModel extends CI_Model {
	
	public function addAccessToken($configuration){
		$id = 0;
		try {
			if ($this->db->insert('configuration', $configuration)) {
				$id = $this->db->insert_id();
			}
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> configurationModel Method -> addAccessToken -> Exception '.$e);
		}
		return $id;
	}

	public function deleteAccessToken(){
		$resultDelete = false;
    	try{
			$this->db->delete('lock');
			if($this->db->affected_rows()>0){
				$resultDelete=true;
			}
			//echo $this->db->last_query();	
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> deleteAccessToken -> Exception '.$e);
		}
		return $resultDelete;
	}

	public function getAccessToken(){
		$result = null;
    	try{
			$this->db->select('accessToken');
			$this->db->from('configuration');
			$this->db->limit('1');
			$query = $this->db->get();
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row) {
	                $result = $row->accessToken;
	            }
	        }
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> getAccessToken -> Exception '.$e);
		}
    	return $result;
	}

	public function updateAccessToken($oldToken,$newToken){
		$resultUpdate = false;
		try{
			$this->db->set('accessToken', $newToken);
			$this->db->where('accessToken',$oldToken);
			$this->db->update('configuration');
			if($this->db->affected_rows()>0){
				$resultUpdate=true;
			}
			//echo $this->db->last_query();	
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> updateAccessToken -> Exception '.$e);
		}
		return $resultUpdate;
	}

	public function getAccessTokenInstagram(){
		$result = null;
    	try{
			$this->db->select('accessTokenInstagram');
			$this->db->from('configuration');
			$this->db->limit('1');
			$query = $this->db->get();
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row) {
	                $result = $row->accessTokenInstagram;
	            }
	        }
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> getAccessTokenInstagram -> Exception '.$e);
		}
    	return $result;
	}

	public function getCurrentConfiguration(){
		$result = null;
    	try{
			$this->db->select('idConfiguration');
			$this->db->from('configuration');
			$this->db->limit('1');
			$query = $this->db->get();
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row) {
	                $result = $row->idConfiguration;
	            }
	        }
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> getCurrentConfiguration -> Exception '.$e);
		}
    	return $result;
	}

	public function updateAccessTokenInstagram($idConfiguration,$newToken){
		$resultUpdate = false;
		try{
			$this->db->set('accessTokenInstagram', $newToken);
			$this->db->where('idConfiguration',$idConfiguration);
			$this->db->update('configuration');
			if($this->db->affected_rows()>0){
				$resultUpdate=true;
			}
			//echo $this->db->last_query();	
		}catch(exception $e){	
			log_message('Error', 'Class -> configurationModel Method -> updateAccessTokenInstagram -> Exception '.$e);
		}
		return $resultUpdate;
	}
}

