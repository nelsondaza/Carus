<?
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 27/11/2014
 * Time: 10:30 AM
 */
	$action = ( isset( $action ) && $action ? $action : null );
?>
<div class="menu" id="mainMenu">
	<div class="ui icon buttons">
		<button class="ui button"><i class="sidebar big inverted icon"></i></button>
	</div>
	<div class="ui flowing mini popup hidden">
		<div class="ui vertical menu">
			<div class="item">
				<div class="menu">
					<a href="<?= base_url() ?>" class="<?= $action == 'store' ? 'active' : '' ?> item"><i class="building icon"></i> Tiendas</a>
					<a href="<?= base_url() ?>products" class="<?= $action == 'products' ? 'active' : '' ?> item"><i class="cart icon"></i> Mis Productos</a>
					<!--
					<a class="item"><i class="search icon"></i> Buscar</a>
					<a class="item"><i class="cart icon"></i> Mis compras</a>
					-->
				</div>
			</div>
		</div>
	</div>
</div>
