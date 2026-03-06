<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('accounts.index') }}" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-primary rounded-xl shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                        {{ __('Create Account') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Add a new financial account</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Account</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Fill in the details to add a new account</p>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <form action="{{ route('accounts.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Account Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Account Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 dark:border-slate-600 dark:bg-slate-900 text-gray-900 dark:text-gray-300 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                    placeholder="e.g., Main Wallet, BCA Savings">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Account Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <select name="type" id="type" required
                                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 dark:border-slate-600 dark:bg-slate-900 text-gray-900 dark:text-gray-300 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                                    <option value="">Select account type</option>
                                    <option value="cash" {{ (old('type') ?? $selectedType ?? '') === 'cash' ? 'selected' : '' }}>Kas Kecil (Cash)</option>
                                    <option value="bank" {{ (old('type') ?? $selectedType ?? '') === 'bank' ? 'selected' : '' }}>Kas Besar (Bank)</option>
                                    <option value="e-wallet" {{ (old('type') ?? $selectedType ?? '') === 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    <option value="credit_card" {{ (old('type') ?? $selectedType ?? '') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                </select>
                            </div>
                            @error('type')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Initial Balance -->
                        <div>
                            <label for="balance" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Initial Balance <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-lg font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="balance_display" 
                                    class="w-full pl-14 pr-4 py-3 rounded-lg border border-gray-200 dark:border-slate-600 dark:bg-slate-900 text-lg font-bold text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                    placeholder="0"
                                    onblur="formatBalance(this)"
                                    onfocus="cleanBalance(this)">
                                <input type="hidden" name="balance" id="balance" value="{{ old('balance', 0) }}">
                            </div>
                            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Enter the starting balance for this account</p>
                            @error('balance')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <a href="{{ route('accounts.index') }}" 
                                class="flex-1 px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600 hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200 text-center">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Create Account
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatBalance(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value);
                document.getElementById('balance').value = value;
                input.value = value.toLocaleString('id-ID');
            } else {
                document.getElementById('balance').value = 0;
                input.value = '';
            }
        }
        
        function cleanBalance(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value;
        }
    </script>
</x-app-layout>
