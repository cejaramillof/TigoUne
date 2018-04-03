<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => [ 'auth' ]], function(){

	Route::post('/7f928f285f227106652fd7175593ad8f3c4d6e015b16247e08eba78c64e4', ['uses' => 'ControlApp\FormulariosController@setAlmacenaUsuarioData'] );
	Route::get('/eca1e7d1d8baf35095ecd0a14dec6e452b8801ef7cdfac7ee417d2c7ae12', ['uses' => 'ControlApp\ControlController@getFormularioCargaUsuarios'] );

	Route::get('/84979d35fb740b370b64ad2e00e1fea0b51058c5780c04c88485046f8bc1/{tipo}/{desde}/{hasta}', ['uses' => 'ControlApp\FormulariosController@getDescargarAcompanamientos'] ) -> where([ 'tipo' => '[0-9A-Za-z-]+', 'desde' => '[0-9-]+', 'hasta' => '[0-9-]+' ]);
	Route::post('/7085046f8bc1b64ac5780c04c840bd2e00e1fea0b51058378484979d35fb', ['uses' => 'ControlApp\FormulariosController@getHistoricoAcompanamientos'] );
	Route::get('/historico', ['uses' => 'ControlApp\ControlController@getHistorico'] );

	Route::post('/8a1b1756b1dcd1e6340979c41ca0067b6584f708de3d89e4dd4d927b443e', ['uses' => 'ControlApp\FormulariosController@setAlmacenaFormularioData'] );
	Route::post('/08bc1b64aca0b51058372e1f7085046f580c04c840bd78484979d35fbe0e', ['uses' => 'ControlApp\FormulariosController@getIdPunto'] );
	Route::get('/marcacion/{url}', ['uses' => 'ControlApp\ControlController@getFormulario'] ) -> where([ 'url' => '[0-9A-Za-z-]+']);
	Route::get('/dashboard', ['uses' => 'ControlApp\ControlController@getDashboard'] );

});


Route::post('/8484979d35fb8bc1b64ac580c04c840bd7ea0b51058372e00e1f7085046f', ['uses' => 'ControlApp\FormulariosController@getCedula'] );
Route::get('/', 'Auth\AuthController@showLoginForm');
Route::post('/login', ['uses' => 'ControlApp\LoginController@setValidaIngreso'] );
Route::get('/salir', 'Auth\AuthController@logout');
Route::get('/e6340067b6584f708b1d78a1b17569c41ca0de3d89dd4d927b443eecd194', ['uses' => 'ControlApp\LoginController@setCrearContraseina'] );

//Route::get('/actualizarponderacion', ['uses' => 'ControlApp\ControlController@getActualizarPonderacion1111111111111'] );
