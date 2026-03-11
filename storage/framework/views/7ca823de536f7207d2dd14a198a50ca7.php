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
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('reports.index')); ?>" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Laporan per Akun
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Analisis transaksi berdasarkan akun masjid</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <form method="GET" action="<?php echo e(route('reports.by-account')); ?>" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Periode</label>
                        <select name="period" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <option value="month" <?php echo e($period === 'month' ? 'selected' : ''); ?>>Bulanan</option>
                            <option value="year" <?php echo e($period === 'year' ? 'selected' : ''); ?>>Tahunan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select name="year" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <?php for($y = now()->year; $y >= now()->year - 5; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <?php if($period === 'month'): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select name="month" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                            <?php $__currentLoopData = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($index + 1); ?>" <?php echo e($month == $index + 1 ? 'selected' : ''); ?>><?php echo e($month); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Accounts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('reports.by-account', array_merge(request()->query(), ['account_id' => $account->id]))); ?>" 
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 hover:shadow-md transition-all <?php echo e($accountId == $account->id ? 'ring-2 ring-yellow-500' : ''); ?>">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($account->transactions_count); ?> transaksi</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1"><?php echo e($account->name); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2"><?php echo e($account->typeLabel); ?></p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Pemasukan</p>
                                <p class="font-medium text-green-600 dark:text-green-400">Rp <?php echo e(number_format($account->transactions_sum_amount ?? 0, 0, ',', '.')); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Pengeluaran</p>
                                <p class="font-medium text-red-600 dark:text-red-400">Rp <?php echo e(number_format($account->expense_sum ?? 0, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-slate-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Saat Ini</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">Rp <?php echo e(number_format($account->balance, 0, ',', '.')); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada akun</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Selected Account Details -->
            <?php if($selectedAccount): ?>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($selectedAccount->name); ?></h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($selectedAccount->typeLabel); ?></p>
                            </div>
                            <a href="<?php echo e(route('reports.by-account', request()->except('account_id'))); ?>" class="text-sm text-yellow-600 hover:text-yellow-700">Lihat Semua</a>
                        </div>
                    </div>
                    
                    <!-- Summary -->
                    <div class="grid grid-cols-3 gap-4 p-6 border-b border-gray-100 dark:border-slate-700">
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Saldo Saat Ini</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">Rp <?php echo e(number_format($selectedAccount->balance, 0, ',', '.')); ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Pemasukan</p>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400">Rp <?php echo e(number_format($transactions->where('type', 'income')->sum('amount'), 0, ',', '.')); ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Pengeluaran</p>
                            <p class="text-xl font-bold text-red-600 dark:text-red-400">Rp <?php echo e(number_format($transactions->where('type', 'expense')->sum('amount'), 0, ',', '.')); ?></p>
                        </div>
                    </div>

                    <!-- Transactions List -->
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Transaksi (<?php echo e($transactions->count()); ?>)</h4>
                        <?php if($transactions->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-white"><?php echo e($transaction->description ?? '-'); ?></p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($transaction->transaction_date->format('d M Y')); ?> • <?php echo e($transaction->category ?? '-'); ?></p>
                                        </div>
                                        <p class="font-bold <?php echo e($transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                            <?php echo e($transaction->type === 'income' ? '+' : '-'); ?>Rp <?php echo e(number_format($transaction->amount, 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada transaksi</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/reports/by-account.blade.php ENDPATH**/ ?>