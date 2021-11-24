<?php

namespace App\Http\Controllers\admin\user_module;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

                    // Redirigimos al usuario a la vista de dashboard y enviamos sus datos a la vista: 
                    $data = ['name' => $validateUser->name, 'status' => $validateUser->status];
                    return ['login' => true, 'user' => $data];

                }else{

                    // Redirigimos al usuario a la vista principal e imprimimos el error en pantalla: 
                    $error = 'Usted solicitó un restablecimiento de contraseña';
                    return route('/', ['error', $error]);
                }


                return "Ingresado satisfactoriamente";
            }else{
                return "Contrasenia incorrecta";
            }

        }else{
            return "No existe ese usuario en el sistema.";
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
