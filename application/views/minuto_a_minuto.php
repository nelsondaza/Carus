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
<body class="min-a-min">
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
				<h2>¡Así se vivió esta experiencia!</h2>
				<br>
				<h1><img align="Reebok Academy" src="/images/logo_academy.png"></h1>
			</div>
			<div class="posts">
				<div id="posts">
<?php
	foreach( $posts as $post ) {
		$type = 'pump';
		switch( $post['ty'] ) {
			case 'ins':
				$type = 'instagram';
				break;
			case 'twt':
				$type = 'twitter';
				break;
			case 'you':
				$type = 'youtube';
				break;
			default:
				$type = 'pump';
		}
?>
					<div class="post <?= $post['ty'] ?>" data-type="<?= $type ?>" data-id="P<?= $post['id'] ?>" data-video="<?= $post['video'] ?>">
						<img class="image" src="<?= $post['image'] ?>">
						<img class="over" src="/images/trainer-back.png">
						<div class="info">
							<div class="name"><?= $post['name'] ?></div>
							<div class="account">@<?= $post['arroba'] ?></div>
							<div class="share">
								<img src="/images/mam-share.png" class="front">
								<div class="counter"><?= sprintf( "%06d", $post['shares'] ) ?></div>
							</div>
							<div class="desc hidden"><?= $post['descr'] ?></div>
						</div>
						<div class="pump">
							<img src="/images/mam-pump-<?= $type ?>.png" class="front">
						</div>
					</div>
<?php
	}
?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="posts-nav">
<?php
	if( $page > 1 ) {
?>
				<a class="posts-prev" href="/minuto_a_minuto/<?= $page - 1 ?>">&laquo; Anterior</a>
<?php
	}
	if( $page < $pages ) {
?>
				<a class="posts-next" href="/minuto_a_minuto/<?= $page + 1 ?>">Siguiente &raquo;</a>
<?php
	}
?>
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

	<div id="model-popup" class="model-popup">
		<div class="back"></div>
		<div class="content">
			<div class="holder">
				<div class="share-post">
					<div class="media">
						<img class="image" src="">
					</div>
					<div class="info">
						<div class="name"></div>
						<div class="account"></div>
						<div class="desc-holder">
							<div class="desc"></div>
						</div>
						<div class="share">
							<img src="/images/mam-share.png" class="front">
							<div class="counter"></div>
						</div>
					</div>
				</div>
				<div class="close"><img src="/images/close.png" alt="Close"></div>
				<div class="share">
					Compártelo
					<br>
					<div class="links"></div>
				</div>

				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>

	<script src="/js/jquery-1.7.1.min.js"></script>

	<script src="/js/masonry.pkgd.min.js"></script>
	<script src="/js/imagesloaded.js"></script>
	<script src="/js/classie.js"></script>
	<script src="/js/AnimOnScroll.js"></script>
	<script src="/js/jquery.infinitescroll.min.js"></script>

	<script src="/js/plugins.js"></script>
	<script src="/js/main.js"></script>

	<script type="text/javascript">
		window.aos = new AnimOnScroll( $('#posts')[0], {
			minDuration : 0.4,
			maxDuration : 0.6,
			viewportFactor : 0.2
		} );

		window.securecode = '<?= $hash ?>';
<?php
	if( isset( $selected ) && $selected ) {
?>
		$(function(){
			$('#posts .post:first').click();
		});
<?php
	}
?>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-59677829-3', 'auto');
		ga('require', 'displayfeatures');
		ga('send', 'pageview');
	</script>
</body>
</html>
