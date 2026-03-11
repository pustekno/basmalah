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
                <?php echo e(__('Laporan Deposit')); ?>

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
                    <form method="GET" action="<?php echo e(route('reports.deposits')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="<?php echo e($startDate); ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="<?php echo e($endDate); ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="goal_id" class="block text-sm font-medium text-gray-700">Target</label>
                            <select name="goal_id" id="goal_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Target</option>
                                <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($goal->id); ?>" <?php echo e($goalId == $goal->id ? 'selected' : ''); ?>>
                                        <?php echo e($goal->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <p class="text-3xl font-bold text-blue-600">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Jumlah Transaksi</p>
                        <p class="text-3xl font-bold text-green-600"><?php echo e($totalCount); ?></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Rata-rata Deposit</p>
                        <p class="text-3xl font-bold text-purple-600">Rp <?php echo e(number_format($avgAmount, 0, ',', '.')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Deposits by Goal -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Deposit per Target</h3>
                        <?php if($depositsByGoal->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $depositsByGoal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium"><?php echo e($item->goal->title); ?></span>
                                            <span class="text-blue-600 font-bold">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" 
                                                style="width: <?php echo e($totalAmount > 0 ? ($item->total / $totalAmount * 100) : 0); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo e($item->count); ?> deposit • <?php echo e($totalAmount > 0 ? number_format(($item->total / $totalAmount * 100), 1) : 0); ?>% dari total
                                        </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data deposit</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Metode Pembayaran</h3>
                        <?php if($paymentMethods->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium"><?php echo e($method->payment_method); ?></span>
                                            <span class="text-green-600 font-bold">Rp <?php echo e(number_format($method->total, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" 
                                                style="width: <?php echo e($totalAmount > 0 ? ($method->total / $totalAmount * 100) : 0); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo e($method->count); ?> transaksi • <?php echo e($totalAmount > 0 ? number_format(($method->total / $totalAmount * 100), 1) : 0); ?>%
                                        </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data metode pembayaran</p>
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
                                        <th class="text-right py-2">Total Deposit</th>
                                        <th class="text-right py-2">Jumlah Transaksi</th>
                                        <th class="text-right py-2">Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $monthlyTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3"><?php echo e(\Carbon\Carbon::parse($trend->month . '-01')->format('M Y')); ?></td>
                                            <td class="text-right text-blue-600 font-semibold">Rp <?php echo e(number_format($trend->total, 0, ',', '.')); ?></td>
                                            <td class="text-right"><?php echo e($trend->count); ?></td>
                                            <td class="text-right text-gray-600">Rp <?php echo e(number_format($trend->count > 0 ? $trend->total / $trend->count : 0, 0, ',', '.')); ?></td>
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
                                <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <?php echo e($deposit->deposit_date->format('d M Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-medium"><?php echo e($deposit->donor_name); ?></div>
                                            <?php if($deposit->notes): ?>
                                                <div class="text-gray-500 text-xs"><?php echo e(Str::limit($deposit->notes, 30)); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <?php echo e($deposit->goal->title); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <?php echo e($deposit->payment_method ?: '-'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                                            Rp <?php echo e(number_format($deposit->amount, 0, ',', '.')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Tidak ada data deposit untuk periode ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/reports/deposits.blade.php ENDPATH**/ ?>