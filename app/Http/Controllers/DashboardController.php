<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\TransactionService;
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
        // Get financial statistics
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
        
        return view('dashboard', compact(
            'totalBalance',
            'accounts',
            'thisMonthStats',
            'last30Days',
            'recentTransactions'
        ));
    }
}
