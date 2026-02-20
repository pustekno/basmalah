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

        // Format for calendar
        $events = [];
        foreach ($transactionsByDate as $date => $data) {
            $events[] = [
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

        return response()->json($events);
    }
}
