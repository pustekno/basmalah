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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Laporan Keuangan')); ?>

            </h2>
            <a href="<?php echo e(route('reports.index')); ?>" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Kembali
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="<?php echo e(route('reports.financial')); ?>" class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="<?php echo e(request('start_date', $startDate)); ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="<?php echo e(request('end_date', $endDate)); ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Total Pemasukan</p>
                        <p class="text-3xl font-bold text-green-600">Rp <?php echo e(number_format($totalIncome, 0, ',', '.')); ?></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Total Pengeluaran</p>
                        <p class="text-3xl font-bold text-red-600">Rp <?php echo e(number_format($totalExpense, 0, ',', '.')); ?></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Saldo</p>
                        <p class="text-3xl font-bold <?php echo e($balance >= 0 ? 'text-blue-600' : 'text-red-600'); ?>">
                            Rp <?php echo e(number_format($balance, 0, ',', '.')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Income by Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Pemasukan per Kategori</h3>
                        <?php if($incomeByCategory->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $incomeByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium"><?php echo e($item->category); ?></span>
                                            <span class="text-green-600 font-bold">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" 
                                                style="width: <?php echo e($totalIncome > 0 ? ($item->total / $totalIncome * 100) : 0); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo e($totalIncome > 0 ? number_format(($item->total / $totalIncome * 100), 1) : 0); ?>% dari total pemasukan
                                        </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data pemasukan</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Expense by Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Pengeluaran per Kategori</h3>
                        <?php if($expenseByCategory->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $expenseByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium"><?php echo e($item->category); ?></span>
                                            <span class="text-red-600 font-bold">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" 
                                                style="width: <?php echo e($totalExpense > 0 ? ($item->total / $totalExpense * 100) : 0); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo e($totalExpense > 0 ? number_format(($item->total / $totalExpense * 100), 1) : 0); ?>% dari total pengeluaran
                                        </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data pengeluaran</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tren Bulanan (6 Bulan Terakhir)</h3>
                    <?php if($monthlyTrend->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2">Bulan</th>
                                        <th class="text-right py-2">Pemasukan</th>
                                        <th class="text-right py-2">Pengeluaran</th>
                                        <th class="text-right py-2">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $monthlyTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $monthBalance = $trend->income - $trend->expense;
                                        ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3"><?php echo e(\Carbon\Carbon::parse($trend->month . '-01')->format('M Y')); ?></td>
                                            <td class="text-right text-green-600 font-semibold">Rp <?php echo e(number_format($trend->income, 0, ',', '.')); ?></td>
                                            <td class="text-right text-red-600 font-semibold">Rp <?php echo e(number_format($trend->expense, 0, ',', '.')); ?></td>
                                            <td class="text-right font-bold <?php echo e($monthBalance >= 0 ? 'text-blue-600' : 'text-red-600'); ?>">
                                                Rp <?php echo e(number_format($monthBalance, 0, ',', '.')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-8">Tidak ada data tren bulanan</p>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/reports/financial.blade.php ENDPATH**/ ?>