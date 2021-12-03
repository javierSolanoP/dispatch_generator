<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\at;
use function Symfony\Component\String\s;

class RoleController extends Controller
{

    protected $permissions = ['crear', 'leer', 'actualizar', 'eliminar'];
    protected $authorization = false;

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

            try{
                // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
                $permissionRoleController = new PermissionRoleController;

                // Validamos que el usuario tenga el permiso requerido:
                $validatePermission = $permissionRoleController->show($user);

                $responseValidatePermission = $validatePermission->getOriginalContent();

                // Si tiene permiso, validamos que tenga permisos: 
                if($responseValidatePermission['query']){
                    
                    // Iteramos la matriz de respuesta de la validacion: 
                    foreach($responseValidatePermission['permissions'] as $permission){

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
