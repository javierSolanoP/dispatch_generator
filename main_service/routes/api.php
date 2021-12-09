<?php

use App\Http\Controllers\services\main\GenderController;
use App\Http\Controllers\services\main\PermissionController;
use App\Http\Controllers\services\main\RoleController;
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
Route::get('/role/users/v1/{user}/{id_role?}', [UserController::class, 'index']);

// Ruta para retornar un usuario especifico: 
Route::get('/users/v1/{user}/{identification}', [UserController::class, 'show']);

// Ruta para actualizar el registro de un usuario: 
Route::put('/users/v1/{user}/{identification}', [UserController::class, 'update']);

// Ruta para eliminar un usuario: 
Route::delete('/users/v1/{user}/{identification}', [UserController::class, 'destroy']);


// CONTROLADOR DE ROLES: 
// Ruta para retornar todos los roles: 
Route::get('/roles/v1/{user}', [RoleController::class, 'index']);

// Ruta para validar si existe un role: 
Route::get('/validate/roles/v1/{user}/{id}', [RoleController::class, 'show']);

// Ruta para eliminar un role: 
Route::delete('/roles/v1/{user}/{id}', [RoleController::class, 'destroy']);


// CONTROLADOR DE GENEROS:
// Ruta para retoranar todos los generos:  
Route::get('/genders/v1/{user}', [GenderController::class, 'index']);

// Ruta para validar si existe un genero:
Route::get('/validate/genders/v1/{user}/{id}', [GenderController::class, 'show']);

// Ruta para eliminar un genero: 
Route::delete('/genders/v1/{user}/{id}', [GenderController::class, 'destroy']);


// CONTROLADOR DE PERMISOS: 
// Ruta para retornar todos los permisos: 
Route::get('/permissions/v1/{user}', [PermissionController::class, 'index']);

// Ruta para validar si existe un permiso: 
Route::get('/validate/permissions/v1/{user}/{id}', [PermissionController::class, 'show']);

// Ruta para eliminar un permiso: 
Route::delete('/permissions/v1/{user}/{id}', [PermissionController::class, 'destroy']);