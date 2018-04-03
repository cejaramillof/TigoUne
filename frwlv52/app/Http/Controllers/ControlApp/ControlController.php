<?php

namespace Control\Http\Controllers\ControlApp;

use Illuminate\Http\Request;
use Control\Http\Requests;
use Control\Http\Controllers\Controller;
use Auth;
use DB;

class ControlController extends Controller
{

	############################################################################# NUEVO ASESOR
	public static function getFormularioCargaUsuarios( Request $solicitud )
	{
		if( $solicitud -> ajax() ):
			$data['canal'] = DB::table('users') -> select( 'canal' ) -> where( 'canal', '!=', '' ) -> groupBy('canal') -> get();
			$data['plaza'] = DB::table('users') -> select( 'plaza' ) -> where( 'plaza', '!=', '' ) -> groupBy('plaza') -> get();
			return view('control.cargausuarios', $data) -> render();
		endif;
	}
	############################################################################# END, NUEVO ASESOR

	############################################################################# HISTORICO
	public static function getHistorico( Request $solicitud )
	{
		$data['nav'] = self::getNav();
		return view('control.historico', $data);
	}

	############################################################################# ALMACENA INFORMACION FORMULARIO
	public static function getFormulario( Request $solicitud )
	{
		$url = clean( $solicitud -> url );
		$data['nav'] = self::getNav();
		$data['formulario'] = DB::table('formularios')
							  -> select ( 'id', 'titulo', 'configuracion')
							  -> where( 'activo', '=', 1 )
							  -> where( 'url', '=', $url )
							  -> where ( 'vp', 'like', '%'.Auth::user() -> vp.'%') 
							  -> get();
		if( count($data['formulario']) == 0 )
			return redirect('/dashboard');
		else
			return view('control.formularios', $data);
	}
	############################################################################# END, ALMACENA INFORMACION FORMULARIO


	############################################################################# DASHBOARD
	public static function getDashboard()
	{
		$data['nav'] = self::getNav();
		return view('control.dashboard', $data );
	}
	############################################################################# END, DASHBOARD


	############################################################################# MENU
	public static function getNav()
	{
		return DB::table('tipo_formulario') 
			   -> join ( 'formularios', 'formularios.id_tipo_formulario', '=', 'tipo_formulario.id' )
			   -> select ( 'tipo_formulario.id AS idTipoFormulario', 'tipo_formulario.titulo AS tipoFormulario', 'formularios.grupo', 'formularios.titulo AS titulo', 'formularios.url AS url' )
			   -> where( 'activo', '=', 1 )
			   -> where ( 'vp', 'like', '%'.Auth::user() -> vp.'%') 
			   -> orderBY( 'formularios.grupo' )
			   -> get();
	}
	############################################################################# END, MENU





















	/*
	public static function getActualizarPonderacion1111111111111()
	{
		$evaluado = DB::table('evaluado') -> select ( 'id' ) -> whereBetween ('id', [5001, 6000] ) -> get();
		$data = DB::table('evaluado_data') -> select ( 'id_evaluado', 'aspecto', 'llave', 'valor', 'valor_str', 'ponderacion' ) -> whereBetween ('id_evaluado', [5001, 6000] )  -> get();

		foreach ( $evaluado AS $e ):

			$aspecto_actual = '';
			$calificacion_aspecto = [];
			$cantidad_aspecto = [];
			$nota_final = 0;

			$da = '';

			foreach ( $data AS $d ):

				if( $e -> id == $d -> id_evaluado ):

					$llave_grupo_aspectos = trim($d -> aspecto);

					if( $d -> aspecto != '' ):

						$aspecto_actual = $llave_grupo_aspectos;

						if( !isset($calificacion_aspecto[ $aspecto_actual ]) )
							$calificacion_aspecto[ $aspecto_actual ] = 0;

						if( !isset($cantidad_aspecto[ $aspecto_actual ]) )
							$cantidad_aspecto[ $aspecto_actual ] = 0;

						if( $d -> valor != 0 )
							$cantidad_aspecto[ $aspecto_actual ] ++;

						$calificacion_aspecto[ $aspecto_actual ] += $d -> valor;

						$nota_final += $d -> ponderacion;

					endif;

					if( $d -> llave != '' ):
						$da .= $d -> aspecto.'##'.$d -> llave.'##'.$d -> valor.'##'.$d -> valor_str.'##'.$d -> ponderacion.'#|#';
					endif;

				endif;
				
			endforeach;

			$calificacion = '';
			foreach( $calificacion_aspecto AS $clave => $valor ):
				if( $cantidad_aspecto[$clave] != 0 )
					$calificacion .= $clave.'##'.$valor / $cantidad_aspecto[$clave].'##';
				else
					$calificacion .= $clave.'##'.$valor.'##';
			endforeach;
			$calificacion = substr($calificacion, 0, -2);
			$da .= $calificacion.'##NOTA PONDERADA##'.$nota_final;

			DB::table('evaluado') ->where( 'id', $e -> id ) -> update([ 'valores' => $da ]);

		endforeach;

		//return $da;
	}
	*/

}
