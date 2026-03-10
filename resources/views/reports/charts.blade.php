<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Visualisasi Data & Chart') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Goals by Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Target Berdasarkan Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $totalGoals = $goalsData->sum('count');
                            $statusColors = [
                                'active' => ['bg' => 'bg-green-500', 'text' => 'text-green-600', 'label' => 'Aktif'],
                                'completed' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'label' => 'Selesai'],
                                'cancelled' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-600', 'label' => 'Dibatalkan'],
                            ];
                        @endphp
                        @foreach($goalsData as $data)
                            @php
                                $percentage = $totalGoals > 0 ? ($data->count / $totalGoals * 100) : 0;
                                $color = $statusColors[$data->status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-600', 'label' => ucfirst($data->status)];
                            @endphp
                            <div class="text-center">
                                <div class="relative inline-flex items-center justify-center w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-200"/>
                                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" 
                                            class="{{ str_replace('bg-', 'text-', $color['bg']) }}"
                                            stroke-dasharray="{{ 2 * 3.14159 * 56 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 56 * (1 - $percentage / 100) }}"
                                            stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute">
                                        <div class="text-2xl font-bold {{ $color['text'] }}">{{ $data->count }}</div>
                                    </div>
                                </div>
                                <p class="font-semibold">{{ $color['label'] }}</p>
                                <p class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Dana Terkumpul per Kategori -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Dana Terkumpul per Kategori</h3>
                    @if($categoryData->count() > 0)
                        @php
                            $maxAmount = $categoryData->max('total');
                            $colors = ['blue', 'green', 'purple', 'orange', 'teal', 'pink', 'indigo'];
                        @endphp
                        <div class="space-y-4">
                            @foreach($categoryData as $index => $data)
                                @php
                                    $color = $colors[$index % count($colors)];ywyttewy31
                                    $percentage = $maxAmount > 0 ? =[
                                        ($data->total / $maxA
                                    834ldouc4i8ic487f9.7f ++++++
                                    "
                        , ?235P[9786I1opmount * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-medium">{{ $data->category }}</span>
                                        <span class="text-{{ $color }}-600 font-bold">Rp {{ number_format($data->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="relative h-8 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="absolute h-full bg-gradient-to-r from-{{ $color }}-400 to-{{ $color }}-600 rounded-full transition-all duration-500"
                                            style="width: {{ $percentage }}%">
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-white">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada data kategori</p>
                    @endif
                </div>
            </div>

            <!-- Monthly Trends -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goals Created per Month -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Target Dibuat per Bulan (12 Bulan)</h3>
                        @if($monthlyGoals->count() > 0)
                            @php
                                $maxGoals = $monthlyGoals->max('count');
                            @endphp
                            <div class="flex items-end justify-between h-64 gap-2">
                                @foreach($monthlyGoals as $data)
                                    @php
                                        $height = $maxGoals > 0 ? ($data->count / $maxGoals * 100) : 0;
                                    @endphp
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="text-xs font-semibold text-blue-600 mb-1">{{ $data->count }}</div>
                                        <div class="w-full bg-gradient-to-t from-blue-500 to-blue-300 rounded-t transition-all duration-500 hover:from-blue-600 hover:to-blue-400"
                                            style="height: {{ $height }}%">
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2 transform -rotate-45 origin-top-left">
                                            {{ \Carbon\Carbon::parse($data->month . '-01')->format('M') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
                        @endif
                    </div>
                </div>

                <!-- Deposits per Month -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Total Deposit per Bulan (12 Bulan)</h3>
                        @if($monthlyDeposits->count() > 0)
                            @php
                                $maxDeposits = $monthlyDeposits->max('total');
                            @endphp
                            <div class="flex items-end justify-between h-64 gap-2">
                                @foreach($monthlyDeposits as $data)
                                    @php
                                        $height = $maxDeposits > 0 ? ($data->total / $maxDeposits * 100) : 0;
                                    @endphp
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="text-xs font-semibold text-green-600 mb-1">
                                            {{ number_format($data->total / 1000000, 1) }}M
                                        </div>
                                        <div class="w-full bg-gradient-to-t from-green-500 to-green-300 rounded-t transition-all duration-500 hover:from-green-600 hover:to-green-400"
                                            style="height: {{ $height }}%">
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2 transform -rotate-45 origin-top-left">
                                            {{ \Carbon\Carbon::parse($data->month . '-01')->format('M') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Note -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Visualisasi Data</p>
                        <p>Chart dan grafik ini menggunakan CSS untuk visualisasi. Untuk chart yang lebih interaktif, dapat diintegrasikan dengan Chart.js atau library lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
