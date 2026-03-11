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
            <?php echo e(__('categories.list')); ?>

        </h2>
        <a href="<?php echo e(route('categories.create')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Category
        </a>
     <?php $__env->endSlot(); ?>

    <div class="py-6" x-data="{ deleteModal: false, deleteCategory: null }">
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

            <!-- Income Categories -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Income Categories
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__empty_1 = true; $__currentLoopData = $incomeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border border-gray-100 dark:border-slate-700 rounded-xl p-4 hover:shadow-md transition duration-200 bg-gray-50 dark:bg-slate-700/30">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: <?php echo e($category->color); ?>20">
                                            <?php echo \App\Helpers\IconHelper::renderIcon($category->icon_name ?? 'tag', 'w-5 h-5', $category->color); ?>

                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white"><?php echo e($category->name); ?></h4>
                                            <?php if($category->description): ?>
                                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($category->description); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if($category->children->count() > 0): ?>
                                    <div class="mb-3 pl-4 border-l-2 border-gray-200 dark:border-slate-600">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Sub-categories:</p>
                                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-2">
                                                • <?php echo e($child->name); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="flex gap-3 mt-3 pt-3 border-t border-gray-200 dark:border-slate-600">
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                    <button @click="deleteModal = true; deleteCategory = '<?php echo e($category->id); ?>'" class="text-sm text-gray-500 hover:text-red-600 font-medium">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
                                No income categories found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Expense Categories -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                        Expense Categories
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__empty_1 = true; $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border border-gray-100 dark:border-slate-700 rounded-xl p-4 hover:shadow-md transition duration-200 bg-gray-50 dark:bg-slate-700/30">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: <?php echo e($category->color); ?>20">
                                            <?php echo \App\Helpers\IconHelper::renderIcon($category->icon_name ?? 'tag', 'w-5 h-5', $category->color); ?>

                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white"><?php echo e($category->name); ?></h4>
                                            <?php if($category->description): ?>
                                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($category->description); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if($category->children->count() > 0): ?>
                                    <div class="mb-3 pl-4 border-l-2 border-gray-200 dark:border-slate-600">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Sub-categories:</p>
                                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="text-sm text-gray-700 dark:text-gray-300 mb-1">• <?php echo e($child->name); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="flex gap-3 mt-3 pt-3 border-t border-gray-200 dark:border-slate-600">
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">Edit</a>
                                    <button @click="deleteModal = true; deleteCategory = '<?php echo e($category->id); ?>'" class="text-sm text-gray-500 hover:text-red-600 font-medium">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
                                No expense categories found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Category</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                            Are you sure you want to delete this category? This action cannot be undone.
                        </p>
                        <div class="flex gap-3">
                            <button @click="deleteModal = false" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-colors">
                                Cancel
                            </button>
                            <form :action="'<?php echo e(route('categories.index')); ?>/' + deleteCategory" method="POST" class="flex-1">
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
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/categories/index.blade.php ENDPATH**/ ?>