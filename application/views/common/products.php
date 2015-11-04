<?php

?>
<section class="body-content">
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<div class="map products">
		<div id="products-map-canvas"></div>
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
		<div class="product_content" id="product_content">
			<div class="nav" id="product-create">
				<i class="close large icon"></i>
				<form id="product-form" class="ui small form" autocomplete="off" action="" method="post">
					<input type="hidden" value="<?= $store['id'] ?>" name="id_store" />
					<div class="inline fields">
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
					</div>
					<div class="inline fields">
						<div class="ui fluid small teal submit button">Crear</div>
						<div class="ui error message"></div>
					</div>
				</form>
			</div>
			<div class="nav" id="product-select">
				<i class="close large icon"></i>
				<div class="header"></div>
				<div class="ui mini action labeled input">
					<div class="ui black inverted label">
						Nuevo
					</div>
					<input type="number" name="price" value="" placeholder="Precio" id="product_new_price">
					<button class="ui teal mini right labeled icon button" id="product_new_price_add">
						<i class="checkmark icon"></i>
						Actualizar
					</button>
				</div>
				<div class="subheader">Otros precios</div>
				<div class="list">
					<div class="result">
						<div class="price">$2.500</div>
						<div class="title">Coca Cola ~ 350 [Coca Cola] </div>
						<div class="description">@Papa John's ~ hace 9 horas a 5 km.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var storePoint = {
		id: <?= $store['id'] ?>,
		lat: <?= $store['latitude'] ?>,
		lng: <?= $store['longitude'] ?>
	}
</script>
