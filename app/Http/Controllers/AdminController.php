<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminController extends Controller
{
    public function register(Request $request){
    	//recoger las variables que nos llegan por post
    	$json  =  $request->input('json');
    	$params = json_decode($json);

    	$email  = (!is_null($json) && isset($params->email)) ? $params->email : null;
    	$name  = (!is_null($json) && isset($params->name)) ? $params->name : null;
    	$dni  = (!is_null($json) && isset($params->dni)) ? $params->dni : null;
    	$pais  = (!is_null($json) && isset($params->pais)) ? $params->pais : null;
    	$edad  = (!is_null($json) && isset($params->edad)) ? $params->edad : null;
    	$genero  = (!is_null($json) && isset($params->genero)) ? $params->genero : null;
    	$intereses  = (!is_null($json) && isset($params->intereses)) ? $params->intereses : null;
    	$password  = (!is_null($json) && isset($params->password)) ? $params->password : null;

        if (!is_null($email) && !is_null($password) && !is_null($name)) {
            # crear el usuario
            $user = new User();
            $user->email = $email;           
            $user->name = $name;
            $user->dni = $dni;
            $user->pais = $pais;
            $user->edad = $edad;
            $user->genero = $genero;
            $user->intereses = $intereses;

            //para cifrar la  contraseña
            $pwd = hash('sha256', $password);
            $user->password =  $pwd;

            //comprobar usuario duplicado
            $isset_user = User::where('email', '=', $email)->first();

            if (is_object($isset_user) == 0) {
                # guardar el usuario
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Ususario registrado correctamente'
                );
            }else{
                //no guardar el usuario porque ya existe
                    $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El usuario ya existe'
                );
            }


        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Ususario no creado'
            );
        }

        return response()->json($data, 200);
    }

    public function login(Request $request){
    	echo "Accion login"; die();
    }


}
