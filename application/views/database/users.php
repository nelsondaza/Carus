<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?= $this->load->view('admin/head', array('title' => 'DATABASE') ) ?>
</head>
<body>
<?= $this->load->view('admin/header') ?>
<div class="container content">
	<?= $this->load->view('admin/menu', array('current' => 'database_users') ) ?>
	<div class="sub-header"><i class="icon users"></i> Usuarios</div>
	<div class="section">
<?php

	$table = array( );

	$query = $this->db->query ( "
            SELECT a3m_account_details.*, a3m_account.email
            FROM a3m_account_details, a3m_account
            WHERE a3m_account_details.account_id = a3m_account.id
            AND a3m_account_details.gender IS NOT NULL
            ORDER BY a3m_account.id DESC
        " );
	$list = $query->result_array();

	$table = array( );

	$table['headers'] = array(
		'Nombre',
		'Apellido',
		'Tipo de Doc.',
		'Documento',
		'Nacimiento',
		'Género',
		'E-mail',
		'Teléfono',
		'Ciudad',
		'Facebook',
		'Twitter',
		'Instagram',
		'Tiene Certificados',
		'Certificados',
		'Entrenamientos',
		'Tiene Patrocinios',
		'Patrocinios',
		'Parques',
		'Acepta Términos',
		'Autoriza Uso',
	);

	$table['rows'] = array( );
	$table['rows_options'] = array( );

	foreach( $list as $object ) {
		$table['rows'][] = array(
			$object['firstname'],
			$object['lastname'],
			$object['doc_type'],
			$object['doc_num'],
			$object['dateofbirth'],
			$object['gender'],
			$object['email'],
			$object['telefono'],
			$object['ciudad'],
			$object['link_facebook'],
			$object['link_twitter'],
			$object['link_instagram'],
			$object['certificados_tiene'],
			$object['certificados'],
			$object['entrenamientos'],
			$object['patrocinios_tiene'],
			$object['patrocinios'],
			$object['parques'],
			$object['terminos_acepta'],
			$object['autoriza_datos'],
		);
	}

	$this->load->view('admin/table', $table );

?>
	</div>
	<div class="clearfix"></div>
</div>
<?= $this->load->view('admin/footer') ?>
</body>
</html>
