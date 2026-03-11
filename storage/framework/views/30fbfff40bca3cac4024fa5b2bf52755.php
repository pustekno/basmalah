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
                <a href="<?php echo e(route('transactions.index')); ?>" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-yellow-600 rounded-xl shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                            New Transaction
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Add a new financial transaction</p>
                    </div>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <script>
        // Transaction Form Alpine Component
        document.addEventListener('alpine:init', () => {
            Alpine.data('transactionForm', function() {
                return {
                    type: 'expense',
                    amount: 0,
                    amountDisplay: '',
                    
                    // Category options based on type
                    incomeCategories: [
                        { value: 'Zakat', label: 'Zakat' },
                        { value: 'Infaq', label: 'Infaq' },
                        { value: 'Sedekah', label: 'Sedekah' },
                        { value: 'Donasi', label: 'Donasi' },
                        { value: 'Lainnya', label: 'Lainnya' }
                    ],
                    expenseCategories: [
                        { value: 'Operasional', label: 'Operasional' },
                        { value: 'Perlengkapan', label: 'Perlengkapan' },
                        { value: ' Kegiatan', label: ' Kegiatan' },
                        { value: 'Lainnya', label: 'Lainnya' }
                    ],
                    
                    get categories() {
                        return this.type === 'income' ? this.incomeCategories : this.expenseCategories;
                    },
                    
                    init() {
                        // Check URL params for type
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.get('type')) {
                            this.type = urlParams.get('type');
                        }
                        
                        // Reset category when type changes
                        this.$watch('type', () => {
                            const categorySelect = document.getElementById('category');
                            if (categorySelect) {
                                categorySelect.value = '';
                            }
                        });
                    },
                    
                    updateAmount() {
                        // Get raw value - remove all non-numeric except decimal
                        let value = this.amountDisplay.replace(/[^\d,]/g, '');
                        
                        // Handle decimal - convert Indonesian format to standard
                        if (value.includes(',')) {
                            const parts = value.split(',');
                            // If there's more than 2 digits after comma, treat last 2 as decimals
                            if (parts[parts.length - 1].length > 2) {
                                value = value.replace(/,/g, '');
                            }
                        }
                        
                        // Convert to number
                        let numValue = parseInt(value) || 0;
                        this.amount = numValue;
                        
                        // Format display with Indonesian format
                        if (numValue > 0) {
                            this.amountDisplay = numValue.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                        } else {
                            this.amountDisplay = '';
                        }
                    },
                    
                    formatAmount() {
                        if (this.amount > 0) {
                            this.amountDisplay = this.amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                        }
                    }
                }
            });
        });
    </script>

    <div class="py-6" x-data="transactionForm">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="<?php echo e(route('transactions.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <!-- Transaction Type Toggle -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Transaction Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="type = 'income'" :class="type === 'income' ? 'bg-yellow-600 text-white border-yellow-600' : 'bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-slate-600'" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            Income
                        </button>
                        <button type="button" @click="type = 'expense'" :class="type === 'expense' ? 'bg-yellow-600 text-white border-yellow-600' : 'bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-slate-600'" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                            Expense
                        </button>
                    </div>
                    <input type="hidden" name="type" :value="type">
                </div>

                <!-- Main Form -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 space-y-5">
                    <!-- Amount -->
                    <div>
                        <label for="amount_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                            <input type="text" id="amount_display" x-model="amountDisplay" @input="updateAmount" @blur="formatAmount" placeholder="0" required
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <input type="hidden" name="amount" id="amount" :value="amount">
                        </div>
                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" id="category" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <option value="">Select Category</option>
                            <template x-for="cat in categories" :key="cat.value">
                                <option :value="cat.value" x-text="cat.label"></option>
                            </template>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Account -->
                    <div>
                        <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Account</label>
                        <select name="account_id" id="account_id" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <option value="">Select Account</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction Date</label>
                        <input type="date" name="transaction_date" id="transaction_date" value="<?php echo e(old('transaction_date', date('Y-m-d'))); ?>" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                        <?php $__errorArgs = ['transaction_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Enter description (optional)"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all resize-none"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Upcoming Flag -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="upcoming_flag" id="upcoming_flag" value="1" <?php echo e(old('upcoming_flag') ? 'checked' : ''); ?>

                            class="w-5 h-5 rounded border-gray-300 dark:border-slate-600 text-yellow-600 focus:ring-yellow-500/30">
                        <label for="upcoming_flag" class="text-sm text-gray-700 dark:text-gray-300">Mark as upcoming/recurring</label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3.5 px-6 rounded-xl transition-all duration-200">
                        Create Transaction
                    </button>
                    <a href="<?php echo e(route('transactions.index')); ?>" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3.5 px-6 rounded-xl transition-all duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/transactions/create.blade.php ENDPATH**/ ?>