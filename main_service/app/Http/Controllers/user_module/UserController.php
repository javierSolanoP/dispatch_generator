<?php

namespace App\Http\Controllers\user_module;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Metodo para retornar todos los usuarios de la entidad de la base de datos: 
    public function index()
    {
        try{
            // Realizamos la consulta de la entidad 'users': 
            $model = DB::table('users')

                        // Realizamos la consulta en la entidad 'roles':  
                        ->join('roles', 'roles.id_role', '=', 'users.role_id')

                        // Seleccionamos los campos que requerimos: 
                        ->select('users.name', 'users.last_name', 'users.email', 'users.user_name', 'roles.name as role')

                        // Obtenemos todos los registros: 
                        ->get();

            // Si existen registros, retornamos una respuesta: 
            if(count($model) != 0) {

                // Retornamos la respuesta: 
                return response(['query' => true, 'users' => $model]);

            }else{

                // Retornamos el error: 
                return response(['query' => false, 'error' => 'No existen usuarios en el sistema.', 404]);

            }

        }catch(Exception $e){
            
            // Retornamos el error: 
            return response(['query' => false, 'error' => $e->getMessage()], 500);
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
        //
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
