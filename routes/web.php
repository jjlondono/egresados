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

//Rutas o urls
Route::post('/api/register', 'AdminController@register');
Route::post('/api/login', 'AdminController@login');
Route::post('/api/egresado', 'EgresadoController@register');
Route::resource('/api/egresados', 'EgresadoController');



