<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("general_model.php");

class TweetsModel extends General_model {
    protected $tableName = 'tweets';

    public function addTweets($tweets) {
        $id = 0;
        try {
            $this->db->where('tweet_id', $tweets['tweet_id']);
            $query = $this->db->get('tweets');
            if ($query->num_rows() <= 0) {
                if ($this->db->insert('tweets', $tweets)) {
                    $id = $tweets['tweet_id'];
                }
            }
        } catch (Exception $e) {
            //Exception
            log_message('Error', 'Class -> TweetsModel Method -> addTweets -> Exception ' . $e);
        }
        return $id;
    }

    public function getBlacklist($param) {
        //$query = $this->db->query("select * from blacklist where MATCH (palabra) AGAINST ('" . $param . "' WITH QUERY EXPANSION)");
        //return $query->num_rows();
        return 0;
    }

    public function updateTweetsByParsed($tweets) {
        $resultUpdate = false;
        try {
            $this->db->set('parsed', 1);
            $this->db->where('tweet_id', $tweets['tweet_id']);
            $this->db->where('parsed', 0);
            $this->db->update('tweets');
            if ($this->db->affected_rows() > 0) {
                $resultUpdate = true;
            }
            //echo $this->db->last_query();	
        } catch (exception $e) {
            log_message('Error', 'Class -> TweetsModel Method -> updateTweetsByParsed -> Exception ' . $e);
        }
        return $resultUpdate;
    }

    public function getTweetsById($tweets) {
        $result = null;
        try {
            $this->db->where('tweet_id', $tweets['tweet_id']);
            $this->db->limit(1);
            $query = $this->db->get('tweets');
            if ($query->num_rows() == 1) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                $result = $data;
            }
        } catch (Exception $e) {
            //Exception
            log_message('Error', 'Class -> TweetsModel Method -> getTweetsById -> Exception ' . $e);
        }
        return $result;
    }

    public function getAllTweetsNotParsed() {
        $result = null;
        try {
            $this->db->where('parsed', 0);
            $this->db->order_by('created_at', 'asc');
            $query = $this->db->get('tweets');
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                $result = $data;
            }
        } catch (Exception $e) {
            //Exception
            log_message('Error', 'Class -> TweetsModel Method -> getAllTweetsNotParsed -> Exception ' . $e);
        }
        return $result;
    }

}
