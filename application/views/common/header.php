<header>
	<div class="header">
		<h1 class="logo">
			<a href="<?= base_url() ?>" aria-label="Carus"><img src="<?= base_url() ?>resources/img/icon-white-shadow.png" alt="U" height="38"></a>
		</h1>
		<div class="right" id="user-actions">
			<div class="ui basic mini buttons">
<?php
	if( $this->authentication->is_signed_in( ) ) {
?>
				<button class="ui button" id="user-account"><?= ( isset( $account_details ) ? htmlentities( $account_details->fullname ) : '' ) ?></button>
				<button class="ui button" id="user-logout">Salir <i class="sign out icon"></i></button>
<?php
	}
	else {
?>
				<button class="ui button active" id="user-login">Entrar</button>
				<button class="ui button" id="user-register">Regístrarme</button>
<?php
	}
?>
			</div>
		</div>
	</div>
</header>
