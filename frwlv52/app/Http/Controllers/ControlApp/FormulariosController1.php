<?php

namespace Control\Http\Controllers\ControlApp;

use Illuminate\Http\Request;
use Control\Http\Requests;
use Control\Http\Controllers\Controller;
use Auth;
use DB;
use Process;

class FormulariosController extends Controller
{

	############################################################################# CREA NUEVO ASESOR
	public static function setAlmacenaUsuarioData( Request $solicitud )
	{
		if( $solicitud -> ajax() ):

			$msg = 'ok';
			$rpta = trans('app.msg00001');
			$class = 'alert alert-success';
			$status = true;

			$data = clean( $solicitud -> data );

			$query = DB::table('users') -> select ('cedula') -> where ('cedula', '=', $data['evaluado'][0]) -> get();
			if( count($query) > 0 ):

				$msg = 'bad';
				$rpta = trans('app.msg00003');
				$class = 'alert alert-danger';

			else:			

				$nombre = strtr(strtoupper($data['evaluado'][1]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$query = DB::table('users')
						-> insertGetId([
											'cedula' => $data['evaluado'][0],
											'nombre_empleado' => $nombre,
											'cargo' => 'ASESOR',
											'regional' => Auth::user() -> regional,
											'canal' => $data['evaluado'][2], 
											'plaza' => $data['evaluado'][3], 
											'cedula_solicitante' => Auth::user() -> cedula, 
											'estado' => 'INACTIVO', 
											'jerarquia' => 'PO'
										]);

				if( !$status ):
					$msg = 'bad';
					$rpta = trans('app.erro00004');
					$class = 'alert alert-danger';
				endif;

			endif;

			return response() -> json( array( 'msg' => $msg, 'rpta' => $rpta, 'class' => $class ) );
			
		endif;
	}
	############################################################################# END, CREA NUEVO ASESOR




	############################################################################# HISTORICO Y DESCARGA ACOMPAÑAMIENTOS

		############################################################################# CONSULTAS SEGÚN ROL
			private static function getQueryHistoricoAcompanamientos( $tipo_formulario = 1, $desde = '0000-00-00', $hasta = '0000-00-00' )
			{
				$data_a = DB::table('formularios')
						  -> join ( 'formulario', 'formulario.id_formulario', '=', 'formularios.id' )
						  -> join ( 'evaluado', 'evaluado.id_formulario', '=', 'formulario.id' )
						  -> join ( 'evaluado_data', 'evaluado.id', '=', 'evaluado_data.id_evaluado' )
						  -> join ( 'users', 'users.cedula', '=', 'evaluado.cedula' )
						  -> select (
										'formularios.titulo AS FORMULARIO', 
										'formularios.grupo AS GRUPO', 
										'formulario.id AS ID', 
										'formulario.cedula_evaluador AS CEDULA_EVALUADOR', 
										'formulario.fecha_actividad AS FECHA_ACTIVIDAD', 
										'formulario.duracion_actividad AS DURACION_ACTIVIDAD', 
										DB::raw( '(SELECT nombre_empleado FROM users WHERE cedula = formulario.cedula_evaluador) AS "NOMBRE_EVALUADOR"' ), 
										DB::raw( '(SELECT cargo FROM users WHERE cedula = formulario.cedula_evaluador) AS "CARGO_EVALUADOR"' ), 
										DB::raw( '(SELECT regional FROM users WHERE cedula = formulario.cedula_evaluador) AS "REGIONAL_EVALUADOR"' ),
						  				DB::raw( 'formulario.created_at AS FECHA_SISTEMA' ), 
										DB::raw( 'YEAR(formulario.created_at) AS "ANIO"' ), 
										DB::raw( 'MONTH(formulario.created_at) AS "MES"' ), 
										DB::raw( 'DAY(formulario.created_at) AS "DIA"' ), 
										DB::raw( 'TIME(formulario.created_at) AS "HORA"' ), 
										'users.cedula AS CEDULA_EVALUADO', 
										'users.nombre_empleado AS NOMBRE_EVALUADO', 
										'users.cargo AS CARGO_EVALUADO', 
										'users.empresa AS PROVEEDOR_EVALUADO', 
										'users.unidad AS ESTRATEGIA_EVALUADO', 
										'users.regional AS REGIONAL_EVALUADO', 
										'users.plaza AS CIUDAD_EVALUADO', 
										'users.canal AS CANAL_EVALUADO', 
										'users.linea_contacto AS CELULAR', 
										DB::raw( 'CONCAT("http://maps.google.com/maps?q=",formulario.latitud,",",formulario.longitud) as UBICACION' ),
										'evaluado.valores AS VALORES'
						  			);


				$data_b = DB::table('formularios')
							  -> join ( 'formulario', 'formulario.id_formulario', '=', 'formularios.id' )
							  -> join ( 'evaluado', 'evaluado.id_formulario', '=', 'formulario.id' )
							  -> join ( 'users_ext', 'users_ext.cedula', '=', 'evaluado.cedula' )
							  -> select (
											'formularios.titulo AS FORMULARIO', 
											'formularios.grupo AS GRUPO', 
											'formulario.id AS ID', 
											'formulario.cedula_evaluador AS CEDULA_EVALUADOR', 
											'formulario.fecha_actividad AS FECHA_ACTIVIDAD', 
											'formulario.duracion_actividad AS DURACION_ACTIVIDAD', 
											DB::raw( '(SELECT nombre_empleado FROM users WHERE cedula = formulario.cedula_evaluador) AS "NOMBRE_EVALUADOR"' ), 
											DB::raw( '(SELECT cargo FROM users WHERE cedula = formulario.cedula_evaluador) AS "CARGO_EVALUADOR"' ), 
											DB::raw( '(SELECT regional FROM users WHERE cedula = formulario.cedula_evaluador) AS "REGIONAL_EVALUADOR"' ),
							  				DB::raw( 'formulario.created_at AS FECHA_SISTEMA' ), 
											DB::raw( 'YEAR(formulario.created_at) AS "ANIO"' ), 
											DB::raw( 'MONTH(formulario.created_at) AS "MES"' ), 
											DB::raw( 'DAY(formulario.created_at) AS "DIA"' ), 
											DB::raw( 'TIME(formulario.created_at) AS "HORA"' ), 
											'users_ext.cedula AS CEDULA_EVALUADO', 
											'users_ext.nombre_empleado AS NOMBRE_EVALUADO', 
											DB::raw('"ASESOR" AS "CARGO_EVALUADO"'), 
											'users_ext.empresa AS PROVEEDOR_EVALUADO', 
											DB::raw( '"" AS "ESTRATEGIA_EVALUADO"' ), 
											'users_ext.regional AS REGIONAL_EVALUADO', 
											'users_ext.plaza AS CIUDAD_EVALUADO', 
											'users_ext.canal AS CANAL_EVALUADO', 
											'users_ext.celular AS CELULAR', 
											DB::raw( 'CONCAT("http://maps.google.com/maps?q=",formulario.latitud,",",formulario.longitud) as UBICACION' ), 
											'evaluado.valores AS VALORES'
							  			);

				$checkdate = false;
				if( $desde != '0000-00-00' && $hasta != '0000-00-00' ):

					$check_desde = explode('-', $desde);
					$check_hasta = explode('-', $hasta);

					if( checkdate( $check_desde[1], $check_desde[2], $check_desde[0] ) || checkdate( $check_hasta[1], $check_hasta[2], $check_hasta[0] ) ):
						$checkdate = true;
						$hasta = strtotime ( '+1 day' , strtotime ( $hasta ) ) ;
						$hasta = date ( 'Y-m-j' , $hasta );
					endif;

				endif;

				if( Auth::user() -> jerarquia == 'ENTRENADOR_COMERCIAL' || Auth::user() -> jerarquia == 'ENTRENADOR_SERVICIO' || Auth::user() -> jerarquia == 'ENTRENADOR_TECNICOS' || Auth::user() -> jerarquia == 'SUPERVISOR_COMERCIAL' || Auth::user() -> jerarquia == 'SUPERVISOR_TECNICOS'):

                    if ($tipo_formulario != 1):
					   $data_a = $data_a -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
              
					//$data_a = $data_a -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					$data_a = $data_a -> where( 'formulario.cedula_evaluador', '=', Auth::user() -> cedula );
					if( $checkdate ):
						$data_a = $data_a -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_a = $data_a -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_a = $data_a -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_a = $data_a -> whereIN( 'formularios.id', [3, 4, 5, 6, 7, 8, 9, 13, 15, 16, 19] );
					$data_a = $data_a -> groupBY( 'formulario.id' );
					$data_a = $data_a -> orderBY( 'formularios.id' );
					$data_a = $data_a -> get();

                    if ($tipo_formulario != 1):
					   $data_b = $data_b -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					//$data_b = $data_b -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					$data_b = $data_b -> where( 'formulario.cedula_evaluador', '=', Auth::user() -> cedula );
					if( $checkdate ):
						$data_b = $data_b -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_b = $data_b -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_b = $data_b -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_b = $data_b -> whereIN( 'formularios.id', [1, 2, 12] );
					$data_b = $data_b -> groupBY( 'formulario.id' );
					$data_b = $data_b -> orderBY( 'formularios.id' );
					$data_b = $data_b -> get();

					$query = array_merge( $data_a, $data_b );

				elseif( Auth::user() -> jerarquia == 'ENTRENADOR_COMERCIAL_LIDER' || Auth::user() -> jerarquia == 'ESPECIALISTA_REGIONAL' || Auth::user() -> jerarquia == 'COORDINADOR_TECNICOS'):
                    if ($tipo_formulario != 1):
				        $data_a = $data_a -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
              
					//$data_a = $data_a -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_a = $data_a -> where( 'users.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_a = $data_a -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_a = $data_a -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_a = $data_a -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_a = $data_a -> whereIN( 'formularios.id', [3, 4, 5, 6, 7, 8, 9, 13, 15, 16, 19] );
					$data_a = $data_a -> groupBY( 'formulario.id' );
					$data_a = $data_a -> orderBY( 'formularios.id' );
					$data_a = $data_a -> get();

                    if ($tipo_formulario != 1):
				        $data_b = $data_b -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					$data_b = $data_b -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_b = $data_b -> where( 'users_ext.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_b = $data_b -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_b = $data_b -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_b = $data_b -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_b = $data_b -> whereIN( 'formularios.id', [1, 2, 12,] );
					$data_b = $data_b -> groupBY( 'formulario.id' );
					$data_b = $data_b -> orderBY( 'formularios.id' );
					$data_b = $data_b -> get();

					$query = array_merge( $data_a, $data_b );
				elseif( Auth::user() -> jerarquia == 'ESPECIALISTA_SERVICIO' ):
                    if ($tipo_formulario != 1):
				        $data_a = $data_a -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
              
					//$data_a = $data_a -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_a = $data_a -> where( 'users.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_a = $data_a -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_a = $data_a -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_a = $data_a -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_a = $data_a -> whereIN( 'formularios.id', [4, 19] );
					$data_a = $data_a -> groupBY( 'formulario.id' );
					$data_a = $data_a -> orderBY( 'formularios.id' );
					$data_a = $data_a -> get();

                    if ($tipo_formulario != 1):
				        $data_b = $data_b -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					$data_b = $data_b -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_b = $data_b -> where( 'users_ext.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_b = $data_b -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_b = $data_b -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_b = $data_b -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_b = $data_b -> whereIN( 'formularios.id', [] );
					$data_b = $data_b -> groupBY( 'formulario.id' );
					$data_b = $data_b -> orderBY( 'formularios.id' );
					$data_b = $data_b -> get();

					$query = array_merge( $data_a, $data_b );              
				elseif( Auth::user() -> jerarquia == 'OUTSOURCING'):
                    if ($tipo_formulario != 1):
				        $data_a = $data_a -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
              
					//$data_a = $data_a -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_a = $data_a -> where( 'users.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_a = $data_a -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_a = $data_a -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_a = $data_a -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_a = $data_a -> whereIN( 'formularios.id', [17,18] );
					$data_a = $data_a -> groupBY( 'formulario.id' );
					$data_a = $data_a -> orderBY( 'formularios.id' );
					$data_a = $data_a -> get();

                    if ($tipo_formulario != 1):
				        $data_b = $data_b -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					//$data_b = $data_b -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					//$data_b = $data_b -> where( 'users_ext.regional', '=', Auth::user() -> regional );
					if( $checkdate ):
						$data_b = $data_b -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_b = $data_b -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_b = $data_b -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_b = $data_b -> whereIN( 'formularios.id', [] );
					$data_b = $data_b -> groupBY( 'formulario.id' );
					$data_b = $data_b -> orderBY( 'formularios.id' );
					$data_b = $data_b -> get();

					$query = array_merge( $data_a, $data_b );

				else:
                    if ($tipo_formulario != 1):
				        $data_a = $data_a -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					//$data_a = $data_a -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					if( $checkdate ):
						$data_a = $data_a -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_a = $data_a -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_a = $data_a -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_a = $data_a -> whereIN( 'formularios.id', [3, 4, 5, 6, 7, 8, 9, 13, 15, 16, 19] );
					$data_a = $data_a -> groupBY( 'formulario.id' );
					$data_a = $data_a -> orderBY( 'formularios.id' );
					$data_a = $data_a -> get();

                    if ($tipo_formulario != 1):
					     $data_b = $data_b -> where( 'formularios.id_tipo_formulario', '=', $tipo_formulario );
                    endif;
					//$data_b = $data_b -> where( 'formularios.vp', 'like', '%'.Auth::user() -> vp.'%' );
					if( $checkdate ):
						$data_b = $data_b -> whereBetween( 'formulario.created_at', [ $desde, $hasta ] );
					else:
						$data_b = $data_b -> whereYear( 'formulario.created_at', '=', date('Y'));
						$data_b = $data_b -> whereMonth( 'formulario.created_at', '=', date('m'));
					endif;
					$data_b = $data_b -> whereIN( 'formularios.id', [1, 2, 12] );
					$data_b = $data_b -> groupBY( 'formulario.id' );
					$data_b = $data_b -> orderBY( 'formularios.id' );
					$data_b = $data_b -> get();

					$query = array_merge( $data_a, $data_b );

				endif;

				return $query;
			}
		############################################################################# END, CONSULTAS SEGÚN ROL

		############################################################################# CREA Y DESCARGA ARCHIVO .csv SEGÚN CONSULTA
			public static function getDescargarAcompanamientos( Request $solicitud )
			{
				$query = self::getQueryHistoricoAcompanamientos( clean( $solicitud -> tipo ), clean( $solicitud -> desde ), clean( $solicitud -> hasta ) );

				$aspecto = [];
				$rpta_aspectos = [];

				$pregunta_aspecto = [];
				$rpta_pregunta_aspecto = [];

				$pregunta = [];
				$rpta_pregunta = [];

				$valores = [];

				foreach( $query AS $c ):

					$fila = explode('#|#', $c -> VALORES);
					for( $j = 0; $j < (count($fila)- 1); $j++ ):
						$columna = explode( '##', $fila[$j] );
							if( $columna[0] != '' && $columna[0] != '-' ):

							$txtaspecto = trim($columna[0]);
							$txtpregunta_aspecto = trim($columna[1]);
							$valorpregunta_aspecto = trim($columna[2]);

							$aspecto[ $txtaspecto ] = $txtaspecto;
							$pregunta_aspecto[ $txtpregunta_aspecto ] = $txtpregunta_aspecto;
							$rpta_pregunta_aspecto[ $txtpregunta_aspecto.'-'.$c -> ID ] = ( $valorpregunta_aspecto == 0 ) ? '' : number_format($valorpregunta_aspecto, 2, ',', '.');

						else:

							$txtpregunta = trim($columna[1]);

							$pregunta[ $txtpregunta ] = $txtpregunta;
							if( !isset($rpta_pregunta[ $txtpregunta.'-'.$c -> ID ]) )
								$rpta_pregunta[ $txtpregunta.'-'.$c -> ID ] = trim($columna[3]);
							else
								$rpta_pregunta[ $txtpregunta.'-'.$c -> ID ] .= ', '.trim($columna[3]);

						endif;
					endfor;

                $columna = explode( '##', end( $fila ) );
                for( $j = 0; $j < count($columna); $j += 2 ):
                    if( isset($columna[$j+1]) ):
                        $valor = Process::getRedondearDosDecimales($columna[$j+1]);
                        $rpta_aspectos[ $columna[$j].'-'.$c -> ID ] = ( $valor < 1 ) ? '' : $valor;
                    else:
                        $rpta_aspectos[ $columna[$j].'-'.$c -> ID ] = '';
                    endif;
                endfor;

                
				endforeach;

				$headers['headers'] = [ 'ID', 'FORMULARIO', 'GRUPO', 'FECHA_SISTEMA', 'AÑO', 'MES', 'DÍA', 'HORA', 'CEDULA_EVALUADOR', 'NOMBRE_EVALUADOR', 'CARGO_EVALUADOR', 'REGIONAL_EVALUADOR', 'CEDULA_EVALUADO', 'NOMBRE_EVALUADO', 'CARGO_EVALUADO', 'CELULAR_EVALUADO', 'PROVEEDOR_EVALUADO', 'ESTRATEGIA_EVALUADO', 'REGIONAL_EVALUADO', 'PLAZA_EVALUADO', 'CANAL_EVALUADO', 'FECHA_ACTIVIDAD' ];
              
				//$headers['headers'] = [ 'ID', 'FORMULARIO', 'GRUPO', 'FECHA_SISTEMA', 'CEDULA_EVALUADOR', 'NOMBRE_EVALUADOR', 'CARGO_EVALUADOR', 'REGIONAL_EVALUADOR', 'CEDULA_EVALUADO', 'NOMBRE_EVALUADO', 'CARGO_EVALUADO', 'CELULAR_EVALUADO', 'PROVEEDOR_EVALUADO', 'ESTRATEGIA_EVALUADO', 'REGIONAL_EVALUADO', 'PLAZA_EVALUADO', 'CANAL_EVALUADO', 'FECHA_ACTIVIDAD' ];
              
				if( Auth::user() -> jerarquia == 'ADMINISTRADOR' || Auth::user() -> jerarquia == 'OUTSOURCING' ):
                  foreach( $pregunta_aspecto AS $value ):
                      array_push($headers['headers'], $value);
                  endforeach;
                endif;
              
				foreach( $pregunta AS $value ):
					array_push($headers['headers'], $value);
				endforeach;
				
				foreach( $aspecto AS $value ):
					array_push($headers['headers'], $value);
				endforeach;

				array_push($headers['headers'], 'NOTA PONDERADA');
				array_push($headers['headers'], 'LOCALIZAR');
				array_push($headers['headers'], 'DURACION_ACTIVIDAD');


				foreach( $query AS $c ):
					//$valores[$c -> ID] = array( $c -> ID, $c -> FORMULARIO, $c -> GRUPO, $c -> FECHA_SISTEMA, $c -> CEDULA_EVALUADOR, $c -> NOMBRE_EVALUADOR, $c -> CARGO_EVALUADOR, $c -> REGIONAL_EVALUADOR, $c -> CEDULA_EVALUADO, $c -> NOMBRE_EVALUADO, $c -> CARGO_EVALUADO, $c -> CELULAR, $c -> PROVEEDOR_EVALUADO, $c -> ESTRATEGIA_EVALUADO, $c -> REGIONAL_EVALUADO, $c -> CIUDAD_EVALUADO, $c -> CANAL_EVALUADO, $c -> FECHA_ACTIVIDAD );
              
					$valores[$c -> ID] = array( $c -> ID, $c -> FORMULARIO, $c -> GRUPO, $c -> FECHA_SISTEMA, $c -> ANIO, $c -> MES, $c -> DIA, $c -> HORA, $c -> CEDULA_EVALUADOR, $c -> NOMBRE_EVALUADOR, $c -> CARGO_EVALUADOR, $c -> REGIONAL_EVALUADOR, $c -> CEDULA_EVALUADO, $c -> NOMBRE_EVALUADO, $c -> CARGO_EVALUADO, $c -> CELULAR, $c -> PROVEEDOR_EVALUADO, $c -> ESTRATEGIA_EVALUADO, $c -> REGIONAL_EVALUADO, $c -> CIUDAD_EVALUADO, $c -> CANAL_EVALUADO, $c -> FECHA_ACTIVIDAD );
              
                    if( Auth::user() -> jerarquia == 'ADMINISTRADOR' || Auth::user() -> jerarquia == 'OUTSOURCING' ):
                      foreach( $pregunta_aspecto AS $p ):
                          if( isset( $rpta_pregunta_aspecto[ $p.'-'.$c -> ID ] ) ):
                              array_push( $valores[$c -> ID], $rpta_pregunta_aspecto[ $p.'-'.$c -> ID ] );
                          else:
                              array_push( $valores[$c -> ID], '' );
                          endif;
                      endforeach;
                    endif;
              
					foreach( $pregunta AS $p ):
						if( isset( $rpta_pregunta[ $p.'-'.$c -> ID ] ) ):
							array_push( $valores[$c -> ID], $rpta_pregunta[ $p.'-'.$c -> ID ] );
						else:
							array_push( $valores[$c -> ID], '' );
						endif;
					endforeach;

					foreach( $aspecto AS $a ):
						if( isset( $rpta_aspectos[ $a.'-'.$c -> ID ] ) ):
							array_push( $valores[$c -> ID], $rpta_aspectos[ $a.'-'.$c -> ID ] );
						else:
							array_push( $valores[$c -> ID], '' );
						endif;
					endforeach;
                    
                    if( !isset( $rpta_aspectos[ 'NOTA PONDERADA-'.$c -> ID ] ) ):
                        array_push( $valores[$c -> ID], '' );
                    else:
                        array_push( $valores[$c -> ID], $rpta_aspectos[ 'NOTA PONDERADA-'.$c -> ID ] );
                    endif;
                    
					array_push( $valores[$c -> ID], $c -> UBICACION );
					array_push( $valores[$c -> ID], $c -> DURACION_ACTIVIDAD );

				endforeach;

				
				// RENDER FILE
				$fp = fopen( 'php://temp/maxmemory:'. (12*1024*1024) , 'r+' );

				fputs( $fp, $bom = ( chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ) );
				fputcsv( $fp, $headers['headers'], ";", '"' );

				foreach( $valores AS $val ):
					fputcsv( $fp, $val, ";", '"' );
				endforeach;
				rewind( $fp );
				$output = stream_get_contents( $fp );
				fclose( $fp );

				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=Control-Acompañamientos-'. time() .'.csv' );
				header('Content-Length: '. strlen($output) );
				header( 'Cache-Control: max-age=0' );
				header( 'Cache-Control: max-age=1' );
				header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
				header( 'Cache-Control: cache, must-revalidate' );
				header( 'Pragma: public' );
				// END, RENDER FILE

				return $output;
			}
		############################################################################# END, CREA Y DESCARGA ARCHIVO .csv SEGÚN CONSULTA
  
		############################################################################# CREA JSON PARA CARGA EN DATATABLE
			public static function getHistoricoAcompanamientos( Request $solicitud )
			{
				//$tipo_formulario = $solicitud -> input('tipo_formulario');
				$tipo_formulario = 1;

				$query = self::getQueryHistoricoAcompanamientos( $tipo_formulario );

				if( count($query) > 0 ):

					$json['headers'] = [ 'ID','FORMULARIO','GRUPO', 'FECHA_SISTEMA', 'AÑO','MES','DÍA','HORA', 'CEDULA_EVALUADOR', 'NOMBRE_EVALUADOR', 'CARGO_EVALUADOR', 'REGIONAL_EVALUADOR', 'CEDULA_EVALUADO', 'NOMBRE_EVALUADO', 'CARGO_EVALUADO', 'PROVEEDOR_EVALUADO', 'ESTRATEGIA_EVALUADO', 'REGIONAL_EVALUADO', 'PLAZA_EVALUADO', 'CANAL_EVALUADO', 'FECHA_ACTIVIDAD' ];

					$json['data'] = [];
					foreach( $query AS $c ):

						array_push( $json['data'], [ $c -> ID, $c -> FORMULARIO, $c -> GRUPO, $c -> FECHA_SISTEMA, $c -> ANIO, $c -> MES, $c -> DIA, $c -> HORA, $c -> CEDULA_EVALUADOR, $c -> NOMBRE_EVALUADOR, $c -> CARGO_EVALUADOR, $c -> REGIONAL_EVALUADOR, $c -> CEDULA_EVALUADO, $c -> NOMBRE_EVALUADO, $c -> CARGO_EVALUADO, $c -> PROVEEDOR_EVALUADO, $c -> ESTRATEGIA_EVALUADO, $c -> REGIONAL_EVALUADO, $c -> CIUDAD_EVALUADO, $c -> CANAL_EVALUADO, $c -> FECHA_ACTIVIDAD ] );

					endforeach;
					return response() -> json( $json );

				else:

					return response() -> json( $json['error'] = [ 'Error', trans('app.msg00004') ] );

				endif;
			}
		############################################################################# END, CREA JSON PARA CARGA EN DATATABLE

	############################################################################# END, HISTORICO Y DESCARGA ACOMPAÑAMIENTOS



	############################################################################# ALMACENA INFORMACION FORMULARIO
	public static function setAlmacenaFormularioData( Request $solicitud )
	{
		$msg = 'ok';
		$rpta = trans('app.msg00001');
		$class = 'alert alert-success';
		if( $solicitud -> ajax() ):

			$status = true;
			$id_evaluado = array();
			$data = clean( $solicitud -> data );
			$id_formulario = Process::setDescifrar( $data['formulario']['token'] );
			$cedula_evaluador = Auth::user() -> cedula;
			$evaluado = 0;

			
			if( $data['evaluado'][0][0] == 'ext' ):

				$query = DB::table('users_ext')
								  -> select ( 'id_punto' )
								  -> where( 'id_punto', '=', $data['evaluado'][0][1] )
								  -> where( 'cedula', '=', $data['evaluado'][0][2] )
								  -> get();

				if( count($query) == 0 ):

					$query_ext = DB::table('users_ext')
										  -> insert([
														'id_punto' => strtoupper( $data['evaluado'][0][1] ), 
														'cedula' => strtoupper( $data['evaluado'][0][2] ), 
														'nombre_empleado' => strtoupper( $data['evaluado'][0][3] ), 
														'empresa' => strtoupper( $data['evaluado'][0][4] ), 
														'celular' => strtoupper( $data['evaluado'][0][5] ), 
														'regional' => Auth::user() -> regional, 
														'plaza' => strtoupper( $data['evaluado'][0][6] ), 
														'canal' => strtoupper( $data['evaluado'][0][7] ), 
														'cedula_solicitante' => $cedula_evaluador
									  				]);

					if( !$query_ext ):
						$status = false;
					endif;

				else:

					$query_ext = DB::table('users_ext')
										  -> where ( 'id_punto', $data['evaluado'][0][1] )
										  -> update([
														'nombre_empleado' => strtoupper( $data['evaluado'][0][3] ), 
														'empresa' => strtoupper( $data['evaluado'][0][4] ), 
														'celular' => $data['evaluado'][0][5], 
														'plaza' => strtoupper( $data['evaluado'][0][6] ), 
														'canal' => strtoupper( $data['evaluado'][0][7] )
									  				]);

				endif;

				$evaluado = $data['evaluado'][0][2];

			endif;

			if( $status ):

				$query_formulario = DB::table('formulario')
									-> insertGetId([
														'id_formulario' => $id_formulario, 
														'cedula_evaluador' => $cedula_evaluador, 
														'longitud' => $data['formulario']['longitude'], 
														'latitud' => $data['formulario']['latitude'], 
														'fecha_actividad' => $data['formulario']['date'], 
														'duracion_actividad' => $data['formulario']['time'] 
													]);

				if( !$query_formulario ):
					$status = false;
				endif;

			endif;


			if( $status ):

				$ultimo_id = $query_formulario;

				if( $evaluado == 0 ):

					for( $i = 0; $i < count( $data['evaluado'] ) && $status; $i++ ):

						$query_evaluado = DB::table('evaluado') -> insertGetId([ 'id_formulario' => $ultimo_id, 'cedula' => $data['evaluado'][$i], 'valores' => $data['strelementos'][0] ]);
						if( !$query_evaluado ):
							$status = false;
						else:
							array_push( $id_evaluado, $query_evaluado );
						endif;

					endfor;

				else:

					$query_evaluado = DB::table('evaluado') -> insertGetId([ 'id_formulario' => $ultimo_id,  'cedula' => $evaluado, 'valores' => $data['strelementos'][0] ]);
					if( !$query_evaluado ):
						$status = false;
					else:
						array_push( $id_evaluado, $query_evaluado );
					endif;

				endif;

			endif;


			if( $status ):

				for( $i = 0; $i < count( $id_evaluado ) && $status; $i++ ):

					for( $j = 0; $j < count( $data['elementos'] ) && $status; $j++ ):

						$query_ed = DB::table('evaluado_data')
								-> insert([
												'id_evaluado' => $id_evaluado[$i], 
												'aspecto' => $data['elementos'][$j][0], 
												'llave' => $data['elementos'][$j][1], 
												'valor' => $data['elementos'][$j][2], 
												'valor_str' => $data['elementos'][$j][3], 
												'ponderacion' => $data['elementos'][$j][4]
										  ]);

						if( !$query_ed )
							$status = false;

					endfor;

				endfor;

			endif;

			if( !$status ):
				DB::table('formulario') -> where('id', '=', $id_formulario) -> delete();
				$msg = 'bad';
				$rpta = trans('app.erro00004');
				$class = 'alert alert-danger';
			endif;			

			return response() -> json( array( 'msg' => $msg, 'rpta' => $rpta, 'class' => $class ) );

		endif;
	}
	############################################################################# END, ALMACENA INFORMACION FORMULARIO



	############################################################################# CARGA INFORMACIÓN EVALUADO
	public static function getIdPunto( Request $solicitud )
	{
		if( $solicitud -> ajax() ):

			$solicitud = clean( $solicitud -> input('a') );
			$data = DB::table('users_ext') 
					-> select( 'id_punto', 'cedula', 'nombre_empleado', 'empresa', 'celular', 'regional', 'plaza', 'canal' ) 
					-> where ( 'id_punto', 'like', '%'.$solicitud.'%') 
					-> get();

			$html = '';
			if( count($data) > 0 ):

				$html .= '<select class="form-control">';
					$html .= '<option value="" >Seleccione</option>';
					foreach( $data AS $c ):
						$val = $c -> id_punto.' / '.$c -> cedula.' / '.$c -> nombre_empleado.' / '.$c -> empresa.' / '.$c -> celular.' / '.$c -> plaza.' / '.$c -> canal;
						$html .= '<option value="'.$val.'" >'.$val.'</option>';
					endforeach;
				$html .= '</select>';

			else:

				$html .= 'No se encontraron ningun resultado para su búsqueda';

			endif;

			return $html;

		endif;
	}
	############################################################################# END, CARGA INFORMACIÓN EVALUADO


	############################################################################# CARGA INFORMACIÓN EVALUADO
	public static function getCedula( Request $solicitud )
	{
		if( $solicitud -> ajax() ):

			$solicitud = clean( $solicitud -> input('a') );
			$data = DB::table('users') 
					-> select( 'cedula', 'nombre_empleado', 'cargo', 'regional', 'canal' ) 
					-> where ( 'cedula', 'like', '%'.$solicitud.'%') 
					-> get();

			$html = '';
			if( count($data) > 0 ):

				$html .= '<select class="form-control">';
					$html .= '<option value="" >Seleccione</option>';
					foreach( $data AS $c ):
						$val = $c -> cedula.' / '.$c -> nombre_empleado.' / '.$c -> cargo.' / '.$c -> regional.' / '.$c -> canal;
						$html .= '<option value="'.$val.'" >'.$val.'</option>';
					endforeach;
				$html .= '</select>';

			else:

				$html .= trans('app.erro00003');

			endif;

			return $html;

		endif;
	}
	############################################################################# END, CARGA INFORMACIÓN EVALUADO


}
