<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Balance -->
                <div class="bg-primary rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-white/80 text-xs font-medium mb-1">{{ __('dashboard.total_balance') }}</h3>
                    <p class="text-2xl font-extrabold mb-1">Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-white/60">{{ __('dashboard.across_all_accounts') }}</p>
                </div>

                <!-- Monthly Income -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-primary-lightest rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-xs font-medium mb-1">{{ __('dashboard.monthly_income') }}</h3>
                    <p class="text-2xl font-extrabold text-gray-900 mb-1">Rp {{ number_format($monthlyIncome ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">{{ __('dashboard.this_month') }}</p>
                </div>

                <!-- Monthly Expense -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-xs font-medium mb-1">{{ __('dashboard.monthly_expense') }}</h3>
                    <p class="text-2xl font-extrabold text-gray-900 mb-1">Rp {{ number_format($monthlyExpense ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">{{ __('dashboard.this_month') }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('transactions.create') }}" class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-3 rounded-xl font-semibold transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('dashboard.new_transaction') }}
                </a>
                <a href="{{ route('accounts.index') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-3 rounded-xl font-semibold transition shadow-lg border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    {{ __('navigation.accounts') }}
                </a>
                <a href="{{ route('goals.index') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-3 rounded-xl font-semibold transition shadow-lg border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('navigation.goals') }}
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-3 rounded-xl font-semibold transition shadow-lg border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('navigation.reports') }}
                </a>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl shadow-lg">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('dashboard.recent_transactions') }}</h3>
                </div>
                <div class="p-6">
                    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentTransactions as $transaction)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 {{ $transaction->type === 'income' ? 'bg-primary-lightest' : 'bg-red-50' }} rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 {{ $transaction->type === 'income' ? 'text-primary' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($transaction->type === 'income')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $transaction->description }}</p>
                                            <p class="text-sm text-gray-500">{{ $transaction->date->format('d M Y') }} • {{ $transaction->account->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold {{ $transaction->type === 'income' ? 'text-primary' : 'text-red-500' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('transactions.index') }}" class="text-primary hover:text-primary-dark font-semibold">
                                {{ __('dashboard.view_all_transactions') }} →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">{{ __('dashboard.no_transactions') }}</p>
                            <a href="{{ route('transactions.create') }}" class="inline-block mt-4 text-primary hover:text-primary-dark font-semibold">
                                {{ __('dashboard.create_first_transaction') }} →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
