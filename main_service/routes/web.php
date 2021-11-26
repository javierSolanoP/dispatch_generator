<?php

use App\Http\Controllers\admin\dashboard\DashBoardController;
use App\Http\Controllers\admin\dashboard\MonthlyPaymentController;
use App\Http\Controllers\admin\user_module\UserController;
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

// Login: 
Route::get('/', [UserController::class, 'index'])->name('home');
Route::post('/login', [UserController::class, 'store'])->name('login');

// Dashboard: 
Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
Route::get('/logout', [DashBoardController::class, 'logout'])->name('logout');
Route::get('/dashboard/mensualidades', [MonthlyPaymentController::class, 'index'])->name('monthly_payments');