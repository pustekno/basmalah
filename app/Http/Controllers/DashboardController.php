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
        $totalBalance = (float) $this->accountService->getTotalBalance();
        $monthlyIncome = $this->transactionService->getMonthlyIncome();
        $monthlyExpense = $this->transactionService->getMonthlyExpense();
        $recentTransactions = $this->transactionService->getRecentTransactions(5);

        return view('dashboard', compact('totalBalance', 'monthlyIncome', 'monthlyExpense', 'recentTransactions'));
    }
}
