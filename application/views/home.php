<?= $this->load->view('common/head') ?>
<?= $this->load->view('common/header') ?>

<section class="body-content" style="background-image: url('<?= base_url( )?>resources/img/backs/<?= rand(1,5) ?>.jpg')">

	<div class="ui middle aligned centered aligned grid">
		<div class="twelve wide column mobile eight wide tablet four wide computer column">
			<form id="home-form" class="ui mini form" autocomplete="off" action="" method="post">
				<h1><a href="<?= base_url() ?>" aria-label="Carus">Carus</a></h1>
				<div class="field">
					<div class="ui left icon input">
						<i class="at icon"></i>
						<input type="text" name="email" placeholder="E-mail" autocomplete="off">
					</div>
				</div>
				<div class="field">
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="password" placeholder="Clave" autocomplete="off">
					</div>
				</div>
				<div class="ui fluid large teal submit button">Ingresar</div>
				<div class="ui error message"></div>
			</form>
		</div>
	</div>

</section>

<?= $this->load->view('common/footer') ?>