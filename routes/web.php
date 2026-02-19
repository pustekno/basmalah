<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:Super Admin|Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management - Super Admin Only
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
        Route::delete('/users/{user}/remove-role', [UserController::class, 'removeRole'])->name('users.remove-role');
    });
});

// Permission-based Routes Examples
Route::middleware(['auth', 'permission:view reports'])->group(function () {
    // Reports routes
});

Route::middleware(['auth', 'permission:manage accounts'])->group(function () {
    // Account management routes
});

Route::middleware(['auth', 'permission:create transactions'])->group(function () {
    // Transaction creation routes
});

require __DIR__.'/auth.php';
