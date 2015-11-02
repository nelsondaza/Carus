<?php

	/*
	$googleURL = 'https://accounts.google.com/o/oauth2/auth?scope=' .
	       rawurlencode( 'openid email') . '&amp;' .
	       'state=' . $this->google_lib->getState() . '&amp;' .
	       'redirect_uri=' . $this->google_lib->getRedirectURI() . '&amp;'.
	       'response_type=code&amp;' .
	       'client_id=' . $this->google_lib->getClientID() . '&amp;' .
	       'access_type=offline';
*/
?>
<section class="body-content" style="background-image: url('<?= base_url( )?>resources/img/backs/<?= rand(1,6) ?>.jpg')">

	<div class="ui middle aligned centered aligned grid">
		<div class="ten wide column mobile eight wide tablet six wide computer column">
			<h1><a href="<?= base_url() ?>" aria-label="Carus">Carus</a></h1>
			<form id="login-form" class="ui small form" autocomplete="off" action="" method="post">
				<div class="field">
					<div class="ui left icon input">
						<i class="at icon"></i>
						<input type="email" name="email" placeholder="E-mail" autocomplete="off">
					</div>
				</div>
				<div class="field">
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="password" placeholder="Clave" autocomplete="off">
					</div>
				</div>
				<input type="submit" class="ui fluid large teal submit button" value="Ingresar" />
				<div class="ui error message"></div>
			</form>
			<form id="register-form" class="ui small form hidden" autocomplete="off" action="" method="post">
				<div class="field">
					<div class="ui left icon input">
						<i class="user icon"></i>
						<input type="text" name="name" placeholder="Nombre" autocomplete="off">
					</div>
				</div>
				<div class="field">
					<div class="ui left icon input">
						<i class="gender icon"></i>
						<select class="ui dropdown" name="gender">
							<option value="F"> ♀ Femenino</option>
							<option value="M"> ♂ Masculino</option>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="ui left icon input">
						<i class="at icon"></i>
						<input type="email" name="email" placeholder="E-mail" autocomplete="off">
					</div>
				</div>
				<div class="field">
					<div class="ui left icon input">
						<i class="lock icon"></i>
						<input type="password" name="password" placeholder="Clave" autocomplete="off">
					</div>
				</div>
				<div class="field">
					<div class="ui segment">
						<div class="ui checked checkbox">
							<input type="checkbox" name="terms" id="terms" value="1">
							<label for="terms">Acepto los término y condiciones de uso.</label>
						</div>
					</div>
				</div>
				<input type="submit" class="ui fluid large teal submit button" value="Registrarme" />
				<div class="ui error message"></div>
			</form>
		</div>
	</div>

</section>
