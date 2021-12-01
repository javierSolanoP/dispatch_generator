<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Metodo para retornar todos los roles de la DB: 
    public function index()
    {
        // Realizamos la consulta en la DB: 
        $model = Role::select('name');

        // Validamos que existan roles en la DB: 
        $validateRole = $model->get();

        // Si existen, los retornamos: 
        if(count($validateRole) != 0){

            // Retornamos la respuesta: 
            return response(['query' => true, 'roles' => $validateRole]);

        }else{
            // Retornamos el error: 
            return response(['query' => false, 'error' => 'No existen roles en el sistema.'], 404);
        }
    }

    // Metodo para registrar un role en la DB: 
    public function store(Request $request)
    {
        // Asignamos los datos recibidos: 
        $user = $request->input('user');
        $name = $request->input('name');

        // Validamos que no existan datos vacios: 
        if(!empty($user) && !empty($name)){

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user);

            // Si tiene permiso, validamos que no sea intento 'XSS': 
            if($validatePermission['query']){

                // Validamos que no sea un intento 'XSS': 
                $validateXSS = stristr($name, '</script>');

                // Si no lo es, validamos el dato: 
                if(!$validateXSS){

                }else{
                    // Retornamos el error: 
                    return response(['register' => false, 'error' => 'Buen intento, pero no lo vas a lograr!'], 403);
                }

            }else{
                // Retornamos el error: 
                return response(['register' => false, 'error' => $validatePermission['error'], 401]);
            }

        }else{
            // Retornamos el error: 
            return response(['register' =>  false, 'error' => 'No deben existir datos vacios'], 403);
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
