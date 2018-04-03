/* ======================================================================= ERRORES LLAMADO AJAX ====== */
function getErrors( jqXHR, textStatus, errorThrown )
{
	console.log( jqXHR );
	console.log( textStatus );
	console.log( errorThrown );
}
/* ======================================================================= END, ERRORES LLAMADO AJAX ====== */



/* ADICIONA LOS INPUTS PARA CONFIGURAR CADA ELEMENTO DEL FORMULARIO */
function getElementosConfiguracionFormulario( tipo, identificador )
{
	var multiple = '';
	var html = '';
		html += '<div class="w_field_config">';
			html += '<div><label>Título</label><input type="text" name="txtTitulo"></div>';

			if( tipo == 'titulo' )
				html += '<div><label>Descripción</label><input type="text" name="txtDescripcion"></div>';
			else if( tipo == 'generico' )
			{
				html += '<div><label>Requerido<input type="checkbox" name="txtRequerido"></label></div>';
				html += '<div><label>Ayuda</label><textarea name="txtAyuda" rows="4"></textarea></div>';
			}
			else if( tipo == 'selector' )
			{
				$('#'+identificador+' select option').each(function( e ){
					multiple += '<div><input type="text" class="options" name="txtOpcion" value="'+$(this).val()+'"><span><i class="fa fa-minus-square" aria-hidden="true"></i></span></div>';
				});

				html += '<div><label>Requerido<input type="checkbox" name="txtRequerido"></label></div>';
				html += '<div class="w_plus"><i class="fa fa-plus-square" aria-hidden="true"></i></div>';
				html += '<div class="w_options selector">';
					html += multiple;
				html += '</div>';
				html += '<div><label>Ayuda</label><textarea name="txtAyuda" rows="4"></textarea></div>';
			}
			else if( tipo == 'radio' || tipo == 'checkbox' )
			{
				$('#'+identificador+' input').each(function( e ){
					multiple += '<div>';
						multiple += '<input type="text" class="options" name="txtOpcion" value="'+$(this).val()+'">';
						multiple += '<input type="number" class="options" min="0" name="txtValor" value="0">';
						multiple += '<span><i class="fa fa-minus-square" aria-hidden="true"></i></span>';
					multiple += '</div>';
				});
				html += '<div><label>Requerido<input type="checkbox" name="txtRequerido"></label></div>';
				html += '<div class="w_plus"><i class="fa fa-plus-square" aria-hidden="true"></i></div>';
				html += '<div class="w_options '+tipo+'">';
					html += multiple;
				html += '</div>';
				html += '<div><label>Ayuda</label><textarea name="txtAyuda" rows="4"></textarea></div>';
			}
			else if( tipo == 'slider' )
			{
				html += '<div><label>Valor mínimo</label><input type="number" min="0" name="txtMinimo"></div>';
				html += '<div><label>Valor máximo</label><input type="number" min="0" name="txtMaximo"></div>';
				html += '<div><label>Ayuda</label><textarea name="txtAyuda" rows="4"></textarea></div>';
			}			

			html += '<div><span class="btn btn-primary btnGuardarCampo">Guardar</span></div>';
		html += '</div>';


	$('.w_panel').hide();
	$('.configuration').html( html ).show();

	$('[name=txtTitulo]').on('input',function(e){
		e.preventDefault();
		var valor = $(this).val();
		if( valor != '' )
			$('#'+identificador).find('.txtTitle').html(valor);
		else
			$('#'+identificador).find('.txtTitle').html( $('#'+identificador).attr('data-title') );
	});

	if( $('.slider').length > 0 )
	{
		$('#'+identificador+' .slider').slider({ min : 1, max : 4 });
	}

	if( $('.w_options').length > 0 )
	{
		$('.w_plus').click(function(){
			var html ='';
				html += '<div>';
					html += '<input type="text" class="options" name="txtOpcion" value="">';
					html += '<input type="number" min="0" class="options" name="txtValor" value="0">';
					html += '<span><i class="fa fa-minus-square" aria-hidden="true"></i></span>';
				html += '</div>';
			$('.w_options').append( html );
		})
		$('.w_options').on('click', 'span', function(){
			$(this).parent().remove();
		})
	}

	if( $('[name=txtAyuda]').length > 0 )
	{
		$('[name=txtAyuda]').on('input',function(e){
			e.preventDefault();
			var valor = $(this).val();
			if( valor != '' )
			{
				$('#'+identificador).find('.w_help span').html(valor);
				$('#'+identificador).find('.w_help').show();
			}
			else
			{
				$('#'+identificador).find('.w_help span').html('');
				$('#'+identificador).find('.w_help').hide();
			}
		});
	}

	if( $('[name=txtRequerido]').length > 0 )
	{
		$('[name=txtRequerido]').click(function(){
			if( $(this).is(':checked') )
			{
				$('#'+identificador).find('label').append( '<span class="required"> *</span>' );
				$('#'+identificador).attr('attr-required', 'requerido');
			}
			else
			{
				$('#'+identificador).find('.required').remove();
				$('#'+identificador).removeAttr('attr-required', 'requerido');
			}
		})
	}

	if( $('[name=txtDescripcion]').length > 0 )
	{
		$('[name=txtDescripcion]').on('input',function(e){
			e.preventDefault();
			var valor = $(this).val();
			if( valor != '' )
				$('#'+identificador).find('.description').html(valor);
			else
				$('#'+identificador).find('.description').html( $('#'+identificador).attr('data-description') );
		});
	}

	$('.btnGuardarCampo').click(function(){
		if( $('.selector').length > 0 )
		{
			$('#'+identificador+' select option').remove();
			$('.w_options input[type=text]').each(function(){
				if( $(this).val() != '' )
					$('#'+identificador+' select').append('<option value="'+$(this).val()+'">'+$(this).val()+'</option>');
			})
			$('#'+identificador+' select option:first-child').attr("selected", true);

		}
		else if( $('.radio').length > 0 )
		{
			$('#'+identificador+' .w_choices').find('div').remove();
			$('.w_options input[type=text]').each(function(){
				var llave = $(this).val();
				var valor = $(this).parent().find('input[type=number]').val();
				if( llave != '' && valor != '' )
					$('#'+identificador+' .w_choices').append( '<div class="choice"><label class="choice-label"><input type="radio" value="'+valor+'" disabled><span>'+llave+'</span></label></div>' );
			})
			$('#'+identificador+' .w_choices [type=radio]:first').attr("checked", true);
		}
		else if( $('.checkbox').length > 0 )
		{
			$('#'+identificador+' .w_choices').find('div').remove();
			$('.w_options input[type=text]').each(function(){
				var llave = $(this).val();
				var valor = $(this).parent().find('input[type=number]').val();
				if( llave != '' && valor != '' )
					$('#'+identificador+' .w_choices').append( '<div class="choice"><label class="choice-label"><input type="radio" value="'+valor+'" disabled><span>'+llave+'</span></label></div>' );
			})
			$('#'+identificador+' .w_choices [type=checkbox]:first').attr("checked", true);
		}
		else if( $('.slider').length > 0 )
		{
			$('#'+identificador).attr("min-value", $('[name=txtMinimo]').val());
			$('#'+identificador).attr("max-value", $('[name=txtMaximo]').val());			
		}

		$('.w_panel').hide();
		$('.configuration').html( '' );
		$('.element').show();
	})
}


