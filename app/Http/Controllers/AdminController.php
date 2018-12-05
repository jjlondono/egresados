<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json(array(
            'users' => $users,
            'status' => 'success'
        ), 200);

    }

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
        $direccion  = (!is_null($json) && isset($params->direccion)) ? $params->direccion : null;
        $telefono  = (!is_null($json) && isset($params->telefono)) ? $params->telefono : null;
        $ciudad  = (!is_null($json) && isset($params->ciudad)) ? $params->ciudad : null;
        $role  = (!is_null($json) && isset($params->role)) ? $params->role : null;
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
            $user->direccion = $direccion;
            $user->telefono = $telefono;
            $user->ciudad = $ciudad;
            $user->role = $role;

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
    	$jwtAuth = new JwtAuth();

    	//recoger los datos por post
    	$json = $request->input('json', null);
    	$params = json_decode($json);

    	$email = (!is_null($json) && isset($params->email)) ? $params->email : null;
    	$password = (!is_null($json) && isset($params->password)) ? $params->password : null;
    	$getToken = (!is_null($json) && isset($params->getToken)) ? $params->getToken : null;

    	//cifrar la contraseña
    	$pwd = hash('sha256', $password);

    	if (!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')) {
    		$signup = $jwtAuth->signup($email, $pwd);

    		
    	}elseif($getToken != null){
    		$signup = $jwtAuth->signup($email, $pwd, $getToken);
    		
    	}else{
    		$signup = array(
    			'status' => 'error',
    			'message' => 'Envia tus datos por post'
    		);
    	}

    	return response()->json($signup, 200);
    }


    // metodo para eliminar un administrador
    public function destroy($id, Request $request){
        $hash = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            # Comprobar que existe el registro
            $admin = User::find($id);

            // Borrar el registro
            $admin->delete();

            // Devolver el registro
            $data = array(
                'admin' => $admin,
                'status' => 'success',
                'code' => 200
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Login incorrecto'
            );
        }

        return  response()->json($data, 200);
    }


    //metodo para actualizar los datos de un administrador
    public function update($id,Request $request){
        $hash = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            // Recoger parametros post
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

           


            # Actualizar el registro
            unset($params_array['id']);
            //unset($params_array['user_id']);
            unset($params_array['created_at']);
            //unset($params_array['user']);
            $admin = User::where('id', $id)->update($params_array);

            $data = array(
                'admin' => $params,
                'status' => 'success',
                'code' =>200
            );

        }else{
            //devolver error
            $data = array(
                'admin' => 'Login incorrecto',
                'status' => 'error',
                'code' => 400,
            );
        }

        return response()->json($data, 200);
    }

    //metodo para mostrar los datos de un administrador especifico
    public function show($id){
        $admin = User::find($id);

        if (is_object($admin)) {
            $admin = User::find($id);
            return response()->json(array('admin' => $admin, 'status' => 'success'),200);
        }else {
            return response()->json(array('message' => 'El administrador no existe', 'status' => 'error'),200);
        }
        
        
    } 


}
