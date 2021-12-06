<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Los permisos que se le asigna a cada usaurio: 
    protected $permissions = ['crear', 'leer', 'actualizar', 'eliminar'];

    // Inicializamos la propiedad que define la autorizacion de una peticion: 
    protected $authorization = false;

    // Los estados de sesion: 
    protected static $status = ['activa' => 1, 'inactiva' => 2, 'pendiente' => 3];

    // Los avatar que se le asigna dependiendo el 'genero' de cada usuario:
    protected static $avatar_men = 'men.png';
    protected static $avatar_women = 'women.png'; 

    // Metodo para retornar todos los usuarios registrados en la DB: 
    public function index($id_role = null)
    {
        try{
            // Realizamos la consulta a la DB: 
            $model = DB::table('users')

                        ->join('roles', 'roles.id_role', '=', 'users.role_id')

                        ->join('genders', 'genders.id_gender', '=', 'users.gender_id')
                        
                        ->select(
                            'users.identification',
                            'users.user_name',
                            'users.name', 
                            'users.last_name',
                            'users.email',
                            'roles.name as role',
                            'genders.gender'
                        );

            // Si se recibe un role especifico, filtramos por el role solicitado: 
            if($id_role != null){
                // Con filtro:
                $users = $model->where('role_id', '=', $id_role)->get();
            }else{
                // Sin filtro: 
                $users = $model->get();
            }           

            // Validamos que existan usuarios registrados en la DB: 
            if(count($users) != 0){

                // Retornamos la respuesta: 
                return response(['query' => true, 'users' =>  $users], 200);

            }else{
                // Retornamos el error: 
                return response(['query' => false, 'error' => 'No existen usuarios en el sistema.'], 404);
            }

        }catch(Exception $e){
            // Retornamos el error: 
            return response(['query' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Metodo para registrar un usuario en la DB: 
    public function store(Request $request)
    {
        // Asignamos los datos recibidos: 
        $identification = $request->input('identification');
        $user = $request->input('user');
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
        && !empty($user)
        && !empty($userName)
        && !empty($name)
        && !empty($lastName)
        && !empty($email)
        && !empty($password)
        && !empty($confirmPassword)
        && !empty($role)
        && !empty($gender)){

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
                                                                                        'lastName' => $lastName
                                                                                    ]),
                                            'number' =>  $validateClass->validateNumber([
                                                                                            'identification' => $identification,
                                                                                            'role' => $role,
                                                                                            'gender' => $gender
                                                                                        ]),
                                            'email' => $validateClass->validateEmail(['email' => $email]),
                                            'password' => $validateClass->validatePassword($password, $confirmPassword)
                                        ];

                        foreach($validateData as $array){

                            if(isset($array['error'])){
                                // Retornamos el error: 
                                return ['register' => false, 'error' => $array['error']];
                            }
                        }

                        // Realizamos la consulta en la DB: 
                        $model = DB::table('users')

                                    ->select('user_name')

                                    ->where('identification', '=', $identification)

                                    ->orWhere('user_name', '=', $userName)

                                    ->orWhere('email', '=', $email)

                                    ->first();

                        // Si no existe, realizamos el registro: 
                        if(!$model){

                            if($gender == 1){
                                $avatar = self::$avatar_men;
                            }elseif($gender == 2){
                                $avatar = self::$avatar_women;
                            }

                            // Registramos el usuario: 
                            User::create([
                                            'identification' => $identification,
                                            'user_name' => $userName,
                                            'name' => $name,
                                            'last_name' => $lastName,
                                            'email' => $email,
                                            'password' => bcrypt($password),
                                            'avatar' => $avatar,
                                            'role_id' => $role,
                                            'session_id' => self::$status['inactiva'],
                                            'gender_id' => $gender
                                        ]);

                            // Retornamos la respuesta: 
                            return response(['register' => true], 201);

                        }else{
                            // Retornamos el error: 
                            return response(['register' => false, 'error' => 'Ya existe ese usuario en el sistema.'], 403); 
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
