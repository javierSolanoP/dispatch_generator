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

    // Declaramos las propiedades de estado de sesion: 
    protected static $active = 'Activa';
    protected static $inactive = 'Inactiva';

    public function index()
    {
        // Si no existe un estado de sesion, retornamos la vista principal:
        if(isset($_SESSION['status'])){

            // Si el estado de la sesion es 'Activa', redirigimos directamente a la ruta 'dashboard': 
            if($_SESSION['status'] == self::$active){

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

    public function login(Request $request)
    {
        try{

            // Instanciamos el controlador 'User' del servicio 'main', para validar si existe el usuario: 
            $userController = new UserController;

            // Iniciamos sesion del usuario: 
            $login = $userController->login($request, self::$userAdmin);

            $responseLogin = $login->getOriginalContent();

            if($responseLogin['login']){

                // Asignamos los datos de la respuesta en las siguientes sesiones: 
                $_SESSION['user'] = $responseLogin['content']['user'];
                $_SESSION['services'] = $responseLogin['content']['services'];
                $_SESSION['permissions'] = $responseLogin['content']['permissions'];

                // Recorremos la matriz de la sesion 'services', para validar si tiene acceso al servicio principal: 
                foreach($_SESSION['services'] as $services){

                    if($services->service == self::$serviceMain){

                        // Iniciamos la sesion del usuario localmente: 
                        $_SESSION['status'] = self::$active;

                        // Redirigimos al usuario al dashboard: 
                        return redirect()->route('dashboard');
                    }
                }

                // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                $error = 'Usted no tiene autorización para ingresar a este módulo';
                return view('welcome', ['error' => $error]);

            }else{

                // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                $error = $responseLogin['error'];
                return view('welcome', ['error' => $error]);
            }
    
        }catch(Exception $e){
            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
        
    }

    // Metodo para terminar sersion del usuario: 
    public function logout(Request $request){

        try{

            // Si el estado de la sesion es 'Inactiva', redirigimos directamente a la ruta 'home': 
            if($_SESSION['status'] == self::$active){

                // Instanciamos el controlador 'User' del servicio 'main', para validar si existe el usuario: 
                $userController = new UserController;

                // Iniciamos sesion del usuario: 
                $logout = $userController->logout($request, self::$userAdmin);

                if($logout->status() == 204){

                    // Terminamos la sesion del usuario localmente: 
                    $_SESSION['status'] = self::$inactive;

                    // Redirigimos al usuario a la vista principal: 
                    return redirect()->route('home');

                }else{

                    // Obtenemos el contenido del error: 
                    $responseLogout = $logout->getOriginalContent();

                    // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                    $error = $responseLogout['error'];
                    return view('welcome', ['error' => $error]);
                }

            }else{
                // Redirigimos: 
                return redirect()->route('home');
            }
            
        }catch(Exception $e){
            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
    }

}
