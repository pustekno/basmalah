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
            <?php echo e(__('dashboard.title')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Login As User Alert -->
            <?php if(session('original_user_id')): ?>
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/30 border-2 border-blue-200 dark:border-blue-800 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">You are currently logged in as <?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-blue-700 dark:text-blue-300">Super Admin impersonation mode is active</p>
                        </div>
                    </div>
                    <form action="<?php echo e(route('admin.users.back-to-admin')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all shadow-sm">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Back to Admin
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(__('dashboard.welcome_back')); ?>, <?php echo e(Auth::user()->name); ?>!</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1"><?php echo e(__('dashboard.overview')); ?></p>
            </div>
            
            <!-- Stats Cards - MacBook Style -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- Total Balance -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium"><?php echo e(__('dashboard.total_balance')); ?></h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Rp <?php echo e(number_format($totalBalance ?? 0, 0, ',', '.')); ?></p>
                    <p class="text-xs text-gray-400 mt-2"><?php echo e(__('dashboard.across_all_accounts')); ?></p>
                </div>

                <!-- Monthly Income -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium"><?php echo e(__('dashboard.monthly_income')); ?></h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Rp <?php echo e(number_format($monthlyIncome ?? 0, 0, ',', '.')); ?></p>
                    <p class="text-xs text-gray-400 mt-2"><?php echo e(__('dashboard.this_month')); ?></p>
                </div>

                <!-- Monthly Expense -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-gray-100 dark:bg-slate-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium"><?php echo e(__('dashboard.monthly_expense')); ?></h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Rp <?php echo e(number_format($monthlyExpense ?? 0, 0, ',', '.')); ?></p>
                    <p class="text-xs text-gray-400 mt-2"><?php echo e(__('dashboard.this_month')); ?></p>
                </div>
            </div>

            <!-- Quick Actions - Clean Button Style -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
                <a href="<?php echo e(route('transactions.create')); ?>" class="flex items-center justify-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3.5 rounded-xl font-medium transition-colors duration-200 shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span><?php echo e(__('dashboard.new_transaction')); ?></span>
                </a>
                <a href="<?php echo e(route('accounts.index')); ?>" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-3.5 rounded-xl font-medium transition-colors duration-200 shadow-sm border border-gray-200 dark:border-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <span><?php echo e(__('navigation.accounts')); ?></span>
                </a>
                <a href="<?php echo e(route('goals.index')); ?>" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-3.5 rounded-xl font-medium transition-colors duration-200 shadow-sm border border-gray-200 dark:border-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><?php echo e(__('navigation.goals')); ?></span>
                </a>
                <a href="<?php echo e(route('reports.index')); ?>" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-3.5 rounded-xl font-medium transition-colors duration-200 shadow-sm border border-gray-200 dark:border-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span><?php echo e(__('navigation.reports')); ?></span>
                </a>
            </div>

            <!-- Recent Transactions - MacBook Style Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo e(__('dashboard.recent_transactions')); ?></h3>
                </div>
                <div class="p-2">
                    <?php if(isset($recentTransactions) && $recentTransactions->count() > 0): ?>
                        <div class="divide-y divide-gray-100 dark:divide-slate-700">
                            <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors rounded-xl mx-1">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 <?php echo e($transaction->type === 'income' ? 'bg-yellow-50 dark:bg-yellow-900/30' : 'bg-gray-100 dark:bg-slate-600'); ?> rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 <?php echo e($transaction->type === 'income' ? 'text-yellow-600' : 'text-gray-500 dark:text-gray-300'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <?php if($transaction->type === 'income'): ?>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                <?php else: ?>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                <?php endif; ?>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white"><?php echo e($transaction->description); ?></p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($transaction->date->format('d M Y')); ?> · <?php echo e($transaction->account->name); ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold <?php echo e($transaction->type === 'income' ? 'text-yellow-600' : 'text-gray-700 dark:text-gray-200'); ?>">
                                            <?php echo e($transaction->type === 'income' ? '+' : '-'); ?> Rp <?php echo e(number_format($transaction->amount / 100, 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mt-4 px-4 pb-2">
                            <a href="<?php echo e(route('transactions.index')); ?>" class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                                <?php echo e(__('dashboard.view_all_transactions')); ?>

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4"><?php echo e(__('dashboard.no_transactions')); ?></p>
                            <a href="<?php echo e(route('transactions.create')); ?>" class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-medium">
                                <?php echo e(__('dashboard.create_first_transaction')); ?>

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </a>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/dashboard.blade.php ENDPATH**/ ?>