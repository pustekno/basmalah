<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('reports.index') }}" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Laporan Pemasukan vs Pengeluaran
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Analisis perbandingan income dan expense</p>
                </div>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="{{ route('reports.income-vs-expense') }}" class="flex flex-wrap gap-4 items-end">
                    <!-- Masjid Filter (Super Admin only) -->
                    @can('Super Admin')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Masjid</label>
                        <select name="masjid_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="">Semua Masjid</option>
                            @foreach($masjids as $masjid)
                                <option value="{{ $masjid->id }}" {{ $masjidId == $masjid->id ? 'selected' : '' }}>{{ $masjid->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endcan
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Periode</label>
                        <select name="period" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select name="year" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    @if($period === 'month')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select name="month" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                                <option value="{{ $index + 1 }}" {{ $month == $index + 1 ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
                    <p class="text-sm font-medium text-green-700 dark:text-green-400 mb-2">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
                    <p class="text-sm font-medium text-red-700 dark:text-red-400 mb-2">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-400 mb-2">Saldo Bersih</p>
                    <p class="text-2xl font-bold {{ $netIncome >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">Rp {{ number_format($netIncome, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Pie Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perbandingan</h3>
                    <div class="relative h-64">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

                <!-- Trend Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren {{ $period === 'month' ? 'Harian' : 'Bulanan' }}</h3>
                    <div class="relative h-64">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Categories -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Income Categories -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Kategori Pemasukan</h3>
                    @if($topIncomeCategories->count() > 0)
                        <div class="space-y-3">
                            @foreach($topIncomeCategories as $category)
                                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $category->category }}</span>
                                    <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format($category->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data</p>
                    @endif
                </div>

                <!-- Top Expense Categories -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Kategori Pengeluaran</h3>
                    @if($topExpenseCategories->count() > 0)
                        <div class="space-y-3">
                            @foreach($topExpenseCategories as $category)
                                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $category->category }}</span>
                                    <span class="font-bold text-red-600 dark:text-red-400">Rp {{ number_format($category->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart
            const pieCtx = document.getElementById('pieChart');
            if (pieCtx) {
                const totalIncome = {{ $totalIncome ?? 0 }};
                const totalExpense = {{ $totalExpense ?? 0 }};
                
                if (totalIncome > 0 || totalExpense > 0) {
                    new Chart(pieCtx.getContext('2d'), {
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
                } else {
                    pieCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data</div>';
                }
            }

            // Trend Chart
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                const dailyData = @json($dailyTrend->toArray());
                
                if (dailyData && dailyData.length > 0) {
                    const labels = dailyData.map(d => d.date || d.month || '');
                    const incomeData = dailyData.map(d => d.income || 0);
                    const expenseData = dailyData.map(d => d.expense || 0);
                    
                    new Chart(trendCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pemasukan',
                                data: incomeData,
                                backgroundColor: '#22c55e',
                                borderRadius: 4
                            }, {
                                label: 'Pengeluaran',
                                data: expenseData,
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
                } else {
                    trendCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data tren</div>';
                }
            }
        });
    </script>
</x-app-layout>