var contandorElementoFormulario = 1;

/* ADICIONA ELEMENTOS AL FORMULARIO */
function getField( e )
{
	$('.w_device_creen ul').append( e );
	//$('.w_device_creen ul').sortable({ stop:function(){} }).disableSelection();

	$( '.w_device_creen ul' ).sortable();
	$( '.w_device_creen ul' ).disableSelection();
	$( '.w_device_creen ul' ).bind( "sortstop", function(event, ui) {
		$('.w_device_creen ul').listview().listview('refresh');
	});

	$('.form-element').last().attr('id','element_'+contandorElementoFormulario);
	var tipoFormulario = $('#element_'+contandorElementoFormulario).attr('data-type');

	if( tipoFormulario == 'element-titulo' )
		getElementosConfiguracionFormulario('titulo', 'element_'+contandorElementoFormulario);
	if( tipoFormulario == 'element-calendario' || tipoFormulario == 'element-email' )
		getElementosConfiguracionFormulario('generico', 'element_'+contandorElementoFormulario);
	if( tipoFormulario == 'element-selector' )
		getElementosConfiguracionFormulario( 'selector', 'element_'+contandorElementoFormulario );
	if( tipoFormulario == 'element-radio' )
		getElementosConfiguracionFormulario( 'radio', 'element_'+contandorElementoFormulario );
	if( tipoFormulario == 'element-checkbox' )
		getElementosConfiguracionFormulario( 'checkbox', 'element_'+contandorElementoFormulario );
	if( tipoFormulario == 'element-slider' )
		getElementosConfiguracionFormulario( 'slider', 'element_'+contandorElementoFormulario );
	
	contandorElementoFormulario ++;
}




