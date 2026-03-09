<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Goals & Targets
        </h2>
        <a href="{{ route('goals.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Target Baru
        </a>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($goals as $goal)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('goals.show', $goal) }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                        {{ $goal->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $goal->description }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-lg ml-4
                                @if($goal->status === 'active') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($goal->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                {{ ucfirst($goal->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Target</p>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Terkumpul</p>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Sisa</p>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Progress</p>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">{{ number_format($goal->progress_percentage, 1) }}%</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($goal->progress_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full transition-all" style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs mt-2 text-gray-500 dark:text-gray-400">
                                <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                                <span>Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $goal->start_date->format('d M Y') }} - {{ $goal->end_date->format('d M Y') }}
                                </span>
                                @if($goal->category)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs">{{ $goal->category }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-lg text-xs font-medium">
                                    {{ $goal->deposits_count }} deposit
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada target</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mulai dengan membuat target baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('goals.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Target
                            </a>
                        </div>
                    </div>
                @endforelse

                @if($goals->hasPages())
                    <div class="mt-4">
                        {{ $goals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
