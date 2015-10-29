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
	<div class="ui mini basic icon buttons">
		<button class="ui button"><i class="sidebar big inverted icon"></i></button>
	</div>
	<div class="ui flowing popup top left transition hidden">
		<div class="ui vertical menu">
			<a class="active teal item">
				Inbox
				<div class="ui teal pointing left label">1</div>
			</a>
			<a class="item">
				Spam
				<div class="ui label">51</div>
			</a>
			<a class="item">
				Updates
				<div class="ui label">1</div>
			</a>
			<div class="item">
				<div class="ui transparent icon input">
					<input type="text" placeholder="Search mail...">
					<i class="search icon"></i>
				</div>
			</div>
		</div>
	</div>
</div>