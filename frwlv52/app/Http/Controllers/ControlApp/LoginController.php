<?php

namespace Control\Http\Controllers\ControlApp;

use Illuminate\Http\Request;
use Control\Http\Requests;
use Control\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Process;
use Exception;

class LoginController extends Controller
{

	############################################################################# VALIDA INGRESO
	public static function setValidaIngreso( Request $solicitud )
	{
		$msg = 'ok';
		$rpta = '';
        try {
          $di = clean( $solicitud -> input('cedula') );
          $pass = clean( $solicitud -> input('password') );

          $userdata = array( 'cedula' => $di, 'password' => $pass, 'estado' => 'ACTIVO' );
          if ( Auth::attempt( $userdata ) ):

              return redirect('/dashboard');

          else:

              return redirect()->back()->with('errorlogin', trans('app.erro00001'));

          endif;
          
        } catch (Exception $e) {
          return response() -> json( array( 'msg' => $msg, 'rpta' => $rpta, 'ex' => $e ) );
        }

	}
	############################################################################# END, VALIDA INGRESO

	############################################################################# GENERA CONTRASEÑAS A PERSONAS QUE EN SU JERARQUIA SEA DIFERENTE DE PO
	public static function setCrearContraseina()
	{
		$data = DB::table('users')
				-> select('cedula')
				-> where('jerarquia', '!=', 'PO')
				-> where ( 'password', '=', '' )
				-> get();
		foreach ( $data AS $c ):
			$data = DB::table('users') -> where( 'cedula', $c -> cedula ) -> update([ 'password' => Hash::make( $c -> cedula ) ]);
		endforeach;

		return 'Proceso terminado';
	}
	############################################################################# END, GENERA CONTRASEÑAS A PERSONAS QUE EN SU JERARQUIA SEA DIFERENTE DE PO


}
