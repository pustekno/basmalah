<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Budgets') }}
        </h2>
        <a href="{{ route('budgets.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-primary-dark transition-colors shadow-md hover:shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Budget
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Budget</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rp {{ number_format($totalBudget, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Spent</h3>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                        Rp {{ number_format($totalSpent, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Remaining</h3>
                    <p class="text-2xl font-bold {{ $totalRemaining >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        Rp {{ number_format($totalRemaining, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Current Budgets -->
            @if($currentBudgets->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Current Budgets</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($currentBudgets as $budget)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $budget->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $budget->category->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $budget->isExceeded() ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' }}">
                                        {{ $budget->percentage_used }}%
                                    </span>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $budget->isExceeded() ? 'bg-red-600' : 'bg-emerald-600' }}" style="width: {{ min($budget->percentage_used, 100) }}%"></div>
                                    </div>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Spent:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($budget->total_spent, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Budget:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($budget->amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Remaining:</span>
                                        <span class="font-semibold {{ $budget->remaining >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('budgets.show', $budget) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">
                                        View Details →
                                    </a>
                                    <a href="{{ route('budgets.edit', $budget) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- All Budgets -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Budgets</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($budgets as $budget)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $budget->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $budget->start_date->format('d M Y') }} - {{ $budget->end_date->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $budget->category->color }}20; color: {{ $budget->category->color }}">
                                            {{ $budget->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ ucfirst($budget->period) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($budget->isActiveNow())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('budgets.show', $budget) }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300">View</a>
                                        <a href="{{ route('budgets.edit', $budget) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Edit</a>
                                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No budgets found. <a href="{{ route('budgets.create') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline">Create your first budget</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($budgets->hasPages())
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        {{ $budgets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
