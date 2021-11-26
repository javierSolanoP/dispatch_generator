<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\Controller;

class MonthlyPaymentController extends Controller
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

                // Si existen, los enviamos a la vista 'dashboard': 
                if(isset($_SESSION['services'])){

                    // Asignamos a la variable 'services', los servicios extraidos: 
                    $services =  $_SESSION['services'];

                    // Retornamos la vista 'monthly_payments': 
                    return view('dashboard.monthly_payments', ['user' => $user, 'services' => $services]);

                }else{
                
                    // Retornamos la vista 'monthly_payments': 
                    return view('dashboard.monthly_payments', ['user' => $user]);
                }
    
            }

        }else{

            // Redirigimos a la vista principal porque no ha iniciado sesion: 
            return redirect()->route('home');
        }
        
    }

}
