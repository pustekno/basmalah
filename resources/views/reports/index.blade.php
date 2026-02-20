<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan & Analisis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Ringkasan Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded">
                            <p class="text-sm text-gray-600">Total Target</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalGoals }}</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded">
                            <p class="text-sm text-gray-600">Target Aktif</p>
                            <p class="text-2xl font-bold text-green-600">{{ $activeGoals }}</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded">
                            <p class="text-sm text-gray-600">Target Selesai</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $completedGoals }}</p>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded">
                            <p class="text-sm text-gray-600">Total Deposit</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $totalDeposits }}</p>
                        </div>
                        <div class="text-center p-4 bg-teal-50 rounded">
                            <p class="text-sm text-gray-600">Total Dana</p>
                            <p class="text-xl font-bold text-teal-600">Rp {{ number_format($totalDepositAmount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Goals Report Card -->
                <a href="{{ route('reports.goals') }}" class="block">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Target</h3>
                                <p class="text-sm text-gray-600">Monitoring progress target dana</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Deposits Report Card -->
                <a href="{{ route('reports.deposits') }}" class="block">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Deposit</h3>
                                <p class="text-sm text-gray-600">Analisis deposit per target</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Charts & Visualization Card -->
                <a href="{{ route('reports.charts') }}" class="block">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Visualisasi Data</h3>
                                <p class="text-sm text-gray-600">Chart dan grafik analisis</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
