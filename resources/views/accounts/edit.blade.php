<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('accounts.index') }}" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                            {{ __('Edit Account') }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update account information</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('accounts.update', $account) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Account Name -->
                        <div class="mb-7">
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Account Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name', $account->name) }}" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner"
                                    placeholder="e.g., Main Wallet, BCA Savings">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Type -->
                        <div class="mb-7">
                            <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Account Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <select name="type" id="type" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner">
                                    <option value="cash" {{ old('type', $account->type) === 'cash' ? 'selected' : '' }}>Kas Kecil (Cash)</option>
                                    <option value="bank" {{ old('type', $account->type) === 'bank' ? 'selected' : '' }}>Kas Besar (Bank)</option>
                                    <option value="e-wallet" {{ old('type', $account->type) === 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    <option value="credit_card" {{ old('type', $account->type) === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                </select>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Balance (Read-only) -->
                        <div class="mb-7">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Current Balance
                            </label>
                            <div class="p-5 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl shadow-lg shadow-emerald-500/30">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">
                                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-emerald-600/70 dark:text-emerald-400/70 mt-1">
                                            Balance is updated automatically through transactions
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('accounts.index') }}" 
                                class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Account
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
