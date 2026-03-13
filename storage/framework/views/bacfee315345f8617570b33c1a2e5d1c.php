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
            <div class="flex items-center">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                        <?php echo e(__('Edit User Roles')); ?>

                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage user roles and permissions</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
                <!-- User Info -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl font-bold">
                            <?php echo e(substr($user->name, 0, 1)); ?>

                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e($user->name); ?></h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($user->email); ?></p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('admin.users.assign-role', $user)); ?>" class="p-6">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Assign Roles -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Assign Roles
                        </label>
                        
                        <div class="space-y-3">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="relative flex items-center p-4 rounded-xl border-2 transition-all cursor-pointer" :class="$user->hasRole('<?php echo e($role->name); ?>') ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300'">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="<?php echo e($role->name); ?>"
                                        id="role-<?php echo e($role->id); ?>"
                                        <?php echo e($user->hasRole($role->name) ? 'checked' : ''); ?>

                                        class="sr-only"
                                        @change="handleRoleChange($el, '<?php echo e($role->name); ?>')"
                                    >
                                    <div class="flex items-center justify-between w-full">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($role->name); ?></span>
                                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all" :class="$user->hasRole('<?php echo e($role->name); ?>') ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                            <svg x-show="$user.hasRole('<?php echo e($role->name); ?>')" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Current Permissions -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Current Permissions</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php $__empty_1 = true; $__currentLoopData = $user->getAllPermissions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-semibold">
                                    <?php echo e($permission->name); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <span class="text-gray-500 text-sm">No permissions</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 hover:text-gray-900 dark:hover:text-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                            Update Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleRoleChange(checkbox, roleName) {
            // Visual feedback is handled by Alpine.js reactivity
        }
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
<?php /**PATH C:\laragon\www\basmalah\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>