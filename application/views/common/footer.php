<?
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 27/11/2014
 * Time: 10:30 AM
 */
	$action = ( isset( $action ) && $action ? $action : null );
?>
<footer>
	<div class="ui fullscreen modal" id="footer-contents">
		<i class="huge close icon"></i>
		<div class="content">content</div>
	</div>
	<div class="right">
		<div class="ui basic mini buttons">
			<a href="<?= base_url() ?>policy/carus" class="ui button <?= $action == 'carus' ? 'active' : '' ?>" id="footer-carus">¿Carus?</a>
			<a href="<?= base_url() ?>policy/terms-of-service" class="ui button <?= $action == 'terms' ? 'active' : '' ?>" id="footer-terms">T<span class="mobile">yC.</span><span class="desktop">érminos</span></a>
			<a href="<?= base_url() ?>policy/privacy" class="ui button <?= $action == 'privacy' ? 'active' : '' ?>" id="footer-privacy">Priv<span class="mobile">.</span><span class="desktop">acidad</span></a>
		</div>
	</div>
</footer>

<script src="<?= base_url() ?>resources/js/vendor/jquery-1.11.3.min.js"></script>
<script src="<?= base_url() ?>resources/js/vendor/semantic.min.js"></script>
<script src="<?= base_url() ?>resources/js/plugins.js"></script>
<script src="<?= base_url() ?>resources/js/site.js"></script>

<script>
	/*
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='https://www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','UA-XXXXX-X','auto');ga('send','pageview');
	*/
</script>
</body>
</html>