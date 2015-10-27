<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?= $this->load->view( 'common/head', array( 'title' => 'Registro' ) ) ?>
</head>
<body>
<?= $this->load->view( 'common/menu', array('action' => 'registro') ) ?>
<?= $this->load->view( 'common/header' ) ?>

<div class="barWhite bgWhite">
	<div class="container">
		<div class="titulo t3">¡BIENVENIDA!</div>
	</div>
</div>

<div class="formulario done">
	<div class="container">
		<form method="get" class="formRegister" action="<?= base_url( ) ?>clases">
			<h3>YA ESTÁS REGISTRADA</h3>
			<br/>
			<p>Ahora debes seleccionar la rutina y la clase a la que deseas asistir. <br/>¡Prepárate para una clase de cardio increíble!</p>
			<br/>
			<a class="loginButton" href="<?= base_url( ) ?>clases">Seleccionar clase</a>
		</form>
	</div>
</div>

<?= $this->load->view( 'common/footer' ) ?>
</body>
</html>