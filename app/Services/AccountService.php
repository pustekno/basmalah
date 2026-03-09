<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountService
{
    /**
     * Get all accounts with transaction count and latest transaction.
     */
    public function getAllAccounts()
    {
        return Account::withCount('transactions')
            ->with(['transactions' => function ($query) {
                $query->latest('transaction_date')->limit(1);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Create a new account.
     */
    public function createAccount(array $data): Account
    {
        // Get masjid_id from authenticated user or active session
        $masjidId = $this->getMasjidId();

        return Account::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'balance' => $data['balance'] ?? 0,
            'masjid_id' => $masjidId,
        ]);
    }

    /**
     * Get masjid_id for current user.
     * Super Admin uses active_masjid_id from session, others use their masjid_id.
     */
    private function getMasjidId(): ?int
    {
        $user = auth()->user();

        // Super Admin: use active masjid from session
        if ($user->hasRole('Super Admin')) {
            return session('active_masjid_id');
        }

        // Other users: use their assigned masjid
        return $user->masjid_id;
    }

    /**
     * Update an existing account.
     */
    public function updateAccount(Account $account, array $data): Account
    {
        $account->update([
            'name' => $data['name'] ?? $account->name,
            'type' => $data['type'] ?? $account->type,
        ]);

        return $account->fresh();
    }

    /**
     * Delete an account.
     */
    public function deleteAccount(Account $account): bool
    {
        return $account->delete();
    }

    /**
     * Update account balance using precise decimal calculation.
     * 
     * @param Account $account
     * @param int $amount Amount in cents (integer)
     * @param string $operation 'add' or 'subtract'
     * @return Account
     */
    public function updateBalance(Account $account, int $amount, string $operation = 'add'): Account
    {
        DB::transaction(function () use ($account, $amount, $operation) {
            // Convert amount from cents to decimal
            $amountDecimal = bcdiv((string)$amount, '100', 4);
            
            // Get current balance
            $currentBalance = (string)$account->balance;
            
            // Calculate new balance using bcmath for precision
            $newBalance = $operation === 'add' 
                ? bcadd($currentBalance, $amountDecimal, 4)
                : bcsub($currentBalance, $amountDecimal, 4);
            
            // Update account balance
            $account->update(['balance' => $newBalance]);
        });

        return $account->fresh();
    }

    /**
     * Get account statistics.
     */
    public function getAccountStatistics(Account $account)
    {
        $transactions = $account->transactions;
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        
        return [
            'total_transactions' => $transactions->count(),
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $account->balance,
        ];
    }

    /**
     * Get total balance across all accounts.
     */
    public function getTotalBalance(): string
    {
        $accounts = Account::all();
        $total = '0';
        
        foreach ($accounts as $account) {
            $total = bcadd($total, (string)$account->balance, 4);
        }
        
        return $total;
    }
}
