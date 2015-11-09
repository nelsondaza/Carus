<?php

	$this->load->view('common/head');
	$this->load->view('common/header');
?>
<section class="body-content">
	<div class="list products">
		<table class="ui basic celled small compact unstackable table ">
			<thead>
			<tr>
				<th class="collapsing">Producto</th>
				<th class="collapsing">Tienda</th>
				<th class="collapsing">Valor</th>
				<th class="collapsing">Fecha</th>
			</tr>
			</thead>
			<tbody>
<?php
	foreach( $products as $product ) {
?>
			<tr>
				<td><?= htmlentities( $product['name'] . ( $product['size'] ? ' ~ ' . $product['size'] : '' ) . ( $product['brand'] ? ' [' . $product['brand'] . '] ' : '' ) ) ?></td>
				<td><?= htmlentities( $product['store'] ) ?></td>
				<td><?= number_format( $product['price'], 0, ',', '.' ) ?></td>
				<td><?= $product['creation'] ?></td>
			</tr>
<?php
	}
?>
			</tbody>
<?php
	if( $pages > 0 ) {
?>
			<tfoot>
			<tr>
				<th colspan="3">
					<div class="ui pagination small menu">
<?php
		if( $page > 1 ) {
?>
						<a href="<?= base_url( )?>products/<?= $page - 1 ?>" class="icon item">
							<i class="left chevron icon"></i>
						</a>
<?php
		}
		for( $c = 1; $c <= $pages; $c ++ ) {
?>
						<a href="<?= base_url( )?>products/<?= $c ?>" class="item <?= $c == $page ? 'active' : ''?>"><?= $c ?></a>
<?php
		}
		if( $page < $pages ) {
?>
						<a href="<?= base_url( )?>products/<?= $page + 1 ?>" class="icon item">
							<i class="right chevron icon"></i>
						</a>
<?php
		}
?>
					</div>
				</th>
			</tr>
			</tfoot>
<?php
	}
?>
		</table>
	</div>
</section>
<?php
	$this->load->view('common/menu', array('action' => 'products'));
	$this->load->view('common/footer');
