<?php
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 27/11/2014
 * Time: 10:30 AM
 */

	if ( !$this->authentication->is_signed_in( ) )
		return;

	if( !isset( $current ) )
		$current = '';

?>
<div class="ui vertical inverted thin sidebar menu" id="toc">
	<div class="item">
		<a class="ui logo icon image" href="<?= base_url() ?>admin">
			<img src="<?= base_url() ?>resources/img/icon-white.png" alt="Carus" width="40">
		</a>
		<a href="<?= base_url() ?>admin"><b>Carus</b></a>
	</div>
<?php
	$active = ( in_array( $current, array( 'account_profile', 'account_settings', 'account_password' ) ) );
?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="user icon"></i> Mi Cuenta</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
				<?= anchor( 'account/account_profile', lang( 'website_profile' ), array( 'class' => 'item' . ( $current == 'account_profile' ? ' active' : '' ) ) ) ?>
				<?= anchor( 'account/account_settings', lang( 'website_account' ), array( 'class' => 'item' . ( $current == 'account_settings' ? ' active' : '' ) ) ) ?>
				<?= anchor( 'account/account_password', lang( 'website_password' ), array( 'class' => 'item' . ( $current == 'account_password' ? ' active' : '' ) ) ) ?>
			</div>
		</div>
<?php
	if ( $this->authorization->is_permitted( array( 'retrieve_users', 'retrieve_roles', 'retrieve_permissions' ) ) ) {
		$active = ( in_array( $current, array( 'manage_users', 'manage_roles', 'manage_permissions' ) ) );
?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="users icon"></i> ACL</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
<?php

		if ( $this->authorization->is_permitted( 'retrieve_users' ) )
			echo anchor( 'account/manage_users', '<i class="users icon"></i> ' . lang( 'website_manage_users' ), array( 'class' => 'item' . ( $current == 'manage_users' ? ' active' : '' ) ) );

		if ( $this->authorization->is_permitted( 'retrieve_roles' ) )
			echo anchor( 'account/manage_roles', '<i class="student icon"></i> ' . lang( 'website_manage_roles' ), array( 'class' => 'item' . ( $current == 'manage_roles' ? ' active' : '' ) ) );

		if ( $this->authorization->is_permitted( 'retrieve_permissions' ) )
			echo anchor( 'account/manage_permissions', '<i class="privacy icon"></i> ' . lang( 'website_manage_permissions' ), array( 'class' => 'item' . ( $current == 'manage_permissions' ? ' active' : '' ) ) );

?>
			</div>
		</div>
<?php
	}

	if ( $this->authorization->is_permitted( array( 'view_reports', 'generate_reports', 'export_reports' ) ) ) {
		$active = ( in_array( $current, array( 'generate_db', 'graphics' ) ) );
?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="lab icon"></i> Reportes</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
<?php

		if ( $this->authorization->is_permitted( 'generate_reports' ) )
			echo anchor( 'reports/generate_db', '<i class="database icon"></i> Base de datos', array( 'class' => 'item' . ( $current == 'generate_db' ? ' active' : '' ) ) );
			echo anchor( 'reports/graphics', '<i class="bar chart icon"></i> Gráficos', array( 'class' => 'item' . ( $current == 'graphics' ? ' active' : '' ) ) );

?>
			</div>
		</div>
<?php
	}

	if ( $this->authorization->is_permitted( array( 'retrieve_users', 'retrieve_measures' ) ) ) {
		$active = ( in_array( $current, array( 'manage_sources', 'manage_measures' ) ) );

?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="settings icon"></i> Sistema</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
<?php

	echo anchor( 'manage/store', '<i class="building icon"></i> Establecimientos', array( 'class' => 'item' . ( $current == 'manage_stores' ? ' active' : '' ) ) );
	echo anchor( 'manage/brand', '<i class="crosshairs icon"></i> Marcas', array( 'class' => 'item' . ( $current == 'manage_brands' ? ' active' : '' ) ) );
	echo anchor( 'manage/product', '<i class="crosshairs icon"></i> Productos', array( 'class' => 'item' . ( $current == 'manage_products' ? ' active' : '' ) ) );
	echo anchor( 'manage/price', '<i class="crosshairs icon"></i> Precios', array( 'class' => 'item' . ( $current == 'manage_prices' ? ' active' : '' ) ) );

?>
			</div>
		</div>
<?php
	}
?>
</div>
<div class="ui black big launch right attached fixed button">
	<i class="content icon"></i>
	<span class="text">Menú</span>
</div>
