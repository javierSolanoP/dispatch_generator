<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    // Los permisos que se le asigna a cada usuario: 
    protected $permissions = ['crear', 'leer', 'eliminar'];

    // Metodo para retornar todos los roles de la DB: 
    public function index($user)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permisos, validamos que tenga el permiso requerido: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[1]);

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Role::select('id_role as id', 'name as role');

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

                }else{
                    // Retornamos el error: 
                    return response(['query' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['query' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
            }
            
        }catch(Exception $e){
            // Retornamos el error: 
            return response(['query' =>  false, 'error' => $e->getMessage()], 500);
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

            try{
                // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
                $permissionRoleController = new PermissionRoleController;

                // Validamos que el usuario tenga el permiso requerido:
                $validatePermission = $permissionRoleController->show($user, $user);

                $responseValidatePermission = $validatePermission->getOriginalContent();

                // Si tiene permiso, validamos que tenga permisos: 
                if($responseValidatePermission['query']){
                    
                    // Si tiene el permiso, autorizamos: 
                    $this->validatePermission($responseValidatePermission['role'], $this->permissions[0]);

                    // Validamos que tenga la autorizacion necesaria: 
                    if($this->authorization){

                        // Validamos que no sea un intento 'XSS': 
                        $validateXSS = stristr($name, '</script>');

                        // Si no lo es, validamos el dato: 
                        if(!$validateXSS){

                            // Instanciamos la clase 'Validate', para validar el tipo de dato: 
                            $validateClass = new Validate;

                            // Validamos el dato: 
                            $validateData = $validateClass->validateText(['name' => $name]);

                            // Si el dato ha sido validado, validamos que no exista ese role en la DB: 
                            if($validateData['validate']){

                                // Realizamos la consulta en la DB: 
                                $model = Role::select('name')->where('name', $name);

                                // Validamos el role: 
                                $valdiateRole = $model->first();

                                // Si no existe, realizamos el registro: 
                                if(!$valdiateRole){

                                    // Registramos el role: 
                                    Role::create(['name' => $name]);

                                    // Retornamos la respuesta: 
                                    return response(['register' => true], 201);

                                }else{
                                    // Retornamos el error: 
                                    return response(['register' => false, 'error' => 'Ya existe ese role en el sistema.'], 403); 
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
                        return response(['register' => false, 'error' => 'No tiene autorizacion para realizar esta peticion'], 401);
                    }

                }else{
                    // Retornamos el error: 
                    return response(['register' => false, 'error' => $responseValidatePermission['error']], 401);
                }

            }catch(Exception $e){
                // Retornamos el error: 
                return response(['register' => false, 'error' => $e->getMessage()], 500);
            }

        }else{
            // Retornamos el error: 
            return response(['register' =>  false, 'error' => 'No deben existir datos vacios'], 403);
        }

    }

    // Metodo para validar si existe un role: 
    public function show($user, $id)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permisos, validamos que tenga el permiso requerido: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[1]);

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Role::select('id_role')->where('id_role', $id);

                    // Validamos que existan roles en la DB: 
                    $validateRole = $model->first();

                    // Si existen, los retornamos: 
                    if($validateRole){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'role' => $validateRole]);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existe ese role en el sistema.'], 404);
                    }

                }else{
                    // Retornamos el error: 
                    return response(['query' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['query' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
            }
            
        }catch(Exception $e){
            // Retornamos el error: 
            return response(['query' =>  false, 'error' => $e->getMessage()], 500);
        }

    }

    // Metodo para eliminar el registro de un role: 
    public function destroy($user, $id)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permisos, validamos que tenga el permiso requerido: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[2]);

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Role::select('id_role')->where('id_role', $id);

                    // Validamos que existan roles en la DB: 
                    $validateRole = $model->first();

                    // Si existen, eliminamos el registro: 
                    if($validateRole){

                        $model->delete();

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['delete' => false, 'error' => 'No existe ese role en el sistema.'], 404);
                    }

                }else{
                    // Retornamos el error: 
                    return response(['delete' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['delete' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
            }
            
        }catch(Exception $e){
            // Retornamos el error: 
            return response(['delete' =>  false, 'error' => $e->getMessage()], 500);
        }

    }

}
