<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ReportController;
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
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/goals', [ReportController::class, 'goals'])->name('reports.goals');
    Route::get('/reports/deposits', [ReportController::class, 'deposits'])->name('reports.deposits');
    Route::get('/reports/charts', [ReportController::class, 'charts'])->name('reports.charts');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Goals & Targets - accessible by authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('goals', GoalController::class);
    
    // Deposits for goals
    Route::get('/goals/{goal}/deposits/create', [DepositController::class, 'create'])->name('deposits.create');
    Route::post('/goals/{goal}/deposits', [DepositController::class, 'store'])->name('deposits.store');
    Route::delete('/deposits/{deposit}', [DepositController::class, 'destroy'])->name('deposits.destroy');
});

require __DIR__.'/auth.php';
