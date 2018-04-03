<?php
namespace Utilities\Process;
use Illuminate\Support\Facades\Facade;
use DB;

class Process
{
	// LLAVE PRIVADA PARA CIFRAR VALORES
	private static function token( )
	{
		return 'b1bc9960742e36ec4a2574144b664ea00d976ba99a8b257b6b9373098d05';
	}

	// REDONDEDA VALORES
	public static function getRedondearDosDecimales($valores)
	{     
		$float_dos_redondeado=round($valores * 100) / 100;
        $number = (string)$float_dos_redondeado;
        $format_number = str_replace('.', ',', $number);
		return $format_number;
	}


	// RENDERIZA ELEMENTO GRUPO IDPUNTO, CEDULA, NOMBRE, NOMBRE PUNTO, CELULAR, CIUDAD, CANAL
	public static function getGrupoA( $elemento )
	{
		$html = '';
		foreach( $elemento AS $c ):

			if( $c -> {'tipo'} == 'radio' )
				$html .= self::getRadio( $c, 'grupo' );
			elseif( $c -> {'tipo'} == 'checkbox' )
				$html .= self::getCheckbox( $c, 'grupo' );
			elseif( $c -> {'tipo'} == 'number' )
				$html .= self::getNumber( $c, 'grupo' );
			elseif( $c -> {'tipo'} == 'idpunto' )
				$html .= self::getIdPunto( $c, 'idpunto' );
			elseif( $c -> {'tipo'} == 'text' )
				$html .= self::getText( $c, 'grupo' );

		endforeach;

		return $html;
	}



	// RENDERIZA ELEMENTO TIEMPO
	public static function getTime( $elemento )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtTime_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$minimo = $elemento -> opciones[0] -> minimo;
		$maximo = $elemento -> opciones[1] -> maximo;
		$html = '';		

		$html .= '<div class="form-group slider" '.$requerido.' '.$peso.' >';
			$html .= self::getLabel( $id, $elemento -> titulo, $elemento -> requerido, $ayuda, $descripcion );
			$html .= sprintf( '<input type="range" name="%s" list="%s" value="%d" min="%d" step="10" max="%d" attr-type="time" class="time">', $id, $id, $minimo, $minimo, $maximo );
			$html .= '<output>'.$minimo.'</output>';
			$html .= '';
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO SLIDER
	public static function getSlider( $elemento )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtSlide_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$minimo = $elemento -> opciones[0] -> minimo;
		$maximo = $elemento -> opciones[1] -> maximo;
		$aspecto = ( isset($elemento -> aspecto) ) ? 'attr-aspect = "'.$elemento -> aspecto.'"' : 'attr-aspect = ""';
		$html = '';		

		$html .= '<div class="form-group slider" '.$requerido.' '.$peso.' '.$aspecto.' >';
			$html .= self::getLabel( $id, $elemento -> titulo, $elemento -> requerido, $ayuda, $descripcion );
			$html .= sprintf( '<input type="range" name="%s" list="%s" value="%d" min="%d" max="%d" attr-type="range">', $id, $id, $minimo, $minimo, $maximo );
			$html .= '<output>'.$minimo.'</output>';
			$html .= '';
		$html .= '</div>';

