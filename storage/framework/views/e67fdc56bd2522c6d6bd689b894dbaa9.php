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
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Create New User
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add a new user to the system</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700">
                <form method="POST" action="<?php echo e(route('admin.users.store')); ?>" class="p-6" x-data="{ 
                    selectedRoles: <?php echo e(json_encode(old('roles', []))); ?>,
                    toggleRole(role, isChecked) {
                        if (isChecked) {
                            if (!this.selectedRoles.includes(role)) {
                                this.selectedRoles.push(role);
                            }
                        } else {
                            this.selectedRoles = this.selectedRoles.filter(r => r !== role);
                        }
                    },
                    selectedMasjid: <?php echo json_encode(old('masjid_id') ? ($masjids->find(old('masjid_id'))?->name ?? '') : null, 15, 512) ?>,
                    selectedMasjidId: <?php echo json_encode(old('masjid_id') ? (int)old('masjid_id') : null, 15, 512) ?>,
                    openMasjid: false,
                    masjids: <?php echo e($masjids->toJson()); ?>,
                    needsMasjid() {
                        return this.selectedRoles.length > 0 && (this.selectedRoles.includes('Admin') || this.selectedRoles.includes('Bendahara'));
                    },
                    selectMasjid(id, name) {
                        this.selectedMasjid = name;
                        this.selectedMasjidId = id;
                        this.openMasjid = false;
                        document.getElementById('masjid_id').value = id;
                    },
                    toggleMasjid() {
                        if (this.needsMasjid()) {
                            this.openMasjid = !this.openMasjid;
                        }
                    }
                }">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="<?php echo e(old('name')); ?>"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                            placeholder="Enter full name"
                        >
                        <?php $__errorArgs = ['name'];
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

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="<?php echo e(old('email')); ?>"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                            placeholder="Enter email address"
                        >
                        <?php $__errorArgs = ['email'];
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

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                            placeholder="Minimum 8 characters"
                        >
                        <?php $__errorArgs = ['password'];
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

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Confirm Password
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                            placeholder="Confirm password"
                        >
                    </div>

                    <!-- Assign Roles -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Assign Roles
                        </label>
                        
                        <div class="space-y-3">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="relative flex items-center p-4 rounded-xl border-2 transition-all cursor-pointer border-gray-200 dark:border-slate-600 hover:border-yellow-300"
                                    :class="{ 
                                        'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20': selectedRoles.includes('<?php echo e($role->name); ?>'),
                                        'border-gray-200 dark:border-slate-600': !selectedRoles.includes('<?php echo e($role->name); ?>')
                                    }">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="<?php echo e($role->name); ?>"
                                        id="role-<?php echo e($role->id); ?>"
                                        x-model="selectedRoles"
                                        class="sr-only"
                                    >
                                    <div class="flex items-center justify-between w-full">
                                        <span class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($role->name); ?></span>
                                        <div class="role-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all"
                                            :class="selectedRoles.includes('<?php echo e($role->name); ?>') ? 'border-yellow-500 bg-yellow-500' : 'border-gray-300 dark:border-slate-500'">
                                            <svg class="checkmark w-4 h-4 text-white" 
                                                :class="selectedRoles.includes('<?php echo e($role->name); ?>') ? 'block' : 'hidden'" 
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
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

                    <!-- Masjid Selection -->
                    <div class="mb-6" x-show="needsMasjid()" x-transition>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Select Masjid <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">Required for Admin/Bendahara</span>
                        </label>
                        
                        <!-- Custom Dropdown -->
                        <div class="relative">
                            <input type="hidden" name="masjid_id" id="masjid_id" value="<?php echo e(old('masjid_id')); ?>">
                            
                            <!-- Dropdown Trigger -->
                            <button 
                                type="button"
                                @click="toggleMasjid()"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl border-2 transition-all duration-200 bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600 hover:border-yellow-400 focus:outline-none focus:border-yellow-500"
                                :class="{'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20': selectedMasjid || openMasjid}"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span x-text="selectedMasjid || '-- Pilih Masjid --'" class="text-gray-900 dark:text-gray-100"></span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{'rotate-180': openMasjid}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Backdrop -->
                            <div x-show="openMasjid" x-cloak @click="openMasjid = false" class="fixed inset-0 z-40"></div>
                            
                            <!-- Dropdown Options -->
                            <div x-show="openMasjid" x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 rounded-xl border-2 border-gray-200 dark:border-slate-600 shadow-xl"
                            >
                                <div class="overflow-y-auto" style="max-height: 240px; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                                    <style>
                                        .overflow-y-auto::-webkit-scrollbar {
                                            width: 6px;
                                        }
                                        .overflow-y-auto::-webkit-scrollbar-track {
                                            background: transparent;
                                        }
                                        .overflow-y-auto::-webkit-scrollbar-thumb {
                                            background-color: #cbd5e1;
                                            border-radius: 3px;
                                        }
                                        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
                                            background-color: #475569;
                                        }
                                    </style>
                                    <?php $__currentLoopData = $masjids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $masjid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button 
                                            type="button"
                                            @click="selectMasjid(<?php echo e($masjid->id); ?>, '<?php echo e(addslashes($masjid->name)); ?>')"
                                            class="w-full flex items-start gap-3 px-4 py-3 text-left hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-150 border-b border-gray-100 dark:border-slate-700 last:border-b-0"
                                            :class="{'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-l-yellow-500': selectedMasjidId == <?php echo e($masjid->id); ?> }"
                                        >
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            <div class="flex-1 min-w-0 text-left">
                                                <p class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($masjid->name); ?></p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($masjid->address ?: 'Tidak ada alamat'); ?></p>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php $__errorArgs = ['masjid_id'];
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

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200">
                            Create User
                        </button>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-6 rounded-xl transition-all duration-200 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
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
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/admin/users/create.blade.php ENDPATH**/ ?>