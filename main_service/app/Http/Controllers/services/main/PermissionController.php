<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;

class PermissionController extends Controller
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

    // Metodo para registrar un permiso en la DB: 
    public function store(Request $request)
    {
        // Asignamos los datos recibidos: 
        $user = $request->input('user');
        $permission_type = $request->input('permission_type');

        // Validamos que no existan datos vacios: 
        if(!empty($user) && !empty($permission_type)){

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user);

            // Si tiene permiso, validamos que no sea intento 'XSS': 
            if($validatePermission['query']){

                // Validamos que no sea un intento 'XSS': 
                $validateXSS = stristr($permission_type, '</script>');

                // Si no lo es, validamos el dato: 
                if(!$validateXSS){

                    // Instanciamos la clase 'Validate', para validar el tipo de dato: 
                    $validateClass = new Validate;

                    // Validamos el dato: 
                    $validateData = $validateClass->validateText(['permission_type' => $permission_type]);

                    // Si el dato ha sido validado, validamos que no exista ese role en la DB: 
                    if($validateData['validate']){

                        try{

                            // Realizamos la consulta en la DB: 
                            $model = Permission::select('permission_type')->where('permission_type', $permission_type);

                            // Validamos el role: 
                            $valdiateRole = $model->first();

                            // Si no existe, realizamos el registro: 
                            if(!$valdiateRole){

                                try{

                                    // Registramos el role: 
                                    Permission::create(['permission_type' => $permission_type]);

                                    // Retornamos la respuesta: 
                                    return response(['register' => true]);

                                }catch(Exception $e){
                                    // Retornamos el error: 
                                    return response(['register' => false, 'error' => $e->getMessage()], 500);
                                }

                            }else{
                                // Retornamos el error: 
                                return response(['register' => false, 'error' => 'Ya existe ese permiso en el sistema.'], 403); 
                            }

                        }catch(Exception $e){
                            // Retornamos el error: 
                            return response(['register' => false, 'error' => $e->getMessage()], 500);
                        }

                    }else{
                        // Retornamos el error: 
                        return response(['register' => false, 'error' => $validateData['error']], 403);
                    }

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

    // Metodo para validar que exista un permiso en el sistema: 
    public function show($permission_type)
    {
        // Realizamos la consulta en la DB: 
        $model = Permission::select('permission_type')->where('permission_type', $permission_type);

        // Validamos que exista el permiso: 
        $validatePermission = $model->first();

        // Si existe, retornamos la respuesta: 
        if($validatePermission){

            // Retornamos la respuesta: 
            return response(['query' => true]);

        }else{
            // Retornamos el error: 
            return response(['query' => false, 'error' => 'No existe ese permiso en el sistema'], 404);
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
