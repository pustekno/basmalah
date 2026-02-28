<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Deposit') }}
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
                    <form method="GET" action="{{ route('reports.deposits') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="goal_id" class="block text-sm font-medium text-gray-700">Target</label>
                            <select name="goal_id" id="goal_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Target</option>
                                @foreach($goals as $goal)
                                    <option value="{{ $goal->id }}" {{ $goalId == $goal->id ? 'selected' : '' }}>
                                        {{ $goal->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Total Deposit</p>
                        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Jumlah Transaksi</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalCount }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Rata-rata Deposit</p>
                        <p class="text-3xl font-bold text-purple-600">Rp {{ number_format($avgAmount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Deposits by Goal -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Deposit per Target</h3>
                        @if($depositsByGoal->count() > 0)
                            <div class="space-y-3">
                                @foreach($depositsByGoal as $item)
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium">{{ $item->goal->title }}</span>
                                            <span class="text-blue-600 font-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" 
                                                style="width: {{ $totalAmount > 0 ? ($item->total / $totalAmount * 100) : 0 }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $item->count }} deposit • {{ $totalAmount > 0 ? number_format(($item->total / $totalAmount * 100), 1) : 0 }}% dari total
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Tidak ada data deposit</p>
                        @endif
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Metode Pembayaran</h3>
                        @if($paymentMethods->count() > 0)
                            <div class="space-y-3">
                                @foreach($paymentMethods as $method)
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium">{{ $method->payment_method }}</span>
                                            <span class="text-green-600 font-bold">Rp {{ number_format($method->total, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" 
                                                style="width: {{ $totalAmount > 0 ? ($method->total / $totalAmount * 100) : 0 }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $method->count }} transaksi • {{ $totalAmount > 0 ? number_format(($method->total / $totalAmount * 100), 1) : 0 }}%
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Tidak ada data metode pembayaran</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Monthly Trend -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tren Bulanan (6 Bulan Terakhir)</h3>
                    @if($monthlyTrend->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2">Bulan</th>
                                        <th class="text-right py-2">Total Deposit</th>
                                        <th class="text-right py-2">Jumlah Transaksi</th>
                                        <th class="text-right py-2">Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyTrend as $trend)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3">{{ \Carbon\Carbon::parse($trend->month . '-01')->format('M Y') }}</td>
                                            <td class="text-right text-blue-600 font-semibold">Rp {{ number_format($trend->total, 0, ',', '.') }}</td>
                                            <td class="text-right">{{ $trend->count }}</td>
                                            <td class="text-right text-gray-600">Rp {{ number_format($trend->count > 0 ? $trend->total / $trend->count : 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada data tren bulanan</p>
                    @endif
                </div>
            </div>

            <!-- Deposits List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Deposit</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donatur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($deposits as $deposit)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $deposit->deposit_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-medium">{{ $deposit->donor_name }}</div>
                                            @if($deposit->notes)
                                                <div class="text-gray-500 text-xs">{{ Str::limit($deposit->notes, 30) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ $deposit->goal->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $deposit->payment_method ?: '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                                            Rp {{ number_format($deposit->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Tidak ada data deposit untuk periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
