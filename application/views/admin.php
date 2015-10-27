<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <?= $this->load->view('admin/head', array('title' => lang('website_home') ) ) ?>
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/vendor/jquery.gridster.css">
    <script src="<?= base_url() ?>resources/js/vendor/jquery.gridster.with-extras.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <?= $this->load->view('admin/header') ?>
    <div class="container content">
        <?= $this->load->view('admin/menu', array('current' => 'home') ) ?>
        <div class="sub-header">
            <i class="icon home"></i> <?= lang('website_home') ?>
        </div>
        <div class="section">
		<div class="flow">
			<div class="page">
				<div class="holder" style="height: 704px !important;">
					<div class="widgets">
						<div class="gridster">
							<div class="widget teal" data-row="1" data-col="1" data-sizex="4" data-sizey="3">
								<div class="head">
                                    INSCRITOS POR CIUDAD
								</div>
								<div class="body" id="upp"></div>
							</div>
							<div class="widget teal" data-row="1" data-col="5" data-sizex="4" data-sizey="3">
								<div class="head">
                                    REGISTROS POR GÉNERO
								</div>
								<div class="body" id="upt"></div>
							</div>
							<div class="widget orange" data-row="5" data-col="1" data-sizex="8" data-sizey="3">
								<div class="head">
                                    REGISTROS POR DÍA
								</div>
								<div class="body" id="uph"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<script type="text/javascript">
				$(function(){ //DOM Ready
					// x = 970 ==> ( 111 + 5 + 5 ) * 8 ==> ( width + margin-left + margin-right ) * columns = 968
					// y = 653 ==> ( 100 + 4 + 4 ) * 6 ==> ( height + margin-top + margin-bottom ) * rows = 648
					$(".flow .page .holder .widgets .gridster").gridster({
						widget_base_dimensions: [111, 100],
						widget_margins: [5, 4],
						widget_selector: 'div',
						max_cols: 8,
						min_rows: 6,
						max_rows: 6,
						autogrow_cols: false,
						resize: {
							enabled: false
						},
						draggable: {
							start: function (event, ui) {
								event.preventDefault();
								return false;
							}
						}
					});
				});
			</script>
<?
	//
	$this->db->select('a3m_account_details.ciudad, COUNT(*) AS total');
	$this->db->where('ciudad IS NOT NULL');
	$this->db->group_by('ciudad');
	$rows = $this->db->get('a3m_account_details')->result_array( );

	$user_types = array( );
	foreach( $rows as $row ) {
		$user_types[$row['ciudad']] = $row['total'];
	}

	$pie = array(
		'name' => 'Inscritos por Ciudad',
		'data' => $user_types
	);
?>
<script type="text/javascript">
	$(function () {
		// Build chart 1
		$('#upp').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: null,
			tooltip: {
				pointFormat: '<b>{point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: <?= ( count( $pie['data']) > 6 ? 'false' : 'true' ) ?>
				}
			},
			series: [{
				type: 'pie',
				name: ('<?= ( $pie['name'] ) ?>'),
				data: [
<?
		foreach( $pie['data'] as $key => $value ) {
?>
					[('<?= ( $key ) ?>'), <?= (float)( $value ) ?> ],
<?
		}
?>
				]
			}]
		});
	});
</script>
<?
	// Users type
	$this->db->select('
		a3m_account_details.gender AS gender, COUNT(*) AS total
		'
	);
	$this->db->where('a3m_account_details.gender IS NOT NULL');
	$this->db->where('a3m_account_details.gender !=', '');
	$this->db->group_by('a3m_account_details.gender');
	$this->db->order_by('a3m_account_details.gender');
	$rows = $this->db->get('a3m_account_details')->result_array( );

	$user_types = array( );
	foreach( $rows as $row ) {
		$user_types[( $row['gender'] == 'F' || $row['gender'] == 'f' ? 'Femenino' : 'Masculino' ) ] = $row['total'];
	}

	$pie = array(
		'name' => 'Registros por Género',
		'data' => $user_types
	);
?>
<script type="text/javascript">
	$(function () {
		// Build chart 1
		$('#upt').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: null,
			tooltip: {
				pointFormat: '<b>{point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: <?= ( count( $pie['data']) > 6 ? 'false' : 'true' ) ?>
				}
			},
			series: [{
				type: 'pie',
				name: ('<?= ( $pie['name'] ) ?>'),
				data: [
<?
		foreach( $pie['data'] as $key => $value ) {
?>
					[('<?= ( $key ) ?>'), <?= (float)( $value ) ?> ],
<?
		}
?>
				]
			}]
		});
	});
</script>
<?php
	$rows = array();

	// Users type
	$query = $this->db->query ( "
		SELECT
		LEFT(createdon, 10) AS fecha, COUNT(*) AS total
		FROM a3m_account
		WHERE createdon > '2015-03-10'
		GROUP BY
		LEFT(createdon, 10)
		ORDER BY fecha ASC
		" );
	$rows = $query->result_array();

	$user_types = array( );
	foreach( $rows as $row ) {
		$user_types[$row['fecha']] = $row['total'];
	}

	$pie = array(
		'name' => 'Registros por día',
		'data' => $user_types
	);
?>
<script type="text/javascript">
	$(function () {
		// Build chart 1
		$('#uph').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: null,
			tooltip: {
				pointFormat: '<b>{point.y}</b>'
			},
            xAxis: {
                type: 'datetime',
                minRange: 4 * 24 * 3600000 // fourteen days
            },
			plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
			},
			series: [{
				type: 'area',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2013, 2, 13),
				name: ('<?= ( $pie['name'] ) ?>'),
				data: [
<?
		foreach( $pie['data'] as $key => $value ) {
				$key = explode('-',$key);
				$key[1]--;
?>
					[Date.UTC(<?= implode(',', $key) ?>), <?= (float)( $value ) ?> ],
<?
		}
?>
				]
			}]
		});
	});
</script>
</div>
        </div>
    </div>
    <?= $this->load->view('admin/footer') ?>
</body>
</html>
