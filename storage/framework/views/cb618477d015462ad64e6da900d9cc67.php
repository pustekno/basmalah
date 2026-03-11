<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Laporan Keuangan
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Dashboard laporan dan analisis keuangan</p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="<?php echo e(route('reports.index')); ?>" class="flex flex-wrap gap-4 items-end">
                    <!-- Masjid Filter (Super Admin only) -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Super Admin')): ?>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Masjid</label>
                        <select name="masjid_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <option value="">Semua Masjid</option>
                            <?php $__currentLoopData = $masjids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $masjid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($masjid->id); ?>" <?php echo e($masjidId == $masjid->id ? 'selected' : ''); ?>><?php echo e($masjid->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="<?php echo e($startDate); ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="<?php echo e($endDate); ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium transition-colors">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-green-700 dark:text-green-400">Total Pemasukan</p>
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp <?php echo e(number_format($totalIncome, 0, ',', '.')); ?></p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">Total Pengeluaran</p>
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp <?php echo e(number_format($totalExpense, 0, ',', '.')); ?></p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Saldo Bersih</p>
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold <?php echo e($netIncome >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                        Rp <?php echo e(number_format($netIncome, 0, ',', '.')); ?>

                    </p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-purple-700 dark:text-purple-400">Total Saldo Akun</p>
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp <?php echo e(number_format($totalBalance, 0, ',', '.')); ?></p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Income vs Expense Pie Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pemasukan vs Pengeluaran</h3>
                    <div class="relative h-64">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>

                <!-- Monthly Trend Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren Bulanan (12 Bulan)</h3>
                    <div class="relative h-64">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Income by Category -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pemasukan per Kategori</h3>
                <?php if($incomeByCategory->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $incomeByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <span class="font-medium text-gray-900 dark:text-white"><?php echo e($category->category); ?></span>
                                <span class="font-bold text-green-600 dark:text-green-400">Rp <?php echo e(number_format($category->total, 0, ',', '.')); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data pemasukan</p>
                <?php endif; ?>
            </div>

            <!-- Expense by Category -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengeluaran per Kategori</h3>
                <?php if($expenseByCategory->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $expenseByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                <span class="font-medium text-gray-900 dark:text-white"><?php echo e($category->category); ?></span>
                                <span class="font-bold text-red-600 dark:text-red-400">Rp <?php echo e(number_format($category->total, 0, ',', '.')); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data pengeluaran</p>
                <?php endif; ?>
            </div>

            <!-- Transactions by Account -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Transaksi per Akun</h3>
                <?php if($transactionsByAccount->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-slate-700">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Akun</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Pemasukan</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Pengeluaran</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $transactionsByAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-b border-gray-100 dark:border-slate-700">
                                        <td class="py-3 px-4 font-medium text-gray-900 dark:text-white"><?php echo e($account->account->name ?? 'N/A'); ?></td>
                                        <td class="py-3 px-4 text-right text-green-600 dark:text-green-400">Rp <?php echo e(number_format($account->total_income, 0, ',', '.')); ?></td>
                                        <td class="py-3 px-4 text-right text-red-600 dark:text-red-400">Rp <?php echo e(number_format($account->total_expense, 0, ',', '.')); ?></td>
                                        <td class="py-3 px-4 text-right text-gray-600 dark:text-gray-400"><?php echo e($account->transaction_count); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada transaksi</p>
                <?php endif; ?>
            </div>

            <!-- Goals Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Target</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($totalGoals); ?></p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Target Aktif</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400"><?php echo e($activeGoals); ?></p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Target Selesai</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo e($completedGoals); ?></p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Deposit</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp <?php echo e(number_format($totalDepositsAmount, 0, ',', '.')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Reports page loaded');
            
            // Income vs Expense Pie Chart
            const pieCtx = document.getElementById('incomeExpenseChart');
            console.log('Pie canvas found:', !!pieCtx);
            
            if (pieCtx) {
                const totalIncome = <?php echo e($totalIncome ?? 0); ?>;
                const totalExpense = <?php echo e($totalExpense ?? 0); ?>;
                console.log('Income:', totalIncome, 'Expense:', totalExpense);
                
                if (totalIncome > 0 || totalExpense > 0) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pemasukan', 'Pengeluaran'],
                            datasets: [{
                                data: [totalIncome, totalExpense],
                                backgroundColor: ['#22c55e', '#ef4444'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    console.log('Pie chart created');
                } else {
                    pieCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data</div>';
                }
            }

            // Monthly Trend Chart
            const trendCtx = document.getElementById('monthlyTrendChart');
            console.log('Trend canvas found:', !!trendCtx);
            
            if (trendCtx) {
                const monthlyLabels = <?php echo json_encode($monthlyTrend->pluck('month')->toArray(), 15, 512) ?>;
                const monthlyIncome = <?php echo json_encode($monthlyTrend->pluck('income')->toArray(), 15, 512) ?>;
                const monthlyExpense = <?php echo json_encode($monthlyTrend->pluck('expense')->toArray(), 15, 512) ?>;
                console.log('Monthly labels:', monthlyLabels);
                
                if (monthlyLabels && monthlyLabels.length > 0) {
                    new Chart(trendCtx, {
                        type: 'bar',
                        data: {
                            labels: monthlyLabels,
                            datasets: [{
                                label: 'Pemasukan',
                                data: monthlyIncome,
                                backgroundColor: '#22c55e',
                                borderRadius: 4
                            }, {
                                label: 'Pengeluaran',
                                data: monthlyExpense,
                                backgroundColor: '#ef4444',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    console.log('Trend chart created');
                } else {
                    trendCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">Tidak ada data tren</div>';
                }
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/reports/index.blade.php ENDPATH**/ ?>