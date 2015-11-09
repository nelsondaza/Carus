<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?= $this->load->view('admin/head', array('title' => lang( $class . '_page_name')) ) ?>
</head>
<body>
<?= $this->load->view('admin/header') ?>
<div class="container content">
	<?= $this->load->view('admin/menu', array('current' => 'manage_' . $class ) ) ?>
	<div class="sub-header"><i class="building icon"></i> <?= lang($class . '_page_name') ?></div>
	<div class="section">
<?php
    $this->load->view( 'admin/message', array( 'content' => lang( $class . '_page_description' ) ) );

    $table = array( );

    if( $this->authorization->is_permitted('create_stores') )
        $table['options'] = anchor( $scope . '/' . $class . '/save', '<i class="plus icon"></i> ' . lang('website_create'), 'class="ui purple button mini"');

    $table['headers'] = array(
        '#',
        lang('store_column_logo'),
        lang('store_column_name'),
        lang('store_column_creation'),
    );

    $table['rows'] = array( );
    $table['rows_options'] = array( );

    foreach( $stores as $object ) {

        $table['rows'][] = array(
            $object['id'],
            showBrandPhoto( $object['logo'], array( 'class' => 'ui mini avatar image' ) ),
            $object['name'] . (
                !$object['active']
                ? ' <span class="ui mini red label floated right">' . lang('store_inactive') . '</span>'
                : ''
            ),
            $object['creation']
        );

        if( $this->authorization->is_permitted('update_stores') )
            $table['rows_options'][] = anchor( $scope . '/' . $class . '/save/' . $object['id'], '<i class="edit icon"></i> ' . lang('website_update'), 'class="ui teal button mini"');
    }

    $this->load->view('admin/table', $table );

?>
	</div>
</div>
<?= $this->load->view('admin/footer') ?>
</body>
</html>