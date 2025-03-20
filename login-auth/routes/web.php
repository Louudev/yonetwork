<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TelesocialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route d'accueil
Route::get('/', function () {
    return redirect('/login');
});

// Route dashboard générique (pour résoudre l'erreur)
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/teleconseiller/dashboard');
        }
    }
    return redirect('/login');
})->name('dashboard');

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Order management routes
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::get('/admin/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
Route::post('/admin/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
Route::post('/admin/orders/{id}/update-payment', [AdminController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment');

// Teleconseiller routes
Route::get('/teleconseiller/dashboard', [TelesocialController::class, 'dashboard'])->name('teleconseiller.dashboard');
Route::post('/teleconseiller/submit-form', [TelesocialController::class, 'submitForm'])->name('teleconseiller.submit-form');
Route::get('/teleconseiller/orders', [TelesocialController::class, 'orderHistory'])->name('teleconseiller.orders');
Route::get('/teleconseiller/orders/{id}', [TelesocialController::class, 'showOrder'])->name('teleconseiller.orders.show');
Route::delete('/teleconseiller/orders/{id}/delete', [TelesocialController::class, 'deleteOrder'])->name('teleconseiller.orders.delete');
Route::post('/teleconseiller/orders/{id}/update-payment', [TelesocialController::class, 'updatePaymentStatus'])->name('teleconseiller.orders.update-payment');

// Routes du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route pour la gestion des téléconseillers
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/teleconseillers', [AdminController::class, 'index'])->name('admin.index');
});
Route::get('/admin/teleconseillers', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/teleconseillers', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/teleconseillers/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::post('/admin/teleconseillers/{id}/block', [AdminController::class, 'block'])->name('admin.block');
Route::post('/admin/teleconseillers/{id}/unblock', [AdminController::class, 'unblock'])->name('admin.unblock');

require __DIR__.'/auth.php';
