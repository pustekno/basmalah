<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:Super Admin|Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management - Super Admin Only
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
        Route::delete('/users/{user}/remove-role', [UserController::class, 'removeRole'])->name('users.remove-role');
    });
});

// Financial Management Routes
Route::middleware(['auth'])->group(function () {
    // Account Management
    Route::resource('accounts', AccountController::class);
    
    // Transaction Management
    Route::resource('transactions', TransactionController::class);
    
    // Calendar View
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/transactions', [CalendarController::class, 'getTransactions'])->name('calendar.transactions');
});

require __DIR__.'/auth.php';
