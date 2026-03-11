<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('goals.index') }}" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $goal->title }}
                </h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('goals.edit', $goal) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium text-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Goal Summary -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $goal->description }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-lg
                        @if($goal->status === 'active') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @elseif($goal->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                        @endif">
                        {{ ucfirst($goal->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Target Dana</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Dana Terkumpul</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Sisa Target</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Progress</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($goal->progress_percentage, 1) }}%</p>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Progress Pencapaian</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($goal->progress_percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3">
                        <div class="bg-yellow-500 h-3 rounded-full transition-all duration-500" style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs mt-2 text-gray-500 dark:text-gray-400">
                        <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                        <span>Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Periode</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $goal->start_date->format('d M Y') }} - {{ $goal->end_date->format('d M Y') }}</p>
                    </div>
                    @if($goal->category)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Kategori</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $goal->category }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Total Deposit</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $goal->deposits_count }} deposit</p>
                    </div>
                </div>
            </div>

            <!-- Deposits -->
            @if($goal->deposits->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Deposit History</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($goal->deposits as $deposit)
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $deposit->description ?: 'Deposit' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $deposit->deposit_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-white">+Rp {{ number_format($deposit->amount, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
