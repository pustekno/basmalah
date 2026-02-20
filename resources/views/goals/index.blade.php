<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Goals & Targets') }}
            </h2>
            <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Target Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($goals as $goal)
                        <div class="mb-6 p-4 border rounded-lg hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold">
                                        <a href="{{ route('goals.show', $goal) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $goal->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $goal->description }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs rounded-full 
                                    @if($goal->status === 'active') bg-green-100 text-green-800
                                    @elseif($goal->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($goal->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 my-3">
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

                            <div class="mt-3">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Progress</span>
                                    <span class="font-semibold">{{ number_format($goal->progress_percentage, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2.5 rounded-full" style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                                    <span>Target: Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="mt-3 flex justify-between items-center text-sm text-gray-600">
                                <div>
                                    <span>{{ $goal->start_date->format('d M Y') }} - {{ $goal->end_date->format('d M Y') }}</span>
                                    @if($goal->category)
                                        <span class="ml-2 px-2 py-1 bg-gray-100 rounded">{{ $goal->category }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">
                                        {{ $goal->deposits_count }} deposit
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Belum ada target yang dibuat.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $goals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
