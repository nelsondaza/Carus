<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Youtube extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('utilimagendigital');
        $this->load->helper('url');
    }

    function getYoutube() {

	    echo '<hr>Youtube - Inicio<br>';
        $this->load->library('apiyoutube');
        //$this->apiyoutube->insertVideo('gol');
        $this->apiyoutube->insertVideo($this->config->item('YOUTUBE_HASHTAG'));
        $this->apiyoutube->insertVideo($this->config->item('HASHTAG_PR'));

	    /*
        $hashList = array_merge( array(),$this->config->item('HASHTAG_LIST'));
        $hashKeys = array_rand($hashList, 10);
        foreach( $hashKeys as $key ) {
	        echo '<br> - Tag #' . $hashList[$key] . '<br>';
	        $this->apiyoutube->insertVideo($hashList[$key]);
        }
	    */

	    echo '<br>Youtube - Fin<hr>';
    }

}
