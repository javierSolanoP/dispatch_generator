<?php

use App\Http\Controllers\services\main\UserController;
use Illuminate\Http\Request;
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

// Ruta para retornar todos los usuarios: 
Route::get('/role-users/v1/{user}/{id_role?}', [UserController::class, 'index']);

// Metodo para retornar un usuario especifico: 
Route::get('/users/v1/{user}/{identification?}', [UserController::class, 'show']);

// Metodo para actualizar el registro de un usuario: 
Route::put('/users/v1/{user}/{identification?}', [UserController::class, 'update']);

// Metodo para eliminar un usuario: 
Route::delete('/users/v1/{user}/{identification?}', [UserController::class, 'destroy']);


// Route::apiResource('/users/v1', 'App\Http\Controllers\services\main\UserController');
// Route::apiResource('/roles/v1', 'App\Http\Controllers\services\main\RoleController');