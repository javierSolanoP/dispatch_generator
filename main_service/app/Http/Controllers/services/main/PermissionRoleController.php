<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\PermissionRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionRoleController extends Controller
{

    // Los permisos que se le asigna a cada usuario: 
    protected $permissions = ['crear', 'leer', 'eliminar'];

    // Metodo para retornar todos los registros de la DB: 
    public function index($user)
    {
        try{

            // Validamos que el usuario tenga el permiso requerido: 
            $validatePermission = $this->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permisos, validamos que tenga el permiso requerido: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[1]);

                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = DB::table('roles')

                                ->join('permission_roles', 'permission_roles.role_id', '=', 'roles.id_role')

                                ->join('permissions', 'permissions.id_permission', '=', 'permission_roles.permission_id')

                                ->select('permissions.permission_type as permission', 'roles.name as role')
                                
                                ->get()

                                ->groupBy('role');
                                

                    // Validamos que existan permisos para ese role: 
                    if(count($model) != 0){
        
                        // Retornamos la respuesta: 
                        return response(['query' => true, 'permissions' => $model]);
        
                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existen permisos para ese role'], 404);
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

    // Metodo para registrar el permiso de un role: 
    public function store(Request $request)
    {

        // Asignamos los datos recibidos: 
        $user = $request->input('user');
        $role_id = $request->input('role_id');
        $permission_id = $request->input('permission_id');

        // Validamos que no existan datos vacios: 
        if(!empty($user) 
        && !empty($role_id)
        && !empty($permission_id)){

            try{

                // Validamos que el usuario tenga el permiso requerido:
                $validatePermission = $this->show($user, $user);

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
                        $validateData = $validateClass->validateNumber(['role_id' => $role_id,
                                                                        'permission_id' => $permission_id]);

                        // Si el dato ha sido validado, validamos que no exista ese role en la DB: 
                        if($validateData['validate']){

                            // Realizamos la consulta en la DB: 
                            $model = PermissionRole::select('permission_id')
                                        
                                                    ->where('permission_id', $permission_id)

                                                    ->where('role_id', $role_id);

                            // Validamos si existe el permiso para el role: 
                            $validatePermission = $model->first();

                            // Si no existe, realizamos el registro: 
                            if(!$validatePermission){

                                // Registramos el permiso: 
                                PermissionRole::create(['role_id' => $role_id,
                                                        'permission_id' => $permission_id]);

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

    // Metodo para retornar los permisos de un usuario: 
    public function show($user, $userName)
    {
        try{
            
            // Realizamos la consulta en la DB: 
            $model = DB::table('users')

                        ->join('permission_roles', 'permission_roles.role_id', '=', 'users.role_id')

                        ->join('permissions', 'permissions.id_permission', '=', 'permission_roles.permission_id')

                        ->select('permissions.permission_type');
                

            // Validamos que el usuario que realiza la peticion, tenga el permiso requerido: 
            $validatePermission = $model->where('user_name', $user)->get();

            if(count($validatePermission) != 0){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($validatePermission, $this->permissions[1]);

                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = DB::table('users')

                                ->join('permission_roles', 'permission_roles.role_id', '=', 'users.role_id')

                                ->join('permissions', 'permissions.id_permission', '=', 'permission_roles.permission_id')

                                ->select('permissions.permission_type as permission');

                    $permissions = $model->where('user_name', $userName)->get();

                    // Validamos que existan permisos para ese role: 
                    if(count($permissions) != 0){
        
                        // Retornamos la respuesta: 
                        return response(['query' => true, 'role' => $permissions]);
        
                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existen permisos para ese role'], 404);
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

    // Metodo para eliminar el permiso de un role: 
    public function destroy($user, $role_id, $permission_id)
    {
        try{

            // Validamos que el usuario tenga el permiso requerido: 
            $validatePermission = $this->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permisos, validamos que tenga el permiso requerido: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[2]);

                // Validamos que tenga la autorizacion necesaria: 
                if($this->authorization){

                    // Realizamos la consulta a la DB: 
                    $model = PermissionRole::select('role_id', 'permission_id')

                                            ->where('role_id', $role_id)

                                            ->where('permission_id', $permission_id);

                    // Validamos que exista el permiso para el role: 
                    $validatePermissionRole = $model->first();

                    // Si existe, eliminamos el permiso para ese role: 
                    if($validatePermissionRole){

                        $model->delete();

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['delete' => false, 'error' => 'El role no tiene ese permiso'], 404);
                    }
                }else{
                    // Retornamos el error: 
                    return response(['delete' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['query' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
            }

        }catch(Exception $e){
            // Retornamos el error: 
            return response(['delete' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
