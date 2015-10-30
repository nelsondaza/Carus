<?php

	$this->load->view('common/head');
	$this->load->view('common/header');
?>
	<section class="body-content" style="background-image: url('<?= base_url( )?>resources/img/backs/<?= rand(1,6) ?>.jpg')">
		<div class="product_search">
			<div class="nav">
				<div class="ui mini left aligned category search" id="product_search">
					<div class="ui icon input">
						<input class="prompt" type="text" placeholder="Buscar producto...">
						<i class="search icon"></i>
					</div>
					<div class="ui teal horizontal small label">
						<i class="marker icon"></i> <?= $store['name'] ?>
					</div>
					<div class="results"></div>
				</div>
			</div>
		</div>
		<div class="product_content">
			<div class="ui centered aligned grid">
				<div class="ten wide column mobile eight wide tablet four wide computer column">
					<h3>Nuevo Producto</h3>
					<form id="product-form" class="ui small form" autocomplete="off" action="" method="post">
						<div class="field">
							<div class="ui left icon input">
								<i class="cart icon"></i>
								<input type="text" name="name" placeholder="Nombre *" autocomplete="off">
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="database icon"></i>
								<input type="text" name="size" placeholder="Tamaño" autocomplete="off">
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="paw icon"></i>
								<input type="text" name="brand" placeholder="Marca" autocomplete="off">
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="dollar icon"></i>
								<input type="number" name="price" placeholder="Precio *" autocomplete="off">
							</div>
						</div>
						<div class="ui fluid small teal submit button">Crear</div>
						<div class="ui error message"></div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php

	$this->load->view('common/menu', array( 'action' => 'product' ));
	$this->load->view('common/footer');
