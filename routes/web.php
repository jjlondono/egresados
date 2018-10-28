<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hola-mundo', function(){
	return 'Hola mundo';
});

Route::post('/hola-mundo', function(){
	return 'hola mundo por post';
});


Route::get('administrador/{nombre?}/{edad?}', function($nombre = "jorge ivan", $edad = 41){
	/*
	return view('administrador', array(
		"nombre" => $nombre,
		"edad" => $edad ));*/

	return view('administrador.administrador')
				->with('nombre', $nombre)
				->with('edad', $edad);
//el campo nombre solo acepta letras y edad solo numeros
})->where([
	'nombre' => '[A-Za-z]+',
	'edad' => '[0-9]+'
]);



