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
            Transactions
        </h2>
        <a href="<?php echo e(route('transactions.create')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Transaction
        </a>
     <?php $__env->endSlot(); ?>

    <div class="py-6" x-data="{ deleteModal: false, deleteTransaction: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <?php if(session('success')): ?>
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?php echo e(route('transactions.create')); ?>?type=income" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 hover:shadow-md hover:border-yellow-300 dark:hover:border-yellow-600 transition-all group">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-900 dark:text-white">Pemasukan</span>
                </a>
                <a href="<?php echo e(route('transactions.create')); ?>?type=expense" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 hover:shadow-md hover:border-yellow-300 dark:hover:border-yellow-600 transition-all group">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-900 dark:text-white">Pengeluaran</span>
                </a>
                <a href="<?php echo e(route('transactions.create')); ?>?type=income&upcoming=1" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 hover:shadow-md hover:border-yellow-300 dark:hover:border-yellow-600 transition-all group">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-900 dark:text-white">Upcoming Income</span>
                </a>
                <a href="<?php echo e(route('transactions.create')); ?>?type=expense&upcoming=1" class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 hover:shadow-md hover:border-yellow-300 dark:hover:border-yellow-600 transition-all group">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-900 dark:text-white">Upcoming Expense</span>
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="<?php echo e(route('transactions.index')); ?>" class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Account</label>
                        <select name="account_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-sm focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="">All Accounts</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>" <?php echo e(request('account_id') == $account->id ? 'selected' : ''); ?>>
                                    <?php echo e($account->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Type</label>
                        <select name="type" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-sm focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="">All Types</option>
                            <option value="income" <?php echo e(request('type') == 'income' ? 'selected' : ''); ?>>Pemasukan</option>
                            <option value="expense" <?php echo e(request('type') == 'expense' ? 'selected' : ''); ?>>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-sm focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">End Date</label>
                        <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-sm focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl transition-colors text-sm font-medium">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transactions List -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Transactions</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 bg-yellow-100 dark:bg-yellow-900/30">
                                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <?php if($transaction->type === 'income'): ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                        <?php else: ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                        <?php endif; ?>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"><?php echo e($transaction->category); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($transaction->transaction_date->format('d M Y')); ?> • <?php echo e($transaction->account->name); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <?php if($transaction->upcoming_flag): ?>
                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-lg">Upcoming</span>
                                <?php endif; ?>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    <?php echo e($transaction->type === 'income' ? '+' : '-'); ?>Rp <?php echo e(number_format($transaction->amount / 100, 0, ',', '.')); ?>

                                </p>
                                <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">No transactions</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Get started by creating a new transaction.</p>
                            <a href="<?php echo e(route('transactions.create')); ?>" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition-colors mt-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Transaction
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($transactions->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700">
                        <?php echo e($transactions->links()); ?>

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
<?php /**PATH C:\laragon\www\basmalah\resources\views/transactions/index.blade.php ENDPATH**/ ?>