<?php

use App\Http\Controllers\DispatchController as ControllersDispatchController;
use App\Imports\DispatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/send', [DispatchController::class, 'collection'])->name('process');
Route::post('/send', [ControllersDispatchController::class, 'import'])->name('process');
