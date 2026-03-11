<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\Masjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Get current Masjid ID for filtering.
     */
    private function getMasjidId(): ?int
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return session('active_masjid_id');
        }

        return $user->masjid_id;
    }

    public function index(Request $request)
    {
        $masjidId = $request->input('masjid_id', $this->getMasjidId());
        $period = $request->input('period', 'month');
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get all masjids for filter (Super Admin only)
        $masjids = Masjid::all();

        // Income vs Expense
        $totalIncome = Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('upcoming_flag', false)
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->sum('amount');
        
        $totalExpense = Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('upcoming_flag', false)
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->sum('amount');
        
        $netIncome = $totalIncome - $totalExpense;

        // Transactions by Category
        $incomeByCategory = Transaction::select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'income')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        $expenseByCategory = Transaction::select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        // Transactions by Account
        $transactionsByAccount = Transaction::select('account_id', 
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->with('account')
            ->groupBy('account_id')
            ->get();

        // Monthly Trend (last 12 months)
        $monthlyTrend = Transaction::select(
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            )
            ->where('upcoming_flag', false)
            ->where('transaction_date', '>=', now()->subMonths(12))
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Goals Stats
        $totalGoals = Goal::when($masjidId, function($query) use ($masjidId) {
            return $query->where('masjid_id', $masjidId);
        })->count();
        
        $activeGoals = Goal::where('status', 'active')
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })->count();
        
        $completedGoals = Goal::where('status', 'completed')
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })->count();
        
        $totalDeposits = Deposit::when($masjidId, function($query) use ($masjidId) {
            return $query->where('masjid_id', $masjidId);
        })->count();
        
        $totalDepositsAmount = Deposit::when($masjidId, function($query) use ($masjidId) {
            return $query->where('masjid_id', $masjidId);
        })->sum('amount');

        // Account Balances
        $accounts = Account::when($masjidId, function($query) use ($masjidId) {
            return $query->where('masjid_id', $masjidId);
        })->get();
        
        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('balance');

        return view('reports.index', compact(
            'masjids',
            'masjidId',
            'totalIncome',
            'totalExpense',
            'netIncome',
            'incomeByCategory',
            'expenseByCategory',
            'transactionsByAccount',
            'monthlyTrend',
            'totalGoals',
            'activeGoals',
            'completedGoals',
            'totalDeposits',
            'totalDepositsAmount',
            'accounts',
            'totalAccounts',
            'totalBalance',
            'startDate',
            'endDate',
            'period'
        ));
    }

    public function incomeVsExpense(Request $request)
    {
        $masjidId = $request->input('masjid_id', $this->getMasjidId());
        $period = $request->input('period', 'month');
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $masjids = Masjid::all();

        if ($period === 'month') {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate = Carbon::create($year, 12, 31)->endOfYear();
        }

        $totalIncome = Transaction::where('type', 'income')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->sum('amount');
        
        $totalExpense = Transaction::where('type', 'expense')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->sum('amount');
        
        $netIncome = $totalIncome - $totalExpense;

        if ($period === 'month') {
            $dailyTrend = Transaction::select(
                    DB::raw('DATE(transaction_date) as date'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->where('upcoming_flag', false)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->when($masjidId, function($query) use ($masjidId) {
                    return $query->where('masjid_id', $masjidId);
                })
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $dailyTrend = Transaction::select(
                    DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->where('upcoming_flag', false)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->when($masjidId, function($query) use ($masjidId) {
                    return $query->where('masjid_id', $masjidId);
                })
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        $topIncomeCategories = Transaction::select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'income')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $topExpenseCategories = Transaction::select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('reports.income-vs-expense', compact(
            'masjids',
            'masjidId',
            'totalIncome',
            'totalExpense',
            'netIncome',
            'dailyTrend',
            'topIncomeCategories',
            'topExpenseCategories',
            'period',
            'year',
            'month',
            'startDate',
            'endDate'
        ));
    }

    public function byCategory(Request $request)
    {
        $masjidId = $request->input('masjid_id', $this->getMasjidId());
        $period = $request->input('period', 'month');
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $categoryId = $request->input('category_id');

        $masjids = Masjid::all();

        if ($period === 'month') {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate = Carbon::create($year, 12, 31)->endOfYear();
        }

        $categoryNames = Transaction::where('upcoming_flag', false)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->distinct()
            ->pluck('category');
        
        $categories = Category::whereIn('name', $categoryNames)
            ->get()
            ->map(function($category) use ($startDate, $endDate, $masjidId) {
                $transactionSum = Transaction::where('category', $category->name)
                    ->where('upcoming_flag', false)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->when($masjidId, function($query) use ($masjidId) {
                        return $query->where('masjid_id', $masjidId);
                    })
                    ->sum('amount');
                
                $transactionCount = Transaction::where('category', $category->name)
                    ->where('upcoming_flag', false)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->when($masjidId, function($query) use ($masjidId) {
                        return $query->where('masjid_id', $masjidId);
                    })
                    ->count();
                
                $category->transactions_sum_amount = $transactionSum;
                $category->transactions_count = $transactionCount;
                
                return $category;
            });

        $transactions = null;
        $selectedCategory = null;
        if ($categoryId) {
            $selectedCategory = Category::find($categoryId);
            if ($selectedCategory) {
                $transactions = Transaction::where('category', $selectedCategory->name)
                    ->where('upcoming_flag', false)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->when($masjidId, function($query) use ($masjidId) {
                        return $query->where('masjid_id', $masjidId);
                    })
                    ->with('account')
                    ->orderBy('transaction_date', 'desc')
                    ->get();
            }
        }

        $categoryTrend = Transaction::select(
                'category',
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('upcoming_flag', false)
            ->whereBetween('transaction_date', [now()->subMonths(6), now()])
            ->when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->groupBy('category', 'month')
            ->orderBy('month')
            ->get()
            ->groupBy('category');

        return view('reports.by-category', compact(
            'masjids',
            'masjidId',
            'categories',
            'transactions',
            'selectedCategory',
            'categoryTrend',
            'period',
            'year',
            'month',
            'categoryId',
            'startDate',
            'endDate'
        ));
    }

    public function byAccount(Request $request)
    {
        $masjidId = $request->input('masjid_id', $this->getMasjidId());
        $period = $request->input('period', 'month');
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $accountId = $request->input('account_id');

        $masjids = Masjid::all();

        if ($period === 'month') {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate = Carbon::create($year, 12, 31)->endOfYear();
        }

        $accounts = Account::when($masjidId, function($query) use ($masjidId) {
                return $query->where('masjid_id', $masjidId);
            })
            ->withSum(['transactions' => function($query) use ($startDate, $endDate) {
                $query->where('type', 'income')
                      ->where('upcoming_flag', false)
                      ->whereBetween('transaction_date', [$startDate, $endDate]);
            }], 'amount')
            ->withSum(['transactions as expense_sum' => function($query) use ($startDate, $endDate) {
                $query->where('type', 'expense')
                      ->where('upcoming_flag', false)
                      ->whereBetween('transaction_date', [$startDate, $endDate]);
            }], 'amount')
            ->withCount(['transactions' => function($query) use ($startDate, $endDate) {
                $query->where('upcoming_flag', false)
                      ->whereBetween('transaction_date', [$startDate, $endDate]);
            }])
            ->get();

        $transactions = null;
        $selectedAccount = null;
        if ($accountId) {
            $selectedAccount = Account::find($accountId);
            $transactions = Transaction::where('account_id', $accountId)
                ->where('upcoming_flag', false)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->when($masjidId, function($query) use ($masjidId) {
                    return $query->where('masjid_id', $masjidId);
                })
                ->with(['account', 'category'])
                ->orderBy('transaction_date', 'desc')
                ->get();
        }

        return view('reports.by-account', compact(
            'masjids',
            'masjidId',
            'accounts',
            'transactions',
            'selectedAccount',
            'period',
            'year',
            'month',
            'accountId',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'transactions');
        $format = $request->input('format', 'csv');
        
        return back()->with('info', 'Export feature coming soon!');
    }
}
