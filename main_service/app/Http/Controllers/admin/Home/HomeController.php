<?php

namespace App\Http\Controllers\admin\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\UserController;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    // Declaramos la propiedad que hace referencia al nombre del servicio al que pertenece el módulo administrador: 
    protected static $serviceMain = 'Principal';

    public function index()
    {
        // Si no existe un estado de sesion, retornamos la vista principal:
        if(isset($_SESSION['status'])){

            // Si el estado de la sesion es 'Activa', redirigimos directamente a la ruta 'dashboard': 
            if($_SESSION['status'] == 'Activa'){

                // Regirigimos: 
                return redirect()->route('dashboard');
            }else{
                // Retornamos la vista principal: 
                return view('welcome');
            }

        }else{
            // Retornamos la vista principal: 
            return view('welcome');
        }
    }

    public function store(Request $request)
    {
        try{

            // Instanciamos el controlador 'User' del servicio 'main', para validar si existe el usuario: 
            $userController = new UserController;

            // Iniciamos sesion del usuario: 
            $login = $userController->login($request, self::$userAdmin);

            // $responseLogin = $login->getOriginalContent();

            return $login;

            // if($responseLogin['login']){

            //     $data = [];

            //     foreach($responseLogin['content'] as $service){

            //         foreach($service as $array){
                        
            //             if($array->service == self::$serviceMain){
                
            //                 foreach($array as $content => $value){
                                
            //                     if($content == 'permission'){
                                
            //                         $data[] = $value;
            //                     }
            //                 }

            //             }

            //         }
                    
            //     }

            //     return $data; 

            // }else{
            //     // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
            //     $error = $responseLogin['error'];
            //     return view('welcome', ['error' => $error]);
            // }

        }catch(Exception $e){
            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
        
    }

    // // Metodo para retornar la informacion de un usuario especifico: 
    // public function show($id)
    // {
    //     // Realizamos la consulta en la DB: 
    //     $model = User::where('id_user', $id);

    //     // Validamos que exista el registro en la entidad: 
    //     $validateUser = $model->first();

    //     // Si existe, retornamos la informacion: 
    //     if($validateUser){

    //         // Retornamos la respuesta: 
    //         return ['query' => true, 'user' => $validateUser];

    //     }else{
    //         // Retornamos el error: 
    //         return ['query' => false, 'error' => 'No existe ese usuario en el sistema.'];
    //     }
    // }

    // // Metodo para actualizar el estado de sesion: 
    // public function updateSession($user_name, $status)
    // {
    //     // Realizamos la consulta a la DB: 
    //     $modelUser = User::where('user_name', $user_name);

    //     // Validamos que exista el registro en la entidad: 
    //     $validateUser = $modelUser->first();

    //     // Si existe, validamos que exista ese estado de sesion: 
    //     if($validateUser){

    //         // Realizamos la consulta a la DB:
    //         $modelSession = Session::select('id_session')
    //                               ->where('type_of_session', $status);

    //         // Validamos que exista el registro en la entidad: 
    //         $validateSession = $modelSession->first();

    //         // Si existe, actualizamos el estado de sesion: 
    //         if($validateSession){

    //             try{

    //                 $modelUser->update([
    //                     'session_id' => $validateSession['id_session']
    //                 ]);

    //                 // Retornamos la respuesta: 
    //                 return ['update' => true];
                        
    //             }catch(Exception $e){
    //                 // Retornamos el error: 
    //                 return ['update' => false, 'error' => $e->getMessage()];
    //             }

    //         }else{
    //             // Retornamos el error: 
    //             return ['update' => false, 'error' => 'No existe ese estado de sesion.'];
    //         }

    //     }else{
    //         // Retornamos el error: 
    //         return ['update' => false, 'error' => 'No existe ese usuario en el sistema.'];
    //     }
    // }

    // public function destroy($id)
    // {
    //     //
    // }
}
