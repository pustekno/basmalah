<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.index') }}" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                            {{ __('Edit Transaction') }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update transaction details</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <script>
        // Transaction Form Alpine Component for Edit
        document.addEventListener('alpine:init', () => {
            Alpine.data('transactionFormEdit', function() {
                return {
                    type: '{{ old('type', $transaction->type) }}',
                    amount: {{ old('amount', $transaction->amount) }},
                    amountDisplay: '{{ number_format(old('amount', $transaction->amount) / 100, 0, ',', '.') }}',
                    
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
                            if (parts[parts.length - 1].length > 2) {
                                value = value.replace(/,/g, '');
                            }
                        }
                        
                        if (value) {
                            let cleanValue = value.replace(/\./g, '');
                            cleanValue = cleanValue.replace(',', '.');
                            
                            const decimalValue = parseFloat(cleanValue);
                            if (!isNaN(decimalValue)) {
                                this.amount = Math.round(decimalValue * 100);
                            }
                        } else {
                            this.amount = 0;
                        }
                    },
                    
                    formatOnBlur() {
                        let value = this.amountDisplay.replace(/[^\d,]/g, '');
                        if (value) {
                            let cleanValue = value.replace(/\./g, '').replace(',', '.');
                            const decimalValue = parseFloat(cleanValue);
                            if (!isNaN(decimalValue)) {
                                this.amountDisplay = decimalValue.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                            }
                        }
                    }
                };
            });
        });
    </script>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data" x-data="transactionFormEdit()">
                    @csrf
                    @method('PUT')

                    <div class="p-8 space-y-8">
                        <!-- Transaction Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                                Transaction Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200 hover:scale-[1.02]" :class="type === 'income' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 shadow-lg shadow-emerald-500/10' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 hover:shadow-md'">
                                    <input type="radio" name="type" value="income" x-model="type" class="sr-only">
                                    <div class="flex items-center w-full">
                                        <div class="p-3 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl shadow-lg shadow-emerald-500/30 mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900 dark:text-gray-100">Pemasukan</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Income</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="type === 'income' ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                        <svg x-show="type === 'income'" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>

                                <label class="relative flex cursor-pointer rounded-2xl border-2 p-5 transition-all duration-200 hover:scale-[1.02]" :class="type === 'expense' ? 'border-rose-500 bg-rose-50 dark:bg-rose-900/20 shadow-lg shadow-rose-500/10' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 hover:shadow-md'">
                                    <input type="radio" name="type" value="expense" x-model="type" class="sr-only">
                                    <div class="flex items-center w-full">
                                        <div class="p-3 bg-gradient-to-br from-rose-400 to-rose-600 rounded-xl shadow-lg shadow-rose-500/30 mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900 dark:text-gray-100">Pengeluaran</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Expense</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="type === 'expense' ? 'border-rose-500 bg-rose-500' : 'border-gray-300'">
                                        <svg x-show="type === 'expense'" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account & Category Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Account Selection -->
                            <div>
                                <label for="account_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    Akun <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <select name="account_id" id="account_id" required
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner">
                                        <option value="">Pilih Akun</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('account_id', $transaction->account_id) == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('account_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <select name="category" id="category" required
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner">
                                        <option value="">Pilih Kategori</option>
                                        <template x-if="type === 'income'">
                                            <>
                                                <optgroup label="Pemasukan">
                                                    <template x-for="cat in incomeCategories" :key="cat.value">
                                                        <option :value="cat.value" x-text="cat.label" :selected="'{{ $transaction->category }}' === cat.value"></option>
                                                    </template>
                                                </optgroup>
                                            </>
                                        </template>
                                        <template x-if="type === 'expense'">
                                            <>
                                                <optgroup label="Pengeluaran">
                                                    <template x-for="cat in expenseCategories" :key="cat.value">
                                                        <option :value="cat.value" x-text="cat.label" :selected="'{{ $transaction->category }}' === cat.value"></option>
                                                    </template>
                                                </optgroup>
                                            </>
                                        </template>
                                    </select>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span x-show="type === 'income'">Pemasukan: Zakat, Infaq, Sedekah, Donasi, Lainnya</span>
                                    <span x-show="type === 'expense'">Pengeluaran: Operasional, Perlengkapan, Kegiatan, Lainnya</span>
                                </p>
                                @error('category')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount_display" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Jumlah (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <span class="text-xl font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="amount_display" x-model="amountDisplay" @input="updateAmount" @blur="formatOnBlur" required
                                    class="w-full pl-16 pr-5 py-4 bg-gray-50 dark:bg-gray-700 border-0 rounded-2xl text-xl font-bold text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white dark:focus:bg-gray-600 shadow-inner transition-all"
                                    placeholder="0">
                                <input type="hidden" name="amount" x-model="amount">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Masukkan jumlah (gunakan koma untuk desimal, contoh: 1.000,50)</p>
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transaction Date -->
                        <div>
                            <label for="transaction_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Tanggal Transaksi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner">
                            </div>
                            @error('transaction_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Keterangan <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-5 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner"
                                placeholder="Tambahkan keterangan...">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upcoming Transaction Flag -->
                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-amber-800/10 rounded-2xl p-5 border border-amber-200 dark:border-amber-800/30">
                            <label class="flex items-start gap-4 cursor-pointer">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="upcoming_flag" value="1" {{ old('upcoming_flag', $transaction->upcoming_flag) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 dark:peer-focus:ring-amber-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                </div>
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-amber-800 dark:text-amber-200">
                                        Transaksi Mendatang
                                    </span>
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">
                                        Centang jika transaksi ini dijadwalkan untuk masa depan dan tidak akan mempengaruhi saldo akun
                                    </p>
                                </div>
                            </label>
                        </div>

                        <!-- Current Proof Image -->
                        @if($transaction->proof_image)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Bukti Transaksi Saat Ini
                            </label>
                            <div class="mt-2">
                                <img src="{{ Storage::url($transaction->proof_image) }}" alt="Proof Image" class="max-w-xs rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg">
                            </div>
                        </div>
                        @endif

                        <!-- Proof Image Upload -->
                        <div>
                            <label for="proof_image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Bukti Transaksi <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="proof_image" id="proof_image" accept="image/*"
                                    class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 dark:file:bg-emerald-900 dark:file:text-emerald-300">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format: JPEG, PNG, JPG, GIF (Maks. 2MB)</p>
                            @error('proof_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end gap-4 px-8 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('transactions.index') }}" class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-gray-200 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                            Update Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
