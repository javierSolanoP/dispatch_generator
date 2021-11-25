<?php

namespace App\Http\Controllers\admin\user_module;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

session_start();

class UserController extends Controller
{

    public function index()
    {
        // Si no existe un estado de sesion, retornamos la vista principal:
        if(isset($_SESSION['status'])){

            // Si el estado de la sesion es 'Activa', redirigimos directamente a la ruta 'dashboard': 
            if($_SESSION['status'] == 'Activa'){

                // Regirigimos: 
                return redirect()->route('dashboard');
            }

        }else{
            // Retornamos la vista principal: 
            return view('welcome');
        }
    }

    public function store(Request $request)
    {
        try{
            // Realizamos la consulta a la entidad de la DB: 
            $model = DB::table('users')
                        ->join('roles', 'roles.id_role', '=', 'users.role_id')
                        ->join('sessions', 'sessions.id_session', '=', 'users.session_id')
                        ->select('users.user_name', 'users.password', 'users.name', 'users.last_name', 'users.password','roles.name as role', 'sessions.type_of_session as status')
                        ->where('user_name', $request->input('user'));

            // Validamos que exista el usuario en la DB: 
            $validateUser = $model->first();

            // Si existe, validamos el hash con la password ingresada: 
            if($validateUser){

                // Verificamos el hash: 
                $verifyPassword = password_verify($request->input('password'), $validateUser->password);

                // Si coincide, validamos el estado de sesion: 
                if($verifyPassword){

                    // Declaramos la variable 'statusSession' con el estado de sesion: 
                    $statusSession = $validateUser->status;

                    // Si el estado de la sesion es 'Activa' o 'Inactiva', concedemos acceso al sistema: 
                    if(($statusSession == 'Activa') || ($statusSession == 'Inactiva')){

                        // Si el estado de la sesion es 'Activa': 
                        if($statusSession == 'Activa'){
                            // Asignamos la sesion 'status', para que el usuario no deba autenticarse de nuevo: 
                            $_SESSION['status'] = $statusSession;
                        }

                        // Redirigimos al usuario a la vista de dashboard y enviamos sus datos a la vista: 
                        $user_name = $validateUser->user_name;
                        
                        return redirect()->route('dashboard', ['view' => strrev($user_name)]);

                    }else{

                        // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                        $error = 'Usted solicitó un restablecimiento de contraseña';
                        return view('welcome', ['error' => $error]);
                    }

                }else{

                    // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                    $error = 'Contraseña incorrecta';
                    return view('welcome', ['error' => $error]);
                }

            }else{

                // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                $error = 'No existe ese usuario en el sistema.';
                return view('welcome', ['error' => $error]);
            }
        }catch(Exception $e){
            // Redirigimos a la vista de error '500': 
            return view('error.500');
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
