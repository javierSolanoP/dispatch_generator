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

Route::get('/users/v1/{id_role?}', [UserController::class, 'index']);
Route::apiResource('/users/v1', 'App\Http\Controllers\services\main\UserController');
Route::apiResource('/roles/v1', 'App\Http\Controllers\services\main\RoleController');