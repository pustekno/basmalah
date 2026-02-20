<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Quick stats
        $totalGoals = Goal::count();
        $activeGoals = Goal::where('status', 'active')->count();
        $completedGoals = Goal::where('status', 'completed')->count();
        $totalDeposits = Deposit::count();
        $totalDepositAmount = Deposit::sum('amount');

        return view('reports.index', compact(
            'totalGoals',
            'activeGoals',
            'completedGoals',
            'totalDeposits',
            'totalDepositAmount'
        ));
    }

    public function goals(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Goal::with('creator')->withCount('deposits');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $goals = $query->orderBy('created_at', 'desc')->get();

        // Statistics
        $totalGoals = Goal::count();
        $activeGoals = Goal::where('status', 'active')->count();
        $completedGoals = Goal::where('status', 'completed')->count();
        $totalTargetAmount = Goal::where('status', 'active')->sum('target_amount');
        $totalCurrentAmount = Goal::where('status', 'active')->sum('current_amount');

        return view('reports.goals', compact(
            'goals',
            'status',
            'totalGoals',
            'activeGoals',
            'completedGoals',
            'totalTargetAmount',
            'totalCurrentAmount'
        ));
    }

    public function deposits(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $goalId = $request->input('goal_id');

        $query = Deposit::with(['goal', 'recorder'])
            ->whereBetween('deposit_date', [$startDate, $endDate]);

        if ($goalId) {
            $query->where('goal_id', $goalId);
        }

        $deposits = $query->orderBy('deposit_date', 'desc')->get();

        // Statistics
        $totalAmount = $deposits->sum('amount');
        $totalCount = $deposits->count();
        $avgAmount = $totalCount > 0 ? $totalAmount / $totalCount : 0;

        // Deposits by goal
        $depositsByGoal = Deposit::select('goal_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->whereBetween('deposit_date', [$startDate, $endDate])
            ->groupBy('goal_id')
            ->with('goal')
            ->orderBy('total', 'desc')
            ->get();

        // Monthly trend (last 6 months)
        $monthlyTrend = Deposit::select(
                DB::raw('DATE_FORMAT(deposit_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('deposit_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Payment methods
        $paymentMethods = Deposit::select('payment_method', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->whereBetween('deposit_date', [$startDate, $endDate])
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->orderBy('total', 'desc')
            ->get();

        $goals = Goal::where('status', 'active')->get();

        return view('reports.deposits', compact(
            'deposits',
            'totalAmount',
            'totalCount',
            'avgAmount',
            'depositsByGoal',
            'monthlyTrend',
            'paymentMethods',
            'goals',
            'startDate',
            'endDate',
            'goalId'
        ));
    }

    public function charts()
    {
        // Data for charts
        $goalsData = Goal::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $categoryData = Goal::select('category', DB::raw('SUM(current_amount) as total'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        $monthlyGoals = Goal::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyDeposits = Deposit::select(
                DB::raw('DATE_FORMAT(deposit_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('deposit_date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('reports.charts', compact(
            'goalsData',
            'categoryData',
            'monthlyGoals',
            'monthlyDeposits'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'goals');
        $format = $request->input('format', 'csv');

        // Implementation for CSV/PDF export
        // This is a placeholder - you can implement actual export logic
        
        return back()->with('info', 'Export feature coming soon!');
    }
}