		return $html;
	}
	
	// RENDERIZA ELEMENTO TEXTO
	public static function getText( $elemento, $grupo = '' )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtText_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $requerido, $ayuda, $descripcion );
			$html .= sprintf( '<input type="text" name="%s" class="form-control '.$grupo.'" attr-type="text" placeholder="%s">', $id, $elemento -> titulo );
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO TEXTAREA
	public static function getTextArea( $elemento )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtComment_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $requerido, $ayuda, $descripcion );
			$html .= sprintf( '<textarea name="%s" class="form-control" attr-type="textarea"></textarea>', $id );
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO CHECKBOX
	public static function getCheckbox( $elemento, $grupo = '' )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtCheck_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$aspecto = ( isset($elemento -> aspecto) ) ? 'attr-aspect = "'.$elemento -> aspecto.'"' : 'attr-aspect = ""';
		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' '.$aspecto.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $elemento -> requerido, $ayuda, $descripcion );

			$html .= '<div class="w_choise">';
				for( $i = 0; $i < count($elemento -> opciones); $i++):
					$html .= '<div class="checkbox">';
						$html .= '<label>';
							$html .= sprintf( '<input type="checkbox" name="%s" value="%s" attr-str="%s" attr-type="checkbox" class="'.$grupo.'" ><span>%s</span>', $id, $elemento -> opciones[$i] -> valor, $elemento -> opciones[$i] -> titulo, $elemento -> opciones[$i] -> titulo );
						$html .= '</label>';
					$html .= '</div>';
				endfor;
			$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO RADIO
	public static function getRadio( $elemento, $grupo = '' )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtRadio_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$aspecto = ( isset($elemento -> aspecto) ) ? 'attr-aspect = "'.$elemento -> aspecto.'"' : 'attr-aspect = ""';
		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' '.$aspecto.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $elemento -> requerido, $ayuda, $descripcion );
			
			$html .= '<div class="w_choise">';
				for( $i = 0; $i < count($elemento -> opciones); $i++):
					$html .= '<div class="item">';
						$html .= '<label>';
							$html .= sprintf( '<input type="radio" name="%s" value="%s" attr-str="%s" attr-type="radio" class="'.$grupo.'" ><span>%s</span>', $id, $elemento -> opciones[$i] -> valor, $elemento -> opciones[$i] -> titulo, $elemento -> opciones[$i] -> titulo );
						$html .= '</label>';
					$html .= '</div>';
				endfor;
			$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO NUMERO
	public static function getNumber( $elemento, $grupo = '' )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtNumber_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$minimo = ( $elemento -> opciones[0] -> minimo ) ? $elemento -> opciones[0] -> minimo : 0;
		$maximo = ( $elemento -> opciones[1] -> maximo ) ? $elemento -> opciones[1] -> maximo : 0;
		$placeholder = trans('app.placeholdervaloresnumericos');
		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $requerido, $ayuda, $descripcion );
	    	$html .= sprintf( '<input type="number" name="%s" class="form-control '.$grupo.'" min="'.$minimo.'" max="'.$maximo.'" placeholder="%s"  attr-type="number">', $id, $placeholder );
	  	$html .= '</div>';

	  	return $html;
	}


	// RENDERIZA ELEMENTO CEDULA DB
	public static function getIdPunto( $elemento, $grupo = '' )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtIdPunto_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$multiple = ( $elemento -> multiple ) ? 'attr-multiple="multiple"' : '';
		$placeholder = trans('app.placeholderidpunto');
		if( $requerido )
			$placeholder = trans('app.placeholderidpunto');

		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $requerido, $ayuda, $descripcion );
			$html .= '<div class="w_users"></div>';
			$html .= sprintf( '<input type="number" name="%s" class="form-control '.$grupo.'" '.$multiple.' placeholder="%s"  attr-type="idpunto">', $id, $placeholder );
			$html .= '<div class="w_autocomplete"></div>';
		$html .= '</div>';

		return $html;
	}



	// RENDERIZA ELEMENTO CEDULA DB
	public static function getCedula( $elemento )
	{
		$requerido = ( $elemento -> requerido ) ? 'attr-required="required"' : '';
		$posicion = $elemento -> posicion;
		$descripcion = $elemento -> descripcion;
		$id = 'txtDI_'.$posicion;
		$ayuda = $elemento -> ayuda;
		$peso = ( $elemento -> peso ) ? 'attr-weight = "'.$elemento -> peso.'"' : 'attr-weight = 0';
		$multiple = ( $elemento -> multiple ) ? 'attr-multiple="multiple"' : '';
		$placeholder = trans('app.placeholdercedula');
		if( $requerido )
			$placeholder = trans('app.placeholdercedulam');

		$html = '';

		$html .= '<div class="form-group" '.$requerido.' '.$peso.' >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id, $elemento -> titulo, $requerido, $ayuda, $descripcion );
			$html .= '<div class="w_users"></div>';
			$html .= sprintf( '<input type="number" name="%s" class="form-control cedula" '.$multiple.' placeholder="%s"  attr-type="di">', $id, $placeholder );
			$html .= '<div class="w_autocomplete"></div>';
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO CALENDARIO
	public static function getCalendario( )
	{
		$requerido = 'attr-required="required"';
		$id = 'txtCalendar_1';
		$html = '';
		
		$html .= '<div class="form-group" '.$requerido.' attr-weight="0" >';
			$html .= '<div class="w_alert"></div>';
			$html .= self::getLabel( $id,  trans('app.fechaactividad'), $requerido, '' );
			$html .= sprintf( '<input type="text" name="%s" class="form-control calendar" attr-type="calendar" onpaste="return false;">', $id );
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO LABEL
	public static function getLabel( $id = 0, $titulo = '', $requerido = false, $ayuda = '', $descripcion = '' )
	{
		$html = '';
		$html .= '<header class="w_question" >';

			if( $requerido && $ayuda == '' )
				$html .= sprintf('<label for="%s">%s</label> <span>*</span>', $id, $titulo);
			else if( $requerido && $ayuda != '' )
				$html .= sprintf('<span class="w_help" data-toggle="modal" data-target="#modal" attr-help="%s"><i class="fa fa-commenting" aria-hidden="true"></i></span> <label for="%s">%s</label> <span>*</span>', $ayuda, $id, $titulo);
			else if( !$requerido && $ayuda != '' )
				$html .= sprintf('<span class="w_help" data-toggle="modal" data-target="#modal" attr-help="%s"><i class="fa fa-commenting" aria-hidden="true"></i></span> <label for="%s">%s</label> ', $ayuda, $id, $titulo);
			else
				$html .= sprintf('<label for="%s">%s</label>', $id, $titulo);

			if( $descripcion != '' )
				$html .= '<p>'.$descripcion.'</p>';

		$html .= '</header>';
		return $html;
	}

	// RENDERIZA ELEMENTO INSTRUCCIONES
	public static function getTitulo( $elemento )
	{
		$html = '';

		$html .= '<div class="form-group-t">';
			if( $elemento -> titulo != '' )
				$html .= '<h4>'.$elemento -> titulo.'</h4>';
			if( $elemento -> descripcion != '' )
				$html .= '<p>'.$elemento -> descripcion.'</p>';
		$html .= '</div>';

		return $html;
	}

	// RENDERIZA ELEMENTO INSTRUCCIONES
	public static function getInstructions( $elemento )
	{
		$html = '';

		$html .= '<div class="form-group">';
			$html .= '<p>'.$elemento -> descripcion.'</p>';
		$html .= '</div>';

		return $html;
	}

	// GENERA UNA CADENA ALEATORIA
	public static function getCadenaAleatoria( $str = '', $inicio = 5, $fin = 60 )
	{
		$patron = array("/","+","=");
		$str = Time().$str;
		return substr( str_replace( $patron, '', hash( "sha512", $str ) ), $inicio, $fin );
	}

	// DESCIFRAR
	public static function setDescifrar( $str = '' )
	{
		$data = '';
		if( $str != '' ):
			$data = str_replace( '___', '/', $str );
			$data = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5( self::token() ), base64_decode($data), MCRYPT_MODE_CBC, md5(md5( self::token() ))), "\0");
		endif;
		return $data;
	}

	// CIFRAR
	public static function setCifrar( $str = '' )
	{
		$data = '';
		if( $str != '' ):
			$data = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5( self::token() ), $str, MCRYPT_MODE_CBC, md5(md5( self::token() ))));
			$data = str_replace( '/', '___', $data );
		endif;
		return $data;
	}
	# ================================================================================================ END, ENCRYPT ========= #
}
?>