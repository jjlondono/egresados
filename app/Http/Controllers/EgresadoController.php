<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\JwtAuth;

class EgresadoController extends Controller
{

   public function index(Request $request){
   	$hash = $request->header('Authorization', null);

   	$jwtAuth = new JwtAuth();
   	$checkToken = $jwtAuth->checkToken($hash);

   	if ($checkToken) {
   		echo "index de egresados controler auntenticado"; die();
   	}else {
   		echo "index de egresados controler no autenticado"; die();
   	}
   
   }
}
