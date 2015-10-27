<!doctype html>
<html class="no-js" lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Reebok Academy</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<link rel="stylesheet" href="/css/main.css">
	<script src="/js/modernizr-2.8.3.min.js"></script>
</head>
<body class="home">
	<header>
		<span id="gmenu" class="gmenu">
			<a href="#">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
		</span>
		<div class="body-zone">
			<nav id="mainMenu">
				<a class="logo" href="/"><img src="/images/logo_header.png"></a>
				<ul class="menu">
					<li><a href="#top" onclick="ga('send','event','Menu','select_Item','REEBOK ACADEMY')">REEBOK ACADEMY</a></li>
					<li><a href="#entrenadores" onclick="ga('send','event','Menu','select_Item','ENTRENADORES ASISTENTES')">ENTRENADORES ASISTENTES</a></li>
					<li><a href="#map" onclick="ga('send','event','Menu','select_Item','UBICA UN ENTRENADOR')">UBICA UN ENTRENADOR</a></li>
					<!--<li><a href="#apoya" onclick="ga('send','event','Menu','select_Item','APOYA TU ENTRENADOR')">APOYA TU ENTRENADOR</a></li>-->
					<li><a href="#conoce-zpump" onclick="ga('send','event','Menu','select_Item','CONOCE ZPUMP')">CONOCE ZPUMP</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<a name="top"></a>
	<section class="section-2">
		<div class="body-zone">
			<div class="banner">
				<div class="content">
					<img src="/images/logo_academy_white.png" align="Reebok Academy">
					<p>¡CONOCE CÓMO FUE EL REEBOK ACADEMY!</p>
					<br><br>
					<a href="/minuto_a_minuto" class="button" onclick="ga('send','event','Home','Ver_mas','Izquierdo')">Ver más<i class="arrow"></i></a>
					<img class="image-logo" src="/images/home-z2-banner-image.png" align="Reebok Academy">
				</div>
			</div>
			<div class="posts">
				<a href="/minuto_a_minuto">
<?php
	foreach( $list as $post ) {
?>
				<div class="post <?= $post['ty'] ?>">
					<img src="<?= $post['image'] ?>">
					<div class="over">
<?php
		if( trim( $post['descr'] ) ) {
?>
						<div class="desc"><?= trim( $post['descr'] ) ?></div>
<?php
		}
?>
					</div>
				</div>
<?php
	}
?>
				</a>
			</div>

			<div class="pump-zone">
				<div class="the-pump">
					<img class="black" src="/images/pump-black.png" alt="ZPump">
					<img class="fire" src="/images/pump-fire.png" alt="ZPump">
					<a href="/minuto_a_minuto" class="pump more" onclick="ga('send','event','Home','Ver_mas','Derecho')">
						<img class="over" src="/images/pump-ver-mas.png" alt="ZPump">
						<img class="out" src="/images/pump-pump.png" alt="ZPump">
					</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</section>
	<a name="entrenadores"></a>
	<section class="section-1">
		<div class="body-zone">
			<div class="trainers">
				<div class="banner">
					<div class="content">
						<img src="/images/logo_academy.png" align="Reebok Academy">
						<p>Ellos son los 50 entrenadores de parque que hicieron parte del <br>Reebok Academy.</p>
						<a href="/entrenadores" class="button" onclick="ga('send','event','Home','Conocelos Aqui','Izquierdo')">CONÓCELOS AQUÍ <i class="arrow"></i></a>
					</div>
				</div>
				<div class="people">
					<a href="/entrenadores">
<?php
	foreach( $trainers as $trainer ) {
?>
					<div class="trainer"><img src="/images/trainers/<?= $trainer['image'] ?>"></div>
<?php
	}
?>
					</a>
				</div>
				<div class="pump-zone">
					<div class="the-pump">
						<img class="black" src="/images/pump-black.png" alt="ZPump">
						<img class="fire" src="/images/pump-fire.png" alt="ZPump">
						<a href="/entrenadores" class="pump more" onclick="ga('send','event','Home','Conocelos Aqui','Derecho')">
							<img class="over" src="/images/pump-conoce.png" alt="ZPump">
							<img class="out" src="/images/pump-pump.png" alt="ZPump">
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</section>
	<a name="map"></a>
	<section class="section-3">
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
		<script src="/js/configMap.js"></script>
		<div class="body-zone">
			<div class="map">
				<div id="map-canvas"></div>
				<div id="results">
					<div class="left">
						<div class="title"><h2>MAPA PUMP</h2></div>
						<div class="text">
							¡Encuentra dónde entrenar para ser más fuerte y más humano!
							<br>
							<br>
							Selecciona tu ciudad, elige tu PUMP más cercano y contacta a tu entrenador para separar tu clase.
							<br>
							<br>
							<div class="cities">
								<select id="cities-filter">
									<option value=""> - Ciudad - </option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="pump-zone">
					<div class="the-pump">
						<img class="black" src="/images/pump-black.png" alt="ZPump">
						<img class="fire" src="/images/pump-fire.png" alt="ZPump">
						<a href="#" class="pump locate">
							<img class="over" src="/images/pump-cerca.png" alt="ZPump">
							<img class="out" src="/images/pump-pump.png" alt="ZPump">
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</section>
	<a name="conoce-zpump"></a>
	<section class="products">
		<div class="body-zone">
			<div class="title">
				<h1><img src="/images/products-title.png" align="The ZPump" /></h1>
				<h2>Conoce la última innovación de Reebok: ZPump ¡disponible ahora!</h2>
			</div>
			<div class="list">
				<div class="product">
					<a href="http://www.reebok.co/reebok-zpump-fusion/V66480.html" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p1.png"></div>
						<div class="name">Z PUMP FUSION</div>
						<div class="desc">Running</div>
						<span class="button">Comprar <i class="arrow"></i></span>
					</a>
				</div>
				<div class="product">
					<a href="http://www.reebok.co/zpump-fusion-tr/V65938.html" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p2.png"></div>
						<div class="name">Z PUMP FUSION TR</div>
						<div class="desc">Training</div>
						<span class="button">Comprar <i class="arrow"></i></span>
					</a>
				</div>
				<div class="product">
					<a href="http://www.reebok.co/tenis-para-training-reebok-rcf-nano-pump-fusion/V67642.html" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p3.png"></div>
						<div class="name">CROSSFIT<sup>&reg;</sup> PUMP NANO</div>
						<div class="desc">Crossfit</div>
						<span class="button">Comprar <i class="arrow"></i></span>
					</a>
				</div>
				<div class="product">
					<a href="http://www.reebok.co/reebok-zpump-fusion/V66479.html" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p4.png"></div>
						<div class="name">Z PUMP FUSION</div>
						<div class="desc">Running</div>
						<span class="button">Comprar <i class="arrow"></i></span>
					</a>
				</div>
				<div class="product">
					<a href="http://www.reebok.co/zpump-fusion-tr/V62658.html" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p5.png"></div>
						<div class="name">Z PUMP FUSION TR</div>
						<div class="desc">Training</div>
						<span class="button">Comprar <i class="arrow"></i></span>
					</a>
				</div>
				<div class="product">
					<a href="http://www.reebok.co/zpump" target="_blank" onclick="ga('send','event','Home','Productos',$(this).find('.name').text())">
						<div class="image"><img src="/images/products/p6.png"></div>
						<div class="name">CROSSFIT<sup>&reg;</sup> PUMP NANO</div>
						<div class="desc">Crossfit</div>
						<span class="button">Comprar <i class="arrow"></i></span>

					</a>
				</div>
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
