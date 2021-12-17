<?php

use App\Http\Controllers\services\main\ServiceUserController;
use App\Http\Controllers\services\main\GenderController;
use App\Http\Controllers\services\main\PermissionController;
use App\Http\Controllers\services\main\PermissionRoleController;
use App\Http\Controllers\services\main\RoleController;
use App\Http\Controllers\services\main\ServiceController;
use App\Http\Controllers\services\main\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// CONTROLADOR DE USUARIOS: 
// Ruta para retornar todos los usuarios: 
Route::get('/role/users/v1/{user}/{roleId?}', [UserController::class, 'index']);

// Ruta para retornar un usuario especifico: 
Route::get('/users/v1/{user}/{identification}', [UserController::class, 'show']);

// Ruta para iniciar sesion: 
Route::post('/users/login/v1/{user}', [UserController::class, 'login']);

// Ruta para terminar sesion: 
Route::post('/users/logout/v1/{user}', [UserController::class, 'logout']);

// Ruta para registrar un usuario: 
Route::post('/users/v1/{user}', [UserController::class, 'store']);

// Ruta para actualizar el registro de un usuario: 
Route::put('/users/v1/{user}/{identification}', [UserController::class, 'update']);

// Ruta para eliminar un usuario: 
Route::delete('/users/v1/{user}/{identification}', [UserController::class, 'destroy']);


// CONTROLADOR DE ROLES: 
// Ruta para retornar todos los roles: 
Route::get('/roles/v1/{user}', [RoleController::class, 'index']);

// Ruta para validar si existe un role: 
Route::get('/validate/roles/v1/{user}/{id}', [RoleController::class, 'show']);

// Ruta para registrar un role: 
Route::post('/roles/v1/{user}', [RoleController::class, 'store']);

// Ruta para eliminar un role: 
Route::delete('/roles/v1/{user}/{id}', [RoleController::class, 'destroy']);


// CONTROLADOR DE GENEROS:
// Ruta para retoranar todos los generos:  
Route::get('/genders/v1/{user}', [GenderController::class, 'index']);

// Ruta para validar si existe un genero:
Route::get('/validate/genders/v1/{user}/{id}', [GenderController::class, 'show']);

// Ruta para registrar un role: 
Route::post('/genders/v1/{user}', [GenderController::class, 'store']);

// Ruta para eliminar un genero: 
Route::delete('/genders/v1/{user}/{id}', [GenderController::class, 'destroy']);


// CONTROLADOR DE PERMISOS: 
// Ruta para retornar todos los permisos: 
Route::get('/permissions/v1/{user}', [PermissionController::class, 'index']);

// Ruta para validar si existe un permiso: 
Route::get('/validate/permissions/v1/{user}/{id}', [PermissionController::class, 'show']);

// Ruta para eliminar un permiso: 
Route::delete('/permissions/v1/{user}/{id}', [PermissionController::class, 'destroy']);


// CONTROLADOR DE ROLES Y PERMISOS: 
// Ruta para retoranar todos los permisos de cada role
Route::get('/permissions-roles/v1/{user}', [PermissionRoleController::class, 'index']);

// Ruta para retornar todos los permisos de un usuario: 
Route::get('/permissions-roles/v1/{user}/{userName}', [PermissionRoleController::class, 'show']);

// Ruta para registrar el permiso de un role: 
Route::post('/permissions-roles/v1/{user}', [RoleController::class, 'store']);

// Ruta para eliminar el permiso de un role: 
Route::delete('/permissions-roles/v1/{user}/{roleId}/{permissionId}', [PermissionRoleController::class, 'destroy']);


// CONTROLADOR DE SERVICIOS:
// Ruta para retornar todos los servicios: 
Route::get('/services/v1/{user}', [ServiceController::class, 'index']);

// Ruta para validar si existe un servicio: 
Route::get('/services/v1/{user}/{id}', [ServiceController::class, 'show']);

// Ruta para registrar un servicio: 
Route::post('/services/v1/{user}', [ServiceController::class, 'store']);

// Ruta para eliminar un servicio: 
Route::delete('/services/v1/{user}/{id}', [ServiceController::class, 'destroy']);


// CONTROLADOR DE SERVICIOS DE USUARIOS: 
// Ruta para retornar todos los servicios de un usuario: 
Route::get('/service-users/v1/{user}', [ServiceUserController::class, 'index']);

// Ruta para validar si existen servicios asignados a un usuario: 
Route::get('/service-users/v1/{user}/{userName}', [ServiceUserController::class, 'show']);

// Ruta para asignar un servicio a un usuario: 
Route::post('/service-users/v1/{user}', [ServiceUserController::class, 'store']);

// Ruta para eliminar un servicio a un usuario: 
Route::delete('/service-users/v1/{user}/{userId}/{serviceId}', [ServiceUserController::class, 'destroy']);