$(document).bind('pageinit', function() {
	$('.w_panel').first().show();
	$('.w_tabs li').click(function(){
		$('.w_panel').hide();
		$('.configuration').html( '' );
		$( '.'+$(this).attr('attr-type') ).show();
	})

	$('.btnNuevoElemento').click(function(){
		$.ajax({
			url : '/plantillas/'+$(this).attr('data-type'),
			type : 'get', 
			success : getField
		});		
	})

	$('.btnRenderizar').click(function(){
		if( $('.form-element').length > 0 )
		{
			var formData = {};
				formData['elemento'] = Array();
			$('.w_device_creen ul li').each(function( i ){
				$('.w_device_creen ul li').find('.required').remove();
				var elemento = {
									'ayuda' : ( $(this).find('.w_help span').text() ) ? $(this).find('.w_help span').text() : '' , 
									'descripcion': ( $(this).find('.description').text() ) ? $(this).find('.description').text() : '', // solo aplica para los campos tipo títulos
									'posicion': i+1,
									'requerido': ( $(this).attr('attr-required') != null && $(this).attr('attr-required') != false ) ? true : false,
									'tipo': $(this).attr('data-type'),
									'titulo' : $(this).find('.label-title').text()
							   }

				if( $(this).attr('data-type') == 'element-selector' || $(this).attr('data-type') == 'element-radio' || $(this).attr('data-type') == 'element-checkbox' || $(this).attr('data-type') == 'element-slider' )
				{
					var opciones = [];
					if( $(this).attr('data-type') == 'element-selector' )
					{
						$(this).find('.w_choices').children('option').each(function(index){
							var opcion = {
											'titulo': $(this).val(),
											'valor': $(this).val(),
											'activo': ( $(this).is(':selected') ) ? true : false,
										 }

							opciones.push(opcion);
							elemento['opciones'] = opciones;
						});
					}
					else if( $(this).attr('data-type') == 'element-slider' )
					{
						var opcion = {
										'valorminimo': $(this).attr('min-value'),
										'valormaximo': $(this).attr('max-value'),
									 }

						opciones.push(opcion);
						elemento['opciones'] = opciones;
					}
					else
					{
						$(this).find('.w_choices').children('.choice').each(function(index){
							var opcion = {
											'titulo': $(this).find('.choice-label').text(),
											'valor': $(this).find('input').val(), 
											'activo': ( $(this).find('input').is(':checked') ) ? true : false,
										 }

							opciones.push(opcion);
							elemento['opciones'] = opciones;
						});
					}
				}
				formData['elemento'].push( elemento );
			})

			$.ajax({
				url : '/render',
				type : 'post', 
				headers : { 'X-CSRF-TOKEN': $('meta[name="prfill"]').attr('content') },
				data : { a : formData }, 
				success: function ( e )
				{
					$('.w_device_creen').html( e );
				}
			});

		}
		else
			alert("No se ha adicionado elementos al formulario");
	})
});





































































