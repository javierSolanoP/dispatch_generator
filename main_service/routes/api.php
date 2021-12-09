<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// CONTROLADOR DE USUARIOS: 
// Ruta para retornar todos los usuarios: 
Route::get('/role/users/v1/{user}/{id_role?}', [UserController::class, 'index']);

// Ruta para retornar un usuario especifico: 
Route::get('/users/v1/{user}/{identification?}', [UserController::class, 'show']);

// Ruta para actualizar el registro de un usuario: 
Route::put('/users/v1/{user}/{identification?}', [UserController::class, 'update']);

// Ruta para eliminar un usuario: 
Route::delete('/users/v1/{user}/{identification?}', [UserController::class, 'destroy']);

// CONTROLADOR DE ROLES: 
// Ruta para retornar todos los roles: 
Route::get('/roles/v1/{user}', [RoleController::class, 'index']);