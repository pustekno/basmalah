<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Target & Goals') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.goals') }}" class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Total Target</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalGoals }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Target Aktif</p>
                        <p class="text-3xl font-bold text-green-600">{{ $activeGoals }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Target Selesai</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $completedGoals }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Total Target Dana</p>
                        <p class="text-xl font-bold text-purple-600">Rp {{ number_format($totalTargetAmount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Dana Terkumpul</p>
                        <p class="text-xl font-bold text-orange-600">Rp {{ number_format($totalCurrentAmount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Overall Progress -->
            @if($activeGoals > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Progress Keseluruhan Target Aktif</h3>
                    <div class="mb-2">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Total Progress</span>
                            <span class="font-bold">{{ $totalTargetAmount > 0 ? number_format(($totalCurrentAmount / $totalTargetAmount * 100), 1) : 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-4 rounded-full transition-all duration-500" 
                                style="width: {{ $totalTargetAmount > 0 ? min(($totalCurrentAmount / $totalTargetAmount * 100), 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">
                        Rp {{ number_format($totalCurrentAmount, 0, ',', '.') }} dari Rp {{ number_format($totalTargetAmount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Goals List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Target</h3>
                    
                    @forelse($goals as $goal)
                        <div class="mb-6 p-4 border rounded-lg">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-lg">
                                        <a href="{{ route('goals.show', $goal) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $goal->title }}
                                        </a>
                                    </h4>
                                    @if($goal->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $goal->description }}</p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 text-xs rounded-full ml-4
                                    @if($goal->status === 'active') bg-green-100 text-green-800
                                    @elseif($goal->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($goal->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                                <div class="text-center p-3 bg-blue-50 rounded">
                                    <p class="text-xs text-gray-600">Target</p>
                                    <p class="font-bold text-blue-600">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-center p-3 bg-green-50 rounded">
                                    <p class="text-xs text-gray-600">Terkumpul</p>
                                    <p class="font-bold text-green-600">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-center p-3 bg-orange-50 rounded">
                                    <p class="text-xs text-gray-600">Sisa</p>
                                    <p class="font-bold text-orange-600">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-center p-3 bg-purple-50 rounded">
                                    <p class="text-xs text-gray-600">Progress</p>
                                    <p class="font-bold text-purple-600">{{ number_format($goal->progress_percentage, 1) }}%</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full" 
                                        style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                                </div>
                            </div>

                            <div class="flex justify-between text-sm text-gray-600">
                                <div>
                                    <span>{{ $goal->start_date->format('d M Y') }} - {{ $goal->end_date->format('d M Y') }}</span>
                                    @if($goal->category)
                                        <span class="ml-2 px-2 py-1 bg-gray-100 rounded text-xs">{{ $goal->category }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Tidak ada target yang ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
