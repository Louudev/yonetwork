<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);

Route::get('/', function () {
    return view('welcome');
});

// Use Auth::routes() for all standard authentication routes
// Auth::routes();

// // Home route (formerly dashboard)
// Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Role-specific routes
// Route::middleware(['auth', 'role:super-admin'])->group(function () {
//     Route::get('/admin-home', [AdminController::class, 'index'])->name('admin.home');
//     // Renamed from admin-dashboard
// });

// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/formulaire-client', [FormController::class, 'show']);
//     Route::post('/formulaire-client', [FormController::class, 'store']);
// });