<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        // Realizamos la consulta en la DB: 
        $model = DB::table('users')

                    ->where('user_name', $user)

                    ->join('permission_roles', 'permission_roles.role_id', '=', 'users.role_id')

                    ->join('permissions', 'permissions.id_permission', '=', 'permission_roles.permission_id')

                    ->select('permissions.permission_type')

                    ->get();

        // Validamos que existan permisos para ese role: 
        if(count($model) != 0){

            // Retornamos la respuesta: 
            return response(['query' => true, 'permissions' => $model]);

        }else{
            // Retornamos el error: 
            return response(['query' => false, 'error' => 'No existen permisos para ese role'], 404);
        }
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
