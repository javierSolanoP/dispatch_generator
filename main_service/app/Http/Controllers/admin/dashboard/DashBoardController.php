<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\admin\Home\HomeController;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    // Declaramos las propiedades de estado de sesion: 
    protected static $active = 'Activa';
    protected static $inactive = 'Inactiva';

    // Metodo para validar el estado de sesion: 
    public function index()
    {
        try{

            // Si existe el estado, lo enviamos a la vista 'dashboard':
            if($_SESSION['status'] == self::$active){

                if(isset($_SESSION['user'])
                && isset($_SESSION['services'])
                && isset($_SESSION['permissions'])){

                    // Asignamos el contenido de las sesiones: 
                    $user = $_SESSION['user'];
                    $services = $_SESSION['services'];

                    // Retornamos la vista 'dashboard': 
                    return view('dashboard.dashboard', ['user' => $user, 
                                                        'services' => $services]);
        
                }else{
                    // Retornamos la vista 'dashboard': 
                    return view('dashboard.dashboard');
                } 

            }else{

                // Redirigimos a la vista principal porque no ha iniciado sesion: 
                return redirect()->route('home');
            }

        }catch(Exception $e){
            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
        
    }

}
