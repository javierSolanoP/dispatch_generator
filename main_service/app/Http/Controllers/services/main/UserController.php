<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $permissions = ['crear', 'leer', 'actualizar', 'eliminar'];
    protected $authorization = false;

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
        // Asignamos los datos recibidos: 
        $identification = $request->input('identification');
        $userName = $request->input('userName');
        $name = $request->input('name');
        $lastName = $request->input('lastName');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmPassword');
        $role = $request->input('role');
        $gender = $request->input('gender');

        // Validamos que no existan datos vacios: 
        if(!empty($identification)
        && !empty($userName)
        && !empty($name)
        && !empty($lastName)
        && !empty($email)
        && !empty($password)
        && !empty($confirmPassword)
        && !empty($role)
        && !empty($gender)){

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($userName);

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

                    // Validamos los datos: 
                    $validateData = [
                                        'text' => $validateClass->validateText([
                                                                                    'name' => $name,
                                                                                    'lastName' => $lastName,
                                                                                    'role' => $role,
                                                                                    'gender' => $gender
                                                                                ]),
                                        'number' =>  $validateClass->validateNumber([$identification]),
                                        'email' => $validateClass->validateEmail(['email' => $email]),
                                        'password' => $validateClass->validatePassword($password, $confirmPassword)
                                    ];

                    foreach($validateData as $array){

                        if(isset($array['error'])){
                            // Retornamos el error: 
                            return ['register' => false, 'error' => $array['error']];
                        }
                    }

                    return $validateData;

                    // Si el dato ha sido validado, validamos que no exista ese role en la DB: 
                    if($validateData['validate']){

                        try{

                            // Realizamos la consulta en la DB: 
                            $model = User::select('name')->where('name', $name);

                            // Validamos el role: 
                            $validateRole = $model->first();

                            // Si no existe, realizamos el registro: 
                            if(!$validateRole){

                                try{

                                    // Registramos el role: 
                                    User::create(['name' => $name]);

                                    // Retornamos la respuesta: 
                                    return response(['register' => true], 201);

                                }catch(Exception $e){
                                    // Retornamos el error: 
                                    return response(['register' => false, 'error' => $e->getMessage()], 500);
                                }

                            }else{
                                // Retornamos el error: 
                                return response(['register' => false, 'error' => 'Ya existe ese role en el sistema.'], 403); 
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
                    return response(['register' => false, 'error' => 'No tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['register' => false, 'error' => $responseValidatePermission['error']], 401);
            }

        }else{
            // Retornamos el error: 
            return response(['register' => false, 'error' => "No pueden existir campos vacios"]);
        }
    }

    /**
     * idsplay the specified resource.
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
