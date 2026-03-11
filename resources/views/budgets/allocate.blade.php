<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Allocate Funds to "{{ $budget->name }}"
        </h2>
        <a href="{{ route('budgets.show', $budget) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl font-medium text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                    <p class="text-sm font-medium text-red-800 dark:text-red-300">Validation Error:</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-700 dark:text-red-400">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">✓ {{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                    <p class="text-sm font-medium text-red-800 dark:text-red-300">✗ {{ session('error') }}</p>
                </div>
            @endif
            
            <!-- Form Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                
                <!-- Budget Info -->
                <div class="px-8 py-6 bg-yellow-50 dark:bg-yellow-900/20 border-b border-gray-100 dark:border-slate-700">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Category</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $budget->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Budget</p>
                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($budget->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Already Allocated</p>
                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($budget->total_spent, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-8">
                    <form action="{{ route('budgets.store-allocate', $budget) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Account -->
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Account to Withdraw From
                            </label>
                            <select name="account_id" id="account_id" required x-data="{ accounts: {{ json_encode($accounts->map(function($a) { return ['id' => $a->id, 'name' => $a->name, 'balance' => $a->balance]; })) }} }" @change="document.getElementById('account-balance').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(accounts.find(a => a.id == parseInt($el.value))?.balance || 0)"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                                <option value="">-- Pilih Akun --</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} (Rp {{ number_format($account->balance, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Selected Account Balance: <span id="account-balance" class="font-semibold text-gray-900 dark:text-white">--</span>
                            </p>
                            @error('account_id')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Amount to Allocate
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-600 dark:text-gray-400 font-medium">Rp</span>
                                <input type="text" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="100.000.000"
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200"
                                    x-data="{ formatAmount(e) { let val = e.target.value.replace(/\D/g, ''); e.target.value = new Intl.NumberFormat('id-ID').format(val); } }" @input="formatAmount($event)">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Remaining Budget: <span class="font-semibold text-yellow-600">Rp {{ number_format($budget->amount - $budget->total_spent, 0, ',', '.') }}</span>
                            </p>
                            @error('amount')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description (Optional)
                            </label>
                            <textarea name="description" id="description" rows="3" placeholder="Enter description..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200 resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                            <p class="text-sm text-blue-900 dark:text-blue-300">
                                <strong>Info:</strong> Ketika Anda mengalokasikan dana, saldo akun yang dipilih akan berkurang otomatis dan progress anggaran akan meningkat.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3.5 px-6 rounded-xl transition-all duration-200">
                                Allocate Funds
                            </button>
                            <a href="{{ route('budgets.show', $budget) }}" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3.5 px-6 rounded-xl transition-all duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
