<?
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 27/11/2014
 * Time: 10:30 AM
 */
	$action = ( isset( $action ) && $action ? $action : null );
?>
<div class="mainHeader">
	<span id="gmenu" class="gmenu">
		<a href="#">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
	</span>
	<span class="logo"><a href="http://reebokcardioultra.com/">Reebok</a></span>
	<div class="userHeader" style="display: <?= ( $this->authentication->is_signed_in( ) ? 'block' : 'none' ) ?>">
		<div class="container">
			<span class="title">Bienvenida:</span> <a href="#"><span class="user"><?= ( isset( $account_details ) ? htmlentities( ( $account_details->fullname ? $account_details->fullname : $account_details->firstname . ' ' . $account_details->lastname ) ) : '' ) ?></span> <span data-icon="n" class="menuIcon"></span></a>
		</div>
	</div>
</div>
<div class="menu" id="mainMenu">
	<div class="container">
		<ul class="nav">
			<li id="userRegisterMO" <?= ( $action == 'registro' ? 'class="active"' : '' ) ?> style="display: <?= ( !$this->authentication->is_signed_in( ) ? 'block' : 'none' ) ?>">
				<a onclick="ga('send', 'event','Menu', 'select_Item', 'REGISTRO')" href="<?= base_url() ?>registro" class="menuOption">
					<div class="menuLabel"><div class="menuLabelContent">REGISTRO</div></div>
					<div data-icon="q" class="menuIcon"></div>
				</a>
			</li>
			<li <?= ( $action == 'productos' ? 'class="active"' : '' ) ?>>
				<a onclick="ga('send', 'event','Menu', 'select_Item', 'PRODUCTOS')" href="<?= base_url() ?>productos" class="menuOption">
					<div class="menuLabel"><div class="menuLabelContent">PRODUCTOS</div></div>
					<div data-icon="p" class="menuIcon"></div>
				</a>
			</li>
			<li <?= ( $action == 'rutinas' ? 'class="active"' : '' ) ?>>
				<a onclick="ga('send', 'event','Menu', 'select_Item', 'RUTINAS CARDIO')" href="<?= base_url() ?>rutinas" class="menuOption">
					<div class="menuLabel"><div class="menuLabelContent">RUTINAS CARDIO</div></div>
					<div data-icon="f" class="menuIcon"></div>
				</a>
			</li>
			<li <?= ( $action == 'classes' ? 'class="active"' : '' ) ?>>
				<a onclick="ga('send', 'event','Menu', 'select_Item', 'CLASES')" href="<?= base_url() ?>clases" class="menuOption">
					<div class="menuLabel"><div class="menuLabelContent">CLASES</div></div>
					<div data-icon="k" class="menuIcon"></div>
				</a>
			</li>
			<li id="userLoggedMO" style="display: <?= ( $this->authentication->is_signed_in( ) ? 'block' : 'none' ) ?>">
				<a onclick="ga('send', 'event','Menu', 'select_Item', 'CERRAR SESIÓN')" href="#" class="menuOption">
					<div class="menuLabel"><div class="menuLabelContent">CERRAR SESIÓN</div></div>
					<div data-icon="n" class="menuIcon"></div>
				</a>
			</li>
		</ul>
	</div>
</div>