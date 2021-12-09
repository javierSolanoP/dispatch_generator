<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionRoleController extends Controller
{
    // Metodo para retornar todos los registros de la DB: 
    public function index()
    {
        //
    }

    // Metodo para registrar el permiso de un role: 
    public function store(Request $request)
    {
        //
    }

    // Metodo para retornar los permisos de un role: 
    public function show($user)
    {
        try{
            // Realizamos la consulta en la DB: 
            $model = DB::table('users')

                        ->join('permission_roles', 'permission_roles.role_id', '=', 'users.role_id')

                        ->join('permissions', 'permissions.id_permission', '=', 'permission_roles.permission_id')

                        ->select('permissions.permission_type')

                        ->where('user_name', $user)

                        ->get();

            // Validamos que existan permisos para ese role: 
            if(count($model) != 0){

                // Retornamos la respuesta: 
                return response(['query' => true, 'permissions' => $model]);

            }else{
                // Retornamos el error: 
                return response(['query' => false, 'error' => 'No existen permisos para ese role'], 404);
            }

        }catch(Exception $e){
            // Retornamos el error: 
            return response(['query' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Metodo para eliminar el permiso de un role: 
    public function destroy($id)
    {
        //
    }
}
