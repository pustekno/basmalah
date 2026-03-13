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
        <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
            <?php echo e(__('Laporan & Analisis')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        
        <!-- Financial Overview (BAGUS Data) -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">Ringkasan Keuangan</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-emerald-100 text-xs font-medium">Total Pemasukan</p>
                    <p class="text-2xl font-extrabold mt-1">Rp <?php echo e(number_format($totalIncome / 100, 0, ',', '.')); ?></p>
                </div>
                <div>
                    <p class="text-emerald-100 text-xs font-medium">Total Pengeluaran</p>
                    <p class="text-2xl font-extrabold mt-1">Rp <?php echo e(number_format($totalExpense / 100, 0, ',', '.')); ?></p>
                </div>
                <div>
                    <p class="text-emerald-100 text-xs font-medium">Net Income</p>
                    <p class="text-2xl font-extrabold mt-1">Rp <?php echo e(number_format($netIncome / 100, 0, ',', '.')); ?></p>
                </div>
                <div>
                    <p class="text-emerald-100 text-xs font-medium">Total Akun</p>
                    <p class="text-2xl font-extrabold mt-1"><?php echo e($totalAccounts); ?></p>
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
                <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400"><?php echo e($totalGoals); ?></p>
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
                <p class="text-2xl font-extrabold text-green-600 dark:text-green-400"><?php echo e($activeGoals); ?></p>
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
                <p class="text-2xl font-extrabold text-purple-600 dark:text-purple-400"><?php echo e($completedGoals); ?></p>
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
                <p class="text-2xl font-extrabold text-orange-600 dark:text-orange-400"><?php echo e($totalDeposits); ?></p>
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
                <p class="text-xl font-extrabold text-teal-600 dark:text-teal-400">Rp <?php echo e(number_format($totalDepositAmount, 0, ',', '.')); ?></p>
            </div>
        </div>

        <!-- Laporan Target (Goals Report) -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan Target</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Progress pencapaian target dana</p>
                    </div>
                </div>
                <a href="<?php echo e(route('goals.index')); ?>" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-medium">
                    Lihat Semua →
                </a>
            </div>

            <!-- Goals Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Total Target Amount</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1">Rp <?php echo e(number_format($totalTargetAmount, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4">
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Total Collected</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300 mt-1">Rp <?php echo e(number_format($totalCurrentAmount, 0, ',', '.')); ?></p>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-4">
                    <p class="text-sm text-orange-600 dark:text-orange-400 font-medium">Remaining</p>
                    <p class="text-2xl font-bold text-orange-700 dark:text-orange-300 mt-1">Rp <?php echo e(number_format($totalTargetAmount - $totalCurrentAmount, 0, ',', '.')); ?></p>
                </div>
            </div>

            <!-- Recent Goals -->
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 dark:border-slate-700 rounded-xl p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900 dark:text-white"><?php echo e($goal->title); ?></h4>
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg <?php echo e($goal->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'); ?>">
                                <?php echo e(ucfirst($goal->status)); ?>

                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <span><?php echo e($goal->deposits_count); ?> deposits</span>
                            <span><?php echo e(number_format($goal->progress_percentage, 1)); ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full" style="width: <?php echo e(min($goal->progress_percentage, 100)); ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada target</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Laporan Deposit -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan Deposit</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Analisis deposit per target</p>
                    </div>
                </div>
            </div>

            <!-- Deposits by Goal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Top 5 Goals by Deposits</h4>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $depositsByGoal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?php echo e($item->goal->title); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($item->count); ?> deposits</p>
                                </div>
                                <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400 ml-2">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Recent Deposits</h4>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $recentDeposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?php echo e($deposit->donor_name); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($deposit->deposit_date->format('d M Y')); ?></p>
                                </div>
                                <p class="text-sm font-bold text-blue-600 dark:text-blue-400 ml-2">Rp <?php echo e(number_format($deposit->amount, 0, ',', '.')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visualisasi Data (Charts) -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Visualisasi Data</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Chart dan grafik analisis</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goals Status Chart -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Goals by Status</h4>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $goalsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $total = $goalsData->sum('count');
                                $percentage = $total > 0 ? ($data->count / $total) * 100 : 0;
                                $color = match($data->status) {
                                    'active' => 'bg-green-500',
                                    'completed' => 'bg-blue-500',
                                    'cancelled' => 'bg-red-500',
                                    default => 'bg-gray-500'
                                };
                            ?>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize"><?php echo e($data->status); ?></span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($data->count); ?> (<?php echo e(number_format($percentage, 1)); ?>%)</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div class="<?php echo e($color); ?> h-3 rounded-full transition-all" style="width: <?php echo e($percentage); ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Monthly Deposits Trend -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Monthly Deposits (Last 6 Months)</h4>
                    <?php if($monthlyTrend->count() > 0): ?>
                        <div class="flex items-end justify-between gap-2" style="height: 250px;">
                            <?php
                                $maxAmount = $monthlyTrend->max('total') ?: 1;
                            ?>
                            <?php $__currentLoopData = $monthlyTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $percentage = ($trend->total / $maxAmount) * 100;
                                    $heightPx = max(($percentage / 100) * 200, 10); // Min 10px
                                ?>
                                <div class="flex-1 flex flex-col items-center gap-2">
                                    <!-- Bar -->
                                    <div class="w-full relative group cursor-pointer" style="height: <?php echo e($heightPx); ?>px;">
                                        <div class="absolute inset-0 bg-gradient-to-t from-blue-500 to-emerald-500 rounded-t-lg hover:opacity-80 transition-opacity"></div>
                                        <!-- Tooltip -->
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                            <div class="font-semibold">Rp <?php echo e(number_format($trend->total, 0, ',', '.')); ?></div>
                                            <div class="text-gray-300"><?php echo e($trend->count); ?> deposits</div>
                                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
                                    <!-- Label -->
                                    <div class="text-xs text-gray-600 dark:text-gray-400 text-center font-medium">
                                        <?php echo e(\Carbon\Carbon::parse($trend->month)->format('M')); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- Y-axis label -->
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Amount (Rp)</p>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            <p>Belum ada data deposit</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
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
<?php /**PATH C:\laragon\www\basmalah\resources\views/reports/index.blade.php ENDPATH**/ ?>