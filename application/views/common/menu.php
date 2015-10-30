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
	<a href="#" id="current_location"><i class="circular icon location arrow"></i></a>
	<br>
	<div class="ui small blue icon buttons">
		<button class="ui button"><i class="sidebar icon"></i></button>
	</div>
	<div class="ui flowing mini popup top left transition hidden">
		<div class="ui small vertical compact menu">
			<div class="item">
				<div class="menu">
					<a class="item"><i class="search icon"></i> Buscar</a>
					<a class="item"><i class="cart icon"></i> Productos</a>
					<a class="active item"><i class="building icon"></i> Tienda</a>
				</div>
			</div>
		</div>
	</div>
</div>