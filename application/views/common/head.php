<!doctype html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
	<title><?= ( isset($title) ? $title . ' - ' : '' ) . lang('website_title') ?></title>
	<meta name="description" content="Recuerda tus compras, cuanto y donde lo has pagado." />
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />-->

    <link rel="apple-touch-icon" href="<?= base_url() ?>apple-touch-icon.png" />
	<link rel="image_src" type="image/jpeg" href="<?= base_url() ?>resources/img/600x315.png" />
	<link rel="shortcut icon" href="<?= base_url() ?>favicon.ico" />

	<meta property="og:site_name" content="<?= lang('website_title') ?>" />
	<meta property="og:title" content="<?= ( isset($title) ? $title . ' - ' : '' ) . lang('website_title') ?>" />
	<meta property="og:description" content="Recuerda tus compras, cuanto y donde lo has pagado." />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?= base_url() ?>resources/img/600x315.png" />
	<meta property="fb:app_id" content="" />


	<link rel="stylesheet" href="<?= base_url() ?>resources/css/normalize.css" />
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/vendor/semantic.min.css" />
	<link rel="stylesheet" href="<?= base_url() ?>resources/css/site.css" />

    <script src="<?= base_url() ?>resources/js/vendor/modernizr-2.8.3.min.js"></script>
	<script type="text/javascript"> var base_url = '<?= base_url() ?>';</script>
</head>
<body class="<?= $class . ( $this->authentication->is_signed_in( ) ? ' in' : '' ) ?>">