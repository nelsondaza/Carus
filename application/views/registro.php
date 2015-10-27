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
		<div class="titulo t3">COMPLETA TUS DATOS</div>
		<div class="subtitulo t2">(Todos los campos son requeridos)</div>
	</div>
</div>

<div class="formulario">
	<div class="container">
		<form method="post" id="formRegister" class="formRegister" novalidate="novalidate">
			<label class="t2 gray">NOMBRES</label>
			<input type="text" name="nombres" id="nombres" value="<?= $user['firstname'] ?>" />
			<label class="t2 gray">APELLIDO</label>
			<input type="text" name="apellidos" id="apellidos" value="<?= $user['lastname'] ?>" />
<?
	if( !$user['provider'] ) {
?>
		<label class="t2 gray">CONTRASEÑA</label>
		<input type="password" name="pass" id="pass" value=""/>
		<label class="t2 gray">VERIFICAR CONTRASEÑA</label>
		<input type="password" name="passto" id="passto" value=""/>
<?
	}
	else {
		$code = md5($user['provider']);
?>
		<input type="hidden" name="pass" id="pass" value="<?= $code ?>"/>
		<input type="hidden" name="passto" id="passto" value="<?= $code ?>"/>
<?
	}
?>
			<label class="t2 gray">E-MAIL</label>
			<input type="text" name="email" id="email" value="<?= $user['email'] ?>" <?= ( isset( $email_error ) && $email_error ? 'class="error"' : '' ) ?> />
<?
	if( isset( $email_error ) && $email_error ) {
?>
			<label for="email" class="error"><?=  $email_error ?></label>
<?
	}
?>
			<label class="t2 gray">TELÉFONO DE CONTACTO</label>
			<input type="text" name="telefono" id="telefono" value="<?= $user['telefono'] ?>" />
			<label class="t2 gray">GÉNERO</label>
			<input type="hidden" name="genero_def" id="genero_def" value="f"/>
			<select class="genero" name="genero" id="genero" >
				<option value="f" <?= $user['gender'] == 'f' ? 'selected' : '' ?>>Femenino</option>
				<option value="m" <?= $user['gender'] != 'f' ? 'selected' : '' ?>>Masculino</option>
			</select>
			<label class="t2 gray">CIUDAD</label>
			<select class="ciudad" name="ciudad" id="ciudad">
				<option>BOGOTÁ</option>
				<option>BUCARAMANGA</option>
				<option>CALI</option>
				<option>MEDELLÍN</option>
			</select>
			<label class="t2 gray">FECHA DE NACIMIENTO</label>
			<div class="t2 gray">
				<select class="dia" name="dia" id="dia" >
<?
	for( $c = 1; $c < 32; $c ++ ) {
?>
					<option value="<?= $c ?>"><?= $c ?></option>
<?
	}
?>
				</select>
				<select class="mes" name="mes" id="mes">
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
					<option value="03">Marzo</option>
					<option value="04">Abril</option>
					<option value="05">Mayo</option>
					<option value="06">Junio</option>
					<option value="07">Julio</option>
					<option value="08">Agosto</option>
					<option value="09">Septiembre</option>
					<option value="10">Octubre</option>
					<option value="11">Noviembre</option>
					<option value="12">Diciembre</option>
				</select>
				<select class="anio" name="anio" id="anio">
<?
	for( $c = date('Y') - 12; $c > date('Y') - 60; $c -- ) {
?>
					<option value="<?= $c ?>"><?= $c ?></option>
<?
	}
?>
				</select>
			</div>
			<div class="t2 gray"><input type="checkbox" name="tyc" value="tyc" checked /> Acepto los términos y condiciones</div>
			<div class="t2 gray"><input type="checkbox" name="habeasdata" value="habeasdata" checked /><p>Autorizo a Reebok para utilizar mis datos personales (incluida mi dirección de e-mail) con fines de marketing, publicidad y estudios de opinión, incluyendo el envío de información sobre productos de Reebok y otros productos del Grupo Adidas.</p></div>
			<input class="loginButton" type="submit" value="Registrarme">
		</form>
	</div>
</div>

<?= $this->load->view( 'common/footer' ) ?>
</body>
</html>