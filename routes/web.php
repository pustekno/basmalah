<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Impersonation Routes (Super Admin only - protected in controller)
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::post('/admin/users/{user}/login-as', [UserController::class, 'loginAs'])->name('admin.users.login-as');
    Route::post('/admin/users/back-to-admin', [UserController::class, 'backToAdmin'])->name('admin.users.back-to-admin');
});

// Language Switcher
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');

// Masjid Switcher (Super Admin & Viewer)
Route::middleware(['auth', 'role:Super Admin|Viewer'])->group(function () {
    Route::post('/masjid/switch', [MasjidController::class, 'switch'])->name('masjid.switch');
    Route::post('/masjid/clear', [MasjidController::class, 'clearSwitch'])->name('masjid.clear');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Accounts - Protected by permissions
    Route::middleware('permission:manage accounts')->group(function () {
        Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
        Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::patch('accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
        Route::delete('accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    });
    Route::middleware('permission:view accounts')->group(function () {
        Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');
    });
    
    // Categories - Protected by permissions
    Route::middleware('permission:manage categories')->group(function () {
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    Route::middleware('permission:view categories')->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });
    
    // Budgets - Protected by permissions
    Route::middleware('permission:manage budgets')->group(function () {
        Route::get('budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
        Route::post('budgets', [BudgetController::class, 'store'])->name('budgets.store');
        Route::get('budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
        Route::get('budgets/{budget}/allocate', [BudgetController::class, 'allocateForm'])->name('budgets.allocate');
        Route::post('budgets/{budget}/allocate', [BudgetController::class, 'allocate'])->name('budgets.store-allocate');
        Route::match(['patch', 'put'], 'budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
        Route::delete('budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
    });
    Route::middleware('permission:view budgets')->group(function () {
        Route::get('budgets', [BudgetController::class, 'index'])->name('budgets.index');
        Route::get('budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show');
    });
    
    // Transactions - Protected by permissions
    Route::middleware('permission:create transactions')->group(function () {
        Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });
    Route::middleware('permission:edit transactions')->group(function () {
        Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::patch('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    });
    Route::middleware('permission:delete transactions')->group(function () {
        Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });
    Route::middleware('permission:view transactions')->group(function () {
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    });
    
    // Goals - Protected by permissions
    Route::middleware('permission:manage goals')->group(function () {
        Route::get('goals/create', [GoalController::class, 'create'])->name('goals.create');
        Route::post('goals', [GoalController::class, 'store'])->name('goals.store');
        Route::get('goals/{goal}/edit', [GoalController::class, 'edit'])->name('goals.edit');
        Route::patch('goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
        Route::patch('goals/{goal}/progress', [GoalController::class, 'updateProgress'])->name('goals.updateProgress');
        Route::delete('goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
        Route::post('goals/{goal}/deposits', [DepositController::class, 'store'])->name('deposits.store');
        Route::delete('deposits/{deposit}', [DepositController::class, 'destroy'])->name('deposits.destroy');
    });
    Route::middleware('permission:view goals')->group(function () {
        Route::get('goals', [GoalController::class, 'index'])->name('goals.index');
        Route::get('goals/{goal}', [GoalController::class, 'show'])->name('goals.show');
    });
    
    // Calendar - Protected by permissions
    Route::middleware('permission:view calendar')->group(function () {
        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('calendar/transactions', [CalendarController::class, 'getTransactions'])->name('calendar.transactions');
    });
    
    // Reports - Protected by permissions
    Route::middleware('permission:view reports')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/income-vs-expense', [ReportController::class, 'incomeVsExpense'])->name('reports.income-vs-expense');
        Route::get('reports/by-category', [ReportController::class, 'byCategory'])->name('reports.by-category');
        Route::get('reports/by-account', [ReportController::class, 'byAccount'])->name('reports.by-account');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:Super Admin|Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management - Super Admin Only
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
        Route::delete('/users/{user}/remove-role', [UserController::class, 'removeRole'])->name('users.remove-role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';
