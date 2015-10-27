<!doctype html>
<html class="no-js" lang="es">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<title>Reebok Academy</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />

	<link rel="stylesheet" href="/css/semantic.css" />
	<link rel="stylesheet" href="/css/main.css" />
	<script src="/js/modernizr-2.8.3.min.js"></script>
</head>
<body class="trainers">
	<header>
		<div class="body-zone">
			<nav>
				<a class="logo" href="/"><img src="/images/logo_header.png"></a>
				<a class="close" href="/"><img src="/images/close.png"></a>
			</nav>
		</div>
	</header>
	<section class="section">
		<div class="body-zone">
			<div class="title">
				<h1>
					<img class="desktop" alt="SoyUnZPumper" src="/images/trainers-hash.png">
					<img class="mobile" alt="SoyUnZPumper" src="/images/trainers-hash-m.png">
				</h1>
				<h2>¡Demuéstrales tu apoyo dándole clic al PUMP!</h2>
				<br>
				<h1><img align="Reebok Academy" src="/images/logo_academy.png"></h1>
			</div>
			<div class="trainers">
<?php
	foreach( $trainers as $trainer ) {
?>
		<div class="trainer">
			<img class="avatar" src="/images/trainers/<?= ( $trainer['image'] ? $trainer['image'] : 't-1.jpg' ) ?>">
			<img class="over" src="/images/trainer-back.png">
			<div class="info">
				<div class="name"><?= $trainer['name'] ?></div>
				<div class="city"><?= $trainer['city'] ?></div>
				<div class="follow">
					<span>Conócel</span>@:
<?php
		if( $trainer['tw'] ) {
?>
					<a href="https://twitter.com/<?= $trainer['tw'] ?>" target="_blank" class="icon_social" id="twitter"></a>
<?php
		}
		if( $trainer['fb'] ) {
?>
					<a href="https://facebook.com/<?= $trainer['fb'] ?>" target="_blank" class="icon_social" id="facebook"></a>
<?php
		}
		if( $trainer['in'] ) {
?>
					<a href="https://instagram.com/<?= $trainer['in'] ?>" target="_blank" class="icon_social" id="instagram"></a>
<?php
		}
?>
				</div>
			</div>
			<div class="pump" data-code="<?= $trainer['id'] ?>">
				<img src="/images/trainer-pump-back.png" class="back">
				<img src="/images/trainer-pump.png" class="front">
				<div class="counter"><?= sprintf( "%06d", $trainer['votes'] ) ?></div>
			</div>
		</div>
<?php
	}
?>
				<div class="clear"></div>
			</div>
		</div>
	</section>
	<footer>
		<div class="body-zone">
			<div class="terms">
				<a class="pp" href="http://reebokacademy.com/politicas">Política de Privacidad</a><a class="tc" href="http://reebokacademy.com/terminos">Términos y Condiciones</a>
				<small class="mobile">© Oficina Reebok. Av. Calle 100 # 19-54 Piso8. Bogotá D.C.</small>
			</div>
			<div class="follow">
				<span>SÍGUENOS EN: </span>
				<a href="https://twitter.com/ReebokColombia" target="_blank" class="icon_social" id="twitter"></a>
				<a href="https://www.facebook.com/Reebok" target="_blank" class="icon_social" id="facebook"></a>
				<a href="https://instagram.com/reebokcolombia" target="_blank" class="icon_social" id="instagram"></a>
				<a href="http://www.pinterest.com/reebok/" target="_blank" class="icon_social" id="pinterest"></a>
			</div>
			<div class="buy">
				<a href="http://www.reebok.co" target="_blank">Compra online en REEBOK.CO</a>
			</div>
		</div>
	</footer>

	<script src="/js/jquery-1.11.3.min.js"></script>
	<script src="/js/plugins.js"></script>
	<script src="/js/main.js"></script>
	<script type="text/javascript">
		window.securecode = '<?= $hash ?>';
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-59677829-3', 'auto');
		ga('require', 'displayfeatures');
		ga('send', 'pageview', {
			page:'/entrenadores',
			title: document.title
		});

	</script>
</body>
</html>