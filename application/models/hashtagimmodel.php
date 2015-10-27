<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    require_once("general_model.php");

class HashtagimModel extends General_model {
    protected $tableName = 'hashtagim';

    public function addHashtagIM($hashtagim) {
        $id = 0;
        try {

	        $this->db->where('instagram', $hashtagim['instagram']);
	        $this->db->where('idMessage', $hashtagim['idMessage']);
	        $query = $this->db->get('hashtagim');
	        if ($query->num_rows() <= 0) {
		        $this->db->where('link', $hashtagim['link']);
		        $query = $this->db->get('hashtagim');

		        if( $query->num_rows( ) > 0 ) {
			        $this->db->where('link', $hashtagim['link']);
			        $this->db->update('hashtagim', $hashtagim );
		        }
		        else {
			        if ($this->db->insert('hashtagim', $hashtagim)) {
				        $id = $this->db->insert_id();
			        }
		        }
	        }

        } catch (Exception $e) {
            //Exception
            log_message('Error', 'Class -> HashtagimModel Method -> addHashtagIM -> Exception ' . $e);
        }
        return $id;
    }

    public function getBlacklist($param) {
        //$query = $this->db->query("select * from blacklist where MATCH (palabra) AGAINST ('" . $param . "' WITH QUERY EXPANSION)");
        //return $query->num_rows();
        return 0;
    }

    /**
     * Metodo encargado de obtener un listado de los mensajes 
     * que no han sido procesados
     * */
    public function getHashTagIMNotParse() {
        $result = null;
        try {

            $this->db->from('hashtagim');
            $this->db->where('hashtagim.parsed IS NULL');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                $result = $data;
            } else {
                $result = null;
            }
            //echo $this->db->last_query();
        } catch (exception $e) {
            log_message('Error', 'Class -> HashtagimModel Method -> getHashTagFBNotParse -> Exception ' . $e);
        }
        return $result;
    }

    public function updateParseHashtagIM($hashtagim) {
        $resultUpdate = false;
        try {
            $this->db->set('parsed', $hashtagim['parsed']);
            $this->db->set('dateUpdate', 'NOW()', false);
            $this->db->where('idHashTagIM', $hashtagim['idHashTagIM']);
            $this->db->update('hashtagim');
            if ($this->db->affected_rows() > 0) {
                $resultUpdate = true;
            }
            //echo $this->db->last_query();	
        } catch (exception $e) {
            log_message('Error', 'Class -> HashtagimModel Method -> updateParseHashtagIM -> Exception ' . $e);
        }
        return $resultUpdate;
    }

    public function getHashTagIMPantalla() {
        $result = null;
        try {

            $totalHtCurrTime = $this->getTotalIMCurrentTime();
            if ($totalHtCurrTime >= 1) {
                $this->db->where('hashtagim.parsed IS NOT NULL');
                $this->db->where('hashtagim.dateCreate + interval 2 MINUTE >=', 'NOW()', false);
                $this->db->order_by('dateCreate', 'DESC');
            } else {
                $this->db->where('hashtagim.parsed IS NOT NULL');
                $this->db->order_by('dateCreate', 'RANDOM');
            }
            $this->db->from('hashtagim');
            $this->db->limit(10);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                $result = $data;
            }
            //echo $this->db->last_query();
        } catch (exception $e) {
            log_message('Error', 'Class -> HashtagfbModel Method -> getHashTagIMPantalla -> Exception ' . $e);
        }
        return $result;
    }

    private function getTotalIMCurrentTime() {
        $result = 0;
        try {
            $this->db->select('count(0)  count');
            $this->db->from('hashtagim');
            $this->db->where('hashtagim.parsed IS NOT NULL');
            $this->db->where('hashtagim.dateCreate + interval 2 MINUTE >=', 'NOW()', false);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $result = $row->count;
                }
            }
            //echo $this->db->last_query();
        } catch (exception $e) {
            log_message('Error', 'Class -> ProfileModel Method -> getTotalIMCurrentTime -> Exception ' . $e);
        }
        return $result;
    }

}
