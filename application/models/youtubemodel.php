<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("general_model.php");

class YouTubeModel extends General_model {
    protected $tableName = 'youtubehashtag';

    function addHashYouTube($param) {

        $id = 0;
        try {
            $this->db->where('videoId', $param['videoId']);
            $query = $this->db->get('youtubehashtag');
            if ($query->num_rows() <= 0) {
                if ($this->db->insert('youtubehashtag', $param)) {
                    $id = $this->db->insert_id();
                    echo $id;
                }
            }
        } catch (Exception $e) {
            //Exception
            //log_message('Error', 'Class -> fbtagModel Method -> addFbTag -> Exception ' . $e);
        }
        return $id;
    }

}
