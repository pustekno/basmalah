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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Budgets
        </h2>
        <a href="<?php echo e(route('budgets.create')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Budget
        </a>
     <?php $__env->endSlot(); ?>

    <div class="py-6" x-data="{ deleteModal: false, deleteBudget: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <?php if(session('success')): ?>
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Budget</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rp <?php echo e(number_format($totalBudget, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Spent</h3>
                    <p class="text-2xl font-bold text-gray-700 dark:text-gray-200">
                        Rp <?php echo e(number_format($totalSpent, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Remaining</h3>
                    <p class="text-2xl font-bold <?php echo e($totalRemaining >= 0 ? 'text-yellow-600' : 'text-red-500'); ?>">
                        Rp <?php echo e(number_format($totalRemaining, 0, ',', '.')); ?>

                    </p>
                </div>
            </div>

            <!-- Current Budgets -->
            <?php if($currentBudgets->count() > 0): ?>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Current Budgets</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $currentBudgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-100 dark:border-slate-700 rounded-xl p-4 hover:shadow-md transition duration-200 bg-gray-50 dark:bg-slate-700/30">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white"><?php echo e($budget->name); ?></h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($budget->category->name); ?></p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($budget->isExceeded() ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'); ?>">
                                        <?php echo e($budget->percentage_used); ?>%
                                    </span>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="w-full bg-gray-200 dark:bg-slate-600 rounded-full h-2">
                                        <div class="h-2 rounded-full <?php echo e($budget->isExceeded() ? 'bg-red-500' : 'bg-yellow-500'); ?>" style="width: <?php echo e(min($budget->percentage_used, 100)); ?>%"></div>
                                    </div>
                                </div>

                                <div class="flex justify-between text-sm mb-3">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Spent:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1">Rp <?php echo e(number_format($budget->total_spent, 0, ',', '.')); ?></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Budget:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1">Rp <?php echo e(number_format($budget->amount, 0, ',', '.')); ?></span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-slate-600">
                                    <span class="text-sm font-medium <?php echo e($budget->remaining >= 0 ? 'text-yellow-600' : 'text-red-500'); ?>">
                                        Rp <?php echo e(number_format($budget->remaining, 0, ',', '.')); ?> left
                                    </span>
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('budgets.edit', $budget)); ?>" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                        <button @click="deleteModal = true; deleteBudget = '<?php echo e($budget->id); ?>'" class="text-sm text-gray-500 hover:text-red-600 font-medium">Delete</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- All Budgets -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Budgets</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            <?php $__empty_1 = true; $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($budget->name); ?></div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e($budget->start_date->format('d M Y')); ?> - <?php echo e($budget->end_date->format('d M Y')); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: <?php echo e($budget->category->color); ?>20; color: <?php echo e($budget->category->color); ?>">
                                            <?php echo e($budget->category->name); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <?php echo e(ucfirst($budget->period)); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        Rp <?php echo e(number_format($budget->amount, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($budget->isActiveNow()): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400">
                                                Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-3">
                                            <a href="<?php echo e(route('budgets.edit', $budget)); ?>" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                            <button @click="deleteModal = true; deleteBudget = '<?php echo e($budget->id); ?>'" class="text-sm text-gray-500 hover:text-red-600 font-medium">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No budgets found. <a href="<?php echo e(route('budgets.create')); ?>" class="text-yellow-600 hover:text-yellow-700 font-medium">Create your first budget</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($budgets->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700">
                        <?php echo e($budgets->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModal" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="deleteModal = false"></div>
                
                <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Budget</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                            Are you sure you want to delete this budget? This action cannot be undone.
                        </p>
                        <div class="flex gap-3">
                            <button @click="deleteModal = false" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-colors">
                                Cancel
                            </button>
                            <form :action="'<?php echo e(route('budgets.index')); ?>/' + deleteBudget" method="POST" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/budgets/index.blade.php ENDPATH**/ ?>