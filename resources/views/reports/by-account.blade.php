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
                        Laporan per Akun
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Analisis transaksi berdasarkan akun masjid</p>
                </div>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="{{ route('reports.by-account') }}" class="flex flex-wrap gap-4 items-end">
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

            <!-- Accounts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @forelse($accounts as $account)
                    <a href="{{ route('reports.by-account', array_merge(request()->query(), ['account_id' => $account->id])) }}" 
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 hover:shadow-md transition-all {{ $accountId == $account->id ? 'ring-2 ring-yellow-500' : '' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $account->transactions_count }} transaksi</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $account->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $account->typeLabel }}</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Pemasukan</p>
                                <p class="font-medium text-green-600 dark:text-green-400">Rp {{ number_format(($account->transactions_sum_amount ?? 0) / 100, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Pengeluaran</p>
                                <p class="font-medium text-red-600 dark:text-red-400">Rp {{ number_format($account->expense_sum ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-slate-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Saat Ini</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada akun</p>
                    </div>
                @endforelse
            </div>

            <!-- Selected Account Details -->
            @if($selectedAccount)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $selectedAccount->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $selectedAccount->typeLabel }}</p>
                            </div>
                            <a href="{{ route('reports.by-account', request()->except('account_id')) }}" class="text-sm text-yellow-600 hover:text-yellow-700">Lihat Semua</a>
                        </div>
                    </div>
                    
                    <!-- Summary -->
                    <div class="grid grid-cols-3 gap-4 p-6 border-b border-gray-100 dark:border-slate-700">
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Saldo Saat Ini</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($selectedAccount->balance, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Pemasukan</p>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($transactions->where('type', 'income')->sum('amount') / 100, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Pengeluaran</p>
                            <p class="text-xl font-bold text-red-600 dark:text-red-400">Rp {{ number_format($transactions->where('type', 'expense')->sum('amount') / 100, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Transactions List -->
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Transaksi ({{ $transactions->count() }})</h4>
                        @if($transactions->count() > 0)
                            <div class="space-y-3">
                                @foreach($transactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $transaction->description ?? '-' }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d M Y') }} • {{ $transaction->category ?? '-' }}</p>
                                        </div>
                                        <p class="font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount / 100, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada transaksi</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
