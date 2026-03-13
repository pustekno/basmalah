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
            <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                <?php echo e(__('Goals & Targets')); ?>

            </h2>
            <a href="<?php echo e(route('goals.create')); ?>" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Target Baru
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <?php if(session('success')): ?>
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 hover:shadow-xl transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <a href="<?php echo e(route('goals.show', $goal)); ?>" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                        <?php echo e($goal->title); ?>

                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo e($goal->description); ?></p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-lg ml-4
                                <?php if($goal->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                <?php elseif($goal->status === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                <?php endif; ?>">
                                <?php echo e(ucfirst($goal->status)); ?>

                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3">
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Target</p>
                                <p class="font-bold text-blue-700 dark:text-blue-300 text-sm">Rp <?php echo e(number_format($goal->target_amount, 0, ',', '.')); ?></p>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-3">
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">Terkumpul</p>
                                <p class="font-bold text-green-700 dark:text-green-300 text-sm">Rp <?php echo e(number_format($goal->current_amount, 0, ',', '.')); ?></p>
                            </div>
                            <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-3">
                                <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">Sisa</p>
                                <p class="font-bold text-orange-700 dark:text-orange-300 text-sm">Rp <?php echo e(number_format($goal->remaining_amount, 0, ',', '.')); ?></p>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-3">
                                <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Progress</p>
                                <p class="font-bold text-purple-700 dark:text-purple-300 text-sm"><?php echo e(number_format($goal->progress_percentage, 1)); ?>%</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                <span class="font-semibold text-gray-900 dark:text-white"><?php echo e(number_format($goal->progress_percentage, 1)); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all" style="width: <?php echo e(min($goal->progress_percentage, 100)); ?>%"></div>
                            </div>
                            <div class="flex justify-between text-xs mt-2 text-gray-500 dark:text-gray-400">
                                <span>Rp <?php echo e(number_format($goal->current_amount, 0, ',', '.')); ?></span>
                                <span>Target: Rp <?php echo e(number_format($goal->target_amount, 0, ',', '.')); ?></span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo e($goal->start_date->format('d M Y')); ?> - <?php echo e($goal->end_date->format('d M Y')); ?>

                                </span>
                                <?php if($goal->category): ?>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs"><?php echo e($goal->category); ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium">
                                    <?php echo e($goal->deposits_count); ?> deposit
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada target</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat target baru.</p>
                        <div class="mt-6">
                            <a href="<?php echo e(route('goals.create')); ?>" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-colors shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Target
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($goals->hasPages()): ?>
                    <div class="mt-4">
                        <?php echo e($goals->links()); ?>

                    </div>
                <?php endif; ?>
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
<?php /**PATH C:\laragon\www\basmalah\resources\views/goals/index.blade.php ENDPATH**/ ?>