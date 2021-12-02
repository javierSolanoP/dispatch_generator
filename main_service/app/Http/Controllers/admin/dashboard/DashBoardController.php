<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\admin\user_module\ServiceUserController;
use App\Http\Controllers\admin\user_module\UserController;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    // Metodo para validar el estado de sesion: 
    public function index()
    {
        // ESTADO: 
        static $active = 'Activa';

        // Si existe el estado, lo enviamos a la vista 'dashboard':
        if($_SESSION['status'] == $active){

            if(isset($_SESSION['user'])){

                // Asignamos el contenido de la sesion 'user' a la variable 'data': 
                $user = $_SESSION['user'];

                // Instanciamos el controlador del modelo 'ServiceUser', para extraer los servicios habilitados para el usuario: 
                $serviceController = new ServiceUserController;

                try{
                    // Validamos que existan servicios habilitados: 
                    $validateService = $serviceController->show($user['id']);

                    // Si existen, los enviamos a la vista 'dashboard': 
                    if($validateService['query']){

                        // Asignamos a la sesion 'services', los servicios extraidos: 
                        $_SESSION['services'] =  $validateService['services'];

                        // Asignamos a la variable 'services', los servicios extraidos:
                        $services = $validateService['services'];

                        // Retornamos la vista 'dashboard': 
                        return view('dashboard.dashboard', ['user' => $user, 'services' => $services]);

                    }else{
                    
                        // Retornamos la vista 'dashboard': 
                        return view('dashboard.dashboard', ['user' => $user]);
                    }
                }catch(Exception $e){
                    // Redirigimos a la vista de error '500': 
                    return view('error.500');
                }
    
            }else{
                // Retornamos la vista 'dashboard': 
                return view('dashboard.dashboard');
            } 

        }else{

            // Redirigimos a la vista principal porque no ha iniciado sesion: 
            return redirect()->route('home');
        }
        
    }

    public function show($id)
    {
        //
    }

    // Metodo para cerrar sesion: 
    public function logout()
    {       
        // ESTADO: 
        static $inactive = 'Inactiva';

        // Asignamos a la variable 'user' el contenido de la sesion 'user': 
        $user = $_SESSION['user'];

        // Instanciamos el controlador del modelo 'User' para actualizar el estado de sesion: 
        $userController = new UserController;

        // Enviamos la solicitud al controlador: 
        $logout = $userController->updateSession($user['user_name'], $inactive);

        // Si se actualizó correctamente, redirigimos al usuario a la vista principal: 
        if($logout['update']){

            // Cambiamos el estado de la sesion: 
            $_SESSION['status'] = $inactive;

            // Redirigimos al usuario: 
            return redirect()->route('home');

        }else{

            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
    }
}
