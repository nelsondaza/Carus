<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProcessExecutionModel extends CI_Model {

	public function addProcessExecution($processExecution){
		$id = 0;
		try {
			$this->db->where('nameProcessExecution', $processExecution['nameProcessExecution']);
			$this->db->where('statusProcessExecution', 1);
			$query = $this->db->get('processExecution');
			if ($query->num_rows() <= 0) {
				if ($this->db->insert('processExecution', $processExecution)) {
					$id = $this->db->insert_id();
				}
			}
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> ProcessExecutionModel Method -> addProcessExecution -> Exception '.$e);
		}
		return $id;
	}

	public function updateProcessExecution($processExecution){
    	$resultUpdate = false;
		try{
			$this->db->set('statusProcessExecution', $processExecution['statusProcessExecution']);
			$this->db->set('finalTimeProcessExecution', 'NOW()',false);
			$this->db->where('nameProcessExecution',$processExecution['nameProcessExecution']);
			$this->db->update('processExecution');
			if($this->db->affected_rows()>0){
				$resultUpdate=true;
			}
			//echo $this->db->last_query();	
		}catch(exception $e){	
			log_message('Error', 'Class -> ProcessExecutionModel Method -> updateProcessExecution -> Exception '.$e);
		}
		return $resultUpdate;
    }

    public function getProcessExecutionByName($processExecution) {
		$result = null;
		try {
			$this->db->where('nameProcessExecution',$processExecution['nameProcessExecution']);
			$this->db->limit(1);
			$query = $this->db->get('processExecution');
			if ($query->num_rows() == 1) {
				foreach ($query->result() as $row) {
	                $data[] = $row;
	            }
	            $result = $data;
			}	
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> ProcessExecutionModel Method -> getProcessExecutionByName -> Exception '.$e);
		}
		return $result;
	}

}