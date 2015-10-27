<?php
/**
 * Created by PhpStorm.
 * User: nelson.daza
 * Date: 30/01/2015
 * Time: 11:37 AM
 */

	$googleURL = 'https://accounts.google.com/o/oauth2/auth?scope=' .
	       rawurlencode( 'openid email') . '&amp;' .
	       'state=' . $this->google_lib->getState() . '&amp;' .
	       'redirect_uri=' . $this->google_lib->getRedirectURI() . '&amp;'.
	       'response_type=code&amp;' .
	       'client_id=' . $this->google_lib->getClientID() . '&amp;' .
	       'access_type=offline';

?>
	<div class="fold <?= ( $this->authentication->is_signed_in( ) ? 'bar' : '' ) ?>">
		<div class="container">
			<div class="logo">
				<a href="<?= base_url() ?>">Reebok</a>
			</div>
			<div class="copy">
				<h1>Vive la experiencia</h1>
				<h2>REEBOK CARDIO ULTRA</h2>
				<p>Regístrate y asiste a una increíble clase gratuita de cardio basada en los programas de Les Mills. Además conoce los nuevos Cardio Ultra, el calzado con el cual dominarás en todas tus clases.</p>
			</div>
			<div class="boxFold">
				<div class="loginGeneral" <?= ( !$this->authentication->is_signed_in( ) ? 'style="display: block"' : '' ) ?>>
					<div class="topBox">
						<h1>REGÍSTRATE Y RESERVA TU CLASE</h1>
						<h2>Los cupos son limitados, asegura el tuyo</h2>
						<div class="separator"></div>
						<div class="loginSocial">
							<div class="txt">Ingresa a través de tus redes o con tu e-mail y contraseña.</div>
							<div class="logos">
								<div><a onclick="ga('send','event','Iniciar_sesion','medio','Facebook')" data-icon="g" class="icon fb" href="#"></a></div>
								<div><a onclick="ga('send','event','Iniciar_sesion','medio','Google')" data-icon="l" class="icon gl" href="<?= $googleURL ?>"></a></div>
							</div>
						</div>
						<div class="loginOne">
							<div class="btnRed registrarme"><a onclick="ga('send','event','Iniciar_sesion','medio','Email')" href="<?= base_url( ) ?>registro">Registrarme</a></div>
							<div class="btnGray ingresar"><a onclick="ga('send','event','Iniciar_sesion','Clic','Ingresar')" href="#">Ingresar</a></div>
						</div>
						<div class="loginTwo">
							<form method="post" id="formLogin" class="loginReebok" novalidate="novalidate" autocomplete="off">
								<input type="text" name="userEmail" id="userEmail" value="" placeholder="E-mail" autocomplete="off" />
								<input type="password" name="userPassword" id="userPassword" value="" placeholder="Contraseña" autocomplete="off" />
								<input class="loginButton" type="submit" value="Ingresar" />
								<label id="userEmailError" class="error info" style="display: none;"></label>
								<div class="forgotPassword"><a onclick="ga('send','event','Iniciar_sesion','Clic','Olvidé contraseña')" href="#">Olvidé mi contraseña</a></div>
							</form>
						</div>
					</div>
				</div>
				<div class="userLoggedIn" <?= ( $this->authentication->is_signed_in( ) ? 'style="display: block"' : '' ) ?>>
					<div class="topBox">
						<?= ( isset( $account_details ) ? '<h1>' . htmlentities( ( $account_details->fullname ? $account_details->fullname : $account_details->firstname . ' ' . $account_details->lastname ) ) . '</h1>' : '' ) ?>
						<h2><b>Bienvenido;</b> ya puedes asistir a una increíble clase gratuita de cardio basada en los programas de <br>Les Mills.</h2>
					</div>
				</div>
				<div class="forgetPass">
					<div class="close"><a href="#"></a></div>
					<div class="topBox">
						<h1>OLVIDÉ MI CONTRASEÑA</h1>
						<h2>Escríbenos tu e-mail y te enviaremos la clave.</h2>
						<div class="separator"></div>
						<div class="loginTwo">
							<form method="post" id="formForgetPass" class="loginReebok" novalidate="novalidate">
								<label>E-mail:</label>
								<input type="text" name="userEmailSend" id="userEmailSend" value="" />
								<input class="loginButton" type="submit" value="Enviar contraseña" />
							</form>
						</div>
					</div>
				</div>
				<div class="forgetPassError">
					<div class="topBox">
						<div class="close"><a href="#"></a></div>
						<h1>CORREO NO ENCONTRADO</h1>
						<div class="separator"></div>
						<div class="message">El correo ingresado no aparece en nuestra base de datos. Inscríbete y vuelve a intentarlo.</div>
						<div class="btnRed ingresar"><a href="<?= base_url() ?>registro">Registrarme</a></div>
					</div>
				</div>
				<div class="forgetPassSent">
					<div class="topBox">
						<div class="close"><a href="#"></a></div>
						<h1>CONTRASEÑA ENVIADA</h1>
						<div class="separator"></div>
						<div class="message">Enviamos a tu e-mail la contraseña para que puedas ingresar.</div>
						<div class="btnRed ingresar"><a href="#">Ingresar</a></div>
					</div>
				</div>
				<div class="bottomBox">
					<h1><span data-icon="k" class="icon"></span> <span>PRÓXIMAS CLASES</span></h1>
					<?
						foreach( $next_classes as $hubClass ) {
							$time = strtotime( $hubClass['start_date'] );
							?>
							<div class="box">
								<div class="city"><?= $hubClass['city'] ?></div>
								<div class="fecha"><?= date( "d", $time ) . ', ' . strtoupper( lang( 'cal_' . strtolower( date("F", $time ) ) ) ) . ' - ' . sprintf("%02d", (int)$hubClass['quota_available']) . ' CUPOS' ?></div>
							</div>
						<?
						}
					?>
					<div class="btnRed verCalendario"><a onclick="ga('send','event','Iniciar_sesion','Programacion','ver-toda-la programacion')" href="<?= base_url( ) ?>clases">Ver todo el calendario</a></div>
				</div>
			</div>
		</div>
		<div class="separatorFold"></div>
	</div>

