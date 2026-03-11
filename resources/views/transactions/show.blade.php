<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('transactions.index') }}" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Transaction Details
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d F Y') }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('transactions.edit', $transaction) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-yellow-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Amount Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            @if($transaction->upcoming_flag)
                                <span class="ml-2 px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-lg">Upcoming</span>
                            @endif
                        </p>
                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mt-2">
                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount / 100, 0, ',', '.') }}
                        </h3>
                        <p class="text-base text-gray-600 dark:text-gray-300 mt-2">{{ $transaction->category }}</p>
                    </div>
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-2xl flex items-center justify-center">
                        @if($transaction->type === 'income')
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transaction Information</h3>
                </div>
                <div class="p-6 space-y-5">
                    <!-- Account -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Account</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->account->name }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->account->type_label }}</span>
                    </div>

                    <!-- Category -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Category</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->category }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Transaction Date</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->transaction_date->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($transaction->description)
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Description</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Created -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Created</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
