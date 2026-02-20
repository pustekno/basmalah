<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['account_id', 'type', 'category', 'start_date', 'end_date']);
        $transactions = $this->transactionService->getAllTransactions($filters);
        $accounts = Account::all();

        return view('transactions.index', compact('transactions', 'accounts'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create(Request $request)
    {
        $accounts = Account::all();
        $selectedType = $request->get('type', 'expense');
        $selectedAccount = $request->get('account_id');
        return view('transactions.create', compact('accounts', 'selectedType', 'selectedAccount'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|integer|min:1', // Amount in cents
            'description' => 'nullable|string',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'transaction_date' => 'required|date',
            'upcoming_flag' => 'nullable|boolean',
        ]);

        $this->transactionService->createTransaction($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        $accounts = Account::all();
        return view('transactions.edit', compact('transaction', 'accounts'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'transaction_date' => 'required|date',
            'upcoming_flag' => 'nullable|boolean',
        ]);

        $this->transactionService->updateTransaction($transaction, $validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->transactionService->deleteTransaction($transaction);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
