<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\admin\user_module\UserController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{

    // Metodo para inicializar una sesion: 
    public function sessionStart(){
        return session_start();
    }

    // Metodo para validar el estado de sesion: 
    public function index()
    {
        // $this->sessionStart();

        // ESTADO: 
        static $active = 'Activa';

        // Si existe el estado, lo enviamos a la vista 'dashboard':
        if($_SESSION['status'] == $active){

            if(isset($_SESSION['user'])){

                // Asignamos el contenido de la sesion 'user' a la variable 'data': 
                $data = $_SESSION['user'];
    
                // Retornamos la vista 'dashboard': 
                return view('dashboard.dashboard', ['data' => $data]);
    
            }else{
                // Retornamos la vista 'dashboard': 
                return view('dashboard.dashboard');
            } 

        }else{

            // Redirigimos a la vista principal porque no ha iniciado sesion: 
            return redirect()->route('home');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            // Retornamos el error: 
            return $logout;
        }
    }
}
