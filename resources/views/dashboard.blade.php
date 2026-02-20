<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white leading-tight">
                    Financial Dashboard
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Welcome back, <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ Auth::user()->name }}</span>
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Action Buttons -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('transactions.create') }}" class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>New Transaction</span>
                </a>
                <a href="{{ route('accounts.create') }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>New Account</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Calendar</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>All Transactions</span>
                </a>
            </div>

            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Balance -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-white/80 text-xs font-medium mb-1">Total Balance</h3>
                    <p class="text-2xl font-extrabold mb-1">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
                    <p class="text-xs text-white/70">{{ $accounts->count() }} accounts</p>
                </div>

                <!-- This Month Income -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium mb-1">Income (This Month)</h3>
                    <p class="text-2xl font-extrabold text-green-600 dark:text-green-400 mb-1">
                        +Rp {{ number_format($thisMonthStats['total_income'] / 100, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $thisMonthStats['transaction_count'] }} transactions</p>
                </div>

                <!-- This Month Expense -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium mb-1">Expense (This Month)</h3>
                    <p class="text-2xl font-extrabold text-red-600 dark:text-red-400 mb-1">
                        -Rp {{ number_format($thisMonthStats['total_expense'] / 100, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Net: Rp {{ number_format($thisMonthStats['net_income'] / 100, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Two Column Layout: Accounts & Recent Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Accounts Overview -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Accounts</h3>
                        <a href="{{ route('accounts.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-medium">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($accounts->take(4) as $account)
                            <a href="{{ route('accounts.show', $account) }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center">
                                    @if($account->type === 'cash')
                                        <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                    @elseif($account->type === 'bank')
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $account->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $account->transactions_count }} transactions</p>
                                    </div>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                            </a>
                        @empty
                            <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                                <p>No accounts yet. <a href="{{ route('accounts.create') }}" class="text-emerald-600 hover:text-emerald-700">Create one</a></p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                        <a href="{{ route('transactions.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-medium">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentTransactions->take(5) as $transaction)
                            <a href="{{ route('transactions.show', $transaction) }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center flex-1">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ $transaction->type === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }}">
                                        <svg class="w-4 h-4 {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($transaction->type === 'income')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $transaction->category }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d M') }} • {{ $transaction->account->name }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount / 100, 0, ',', '.') }}
                                </p>
                            </a>
                        @empty
                            <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                                <p>No transactions yet. <a href="{{ route('transactions.create') }}" class="text-emerald-600 hover:text-emerald-700">Create one</a></p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
