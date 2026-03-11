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
                <?php echo e(__('Visualisasi Data & Chart')); ?>

            </h2>
            <a href="<?php echo e(route('reports.index')); ?>" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Kembali
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Goals by Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Target Berdasarkan Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php
                            $totalGoals = $goalsData->sum('count');
                            $statusColors = [
                                'active' => ['bg' => 'bg-green-500', 'text' => 'text-green-600', 'label' => 'Aktif'],
                                'completed' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'label' => 'Selesai'],
                                'cancelled' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-600', 'label' => 'Dibatalkan'],
                            ];
                        ?>
                        <?php $__currentLoopData = $goalsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $percentage = $totalGoals > 0 ? ($data->count / $totalGoals * 100) : 0;
                                $color = $statusColors[$data->status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-600', 'label' => ucfirst($data->status)];
                            ?>
                            <div class="text-center">
                                <div class="relative inline-flex items-center justify-center w-32 h-32 mb-4">
                                    <svg class="transform -rotate-90 w-32 h-32">
                                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-200"/>
                                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="transparent" 
                                            class="<?php echo e(str_replace('bg-', 'text-', $color['bg'])); ?>"
                                            stroke-dasharray="<?php echo e(2 * 3.14159 * 56); ?>"
                                            stroke-dashoffset="<?php echo e(2 * 3.14159 * 56 * (1 - $percentage / 100)); ?>"
                                            stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute">
                                        <div class="text-2xl font-bold <?php echo e($color['text']); ?>"><?php echo e($data->count); ?></div>
                                    </div>
                                </div>
                                <p class="font-semibold"><?php echo e($color['label']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e(number_format($percentage, 1)); ?>%</p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Dana Terkumpul per Kategori -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Dana Terkumpul per Kategori</h3>
                    <?php if($categoryData->count() > 0): ?>
                        <?php
                            $maxAmount = $categoryData->max('total');
                            $colors = ['blue', 'green', 'purple', 'orange', 'teal', 'pink', 'indigo'];
                        ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $categoryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $color = $colors[$index % count($colors)];
                                    $percentage = $maxAmount > 0 ? ($data->total / $maxAmount * 100) : 0;
                                ?>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-medium"><?php echo e($data->category); ?></span>
                                        <span class="text-<?php echo e($color); ?>-600 font-bold">Rp <?php echo e(number_format($data->total, 0, ',', '.')); ?></span>
                                    </div>
                                    <div class="relative h-8 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="absolute h-full bg-gradient-to-r from-<?php echo e($color); ?>-400 to-<?php echo e($color); ?>-600 rounded-full transition-all duration-500"
                                            style="width: <?php echo e($percentage); ?>%">
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-white">
                                            <?php echo e(number_format($percentage, 1)); ?>%
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-8">Tidak ada data kategori</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Monthly Trends -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goals Created per Month -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Target Dibuat per Bulan (12 Bulan)</h3>
                        <?php if($monthlyGoals->count() > 0): ?>
                            <?php
                                $maxGoals = $monthlyGoals->max('count');
                            ?>
                            <div class="flex items-end justify-between h-64 gap-2">
                                <?php $__currentLoopData = $monthlyGoals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $height = $maxGoals > 0 ? ($data->count / $maxGoals * 100) : 0;
                                    ?>
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="text-xs font-semibold text-blue-600 mb-1"><?php echo e($data->count); ?></div>
                                        <div class="w-full bg-gradient-to-t from-blue-500 to-blue-300 rounded-t transition-all duration-500 hover:from-blue-600 hover:to-blue-400"
                                            style="height: <?php echo e($height); ?>%">
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2 transform -rotate-45 origin-top-left">
                                            <?php echo e(\Carbon\Carbon::parse($data->month . '-01')->format('M')); ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Deposits per Month -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Total Deposit per Bulan (12 Bulan)</h3>
                        <?php if($monthlyDeposits->count() > 0): ?>
                            <?php
                                $maxDeposits = $monthlyDeposits->max('total');
                            ?>
                            <div class="flex items-end justify-between h-64 gap-2">
                                <?php $__currentLoopData = $monthlyDeposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $height = $maxDeposits > 0 ? ($data->total / $maxDeposits * 100) : 0;
                                    ?>
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="text-xs font-semibold text-green-600 mb-1">
                                            <?php echo e(number_format($data->total / 1000000, 1)); ?>M
                                        </div>
                                        <div class="w-full bg-gradient-to-t from-green-500 to-green-300 rounded-t transition-all duration-500 hover:from-green-600 hover:to-green-400"
                                            style="height: <?php echo e($height); ?>%">
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2 transform -rotate-45 origin-top-left">
                                            <?php echo e(\Carbon\Carbon::parse($data->month . '-01')->format('M')); ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
                        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/reports/charts.blade.php ENDPATH**/ ?>