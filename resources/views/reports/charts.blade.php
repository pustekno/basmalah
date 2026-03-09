<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Visualisasi Data & Chart
            </h2>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goals by Status - Doughnut Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Target Berdasarkan Status</h3>
                    </div>
                    <div class="p-6">
                        <div class="relative h-64">
                            <canvas id="goalsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Income vs Expense - Pie Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pemasukan vs Pengeluaran</h3>
                    </div>
                    <div class="p-6">
                        <div class="relative h-64">
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart - Monthly Trend -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tren Bulanan</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-80">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Dana Terkumpul per Kategori</h3>
                </div>
                <div class="p-6">
                    @if($categoryData->count() > 0)
                        <div class="space-y-4">
                            @php
                                $totalAmount = $categoryData->sum('total');
                            @endphp
                            @foreach($categoryData as $data)
                                @php
                                    $percentage = $totalAmount > 0 ? ($data->total / $totalAmount * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $data->category }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">Rp {{ number_format($data->total / 100, 0, ',', '.') }} ({{ number_format($percentage, 1) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3">
                                        <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No category data available</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Goals Chart - Doughnut
            const goalsCtx = document.getElementById('goalsChart').getContext('2d');
            const goalsData = @json($goalsData);
            const totalGoals = goalsData.reduce((sum, item) => sum + item.count, 0);
            
            new Chart(goalsCtx, {
                type: 'doughnut',
                data: {
                    labels: goalsData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                    datasets: [{
                        data: goalsData.map(item => item.count),
                        backgroundColor: [
                            '#f59e0b', // yellow for active
                            '#6b7280', // gray for completed
                            '#9ca3af'  // lighter gray for cancelled
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '60%'
                }
            });

            // Income vs Expense - Pie
            const ieCtx = document.getElementById('incomeExpenseChart').getContext('2d');
            const totalIncome = {{ $totalIncome ?? 0 }};
            const totalExpense = {{ $totalExpense ?? 0 }};
            
            new Chart(ieCtx, {
                type: 'pie',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        data: [totalIncome / 100, totalExpense / 100],
                        backgroundColor: [
                            '#f59e0b', // yellow
                            '#6b7280'  // gray
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Monthly Trend - Bar
            const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
            const monthlyTrend = @json($monthlyTrend ?? []);
            
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: monthlyTrend.map(item => item.month),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: monthlyTrend.map(item => item.income / 100),
                            backgroundColor: '#f59e0b',
                            borderRadius: 6
                        },
                        {
                            label: 'Pengeluaran',
                            data: monthlyTrend.map(item => item.expense / 100),
                            backgroundColor: '#6b7280',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
