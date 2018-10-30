<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\JwtAuth;
use App\Egresado;

class EgresadoController extends Controller
{

   public function index(Request $request){
   	$hash = $request->header('Authorization', null);

   	$jwtAuth = new JwtAuth();
   	$checkToken = $jwtAuth->checkToken($hash);

   	//comprobar si un usuario esta identificado
   	if ($checkToken) {
   		echo "index de egresados controler auntenticado"; die();
   	}else {
   		echo "index de egresados controler no autenticado"; die();
   	}
   
   }

   public function store(Request $request){
		$hash = $request->header('Authorization', null);

	   	$jwtAuth = new JwtAuth();
	   	$checkToken = $jwtAuth->checkToken($hash);

	   	//comprobar si un usuario esta identificado
	   	if ($checkToken) {
	   		//recoger los datos por post
	   		$json = $request->input('json', null);
	   		$params = json_decode(($json));
	   		$params_array = json_decode($json, true);
	   		//conseguir el usuario identificado
	   		
	   		$user = $jwtAuth->checkToken($hash, true);

	   		//validacion
	   		
	   		$validate = \Validator::make($params_array,[
	   			'nombre' => 'required',
	   			'pais' => 'required',
	   			'dni' => 'required',
	   			'email' => 'required',
	   			'password' => 'required',
	   			'intereses' => 'required',
	   			'edad' => 'required',
	   			'genero' => 'required'
	   		]);
	   		

	   		if ($validate->fails()) {
                return response()->json($validate->errors(), 400);
            } 
	   		

	   		//guardar el egresado
	   		
   			$egresado = new Egresado();
   			$egresado->user_id = $user->sub;
			$egresado->nombre = $params->nombre;	
			$egresado->pais = $params->pais; 
			$egresado->dni = $params->dni;
			$egresado->email = $params->email;  
			$egresado->password = $params->password;
			$egresado->intereses = $params->intereses;
			$egresado->edad = $params->edad; 
			$egresado->genero = $params->genero;

			$egresado->save();

			$data = array(
				'egresado' => $egresado,
				'status' => 'success',
				'code' => 200,
			);
		
			

	   	}else {
	   		//devolver error
	   		$data = array(
				'message' => 'Login incorrecto',
				'status' => 'error',
				'code' => 400,
			);
	   	}
	   
	   	return response()->json($data, 200);
   }
}
