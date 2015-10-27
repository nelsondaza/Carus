<?php
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 02/12/2014
 * Time: 03:01 PM
 */

	if( !isset( $headers ) )
		$headers = array( );
	if( !isset( $rows ) )
		$rows = array( );
	if( !isset( $rows_options ) )
		$rows_options = array( );

	if( isset( $options ) )
		echo $options;

?>
<a class="ui black button mini" style="float: right" href="<?= base_url() ?>services/export/excel"><i class="file excel outline icon"></i> Excel</a>
<div class="table_holder">
<table class="ui celled striped table small sortable ">
<?
	if( !empty( $headers ) ) {
?>
	<thead>
	<tr>
<?
		if( !empty( $rows_options ) )
			echo '<th></th>';
		foreach( $headers as $header ) {
?>
			<th><?= $header ?></th>
<?
		}
?>
	</tr>
	</thead>
<?
	}
?>
	<tbody>
<?
		foreach( $rows as $index => $row ) {
?>
	<tr>
<?
			if( isset( $rows_options[$index] ) && $rows_options[$index] )
				if( is_array( $rows_options[$index] ) )
					echo '<td>' . implode(' ', $rows_options[$index] ) . '</td>';
				else
					echo '<td>' . $rows_options[$index] . '</td>';

			foreach( $row as $cell ) {
?>
		<td><?= $cell ?></td>
<?
			}
?>
	</tr>
<?
		}
?>
	</tbody>
</table>
</div>
<a class="ui black button mini" style="float: right" href="<?= base_url() ?>services/export/excel"><i class="file excel outline icon"></i> Excel</a>
<?
	if( isset( $options ) )
		echo $options;
?>
