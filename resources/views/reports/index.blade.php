<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
            {{ __('Laporan & Analisis') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Financial Overview (BAGUS Data) -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Keuangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-emerald-100 text-xs font-medium">Total Pemasukan</p>
                        <p class="text-2xl font-extrabold mt-1">Rp {{ number_format($totalIncome / 100, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-emerald-100 text-xs font-medium">Total Pengeluaran</p>
                        <p class="text-2xl font-extrabold mt-1">Rp {{ number_format($totalExpense / 100, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-emerald-100 text-xs font-medium">Net Income</p>
                        <p class="text-2xl font-extrabold mt-1">Rp {{ number_format($netIncome / 100, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-emerald-100 text-xs font-medium">Total Akun</p>
                        <p class="text-2xl font-extrabold mt-1">{{ $totalAccounts }}</p>
                    </div>
                </div>
            </div>

            <!-- Goals & Deposits Stats (LIGA Data) -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Target</p>
                    <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400">{{ $totalGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Target Aktif</p>
                    <p class="text-2xl font-extrabold text-green-600 dark:text-green-400">{{ $activeGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Target Selesai</p>
                    <p class="text-2xl font-extrabold text-purple-600 dark:text-purple-400">{{ $completedGoals }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Deposit</p>
                    <p class="text-2xl font-extrabold text-orange-600 dark:text-orange-400">{{ $totalDeposits }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Dana</p>
                    <p class="text-xl font-extrabold text-teal-600 dark:text-teal-400">Rp {{ number_format($totalDepositAmount, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Report Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Goals Report Card -->
                <a href="{{ route('reports.goals') }}" class="block group">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 hover:shadow-xl hover:border-green-300 dark:hover:border-green-600 transition-all">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan Target</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Monitoring progress target dana</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Deposits Report Card -->
                <a href="{{ route('reports.deposits') }}" class="block group">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 hover:shadow-xl hover:border-blue-300 dark:hover:border-blue-600 transition-all">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan Deposit</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Analisis deposit per target</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Charts & Visualization Card -->
                <a href="{{ route('reports.charts') }}" class="block group">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 hover:shadow-xl hover:border-purple-300 dark:hover:border-purple-600 transition-all">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Visualisasi Data</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Chart dan grafik analisis</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
