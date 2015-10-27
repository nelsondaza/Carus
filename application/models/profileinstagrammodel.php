<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProfileInstagramModel extends CI_Model {

    public function addProfileInstagram($profileInstagram) {
        $id = 0;
        try {
            $this->db->where('idInstagram', $profileInstagram['idInstagram']);
            $query = $this->db->get('profileinstagram');
            if ($query->num_rows() <= 0) {
                if ($this->db->insert('profileinstagram', $profileInstagram)) {
                    $id = $this->db->insert_id();
                }
            }
        } catch (Exception $e) {
            //Exception
            log_message('Error', 'Class -> ProfileInstagramModel Method -> addProfileInstagram -> Exception ' . $e);
        }
        return $id;
    }

}
