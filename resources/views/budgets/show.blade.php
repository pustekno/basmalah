<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $budget->name }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('budgets.allocate', $budget) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-green-700 transition-colors">
                Allocate Funds
            </a>
            <a href="{{ route('budgets.edit', $budget) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-yellow-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl font-medium text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Budget Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Budget Amount</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rp {{ number_format($budget->amount, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Spent</h3>
                    <p class="text-2xl font-bold text-gray-700 dark:text-gray-200">
                        Rp {{ number_format($budget->total_spent, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Remaining</h3>
                    <p class="text-2xl font-bold {{ $budget->remaining >= 0 ? 'text-yellow-600' : 'text-red-500' }}">
                        Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Usage</h3>
                    <p class="text-2xl font-bold {{ $budget->isExceeded() ? 'text-red-500' : 'text-yellow-600' }}">
                        {{ $budget->percentage_used }}%
                    </p>
                </div>
            </div>

            <!-- Budget Details -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Category</h4>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $budget->category->color }}"></div>
                                <span class="text-base font-semibold text-gray-900 dark:text-white">{{ $budget->category->name }}</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Period</h4>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ ucfirst($budget->period) }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Start Date</h4>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $budget->start_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">End Date</h4>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $budget->end_date->format('d M Y') }}</p>
                        </div>
                        @if($budget->description)
                        <div class="md:col-span-2 lg:col-span-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Description</h4>
                            <p class="text-gray-700 dark:text-gray-300">{{ $budget->description }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-6">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-500 dark:text-gray-400">Budget Progress</span>
                            <span class="font-semibold {{ $budget->isExceeded() ? 'text-red-500' : 'text-yellow-600' }}">
                                {{ $budget->percentage_used }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-slate-600 rounded-full h-3">
                            <div class="h-3 rounded-full {{ $budget->isExceeded() ? 'bg-red-500' : 'bg-yellow-500' }}" style="width: {{ min($budget->percentage_used, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Allocations -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Budget Allocations</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Account</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Allocated By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($budget->allocations as $allocation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $allocation->allocated_at?->format('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $allocation->account->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $allocation->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-gray-700 dark:text-gray-200">
                                        Rp {{ number_format($allocation->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $allocation->createdBy->name ?? 'System' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No allocations yet. <a href="{{ route('budgets.allocate', $budget) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">Allocate funds</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transactions in This Period</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Account</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $transaction->transaction_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $transaction->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $transaction->account->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No transactions found for this budget period.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
