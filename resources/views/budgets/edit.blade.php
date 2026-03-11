<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Budget
        </h2>
        <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl font-medium text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('budgets.update', $budget) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                                <option value="">Select Category</option>

                                <optgroup label="Income Categories">
                                    @foreach($categories->where('type', 'income') as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $budget->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->full_name }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <optgroup label="Expense Categories">
                                    @foreach($categories->where('type', 'expense') as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $budget->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->full_name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Budget Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $budget->name) }}" required placeholder="Enter budget name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Budget Amount (Rp)
                            </label>
                            <input type="text" name="amount_display" id="amount_display" value="{{ old('amount_display', number_format($budget->amount / 100, 0, '.', '.')) }}" required placeholder="100.000"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                            <input type="hidden" name="amount" id="amount" value="{{ old('amount', $budget->amount / 100) }}">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Period -->
                        <div>
                            <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Period
                            </label>
                            <select name="period" id="period" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                                <option value="monthly" {{ old('period', $budget->period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('period', $budget->period) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="yearly" {{ old('period', $budget->period) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @error('period')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Start Date
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $budget->start_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    End Date
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $budget->end_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3" placeholder="Enter description (optional)"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all duration-200 resize-none">{{ old('description', $budget->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $budget->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 dark:border-slate-600 text-yellow-600 focus:ring-yellow-500/30">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3.5 px-6 rounded-xl transition-all duration-200">
                                Update
                            </button>
                            <a href="{{ route('budgets.index') }}" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3.5 px-6 rounded-xl transition-all duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format number with decimal (Indonesian format)
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }

        // Parse formatted number to integer
        function parseFormattedNumber(str) {
            return parseInt(str.replace(/\./g, '')) || 0;
        }

        const amountInput = document.getElementById('amount_display');
        const amountHidden = document.getElementById('amount');

        // Format on input
        amountInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                e.target.value = formatNumber(parseInt(value));
                amountHidden.value = parseInt(value);
            } else {
                e.target.value = '';
                amountHidden.value = '';
            }
        });
    </script>
</x-app-layout>
