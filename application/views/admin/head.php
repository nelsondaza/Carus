<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title><?= isset($title) ? $title.' - '.lang('website_title') : lang('website_title') ?></title>
<meta name="description" content="">
<meta name="keywords" content="" />
<base href="<?= base_url() ?>"/>

<link rel="image_src" type="image/jpeg" href="<?= base_url() ?>img/logo.png" />
<link rel="stylesheet" href="<?= base_url() ?>resources/css/normalize.css">
<link rel="stylesheet" href="<?= base_url() ?>resources/css/vendor/semantic.min.css">
<link rel="stylesheet" href="<?= base_url() ?>resources/css/vendor/jquery.datetimepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css">
<link rel="shortcut icon" href="<?= base_url() ?>favicon.ico"/>
<script src="<?= base_url() ?>resources/js/vendor/modernizr-2.6.2.min.js"></script>
<?
	/*
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= base_url() ?>resources/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	*/
?>
<script src="<?= base_url() ?>resources/js/vendor/jquery-1.10.2.min.js"></script>
<script src="<?= base_url() ?>resources/js/vendor/jquery.datetimepicker.js"></script>
<script src="<?= base_url() ?>resources/js/vendor/jquery.tablesort.min.js"></script>
<script src="<?= base_url() ?>resources/js/vendor/semantic.min.js"></script>
<script src="<?= base_url() ?>resources/js/plugins.js"></script>
<script src="<?= base_url() ?>resources/js/main.js"></script>