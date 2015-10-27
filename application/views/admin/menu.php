<?
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
<div class="main-menu">
	<div class="sub-header"><small><?= lang( 'website_title' ) ?></small></div>
	<br>
	<div class="ui vertical text menu accordion inverted dash sticky">
<?
	echo anchor( 'admin', '<i class="home icon"></i>' . lang( 'website_home' ), array( 'class' => 'item' . ( $current == 'home' ? ' active' : '' ) ) );

	$active = ( in_array( $current, array( 'account_profile', 'account_settings', 'account_password', 'account_linked' ) ) );
?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="user icon"></i><i class="dropdown icon"></i> Mi Cuenta</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
				<?= anchor( 'account/account_profile', lang( 'website_profile' ), array( 'class' => 'item' . ( $current == 'account_profile' ? ' active' : '' ) ) ) ?>
				<?= anchor( 'account/account_settings', lang( 'website_account' ), array( 'class' => 'item' . ( $current == 'account_settings' ? ' active' : '' ) ) ) ?>
				<?= anchor( 'account/account_password', lang( 'website_password' ), array( 'class' => 'item' . ( $current == 'account_password' ? ' active' : '' ) ) ) ?>
				<?= anchor( 'account/account_linked', lang( 'website_linked' ), array( 'class' => 'item' . ( $current == 'account_linked' ? ' active' : '' ) ) ) ?>
			</div>
		</div>
<?
	/*
	<?= anchor( 'account/account_linked', '<i class="user icon"></i> ' . lang( 'website_linked' ), array( 'class' => 'item' ) ) ?>
	<i class="user icon"></i>
	<div class="header item">Administración</div>
	*/
	if ( $this->authorization->is_permitted( array( 'retrieve_users', 'retrieve_roles', 'retrieve_permissions' ) ) ) {

		$active = ( in_array( $current, array( 'manage_users', 'manage_roles', 'manage_permissions' ) ) );

?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="users icon"></i><i class="dropdown icon"></i> Control de Acceso</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
<?

		if ( $this->authorization->is_permitted( 'retrieve_users' ) )
			echo anchor( 'account/manage_users', '<i class="users icon"></i> ' . lang( 'website_manage_users' ), array( 'class' => 'item' . ( $current == 'manage_users' ? ' active' : '' ) ) );

		if ( $this->authorization->is_permitted( 'retrieve_roles' ) )
			echo anchor( 'account/manage_roles', '<i class="student icon"></i> ' . lang( 'website_manage_roles' ), array( 'class' => 'item' . ( $current == 'manage_roles' ? ' active' : '' ) ) );

		if ( $this->authorization->is_permitted( 'retrieve_permissions' ) )
			echo anchor( 'account/manage_permissions', '<i class="privacy icon"></i> ' . lang( 'website_manage_permissions' ), array( 'class' => 'item' . ( $current == 'manage_permissions' ? ' active' : '' ) ) );

?>
			</div>
		</div>
<?
	}


	if ( $this->authorization->is_permitted( array( 'retrieve_database' ) ) ) {

		$active = ( in_array( $current, array( 'database_users' ) ) );

?>
		<div class="item <?= ( $active ? 'active' : '' ) ?>">
			<a class="title <?= ( $active ? 'active' : '' ) ?>"><i class="database icon"></i><i class="dropdown icon"></i> DATABASE</a>
			<div class="menu content <?= ( $active ? 'active' : '' ) ?>">
<?
		if ( $this->authorization->is_permitted( 'retrieve_database' ) )
			echo anchor( 'database/users', '<i class="users icon"></i> Usuarios', array( 'class' => 'item' . ( $current == 'database_users' ? ' active' : '' ) ) );

?>
			</div>
		</div>
<?
	}
?>
	</div>
</div>

