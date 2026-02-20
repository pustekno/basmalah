<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\TransactionService;
use App\Models\Goal;
use App\Models\Deposit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected AccountService $accountService;
    protected TransactionService $transactionService;

    public function __construct(AccountService $accountService, TransactionService $transactionService)
    {
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        // Get financial statistics (BAGUS)
        $totalBalance = $this->accountService->getTotalBalance();
        $accounts = $this->accountService->getAllAccounts();
        
        // Get this month's statistics
        $thisMonthStats = $this->transactionService->getStatistics([
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->endOfMonth(),
        ]);
        
        // Get last 30 days transactions for chart
        $last30Days = $this->transactionService->getStatistics([
            'start_date' => now()->subDays(30),
            'end_date' => now(),
        ]);
        
        // Get recent transactions
        $recentTransactions = $this->transactionService->getAllTransactions(['per_page' => 5]);
        
        // Get goals statistics (LIGA)
        $activeGoals = Goal::where('status', 'active')->count();
        $completedGoals = Goal::where('status', 'completed')->count();
        $totalGoalAmount = Goal::where('status', 'active')->sum('target_amount');
        $totalCollectedAmount = Goal::where('status', 'active')->sum('current_amount');
        
        return view('dashboard', compact(
            'totalBalance',
            'accounts',
            'thisMonthStats',
            'last30Days',
            'recentTransactions',
            'activeGoals',
            'completedGoals',
            'totalGoalAmount',
            'totalCollectedAmount'
        ));
    }
}
