<?php

	$this->load->view('common/head');
	$this->load->view('common/header');
?>
	<section class="body-content" style="background-image: url('<?= base_url( )?>resources/img/backs/<?= rand(1,6) ?>.jpg')">
		<nav>
			<div class="nav">
				<div class="ui mini label">
					<i class="building icon"></i><?= $store['name'] ?>
				</div>
			</div>
		</nav>
		<div class="product_search">
			<div class="nav">
				<div class="ui mini category search">
					<div class="ui icon input">
						<input class="prompt" type="text" placeholder="Buscar producto...">
						<i class="search icon"></i>
					</div>
					<div class="results"></div>
				</div>
			</div>
		</div>
	</section>


<?php

	$this->load->view('common/menu', array( 'action' => 'product' ));
	$this->load->view('common/footer');
