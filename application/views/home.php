<?php

	$this->load->view('common/head');
	$this->load->view('common/header');

	if( !$this->authentication->is_signed_in( ) )
		$this->load->view('common/login');
	else {
		$this->load->view('common/stores');
		$this->load->view('common/menu', array( 'action' => 'store' ));
	}

	$this->load->view('common/footer');
