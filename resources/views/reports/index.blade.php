<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Laporan Keuangan
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Dashboard laporan dan analisis keuangan</p>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap gap-4 items-end">
                    <!-- Masjid Filter (Super Admin only) -->
                    @can('Super Admin')
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Masjid</label>
                        <select name="masjid_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <option value="">Semua Masjid</option>
                            @foreach($masjids as $masjid)
                                <option value="{{ $masjid->id }}" {{ $masjidId == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endcan
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium transition-colors">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-green-700 dark:text-green-400">Total Pemasukan</p>
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">Total Pengeluaran</p>
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Saldo Bersih</p>
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold {{ $netIncome >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        Rp {{ number_format($netIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-purple-700 dark:text-purple-400">Total Saldo Akun</p>
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Income vs Expense Pie Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pemasukan vs Pengeluaran</h3>
                    <div class="relative h-64">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>

                <!-- Monthly Trend Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren Bulanan (12 Bulan)</h3>
                    <div class="relative h-64">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Income by Category -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pemasukan per Kategori</h3>
                @if($incomeByCategory->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($incomeByCategory as $category)
                            <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $category->category }}</span>
                                <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format($category->total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data pemasukan</p>
                @endif
            </div>

            <!-- Expense by Category -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengeluaran per Kategori</h3>
                @if($expenseByCategory->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($expenseByCategory as $category)
                            <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $category->category }}</span>
                                <span class="font-bold text-red-600 dark:text-red-400">Rp {{ number_format($category->total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data pengeluaran</p>
                @endif
            </div>

            <!-- Transactions by Account -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Transaksi per Akun</h3>
                @if($transactionsByAccount->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-slate-700">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Akun</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Pemasukan</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Pengeluaran</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactionsByAccount as $account)
                                    <tr class="border-b border-gray-100 dark:border-slate-700">
                                        <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $account->account->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 text-right text-green-600 dark:text-green-400">Rp {{ number_format($account->total_income, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-right text-red-600 dark:text-red-400">Rp {{ number_format($account->total_expense, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">{{ $account->transaction_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada transaksi</p>
                @endif
            </div>

            <!-- Goals Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Target</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Target Aktif</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $activeGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Target Selesai</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $completedGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Deposit</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format($totalDepositsAmount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Reports page loaded');
            
            // Income vs Expense Pie Chart
            const pieCtx = document.getElementById('incomeExpenseChart');
            console.log('Pie canvas found:', !!pieCtx);
            
            if (pieCtx) {
                const totalIncome = {{ $totalIncome ?? 0 }};
                const totalExpense = {{ $totalExpense ?? 0 }};
                console.log('Income:', totalIncome, 'Expense:', totalExpense);
                
                if (totalIncome > 0 || totalExpense > 0) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pemasukan', 'Pengeluaran'],
                            datasets: [{
                                data: [totalIncome, totalExpense],
                                backgroundColor: ['#22c55e', '#ef4444'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    console.log('Pie chart created');
                } else {
                    pieCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data</div>';
                }
            }

            // Monthly Trend Chart
            const trendCtx = document.getElementById('monthlyTrendChart');
            console.log('Trend canvas found:', !!trendCtx);
            
            if (trendCtx) {
                const monthlyLabels = @json($monthlyTrend->pluck('month')->toArray());
                const monthlyIncome = @json($monthlyTrend->pluck('income')->toArray());
                const monthlyExpense = @json($monthlyTrend->pluck('expense')->toArray());
                console.log('Monthly labels:', monthlyLabels);
                
                if (monthlyLabels && monthlyLabels.length > 0) {
                    new Chart(trendCtx, {
                        type: 'bar',
                        data: {
                            labels: monthlyLabels,
                            datasets: [{
                                label: 'Pemasukan',
                                data: monthlyIncome,
                                backgroundColor: '#22c55e',
                                borderRadius: 4
                            }, {
                                label: 'Pengeluaran',
                                data: monthlyExpense,
                                backgroundColor: '#ef4444',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    console.log('Trend chart created');
                } else {
                    trendCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data tren</div>';
                }
            }
        });
    </script>
</x-app-layout>
