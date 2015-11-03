<?php

?>
<section class="body-content">
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<div class="map stores">
		<div id="stores-map-canvas"></div>
		<div id="stores-menu">
			<div class="nav" id="store-menu-create">
				<i class="close large icon"></i>
				<div class="ui mini action labeled input">
					<div class="ui black inverted label">
						Lugar:
					</div>
					<input type="text" value="" placeholder="Nombre" id="new_store_name">
					<button class="ui teal mini right labeled icon button" id="new_store_add">
						<i class="checkmark icon"></i>
						Crear
					</button>
				</div>
			</div>
			<div class="nav" id="store-menu-select">
				<i class="close large icon"></i>
				<div class="ui mini action labeled input">
					<div class="ui black inverted label">
						<i class="building icon"></i><span></span>
					</div>
					<button class="ui teal mini right labeled icon button" id="store_selected">
						<i class="sign in icon"></i>
						Ir
					</button>
				</div>
			</div>
		</div>
		<button id="current_location" class="ui circular basic yellow icon button">
			<i class="location arrow icon"></i>
		</button>
	</div>
</section>
