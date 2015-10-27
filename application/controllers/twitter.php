<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Twitter extends CI_Controller {

    function __construct() {
        parent::__construct();
        //Include libreria para utilizacion del api de facebook
        $this->load->library('apitwitter');
        //Include libreria de utilidad de Imagen Digital.
        $this->load->library('utilimagendigital');

        $this->load->helper('url');

        //inclide models
        $this->load->model('processExecutionModel');
        $this->load->model('tweetsModel');
        $this->load->model('tweetTagsModel');
    }

    /**
     * search de twitter
     */
    public function searchName() {
        $nameSearch = 'IED Colombia';
        $dataSuggest = $this->apitwitter->getSuggestUser($nameSearch);
        if (is_array($dataSuggest)) {
            foreach ($dataSuggest as $suggest) {
                echo ' <strong>id_str:</strong> ' . $suggest->id_str .
                ' <strong>name:</strong> ' . $suggest->name .
                ' <strong>screen name:</strong> #' . $suggest->screen_name .
                ' <strong>location:</strong> ' . $suggest->location;
                echo '<br>';
            }
        }
    }

    public function getTweets() {

        echo '<hr>Twitter - Inicio<br>';

        $resultArray = $this->startVerificationProcess();
        $tweet_id = -1;
        if ($resultArray['status'] == 0 && $resultArray['id'] > 0) {

            $hashtag = "#" . $this->config->item('TWITTER_HASHTAG');
	        echo '<br> - Tag ' . $hashtag . '<br>';
            $tweets = $this->apitwitter->getTweets($hashtag);

            if (!empty($tweets)) {
                $tweet_id = $this->insertDataTweets($tweets);
                if ($tweet_id == 0) {
                    $next_results = null;
                } else {
                    $next_results = (isset($tweets->search_metadata->next_results) ? $tweets->search_metadata->next_results : null);
                }
                if (!empty($next_results)) {
                    while (!empty($next_results)) {
                        $tweets = $this->apitwitter->getTweets($hashtag, $next_results);
                        $tweet_id = $this->insertDataTweets($tweets);
                        if ($tweet_id == 0) {
                            $next_results = null;
                        } else {
                            $next_results = (isset($tweets->search_metadata->next_results) ? $tweets->search_metadata->next_results : null);
                        }
                        $tweet_id = -1;
                    }
                }
            }

            $hashtag = "#" . $this->config->item('HASHTAG_PR');
	        echo '<br> - Tag ' . $hashtag . '<br>';
            $tweets2 = $this->apitwitter->getTweets($hashtag);

            if (!empty($tweets2)) {
                $tweet_id = $this->insertDataTweets($tweets2);
                if ($tweet_id == 0) {
                    $next_results = null;
                } else {
                    $next_results = (isset($tweets2->search_metadata->next_results) ? $tweets2->search_metadata->next_results : null);
                }
                if (!empty($next_results)) {
                    while (!empty($next_results)) {
                        $tweets2 = $this->apitwitter->getTweets($hashtag, $next_results);
                        $tweet_id = $this->insertDataTweets($tweets2);
                        if ($tweet_id == 0) {
                            $next_results = null;
                        } else {
                            $next_results = (isset($tweets2->search_metadata->next_results) ? $tweets2->search_metadata->next_results : null);
                        }
                        $tweet_id = -1;
                    }
                }
            }

            $hashList = array_merge( array(),$this->config->item('HASHTAG_LIST'));
            $hashKeys = array_rand( $hashList, 10 );

            foreach( $hashKeys as $key ) {
	            echo '<br> - Tag #' . $hashList[$key] . '<br>';
	            $results = $this->apitwitter->getTweets( '#' . $hashList[$key] );

	            if ( !empty($results) ) {
		            $tweet_id = $this->insertDataTweets($results, true);
		            if ($tweet_id == 0) {
			            $next_results = null;
		            } else {
			            $next_results = (isset($results->search_metadata->next_results) ? $results->search_metadata->next_results : null);
		            }
		            if (!empty($next_results)) {
			            while (!empty($next_results)) {
				            $results = $this->apitwitter->getTweets($hashtag, $next_results);
				            $tweet_id = $this->insertDataTweets($results, true);
				            if ($tweet_id == 0) {
					            $next_results = null;
				            } else {
					            $next_results = (isset($results->search_metadata->next_results) ? $results->search_metadata->next_results : null);
				            }
				            $tweet_id = -1;
			            }
		            }
	            }
            }
            $this->stopProcess();
        } else {
	        echo '<br> - En ejecucion<br>';
        }

        //$this->getTweetTag();
	    echo '<br>Twitter - Fin<hr>';
    }

    public function getTweetTag() {
        echo 'inicio proceso getTweetTag<br>';
        $hashtag = strtolower("#" . $this->config->item('TWITTER_HASHTAG'));
        $hashtagSchool = strtolower("#Bogota");
        $dataTweets = $this->tweetsModel->getAllTweetsNotParsed();
        if (!empty($dataTweets)) {
            foreach ($dataTweets as $tweets) {
                $tweetTag['tweet_id'] = $tweets->tweet_id;
                $entities = json_decode($tweets->entities);
                foreach ($entities->hashtags as $tag) {
                    $tagClear = strtolower('#' . $this->utilimagendigital->clearAccent($tag->text));
                    if ($tagClear == $hashtag) {
                        $tweetTag['tag'] = $tagClear;
                    } else if ($tagClear == strtolower($hashtagSchool)) {
                        $tweetTag['tagSchool'] = $tagClear;
                    }
                    $tagClear = '';
                }

                if (!empty($tweetTag['tagSchool']) && !empty($tweetTag['tag'])) {
                    $this->tweetTagsModel->addTweetTags($tweetTag);
                    echo $tweetTag['tweet_id'] . '<br>';
                }
                $this->tweetsModel->updateTweetsByParsed($tweetTag);


                $tweetTag = null;
            }
        }
        echo 'fin proceso getTweetTag<br>';
    }

    private function insertDataTweets($tweets, $anyUser = false ) {
	    echo ' - - Cantidad de Tw obtenidos: ' . count($tweets->statuses) . '<br>';
        $tweet_id = -1;

        $this->load->model( 'trainers_model' );

        $twitters = array();
	    if( !$anyUser ) {
		    $twitters = $this->trainers_model->getTwitterAccounts();

		    if( $this->config->item('TWITTER_ALLOWED_USERS') )
			    $twitters = array_merge( $twitters, $this->config->item('TWITTER_ALLOWED_USERS') );

		    $twitters = array_map('strtolower', $twitters);
	    }

        foreach ($tweets as $tweet) {
            foreach ($tweet as $tw) {
                if (
	                    !empty($tw->entities->media[0]->media_url)
                        &&
	                    (
	                        $anyUser
	                        ||
	                        in_array( strtolower( trim( $tw->user->screen_name ) ), $twitters )
	                    )
                    ) {
                    $dataTweets['tweet_id'] = $tw->id;
                    $dataTweets['tweet_text'] = $tw->text;
                    $dataTweets['entities'] = json_encode(($tw->entities));
                    $dateColombia = new DateTime($tw->created_at, new DateTimeZone('UTC'));
                    $dateColombia->setTimezone(new DateTimeZone('America/Bogota'));
                    $dataTweets['created_at'] = $dateColombia->format('Y-m-d H:i:s');
                    $dataTweets['user_id'] = $tw->user->id;
                    $dataTweets['screen_name'] = $tw->user->screen_name;
                    if (!empty($tw->geo)) {
                        $dataTweets['geo_lat'] = $tw->geo->coordinates[0];
                        $dataTweets['geo_long'] = $tw->geo->coordinates[1];
                    }
                    $dataTweets['name'] = $tw->user->name;
                    $dataTweets['profile_image_url'] = $tw->user->profile_image_url;
                    $dataTweets['media'] = $tw->entities->media[0]->media_url;
                    $dataTweets['fecha'] = $dateColombia->format('Y-m-d H:i:s');
                    
                     $dataTweets['hide'] = 2;
                    if($this->tweetsModel->getBlacklist($dataTweets['tweet_text'])){
                         $dataTweets['hide'] = 1;
                    }
                    
                    
                    $tweet_id = $this->tweetsModel->addTweets($dataTweets);
                    if ($tweet_id == 0) {
	                    echo ' - - Se detiene ' . $dataTweets['tweet_id'] . '<br>';
                        break;
                    }
                }
            }
        }
        return $tweet_id;
    }

    private function insertTweetTag() {
        
    }

    private function startVerificationProcess() {
        $processExecution['nameProcessExecution'] = 'Twitter';
        $dateColombia = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dateColombia->setTimezone(new DateTimeZone('America/Bogota'));
        $processExecution['startTimeProcessExecution'] = $dateColombia->format('Y-m-d H:i:s');
        $processExecution['statusProcessExecution'] = '1';
        $idProcessExecution = 0;
        $statusProcessExecution = -1;
        //Verificacion si el proceso existe
        $dataProcessExecution = $this->processExecutionModel->getProcessExecutionByName($processExecution);
        if (!empty($dataProcessExecution)) {
            foreach ($dataProcessExecution as $row) {
                $idProcessExecution = $row->idProcessExecution;
                $statusProcessExecution = $row->statusProcessExecution;
            }
        } else {
            $idProcessExecution = $this->processExecutionModel->addProcessExecution($processExecution);
            if ($idProcessExecution > 0) {
                $dataProcessExecution = $this->processExecutionModel->getProcessExecutionByName($processExecution);
                foreach ($dataProcessExecution as $row) {
                    $idProcessExecution = $row->idProcessExecution;
                    $statusProcessExecution = $row->statusProcessExecution;
                }
            } else {
                $statusProcessExecution = 0;
            }
        }
        return array('id' => $idProcessExecution, 'status' => 0);
        //return array('id' => $idProcessExecution, 'status' => $statusProcessExecution);
    }

    private function stopProcess() {
        $processExecution['nameProcessExecution'] = 'Twitter';
        $processExecution['statusProcessExecution'] = '0';

        $this->processExecutionModel->updateProcessExecution($processExecution);
    }

}
