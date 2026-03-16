<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicReportController extends Controller
{
    /**
     * Display a listing of public masjids.
     */
    public function index(Request $request)
    {
        $query = Masjid::query()->where('is_active', true);

        // Search by name or city
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $masjids = $query->orderBy('name')->paginate(12);

        return view('public.reports.index', compact('masjids'));
    }

    /**
     * Display the specified public report.
     */
    public function show(Request $request, $masjidSlug)
    {
        $masjid = Masjid::where('slug', $masjidSlug)->orWhere('id', $masjidSlug)->firstOrFail();

        // Get selected month/year or use current
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));

        // Get accounts for this mosque
        $accounts = Account::where('masjid_id', $masjid->id)->get();

        // Calculate totals for the selected period
        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        // Total Income (Pemasukan)
        $totalIncome = Transaction::where('masjid_id', $masjid->id)
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        // Total Expense (Pengeluaran)
        $totalExpense = Transaction::where('masjid_id', $masjid->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        // Balance
        $balance = $totalIncome - $totalExpense;

        // Get transactions for the table
        $transactions = Transaction::where('masjid_id', $masjid->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Get categories for display
        $categories = Category::where('masjid_id', $masjid->id)->get();

        // Monthly data for chart (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = date('n', strtotime("-{$i} months"));
            $y = date('Y', strtotime("-{$i} months"));
            $start = "{$y}-{$m}-01";
            $end = date('Y-m-t', strtotime($start));

            $monthlyData[] = [
                'month' => date('M', strtotime($start)),
                'income' => Transaction::where('masjid_id', $masjid->id)
                    ->where('type', 'income')
                    ->whereBetween('date', [$start, $end])
                    ->sum('amount'),
                'expense' => Transaction::where('masjid_id', $masjid->id)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$start, $end])
                    ->sum('amount'),
            ];
        }

        // Available years (last 3 years)
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        // Available months
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('public.reports.show', compact(
            'masjid', 'totalIncome', 'totalExpense', 'balance',
            'transactions', 'categories', 'monthlyData',
            'year', 'month', 'years', 'months'
        ));
    }

    /**
     * Search masjids for public reports.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $masjids = Masjid::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('city', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'city', 'slug', 'updated_at']);

        return response()->json($masjids);
    }
}
