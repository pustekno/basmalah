<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Display a listing of the accounts.
     */
    public function index()
    {
        $this->authorize('viewAny', Account::class);
        
        $accounts = $this->accountService->getAllAccounts();
        $totalBalance = $this->accountService->getTotalBalance();

        return view('accounts.index', compact('accounts', 'totalBalance'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Account::class);
        
        $selectedType = $request->get('type', 'cash');
        return view('accounts.create', compact('selectedType'));
    }

    /**
     * Store a newly created account in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Account::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,e-wallet,credit_card',
            'balance' => 'nullable|numeric|min:0',
        ]);

        $this->accountService->createAccount($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified account.
     */
    public function show(Account $account)
    {
        $this->authorize('view', $account);
        
        $statistics = $this->accountService->getAccountStatistics($account);
        $transactions = $account->transactions()
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        return view('accounts.show', compact('account', 'statistics', 'transactions'));
    }

    /**
     * Show the form for editing the specified account.
     */
    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified account in storage.
     */
    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,e-wallet,credit_card',
        ]);

        $this->accountService->updateAccount($account, $validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified account from storage.
     */
    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        
        $this->accountService->deleteAccount($account);

        return redirect()->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
