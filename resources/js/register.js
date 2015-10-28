($ || jQuery)(function(){
	var $ = ($ || jQuery);

	if( $("#formulario").length == 0 )
		return;

	$("#formulario").data("validator").settings.submitHandler = function (form) {

		var newUser = {};
		newUser['nombres'] = $('#firstname').val();
		newUser['apellidos'] = $('#lastname').val();
		newUser['anio'] = $('#year').val();
		newUser['mes'] = $('#month').val();
		newUser['dia'] = $('#day').val();
		newUser['genero'] = ( $('#male').is(":checked") ? 'M' : 'F' );
		newUser['email'] = $('#email').val();
		newUser['doc_type'] = $('#doc_type').val();
		newUser['doc_num'] = $('#doc_num').val();
		newUser['telefono'] = $('#phone').val();
		newUser['ciudad'] = $('#city').val();
		newUser['link_facebook'] = $('.input_social:eq(0)').val();
		newUser['link_twitter'] = $('.input_social:eq(1)').val();
		newUser['link_instagram'] = $('.input_social:eq(2)').val();
		newUser['certificados_tiene'] = ( $('#crt_si').is(":checked") ? 1 : 0 );
		newUser['certificados'] = $('#crt_cual').val();
		newUser['entrenamientos'] = $('#training_type').val();
		newUser['patrocinios_tiene'] = ( $('#sponsored_si').is(":checked") ? 1 : 0 );
		newUser['patrocinios'] = $('#sponsored_cual').val();
		newUser['parques'] = $('#places').val();
		newUser['terminos_acepta'] = ( $('#agree').is(":checked") ? 1 : 0 );
		newUser['autoriza_datos'] = ( $('#auth').is(":checked") ? 1 : 0 );

		$.ajax({
			type: "POST",
			url: "services/register",
			data: newUser,
			success: function( data ) {
				if( data.error ) {
					var field = data.error.scope;
					var map = {
						'anio': 'year',
						'dia': 'day',
						'telefono': 'phone',
						'ciudad': 'city',
						'terminos_acepta': 'agree',
					};
					if( map[field] )
						field = map[field];

					var errors = {};
					errors[field] = data.error.msg;

					$("#formulario").data("validator").showErrors(errors);
					$("#formulario").data("validator").focusInvalid();
				}
				else {
					$("#formulario")[0].reset();
					ga('send','event','Registro','enviar','Registro_completo');
					show_success();
				}
			},
			error: function(){
				show_fail();
			},
			dataType: 'json'
		});
		return false;
	};

});