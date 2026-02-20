<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $goal->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('goals.edit', $goal) }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                    Edit
                </a>
                <a href="{{ route('goals.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Goal Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded">
                            <p class="text-sm text-gray-600">Target Dana</p>
                            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded">
                            <p class="text-sm text-gray-600">Dana Terkumpul</p>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded">
                            <p class="text-sm text-gray-600">Sisa Target</p>
                            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded">
                            <p class="text-sm text-gray-600">Progress</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($goal->progress_percentage, 1) }}%</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Progress Pencapaian</span>
                            <span class="font-bold text-blue-600">{{ number_format($goal->progress_percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-4 rounded-full transition-all duration-500" 
                                style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Periode</p>
                            <p class="font-medium">{{ $goal->start_date->format('d M Y') }} - {{ $goal->end_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Status</p>
                            <p class="font-medium">
                                <span class="px-3 py-1 rounded-full text-xs
                                    @if($goal->status === 'active') bg-green-100 text-green-800
                                    @elseif($goal->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($goal->status) }}
                                </span>
                            </p>
                        </div>
                        @if($goal->category)
                        <div>
                            <p class="text-gray-600">Kategori</p>
                            <p class="font-medium">{{ $goal->category }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-600">Dibuat oleh</p>
                            <p class="font-medium">{{ $goal->creator->name }}</p>
                        </div>
                    </div>

                    @if($goal->description)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-gray-600 text-sm">Deskripsi</p>
                        <p class="mt-1">{{ $goal->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Deposits List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Riwayat Deposit</h3>
                        <a href="{{ route('deposits.create', $goal) }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded text-sm">
                            + Tambah Deposit
                        </a>
                    </div>
                    
                    @forelse($deposits as $deposit)
                        <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                            <div class="flex-1">
                                <p class="font-medium">{{ $deposit->donor_name }}</p>
                                <p class="text-sm text-gray-600">{{ $deposit->notes }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $deposit->deposit_date->format('d M Y') }} 
                                    @if($deposit->payment_method)
                                        • {{ $deposit->payment_method }}
                                    @endif
                                    • Dicatat oleh {{ $deposit->recorder->name }}
                                </p>
                            </div>
                            <div class="text-right flex items-center gap-2">
                                <div>
                                    <p class="font-bold text-green-600 text-lg">
                                        + Rp {{ number_format($deposit->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('deposits.destroy', $deposit) }}" 
                                    onsubmit="return confirm('Yakin ingin menghapus deposit ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Belum ada deposit untuk target ini.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $deposits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
