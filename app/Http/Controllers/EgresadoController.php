<?php
//guardar los datos de un egresado 
namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Egresado;

class EgresadoController extends Controller
{

    public function index(){
        $egresados = Egresado::all()->load('user');
        return response()->json(array(
            'egresados' => $egresados,
            'status' => 'success'
        ), 200);

    }

    public function register(Request $request){
    	//recoger las variables que nos llegan por post
    	$json  =  $request->input('json');
    	$params = json_decode($json);

    	$email  = (!is_null($json) && isset($params->email)) ? $params->email : null;
    	$name  = (!is_null($json) && isset($params->name)) ? $params->name : null;
    	//$user_id  = (!is_null($json) && isset($params->user_id)) ? $params->user_id : null;
    	$pais  = (!is_null($json) && isset($params->pais)) ? $params->pais : null;
    	$dni  = (!is_null($json) && isset($params->dni)) ? $params->dni : null;
    	$password  = (!is_null($json) && isset($params->password)) ? $params->password : null;
    	$intereses  = (!is_null($json) && isset($params->intereses)) ? $params->intereses : null;
    	$edad  = (!is_null($json) && isset($params->edad)) ? $params->edad : null;
    	$genero  = (!is_null($json) && isset($params->genero)) ? $params->genero : null;

        if (!is_null($email) && !is_null($password) && !is_null($name)) {
            # crear el usuario
            
            $user = new Egresado();
            $user->email = $email;           
            $user->name = $name;
           // $user->user_id = $user->sub;                           
            $user->pais = $pais; 
            $user->dni = $dni;             
            $user->password = $password;
            $user->intereses = $intereses;
            $user->edad = $edad; 
            $user->genero = $genero;

            //para cifrar la  contraseña
            $pwd = hash('sha256', $password);
            $user->password =  $pwd;

            //comprobar usuario duplicado
            $isset_user = Egresado::where('email', '=', $email)->first();

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


}
