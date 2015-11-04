<?php

	$this->load->view('common/head');
	$this->load->view('common/header');
	$this->load->view('common/products');
	$this->load->view('common/menu', array( 'action' => 'product' ));
	$this->load->view('common/footer');
