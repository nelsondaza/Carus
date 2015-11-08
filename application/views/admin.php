<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <?= $this->load->view('admin/head', array('title' => lang('website_home') ) ) ?>
</head>
<body>
    <?= $this->load->view('admin/header', array('current' => 'home')) ?>
    <div class="container content">
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
                                    ÚLTIMOS PRECIOS REGISTRADOS
								</div>
								<div class="body" id="upp"></div>
							</div>
							<div class="widget teal" data-row="1" data-col="5" data-sizex="4" data-sizey="3">
								<div class="head">
									PRODUCTOS POR MARCA
								</div>
								<div class="body" id="upt"></div>
							</div>
							<div class="widget orange" data-row="5" data-col="1" data-sizex="8" data-sizey="3">
								<div class="head">
                                    PRECIOS REGISTRADOS POR DÍA
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
					// x = 1160 ==> ( 135 + 5 + 5 ) * 8 ==> ( width + margin-left + margin-right ) * columns = 968
					// y = 653 ==> ( 100 + 4 + 4 ) * 6 ==> ( height + margin-top + margin-bottom ) * rows = 648
					$(".flow .page .holder .widgets .gridster").gridster({
						widget_base_dimensions: [135, 100],
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
<?php
	//
	$this->db->select('price.value, price.creation, product.name, product.size, brand.name as brand');
	$this->db->join( 'product', 'product.id = price.id_product' );
	$this->db->join( 'brand', 'product.id_brand = brand.id', 'LEFT' );
	$this->db->group_by('price.id_product');
	$this->db->order_by('price.creation DESC');
	$this->db->order_by('price.value DESC');
	$this->db->limit(10);
	$rows = $this->db->get('price')->result_array( );

	$data = array( );
	foreach( $rows as $row ) {
		$data[$row['name'] . ( $row['size'] ? ' ~' . $row['size'] : '' ) . ( $row['brand'] ? ' (' . $row['brand'] . ')' : '' ) ] = $row['value'];
	}

	$pie = array(
		'name' => 'Últimos Precios',
		'data' => $data
	);
?>
<script type="text/javascript">
$(function () {
	$('#upp').highcharts({
        chart: {
            type: 'column',
            margin: 35,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
		credits: {
			enabled: false
		},
        title: null,
        subtitle: null,
		legend: {
			enabled: false
		},
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: <?= json_encode( array_keys( $pie['data'] ), JSON_UNESCAPED_UNICODE) ?>,
	        labels: {
		        enabled: false
	        }
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Precio',
	        data: <?= json_encode( array_values( $pie['data'] ), JSON_NUMERIC_CHECK) ?>
        }]
    });
});

	$(function () {
		// Build chart 1
		$('#uph2').highcharts({
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
				name: ('<?= ( $pie['name'] ) ?>'),
				data: [
<?php
		foreach( $pie['data'] as $key => $value ) {
?>
					['<?= $key ?>', <?= (float)( $value ) ?> ],
<?php
		}
?>
				]
			}]
		});
	});
</script>
<?php
	// Users type
	$this->db->select('COALESCE(brand.name, "Sin Marca") AS name, COUNT(*) as total', false);
	$this->db->join( 'brand', 'product.id_brand = brand.id', 'LEFT' );
	$this->db->group_by('brand.id');
	$this->db->order_by('brand.name ASC');
	$rows = $this->db->get('product')->result_array( );

	$user_types = array( );
	foreach( $rows as $row ) {
		$user_types[$row['name']] = $row['total'];
	}

	$pie = array(
		'name' => 'Productos',
		'data' => $user_types
	);
?>
<script type="text/javascript">
	$(function () {
		// Build chart 1
		$('#upt').highcharts({
	        chart: {
	            type: 'pie',
	            options3d: {
	                enabled: true,
	                alpha: 45
	            }
	        },
	        title: null,
	        subtitle: null,
	        plotOptions: {
	            pie: {
	                innerSize: 100,
	                depth: 45
	            }
	        },
	        series: [{
		        name: ('<?= ( $pie['name'] ) ?>'),
	            data: [
<?php
		foreach( $pie['data'] as $key => $value ) {
?>
					[('<?= ( $key ) ?>'), <?= (float)( $value ) ?> ],
<?php
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
		LEFT(creation, 10) AS fecha, COUNT(*) AS total
		FROM price
		WHERE creation > DATE_ADD(NOW(), INTERVAL -20 DAY)
		GROUP BY
		LEFT(creation, 10)
		ORDER BY fecha ASC
		" );
	$rows = $query->result_array();

	$user_types = array( );
	foreach( $rows as $row ) {
		$user_types[$row['fecha']] = $row['total'];
	}

	$pie = array(
		'name' => 'Precios registrados por día',
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
                minRange: 20 * 24 * 3600000 // 20 days
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
                pointStart: Date.UTC(<?= date("Y", strtotime("INTERVAL -20 DAY")) ?>, <?= date("m", strtotime("INTERVAL -20 DAY")) - 1 ?>, <?= date("d", strtotime("INTERVAL -20 DAY")) ?>),
				name: ('<?= ( $pie['name'] ) ?>'),
				data: [
<?php
		foreach( $pie['data'] as $key => $value ) {
				$key = explode('-',$key);
				$key[1]--;
?>
					[Date.UTC(<?= implode(',', $key) ?>), <?= (float)( $value ) ?> ],
<?php
		}
?>
				]
			}]
		});
	});
</script>
	<?php
?>
</div>
        </div>
    </div>
    <?= $this->load->view('admin/footer') ?>
</body>
</html>