/*
var fn = [
			[ 'element-titulo', 'getTitulo' ], 
			[ 'element-calendario', 'getCalendario' ], 
			[ 'element-email', 'getEmail' ], 
			[ 'element-selector', 'getSelector' ], 
			[ 'element-radio', 'getRadio' ]
		 ];


$('.w_newElement').click(function(){
	var elemento = $(this).attr('data-type');
	var status = true;
	var call = '';
	
	for( var i = 0; i < fn.length && status; i++ )
	{
		if( fn[i][0] == elemento )
		{
			status = false;
			call = fn[i][1];
		}
	}

	$('.w_left ul').append( window[call] );
	
	$('.w_left ul').sortable({
		stop:function(){}
	}).disableSelection();
})
*/



/*
$('#formBuilder').formBuilder({
	load_url: '/example.json',
	save_url: '/save',
	onSaveForm: function( data ){

		$.ajax({
			url : '/render',
			type : 'post', 
			headers : { 'X-CSRF-TOKEN': $('meta[name="prfill"]').attr('content') },
			data : { data: data }, 
			success: function( e )
			{
				console.log( e );
				$('#form-col').html( e );
				validate();
			},
			error: getErrors
		});

	},
});
*/

/*
$.ajax({
	url : 'cargaformulario',
	type : 'post', 
	headers : { 'X-CSRF-TOKEN': $('meta[name="prfill"]').attr('content') },
	success: function( e )
	{
		$('.listacedula').html( e );

		$('.listacedula select').change(function(){

			var token = $(this).find('option:checked').val();
			var data = $(this).find('option:checked').text();
			var html = '';

			html += '<li token="'+token+'" class="wparticipante" >';
				html += '<span class="left">'+data+'</span>';
				html += '<span class="right" token="{{ $c -> id }}">';

					html += '<ul class="clearul">';
						html += '<li class="delete" >X</li>';
					html += '</ul>';
					
				html += '</span>';
			html += '</li>';

			$('.asesores').append( html );
			$('.listacedula').html('');
			$('#txtParticipante').val('');

		});

	},
	error: getErrors
})
*/



/*
if( $('.listacedula').length > 0 )
{
	$('#txtParticipante').keyup(function( e ){

		if (/\D/g.test(this.value))
			this.value = this.value.replace(/\D/g, '');
		else if( $(this).val().length > 4 )
		{
			$.ajax({
				url : 'consultaparticipante',
				type : 'post', 
				headers : { 'X-CSRF-TOKEN': $('meta[name="prfill"]').attr('content') },
				data:{ a : $(this).val() }, 
				success: function( e )
				{
					$('.listacedula').html( e );

					$('.listacedula select').change(function(){

						var token = $(this).find('option:checked').val();
						var data = $(this).find('option:checked').text();
						var html = '';

						html += '<li token="'+token+'" class="wparticipante" >';
							html += '<span class="left">'+data+'</span>';
							html += '<span class="right" token="{{ $c -> id }}">';

								html += '<ul class="clearul">';
									html += '<li class="delete" >X</li>';
								html += '</ul>';
								
							html += '</span>';
						html += '</li>';

						$('.asesores').append( html );
						$('.listacedula').html('');
						$('#txtParticipante').val('');

					});

				},
				error: getErrors
			})
		}
		else
			$('.listacedulas').html( '' );
	})


	$('.save').click(function(){
		var cantidadtemas = 0;
		$('.tema').each(function(){
			if( $(this).is(":checked") )
				cantidadtemas ++;
		})

		if( cantidadtemas == 0 )
			alert( 'No ha seleccionado un tema' )
		else if( $('.wparticipante').length == 0 )
			alert( 'No ha ingresado ninguna cédula' )
		else
		{
			var temas = [];
			var participantes = [];

			$('.tema').each(function(){
				if( $(this).is(":checked") )
					temas.push( $(this).val() );
			});


			var statusparticipante = true;

			$('.wparticipante').each(function(){
				var token = $(this).attr('token');

				participantes.push({ 'token': token });
			});

		}

		console.log( temas )
		console.log( participantes )

	})
}
*/