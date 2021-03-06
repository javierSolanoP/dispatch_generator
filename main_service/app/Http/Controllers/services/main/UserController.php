<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\services\main\validate\Validate;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\s;

class UserController extends Controller
{
    // Los permisos que se le asigna a cada usuario: 
    protected $permissions = ['crear', 'leer', 'actualizar', 'eliminar'];

    // Los estados de sesion: 
    protected static $status = ['activa' => 1, 'inactiva' => 2, 'pendiente' => 3];

    // Los avatar que se le asigna dependiendo el 'genero' de cada usuario:
    protected static $avatar_men = 'men.png';
    protected static $avatar_women = 'women.png';
    
    // ESTADOS DE SESION: 
    // Declaramos las propiedades que describen los tipos de estados: 
    protected $inactive = 'Inactiva';
    protected $active   = 'Activa';
    protected $pending  = 'Pendiente';

    // Metodo para retornar todos los usuarios registrados en la DB: 
    public function index($user, $roleId = null)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permiso, validamos que tenga permisos: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[1]);

                if($this->authorization){

                    // Realizamos la consulta a la DB: 
                    $model = DB::table('users')

                                ->join('roles', 'roles.id_role', '=', 'users.role_id')

                                ->join('genders', 'genders.id_gender', '=', 'users.gender_id')
                                
                                ->select(
                                    'users.identification',
                                    'users.user_name as user',
                                    'users.name', 
                                    'users.last_name as lastName',
                                    'users.email',
                                    'roles.name as role',
                                    'genders.gender'
                                );

                    // Si se recibe un role especifico, filtramos por el role solicitado: 
                    if($roleId != null){
                        // Con filtro:
                        $users = $model->where('role_id', '=', $roleId)->get();
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

    // Metodo para registrar un usuario en la DB: 
    public function store(Request $request, $user)
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
                        foreach($request->all() as $value){

                            // Validamos el dato: 
                            $validateXSS = stristr($value, '</script>');

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
                    return response(['register' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
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

    // Metodo para actualizar el estado de session: 
    public function updateSession($userName, $status)
    {
        try{

            // Realizamos la consulta a la DB: 
            $modelUser = User::select('session_id')->where('user_name', $userName);

            // Validamos que exista ese estado: 
            $validateSession = $modelUser->first();

            // Si existe, actualizamos el estado: 
            if($validateSession){

                // Realizamos la consulta a la entidad 'Session' de la DB: 
                $modelSession = DB::table('sessions')->select('id_session')
                                    
                                    ->where('type_of_session', $status);

                // Validamos que exista el estado: 
                $validateSession = $modelSession->first();

                // Si existe, actualizamos el estado: 
                if($validateSession){

                    $modelUser->update(['session_id' => $validateSession->id_session]);

                    // Retornamos la respuesta: 
                    return ['update' => true];

                }else{
                    // Retornamos el error: 
                    return ['update' => false, 'error' => 'No existe ese estado de sesion en el sistema'];
                }

            }else{
                // Retornamos el error: 
                return ['update' => false, 'error' => 'No existe ese usuario en el sistema'];
            }

        }catch(Exception $e){
            // Retornamos el error: 
            return ['update' => false, 'error' => $e->getMessage()];
        }
    }

    // Metodo para iniciar sesion: 
    public function login(Request $request, $user)
    {
        // Asignamos los datos recibidos: 
        $userName = $request->input('userName');
        $password = $request->input('password');

        // Validamos que no existan datos vacios: 
        if(!empty($userName) && !empty($password)){

            try{

                // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
                $permissionRoleController = new PermissionRoleController;
    
                // Validamos que el usuario tenga el permiso requerido:
                $validatePermission = $permissionRoleController->show($user, $user);
    
                $responseValidatePermission = $validatePermission->getOriginalContent();
    
                // Si tiene permiso, validamos que tenga permisos: 
                if($responseValidatePermission['query']){
    
                    // Si tiene el permiso, autorizamos: 
                    $this->validatePermission($responseValidatePermission['role'], $this->permissions[2]);
    
                    if($this->authorization){

                        // Realizamos la consulta a la DB: 
                        $model = DB::table('users')->select('password', 'session_id')->where('user_name', $userName);

                        // Validamos que exista el usuario: 
                        $validateUser = $model->first();

                        // Si existe, validamos el hash almacenado en la DB y la password ingresada: 
                        if($validateUser){

                            // Instanciamos la clase 'Validate', para validar: 
                            $validateClass = new Validate; 

                            // Validamos el hash y la password: 
                            $validate = $validateClass->validateHash($validateUser->password, $password);

                            // Si coinciden, actualizamos el estado de sesion: 
                            if($validate['validate']){

                                // Actualizamos el estado de sesion:
                                $updateSession = $this->updateSession($userName, $this->active);

                                if($updateSession['update']){

                                    // Instanciamos los controladores 'PermissionRole' y 'ServiceUser': 
                                    $permissionRoleController = new PermissionRoleController;
                                    $serviceUserController    = new ServiceUserController;

                                    // Asignamos el contenido de las respuestas:
                                    $responseUser            = DB::table('users')->join('sessions', 'sessions.id_session', '=', 'users.session_id')

                                                                ->select(
                                                                            'users.user_name as user',
                                                                            'users.email',
                                                                            'users.avatar',
                                                                            'sessions.type_of_session as status'
                                                                        )
                                                                    
                                                                ->where('user_name', '=', $userName)->first();

                                    $responserPermissionRole = $permissionRoleController->show(self::$userAdmin, $userName)->getOriginalContent();
                                    $responseServiceUser     = $serviceUserController->show(self::$userAdmin, $userName)->getOriginalContent();
                                    
                                    // Retornamos la respuesta: 
                                    return response(['login' => true, 
                                                     'content' => ['user' => $responseUser, 
                                                                   'services' => $responseServiceUser['services'], 
                                                                   'permissions' => $responserPermissionRole['role']]], 200);

                                }else{
                                    // Retornamos el error: 
                                    return response(['login' => false, 'error' => $updateSession['error']], 403);
                                }
                                
                            }else{
                                // Retornamos el error: 
                                return response(['login' => false, 'error' => 'Contrase??a incorrecta'], 403);
                            }

                        }else{
                            // Retornamos el error: 
                            return response(['login' => false, 'error' => 'No existe ese usuario en el sistema'], 404);
                        }
    
                    }else{
                        // Retornamos el error: 
                        return response(['login' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                    }
    
                }else{
                    // Retornamos el error: 
                    return response(['login' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
                }
    
            }catch(Exception $e){
                // Retornamos el error: 
                return response(['login' => false, 'error' => $e->getMessage()], 500);
            }

        }else{
            // Retornamos el error: 
            return response(['login' => false, 'error' => 'No pueden existir datos vacios'], 403);
        }
    }

    // Metodo para terminar sesion: 
    public function logout(Request $request, $user)
    {
        // Asignamos los datos recibidos: 
        $userName = $request->input('userName');

        // Validamos que no exista dato vacio: 
        if(!empty($userName)){

            try{

                // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
                $permissionRoleController = new PermissionRoleController;
    
                // Validamos que el usuario tenga el permiso requerido:
                $validatePermission = $permissionRoleController->show($user, $user);
    
                $responseValidatePermission = $validatePermission->getOriginalContent();
    
                // Si tiene permiso, validamos que tenga permisos: 
                if($responseValidatePermission['query']){
    
                    // Si tiene el permiso, autorizamos: 
                    $this->validatePermission($responseValidatePermission['role'], $this->permissions[2]);
    
                    if($this->authorization){

                        // Realizamos la consulta a la DB: 
                        $model = DB::table('users')->select('session_id')->where('user_name', $userName);

                        // Validamos que exista el usuario: 
                        $validateUser = $model->first();

                        // Si existe, actualizamos el estado de sesion:
                        if($validateUser){

                            // Actualizamos el estado de sesion:
                            $updateSession = $this->updateSession($userName, $this->inactive);

                            if($updateSession['update']){

                                // Retornamos la respuesta: 
                                return response()->noContent();

                            }else{
                                // Retornamos el error: 
                                return response(['logout' => false, 'error' => $updateSession['error']], 403);
                            }

                        }else{
                            // Retornamos el error: 
                            return response(['logout' => false, 'error' => 'No existe ese usuario en el sistema'], 404);
                        }
    
                    }else{
                        // Retornamos el error: 
                        return response(['logout' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                    }
    
                }else{
                    // Retornamos el error: 
                    return response(['logout' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
                }
    
            }catch(Exception $e){
                // Retornamos el error: 
                return response(['logout' => false, 'error' => $e->getMessage()], 500);
            }

        }else{
            // Retornamos el error: 
            return response(['logout' => false, 'error' => 'No pueden existir datos vacios'], 403);
        }
    
    }

    // Metodo para retornar la informacion de un usuario registrado en la DB: 
    public function show($user, $identification = null)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permiso, validamos que tenga permisos: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[1]);

                if($this->authorization){

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
                                )
                                
                                ->where('identification', '=', $identification)->first();

                    // Validamos que exista el registro en la DB: 
                    if($model){

                        // Retornamos la respuesta: 
                        return response(['query' => true, 'user' => $model], 200);

                    }else{
                        // Retornamos el error: 
                        return response(['query' => false, 'error' => 'No existe ese usuario en el sistema'], 404);
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

    // Metodo para actualizar el registro de un usuario en la DB: 
    public function update(Request $request, $user)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permiso, validamos que tenga permisos: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[2]);

                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = User::select('identification')->where('identification', $request->input('identification'));

                    // Validamos que exista el registro: 
                    $validateUser = $model->first();

                    // Si existe, actualizamos el registro: 
                    if($validateUser){

                        // Declaramos el array 'data', para almacenar los datos ingresados: 
                        $data = [];

                        // Iteramos el array que contiene los datos recibidos: 
                        foreach($request->all() as $input => $value){
    
                            // Validamos que no existan datos vacios: 
                            if(!empty($value)){

                                // Validamos el dato: 
                                $validateXSS = stristr($value, '</script>');

                                // Si se encuentra el script, retornamos el error: 
                                if($validateXSS){

                                    // Retornamos el error: 
                                    return response(['update' => false, 'error' => 'Buen intento, pero no lo vas a lograr!'], 403);
                                
                                // Validamos si la clave pertene al usuario que realiza la peticion o si se trata de la 'identificacion' del registro a actualizar:     
                                }elseif(($input == 'user') || ($input == 'identification')){

                                    // Continuamos a la siguiente iteracion: 
                                    continue;
                                
                                // Validamos si el dato contiene caracteres de tipo mayusculas: 
                                }elseif(preg_match("/[N]/", $input)){

                                    // Reemplazamos la notacion 'camelCase' por 'snake_case': 
                                    $data[str_replace('N', '_n', $input)] = $value;

                                }else{

                                    // Validamos si la clave corresponde a una 'password': 
                                    if($input == 'password'){
                                        
                                        // Encriptamos el contenido de la 'password': 
                                        $data[$input] = bcrypt($value);
                                    
                                    }else{

                                        // Almacenamos los datos que no esten vacios: 
                                        $data[$input] = $value;
                                    }
                                }
                            }
                        }

                        // Actualizamos el registro con los datos recibidos: 
                        $model->update($data);

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['update' => false, 'error' => 'No existe ese usuario en el sistema'], 404);
                    }

                }else{
                    // Retornamos el error: 
                    return response(['update' => false, 'error' => 'Usted no tiene autorizacion para realizar esta peticion'], 401);
                }

            }else{
                // Retornamos el error: 
                return response(['update' => false, 'error' => 'Usted no tiene permisos para realizar esta peticion'], 401);
            }

        }catch(Exception $e){
            // Retornamos el error: 
            return response(['update' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($user, $identification = null)
    {
        try{

            // Instanciamos el controlador del modelo 'PermissionRole', para validar que el usuario tenga el permiso requerido: 
            $permissionRoleController = new PermissionRoleController;

            // Validamos que el usuario tenga el permiso requerido:
            $validatePermission = $permissionRoleController->show($user, $user);

            $responseValidatePermission = $validatePermission->getOriginalContent();

            // Si tiene permiso, validamos que tenga permisos: 
            if($responseValidatePermission['query']){

                // Si tiene el permiso, autorizamos: 
                $this->validatePermission($responseValidatePermission['role'], $this->permissions[3]);

                if($this->authorization){

                    // Realizamos la consulta en la DB: 
                    $model = User::select('identification')->where('identification', $identification);

                    // Validamos que se encuentre registrado el usuario: 
                    $validateUser = $model->first(); 

                    // Si existe, eliminamos el registro: 
                    if($validateUser){

                        // Eliminamos el registro: 
                        $model->delete();

                        // Retornamos la respuesta: 
                        return response()->noContent();

                    }else{
                        // Retornamos el error: 
                        return response(['delete' => false, 'error' => 'No existe ese usuario en el sistema'], 404);
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
            return response(['delete' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
