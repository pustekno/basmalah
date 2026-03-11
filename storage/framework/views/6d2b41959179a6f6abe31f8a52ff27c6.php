<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 transform transition-transform duration-300 ease-in-out" 
    :class="{ '-translate-x-full': !sidebarOpen }">
    <div class="flex flex-col h-full">
        <!-- Impersonation Banner -->
        <?php if(session('is_impersonating')): ?>
        <div class="bg-blue-600 dark:bg-blue-700 px-4 py-3">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <div class="text-white">
                        <div class="text-xs font-medium">Viewing as:</div>
                        <div class="text-sm font-bold"><?php echo e(session('impersonating_user_name')); ?></div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('admin.users.back-to-admin')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-3 py-1.5 bg-white text-blue-600 text-xs font-semibold rounded-lg hover:bg-blue-50 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        </svg>
                        Back
                    </button>
                </form>
            </div>
            <?php if(session('impersonating_roles')): ?>
            <div class="flex flex-wrap gap-1">
                <?php $__currentLoopData = session('impersonating_roles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">
                    <?php echo e($role); ?>

                </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <div class="mt-1 text-xs text-blue-200">
                Your Super Admin role is preserved
            </div>
        </div>
        <?php endif; ?>

        <!-- Logo & Brand with Hide Button -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 2C21.8 2 20 3.8 20 6C20 7.5 20.8 8.8 22 9.5V12H18C16.9 12 16 12.9 16 14V16H14C12.9 16 12 16.9 12 18V20H10C8.9 20 8 20.9 8 22V44H40V22C40 20.9 39.1 20 38 20H36V18C36 16.9 35.1 16 34 16H32V14C32 12.9 31.1 12 30 12H26V9.5C27.2 8.8 28 7.5 28 6C28 3.8 26.2 2 24 2ZM24 5C24.6 5 25 5.4 25 6C25 6.6 24.6 7 24 7C23.4 7 23 6.6 23 6C23 5.4 23.4 5 24 5ZM20 23H28V44H20V23ZM12 23H18V44H12V23ZM30 23H36V44H30V23Z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-extrabold text-gray-900 dark:text-white">Basmallah</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Masjid System</div>
                </div>
            </div>
            <!-- Hide Sidebar Button (inside sidebar) -->
            <button @click="sidebarOpen = false" 
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-all"
                title="Sembunyikan Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin|Viewer')): ?>
        <!-- Masjid Switcher (Super Admin & Viewer) -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="font-medium">
                            <?php if(session('active_masjid_id')): ?>
                                <?php echo e(\App\Models\Masjid::find(session('active_masjid_id'))->name); ?>

                            <?php else: ?>
                                All Masjids
                            <?php endif; ?>
                        </span>
                    </div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden z-50">
                    <?php if(session('active_masjid_id')): ?>
                    <form method="POST" action="<?php echo e(route('masjid.clear')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            View All Masjids
                        </button>
                    </form>
                    <div class="border-t border-gray-200 dark:border-slate-700"></div>
                    <?php endif; ?>
                    <?php $__currentLoopData = \App\Models\Masjid::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $masjid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <form method="POST" action="<?php echo e(route('masjid.switch')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="masjid_id" value="<?php echo e($masjid->id); ?>">
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors <?php echo e(session('active_masjid_id') == $masjid->id ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : ''); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <?php echo e($masjid->nama); ?>

                        </button>
                    </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <!-- Dashboard -->
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('dashboard') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>" title="<?php echo e(__('navigation.dashboard')); ?>">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.dashboard')); ?></span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view categories')): ?>
            <!-- Categories -->
            <a href="<?php echo e(route('categories.index')); ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('categories.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>" title="<?php echo e(__('navigation.categories')); ?>">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.categories')); ?></span>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view budgets')): ?>
            <!-- Budgets -->
            <a href="<?php echo e(route('budgets.index')); ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('budgets.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>" title="<?php echo e(__('navigation.budgets')); ?>">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.budgets')); ?></span>
            </a>
            <?php endif; ?>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view accounts')): ?>
            <!-- Accounts -->
            <a href="<?php echo e(route('accounts.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('accounts.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.accounts')); ?></span>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view transactions')): ?>
            <!-- Transactions -->
            <a href="<?php echo e(route('transactions.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('transactions.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.transactions')); ?></span>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view goals')): ?>
            <!-- Goals -->
            <a href="<?php echo e(route('goals.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('goals.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.goals')); ?></span>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view calendar')): ?>
            <!-- Calendar -->
            <a href="<?php echo e(route('calendar.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('calendar.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.calendar')); ?></span>
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view reports')): ?>
            <!-- Reports -->
            <a href="<?php echo e(route('reports.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('reports.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.reports')); ?></span>
            </a>
            <?php endif; ?>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            <!-- Users -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage users')): ?>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.users.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-medium"><?php echo e(__('navigation.users')); ?></span>
            </a>
            <?php endif; ?>
        </nav>

        <!-- User Profile -->
        <div class="border-t border-gray-200 dark:border-slate-700 p-4">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all">
                    <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center text-white font-semibold">
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e(Auth::user()->name); ?></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 right-0 mb-2 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('navigation.profile')); ?></span>
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-sm text-red-600 dark:text-red-400"><?php echo e(__('navigation.logout')); ?></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen && window.innerWidth < 1024" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black/50 z-40" x-transition></div>
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>