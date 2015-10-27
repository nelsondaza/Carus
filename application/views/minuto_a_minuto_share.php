<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Reebok - Academy</title>
	<link rel="shortcut icon" href="/favicon.ico" />

	<meta property="og:site_name" content="Reebok Academy"/>
	<meta property="og:title" content="Reebok Academy" />
	<meta property="og:description" content="<?= $post['name'] ?> - @<?= $post['arroba'] ?>" />

	<meta property="fb:app_id" content="720452694748441" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?= $post['image'] ?>" />

</head>
<body>
<script type="text/javascript">
	window.top.location.href = "/minuto_a_minuto/<?= $type ?>/<?= $post['id'] ?>";
</script>
<img style="display: none" src="<?= $post['image'] ?>">
</body>
</html>