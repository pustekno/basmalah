<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('accounts.index') }}" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                        {{ $account->name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $account->type_label }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Transaction
                </a>
                <a href="{{ route('accounts.edit', $account) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-blue-700 transition-colors">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Account Balance Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Current Balance</p>
                        <h3 class="text-4xl font-extrabold mt-1">Rp {{ number_format($account->balance, 0, ',', '.') }}</h3>
                        <p class="text-emerald-100/70 text-sm mt-2">{{ $statistics['total_transactions'] }} transactions</p>
                    </div>
                    <div class="text-right">
                        @if($account->type === 'cash')
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        @elseif($account->type === 'bank')
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        @else
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Income</p>
                            <p class="text-lg font-bold text-green-600 dark:text-green-400">+Rp {{ number_format($statistics['total_income'] / 100, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Expense</p>
                            <p class="text-lg font-bold text-red-600 dark:text-red-400">-Rp {{ number_format($statistics['total_expense'] / 100, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Transactions</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $statistics['total_transactions'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Net Flow</p>
                            <p class="text-lg font-bold {{ $statistics['total_income'] - $statistics['total_expense'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format(($statistics['total_income'] - $statistics['total_expense']) / 100, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transaction History</h3>
                    <a href="{{ route('transactions.index', ['account_id' => $account->id]) }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        View All →
                    </a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($transactions as $transaction)
                        <a href="{{ route('transactions.show', $transaction) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 flex-shrink-0 {{ $transaction->type === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }}">
                                    <svg class="w-5 h-5 {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($transaction->type === 'income')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                        @endif
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $transaction->category }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d M Y') }} • {{ Str::limit($transaction->description, 25) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <p class="text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount / 100, 0, ',', '.') }}
                                </p>
                                @if($transaction->upcoming_flag)
                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">Upcoming</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No transactions</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This account has no transactions yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Transaction
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($transactions->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
