<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionService
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Get all transactions with filters.
     */
    public function getAllTransactions(array $filters = [])
    {
        $query = Transaction::with('account')->orderBy('transaction_date', 'desc');

        if (isset($filters['account_id'])) {
            $query->where('account_id', $filters['account_id']);
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['start_date'])) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create a new transaction and update account balance.
     */
    public function createTransaction(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            // Handle proof image upload
            $proofImagePath = null;
            if (isset($data['proof_image']) && $data['proof_image']) {
                $proofImagePath = $data['proof_image']->store('transactions', 'public');
            }

            // Create transaction
            $transaction = Transaction::create([
                'account_id' => $data['account_id'],
                'type' => $data['type'],
                'category' => $data['category'],
                'amount' => $data['amount'], // Already in cents (integer)
                'description' => $data['description'] ?? null,
                'proof_image' => $proofImagePath,
                'transaction_date' => $data['transaction_date'],
                'upcoming_flag' => $data['upcoming_flag'] ?? false,
            ]);

            // Update account balance ONLY if NOT upcoming transaction
            if (!$transaction->upcoming_flag) {
                $account = Account::findOrFail($data['account_id']);
                $operation = $data['type'] === 'income' ? 'add' : 'subtract';
                $this->accountService->updateBalance($account, $data['amount'], $operation);
            }

            return $transaction->fresh();
        });
    }

    /**
     * Update an existing transaction and adjust account balance.
     */
    public function updateTransaction(Transaction $transaction, array $data): Transaction
    {
        return DB::transaction(function () use ($transaction, $data) {
            $oldAmount = $transaction->amount;
            $oldType = $transaction->type;
            $oldAccountId = $transaction->account_id;
            $oldUpcomingFlag = $transaction->upcoming_flag;

            // Revert old balance ONLY if old transaction was NOT upcoming
            if (!$oldUpcomingFlag) {
                $oldAccount = Account::findOrFail($oldAccountId);
                $revertOperation = $oldType === 'income' ? 'subtract' : 'add';
                $this->accountService->updateBalance($oldAccount, $oldAmount, $revertOperation);
            }

            // Handle proof image upload
            if (isset($data['proof_image']) && $data['proof_image']) {
                // Delete old image if exists
                if ($transaction->proof_image) {
                    Storage::disk('public')->delete($transaction->proof_image);
                }
                $data['proof_image'] = $data['proof_image']->store('transactions', 'public');
            } else {
                unset($data['proof_image']);
            }

            // Update transaction
            $transaction->update($data);

            // Apply new balance ONLY if new transaction is NOT upcoming
            $newUpcomingFlag = $data['upcoming_flag'] ?? $transaction->upcoming_flag;
            if (!$newUpcomingFlag) {
                $newAccount = Account::findOrFail($data['account_id'] ?? $oldAccountId);
                $newOperation = ($data['type'] ?? $oldType) === 'income' ? 'add' : 'subtract';
                $this->accountService->updateBalance($newAccount, $data['amount'] ?? $oldAmount, $newOperation);
            }

            return $transaction->fresh();
        });
    }

    /**
     * Delete a transaction and adjust account balance.
     */
    public function deleteTransaction(Transaction $transaction): bool
    {
        return DB::transaction(function () use ($transaction) {
            // Revert balance ONLY if transaction was NOT upcoming
            if (!$transaction->upcoming_flag) {
                $account = $transaction->account;
                $operation = $transaction->type === 'income' ? 'subtract' : 'add';
                $this->accountService->updateBalance($account, $transaction->amount, $operation);
            }

            // Delete proof image if exists
            if ($transaction->proof_image) {
                Storage::disk('public')->delete($transaction->proof_image);
            }

            return $transaction->delete();
        });
    }

    /**
     * Get transactions grouped by date for calendar view.
     */
    public function getTransactionsByDate(array $filters = [])
    {
        $query = Transaction::with('account');

        if (isset($filters['account_id'])) {
            $query->where('account_id', $filters['account_id']);
        }

        if (isset($filters['month']) && isset($filters['year'])) {
            $query->whereMonth('transaction_date', $filters['month'])
                  ->whereYear('transaction_date', $filters['year']);
        }

        $transactions = $query->get();

        // Group by date
        return $transactions->groupBy(function ($transaction) {
            return $transaction->transaction_date->format('Y-m-d');
        })->map(function ($dayTransactions) {
            return [
                'transactions' => $dayTransactions,
                'total_income' => $dayTransactions->where('type', 'income')->sum('amount'),
                'total_expense' => $dayTransactions->where('type', 'expense')->sum('amount'),
                'count' => $dayTransactions->count(),
            ];
        });
    }

    /**
     * Get transaction statistics.
     */
    public function getStatistics(array $filters = [])
    {
        $query = Transaction::query();

        if (isset($filters['account_id'])) {
            $query->where('account_id', $filters['account_id']);
        }

        if (isset($filters['start_date'])) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }

        $transactions = $query->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        // Group by category
        $incomeByCategory = $transactions->where('type', 'income')
            ->groupBy('category')
            ->map(fn($items) => $items->sum('amount'));

        $expenseByCategory = $transactions->where('type', 'expense')
            ->groupBy('category')
            ->map(fn($items) => $items->sum('amount'));

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net_income' => $totalIncome - $totalExpense,
            'income_by_category' => $incomeByCategory,
            'expense_by_category' => $expenseByCategory,
            'transaction_count' => $transactions->count(),
        ];
    }
}
