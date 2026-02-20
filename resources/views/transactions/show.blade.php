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
                    <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                        Transaction Details
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d F Y') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('transactions.edit', $transaction) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 transition-colors shadow-lg hover:shadow-xl">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Amount Card -->
            <div class="bg-gradient-to-br {{ $transaction->type === 'income' ? 'from-emerald-500 to-teal-600' : 'from-rose-500 to-red-600' }} rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            @if($transaction->upcoming_flag)
                                <span class="ml-2 px-2 py-1 text-xs font-bold bg-yellow-400 text-yellow-900 rounded">Upcoming</span>
                            @endif
                        </p>
                        <h3 class="text-4xl font-extrabold mt-1">
                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount / 100, 0, ',', '.') }}
                        </h3>
                        <p class="text-white/70 text-sm mt-2">{{ $transaction->category }}</p>
                    </div>
                    <div class="text-right">
                        @if($transaction->type === 'income')
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                        @else
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Transaction Info -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Transaction Information</h3>
                    
                    <div class="space-y-4">
                        <!-- Account -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Transaction Date</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->transaction_date->format('l, d F Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Created -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Created At</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->created_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Proof -->
                <div class="space-y-6">
                    <!-- Description -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Description</h3>
                        @if($transaction->description)
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $transaction->description }}</p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No description provided</p>
                        @endif
                    </div>

                    <!-- Proof Image -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Proof Image</h3>
                        @if($transaction->proof_image)
                            <a href="{{ asset('storage/' . $transaction->proof_image) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $transaction->proof_image) }}" alt="Transaction Proof" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 hover:opacity-90 transition-opacity">
                            </a>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Click to view full size</p>
                        @else
                            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm">No proof image uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('accounts.show', $transaction->account) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        View Account
                    </a>
                    <a href="{{ route('transactions.create', ['account_id' => $transaction->account_id]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl text-sm font-medium text-white hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Transaction
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
