<?php

	$this->load->view('common/head');
	$this->load->view('common/header');
?>
<section class="body-content">
	<div class="policy">
<?php
	$this->load->view('common/policy_privacy');
?>
	</div>
</section>
<?php
	$this->load->view('common/menu');
	$this->load->view('common/footer', array( 'action' => 'privacy' ));
