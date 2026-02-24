<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display the calendar view.
     */
    public function index(Request $request)
    {
        $accounts = Account::all();
        $selectedAccount = $request->get('account_id');

        return view('calendar.index', compact('accounts', 'selectedAccount'));
    }

    /**
     * Get transactions data for calendar (AJAX endpoint).
     */
    public function getTransactions(Request $request)
    {
        $filters = [
            'month' => $request->get('month'),
            'year' => $request->get('year'),
            'account_id' => $request->get('account_id'),
        ];

        $transactionsByDate = $this->transactionService->getTransactionsByDate($filters);

        // Get active budgets for this period
        $startDate = \Carbon\Carbon::create($filters['year'], $filters['month'], 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        $budgets = \App\Models\Budget::with('category')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->get();

        // Format transactions for calendar
        $events = [];
        foreach ($transactionsByDate as $date => $data) {
            $events[] = [
                'type' => 'transaction',
                'date' => $date,
                'transactions' => $data['transactions']->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'type' => $transaction->type,
                        'category' => $transaction->category,
                        'amount' => $transaction->amount,
                        'formatted_amount' => $transaction->formatted_amount,
                        'description' => $transaction->description,
                        'account' => $transaction->account->name,
                        'upcoming' => $transaction->upcoming_flag,
                    ];
                }),
                'total_income' => $data['total_income'],
                'total_expense' => $data['total_expense'],
                'count' => $data['count'],
            ];
        }

        // Add budget events
        foreach ($budgets as $budget) {
            // Budget start event
            $events[] = [
                'type' => 'budget_start',
                'date' => $budget->start_date->format('Y-m-d'),
                'budget' => [
                    'id' => $budget->id,
                    'name' => $budget->name,
                    'category' => $budget->category->name,
                    'amount' => $budget->amount,
                    'formatted_amount' => $budget->formatted_amount,
                    'period' => $budget->period,
                    'color' => $budget->category->color,
                ],
            ];

            // Budget end event
            $events[] = [
                'type' => 'budget_end',
                'date' => $budget->end_date->format('Y-m-d'),
                'budget' => [
                    'id' => $budget->id,
                    'name' => $budget->name,
                    'category' => $budget->category->name,
                    'amount' => $budget->amount,
                    'formatted_amount' => $budget->formatted_amount,
                    'spent' => $budget->total_spent,
                    'formatted_spent' => $budget->formatted_spent,
                    'remaining' => $budget->remaining,
                    'formatted_remaining' => $budget->formatted_remaining,
                    'percentage' => $budget->percentage_used,
                    'exceeded' => $budget->isExceeded(),
                    'period' => $budget->period,
                    'color' => $budget->category->color,
                ],
            ];
        }

        return response()->json($events);
    }
}
