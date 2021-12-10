<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\Gender;
use Exception;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    // Los permisos que se le asigna a cada usuario: 
    protected $permissions = ['crear', 'leer', 'eliminar'];

    // Inicializamos la propiedad que define la autorizacion de una peticion: 
    protected $authorization = false;

    // Metodo para retornar todos los generos de la DB : 
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

                // Iteramos la matriz de respuesta de la validacion: 
                foreach($responseValidatePermission['role'] as $permission){

                    // Iteramos los arrays que contienen los permisos: 
                    foreach($permission as $value){

                        // Si posee el permiso, autorizamos:
                        if($value == $this->permissions[1]){
                            $this->authorization = true;
                        }
                    }
                }

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Gender::select('id_gender as id', 'gender');

                    // Validamos que existan generos en la DB: 
                    $validateGender = $model->get();

                    // Si existen, los retornamos: 
                    if(count($validateGender) != 0){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'genders' => $validateGender]);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existen generos en el sistema.'], 404);
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
            return response(['query' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Metodo para registrar un genero: 
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
                    
                    // Iteramos la matriz de respuesta de la validacion: 
                    foreach($responseValidatePermission['role'] as $permission){

                        // Iteramos los arrays que contienen los permisos: 
                        foreach($permission as $value){

                            // Si posee el permiso, autorizamos:
                            if($value == $this->permissions[0]){
                                $this->authorization = true;
                            }
                        }
                    }

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

                            // Si el dato ha sido validado, validamos que no exista ese genero en la DB: 
                            if($validateData['validate']){

                                // Realizamos la consulta en la DB: 
                                $model = Gender::select('name')->where('name', $name);

                                // Validamos el role: 
                                $valdiateRole = $model->first();

                                // Si no existe, realizamos el registro: 
                                if(!$valdiateRole){

                                    // Registramos el genero: 
                                    Gender::create(['gender' => $name]);

                                    // Retornamos la respuesta: 
                                    return response(['register' => true], 201);

                                }else{
                                    // Retornamos el error: 
                                    return response(['register' => false, 'error' => 'Ya existe ese genero en el sistema.'], 403); 
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
                        return response(['register' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                    }

                }else{
                    // Retornamos el error: 
                    return response(['register' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
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

    // Metodo para validar un registro: 
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

                // Iteramos la matriz de respuesta de la validacion: 
                foreach($responseValidatePermission['role'] as $permission){

                    // Iteramos los arrays que contienen los permisos: 
                    foreach($permission as $value){

                        // Si posee el permiso, autorizamos:
                        if($value == $this->permissions[1]){
                            $this->authorization = true;
                        }
                    }
                }

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Gender::select('id_gender')->where('id_gender', $id);

                    // Validamos que existan generos en la DB: 
                    $validateGender = $model->first();

                    // Si existen, los retornamos: 
                    if($validateGender){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'gender' => $validateGender]);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existe ese genero en el sistema.'], 404);
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

    // Metodo para eliminar un registro: 
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

                // Iteramos la matriz de respuesta de la validacion: 
                foreach($responseValidatePermission['role'] as $permission){

                    // Iteramos los arrays que contienen los permisos: 
                    foreach($permission as $value){

                        // Si posee el permiso, autorizamos:
                        if($value == $this->permissions[2]){
                            $this->authorization = true;
                        }
                    }
                }

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = Gender::select('id_gender')->where('id_gender', $id);

                    // Validamos que existan roles en la DB: 
                    $validateGender = $model->first();

                    // Si existen, eliminamos el registro: 
                    if($validateGender){

                        $model->delete();

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['delete' => false, 'error' => 'No existe ese genero en el sistema.'], 404);
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
