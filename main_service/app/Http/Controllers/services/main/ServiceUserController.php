<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\ServiceUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceUserController extends Controller
{
    // Los permisos que se le asigna a cada usuario: 
    protected $permissions = ['crear', 'leer', 'eliminar'];

    // Metodo para retornar todos los servicios de un usuario: 
    public function index($user, $userName)
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

                    // Realizamos la consulta a la DB: 
                    $model = DB::table('users')

                                ->join('service_users', 'service_users.user_id', '=', 'users.id_user')

                                ->join('services', 'services.id_service', '=', 'service_users.service_id')

                                ->select('services.name as service')

                                ->where('user_name', $userName)

                                ->get();

                    // Validamos que existan servicios para ese usuario: 
                    if(count($model) != 0){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'services' => $model], 200);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existen servicios asignados al usuario'], 404);
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

    // Metodo para asignar un servicio a un usuario: 
    public function store(Request $request, $user)
    {
        // Asignamos los datos recibidos: 
        $user_id = $request->input('user_id');
        $service_id = $request->input('service_id');

        // Validamos que no existan datos vacios: 
        if(!empty($user_id) && !empty($service_id)){

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

                        // Iteramos los datos recibidos, para validar que no sea un intento XSS
                        foreach($request->all() as $data){

                            // Validamos el dato: 
                            $validateXSS = stristr($data, '</script>');

                            // Si se encuentra el script, retornamos el error: 
                            if($validateXSS){
                                // Retornamos el error: 
                                return response(['register' => false, 'error' => 'Buen intento, pero no lo vas a lograr!'], 403);
                            }

                        }

                        // Instanciamos la clase 'Validate', para validar el tipo de dato: 
                        $validateClass = new Validate;

                        // Validamos el dato: 
                        $validateData = $validateClass->validateNumber(['user_id' => $user_id,
                                                                        'service_id' => $service_id]);

                        // Si el dato ha sido validado, validamos que no exista ese role en la DB: 
                        if($validateData['validate']){

                            // Realizamos la consulta en la DB: 
                            $model = ServiceUser::select('service_id')
                                        
                                                ->where('service_id', $service_id)

                                                ->where('user_id', $user_id);

                            // Validamos si existe el servicio para el role: 
                            $validateService = $model->first();

                            // Si no existe, realizamos el registro: 
                            if(!$validateService){

                                // Registramos el servicio: 
                                ServiceUser::create(['user_id' => $user_id,
                                                    'service_id' => $service_id]);

                                // Retornamos la respuesta: 
                                return response(['register' => true], 201);

                            }else{
                                // Retornamos el error: 
                                return response(['register' => false, 'error' => 'Ya se asigno ese servicio.'], 403); 
                            }

                        }else{
                            // Retornamos el error: 
                            return response(['register' => false, 'error' => $validateData['error']], 403);
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

    // Metodo para validar los servicios de un usuario: 
    public function show($user, $userName)
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

                    // Realizamos la consulta a la DB: 
                    $model = DB::table('users')

                                ->join('service_users', 'service_users.user_id', '=', 'users.id_user')

                                ->join('services', 'services.id_service', '=', 'service_users.service_id')

                                ->select('services.name as service')

                                ->where('user_name', $userName)

                                ->get();
                    
                    if(count($model) != 0){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'services' => $model], 200);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existen servicios asignados al usuario'], 404);
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

    // Metodo para eliminar un servicio de un usuario: 
    public function destroy($user, $userId, $serviceId)
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
                    $model = ServiceUser::select('id_service_user')
                                        ->where('user_id', $userId)
                                        ->where('service_id', $serviceId);

                    // Validamos que existan roles en la DB: 
                    $validateServiceUser = $model->first();

                    // Si existen, eliminamos el registro: 
                    if($validateServiceUser){

                        $model->delete();

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['delete' => false, 'error' => 'No existen servicios asignados al usuario.'], 404);
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
