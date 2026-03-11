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
                        Laporan per Kategori
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Analisis transaksi berdasarkan kategori</p>
                </div>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="{{ route('reports.by-category') }}" class="flex flex-wrap gap-4 items-end">
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

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @forelse($categories as $category)
                    <a href="{{ route('reports.by-category', array_merge(request()->query(), ['category_id' => $category->id])) }}" 
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 hover:shadow-md transition-all {{ $categoryId == $category->id ? 'ring-2 ring-yellow-500' : '' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $category->color ?? '#f59e0b' }}20">
                                <svg class="w-5 h-5" style="color: {{ $category->color ?? '#f59e0b' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $category->transactions_count }} transaksi</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $category->name }}</h3>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($category->transactions_sum_amount ?? 0, 0, ',', '.') }}</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada kategori dengan transaksi</p>
                    </div>
                @endforelse
            </div>

            <!-- Selected Category Details -->
            @if($selectedCategory)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $selectedCategory->name }}</h3>
                            <a href="{{ route('reports.by-category', request()->except('category_id')) }}" class="text-sm text-yellow-600 hover:text-yellow-700">Lihat Semua</a>
                        </div>
                    </div>
                    
                    <!-- Chart -->
                    @if($categoryTrend->count() > 0)
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Tren 6 Bulan Terakhir</h4>
                        <div class="relative h-64">
                            <canvas id="categoryTrendChart"></canvas>
                        </div>
                    </div>
                    @endif

                    <!-- Transactions List -->
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Transaksi</h4>
                        @if($transactions && $transactions->count() > 0)
                            <div class="space-y-3">
                                @foreach($transactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $transaction->description ?? '-' }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d M Y') }} • {{ $transaction->account->name ?? '-' }}</p>
                                        </div>
                                        <p class="font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada transaksi</p>
                        @endif
                    </div>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('categoryTrendChart');
            if (ctx) {
                const categoryData = @json($categoryTrend->toArray());
                
                if (categoryData && Object.keys(categoryData).length > 0) {
                    const categories = Object.keys(categoryData);
                    const firstCategory = categoryData[categories[0]] || [];
                    const labels = firstCategory.map(d => d.month || '');
                    
                    const colors = ['#f59e0b', '#22c55e', '#3b82f6', '#ef4444', '#8b5cf6', '#ec4899'];
                    
                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: categories.map((cat, idx) => ({
                                label: cat,
                                data: categoryData[cat].map(d => d.total || 0),
                                borderColor: colors[idx % colors.length],
                                backgroundColor: colors[idx % colors.length] + '20',
                                tension: 0.3,
                                fill: false
                            }))
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
                    ctx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data tren</div>';
                }
            }
        });
    </script>
            @endif
        </div>
    </div>
</x-app-layout>
