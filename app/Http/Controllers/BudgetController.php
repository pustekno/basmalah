<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of budgets.
     */
    public function index()
    {
        $this->authorize('viewAny', Budget::class);
        
        $budgets = Budget::with('category')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        $currentBudgets = Budget::with('category')
            ->current()
            ->get();

        // Calculate total budget vs spent
        $totalBudget = $currentBudgets->sum('amount');
        $totalSpent = $currentBudgets->sum('total_spent');
        $totalRemaining = $totalBudget - $totalSpent;

        return view('budgets.index', compact('budgets', 'currentBudgets', 'totalBudget', 'totalSpent', 'totalRemaining'));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create()
    {
        $this->authorize('create', Budget::class);
        
        $categories = Category::active()->orderBy('name')->get();
        return view('budgets.create', compact('categories'));
    }

    /**
     * Store a newly created budget.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Budget::class);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        // Convert amount to cents (remove decimal separator and multiply by 100)
        // The amount field now contains the raw numeric value without formatting
        $validated['amount'] = $validated['amount'] * 100;

        // Add masjid_id
        $validated['masjid_id'] = $this->getMasjidId();

        Budget::create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    /**
     * Get masjid_id for current user.
     */
    private function getMasjidId(): ?int
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return session('active_masjid_id');
        }

        return $user->masjid_id;
    }

    /**
     * Display the specified budget.
     */
    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        
        $budget->load('category');

        // Get transactions for this budget period
        $transactions = $budget->category->transactions()
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$budget->start_date, $budget->end_date])
            ->with('account')
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Group transactions by date
        $transactionsByDate = $transactions->groupBy(function ($transaction) {
            return $transaction->transaction_date->format('Y-m-d');
        });

        return view('budgets.show', compact('budget', 'transactions', 'transactionsByDate'));
    }

    /**
     * Show the form for editing the specified budget.
     */
    public function edit(Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $categories = Category::active()->orderBy('name')->get();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    /**
     * Update the specified budget.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Convert amount to cents
        $validated['amount'] = $validated['amount'] * 100;

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified budget.
     */
    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }
}
