<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TweetTagsModel extends CI_Model {

	public function addTweetTags($tweetTags){
		$id = 0;
		try {
			$this->db->where('tweet_id', $tweetTags['tweet_id']);
			$this->db->where('tag', $tweetTags['tag']);
			$query = $this->db->get('tweet_tags');
			if ($query->num_rows() <= 0) {
				if ($this->db->insert('tweet_tags', $tweetTags)) {
					$id = $tweetTags['tweet_id'];
				}
			}
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> TweetTagsModel Method -> addTweetTags -> Exception '.$e);
		}
		return $id;
	}

	public function updateTweets($tweetTags){
    	$resultUpdate = false;
		try{
			$this->db->set('statustweets', $tweetTags['statustweets']);
			$this->db->set('finalTimetweets', 'NOW()',false);
			$this->db->where('nametweets',$tweetTags['nametweets']);
			$this->db->update('tweets');
			if($this->db->affected_rows()>0){
				$resultUpdate=true;
			}
			//echo $this->db->last_query();	
		}catch(exception $e){	
			log_message('Error', 'Class -> TweetsModel Method -> updateTweets -> Exception '.$e);
		}
		return $resultUpdate;
    }

    public function getTweetsById($tweetTags) {
		$result = null;
		try {
			$this->db->where('tweet_id',$tweetTags['tweet_id']);
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
			log_message('Error', 'Class -> TweetsModel Method -> getTweetsById -> Exception '.$e);
		}
		return $result;
	}

	public function getAllTweetsNotParsed(){
		$result = null;
		try {
			$this->db->where('parsed',0);
			$this->db->order_by('created_at','asc');
			$query = $this->db->get('tweets');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
	                $data[] = $row;
	            }
	            $result = $data;
			}	
		} catch (Exception $e) {
			//Exception
			log_message('Error', 'Class -> TweetsModel Method -> getAllTweetsNotParsed -> Exception '.$e);
		}
		return $result;
	}

}