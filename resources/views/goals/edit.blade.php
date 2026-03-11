<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('goals.index') }}" class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit Target: {{ $goal->title }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi target dan kelola deposit</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Progress & Deposits -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Progress Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Progress Target</h3>
                        
                        <!-- Progress Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-4">
                                <p class="text-xs text-yellow-700 dark:text-yellow-400 font-medium mb-1">Target Dana</p>
                                <p class="font-bold text-gray-900 dark:text-white text-lg">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4">
                                <p class="text-xs text-green-700 dark:text-green-400 font-medium mb-1">Terkumpul</p>
                                <p class="font-bold text-gray-900 dark:text-white text-lg">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4">
                                <p class="text-xs text-blue-700 dark:text-blue-400 font-medium mb-1">Sisa</p>
                                <p class="font-bold text-gray-900 dark:text-white text-lg">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4">
                                <p class="text-xs text-purple-700 dark:text-purple-400 font-medium mb-1">Progress Dana</p>
                                <p class="font-bold text-gray-900 dark:text-white text-lg">{{ $goal->target_amount > 0 ? number_format(min(($goal->current_amount / $goal->target_amount) * 100, 100), 1) : 0 }}%</p>
                            </div>
                        </div>

                        <!-- Progress Bar Dana -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Progress Dana</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $goal->target_amount > 0 ? number_format(min(($goal->current_amount / $goal->target_amount) * 100, 100), 1) : 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-3 rounded-full transition-all duration-500" style="width: {{ $goal->target_amount > 0 ? min(($goal->current_amount / $goal->target_amount) * 100, 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Progress Bar Pengerjaan -->
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Progress Pengerjaan</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($goal->progress_percentage ?? 0, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ min($goal->progress_percentage ?? 0, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Quick Update Progress Form -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Update Progress Pengerjaan</h4>
                            <form method="POST" action="{{ route('goals.updateProgress', $goal) }}" class="flex gap-3 items-end">
                                @csrf
                                @method('PATCH')
                                <div class="flex-1">
                                    <label for="progress_percentage" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Persentase Pengerjaan (%)</label>
                                    <input type="number" name="progress_percentage" id="progress_percentage" min="0" max="100" step="0.1" value="{{ $goal->progress_percentage ?? 0 }}" required
                                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30">
                                </div>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium text-sm transition-colors">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Deposits List -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Deposit</h3>
                            <button onclick="document.getElementById('depositModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium text-sm transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Deposit
                            </button>
                        </div>

                        @if($deposits->count() > 0)
                            <div class="space-y-3">
                                @foreach($deposits as $deposit)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $deposit->donor_name }}</p>
                                                @if($deposit->account)
                                                    <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs rounded-lg">{{ $deposit->account->name }}</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $deposit->deposit_date->format('d M Y') }}</p>
                                            @if($deposit->notes)
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $deposit->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <p class="font-bold text-green-600 dark:text-green-400">+Rp {{ number_format($deposit->amount, 0, ',', '.') }}</p>
                                            <form action="{{ route('deposits.destroy', $deposit) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus deposit ini? Saldo akan dikembalikan ke akun.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada deposit</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Edit Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Edit Informasi</h3>
                        
                        <form method="POST" action="{{ route('goals.update', $goal) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Target</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $goal->title) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all resize-none">{{ old('description', $goal->description) }}</textarea>
                            </div>

                            <!-- Target Amount -->
                            <div>
                                <label for="target_amount_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Dana (Rp)</label>
                                <input type="text" id="target_amount_display" value="{{ number_format($goal->target_amount, 0, ',', '.') }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                <input type="hidden" name="target_amount" id="target_amount" value="{{ $goal->target_amount }}">
                            </div>

                            <!-- Progress Percentage -->
                            <div>
                                <label for="progress_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Progress Pengerjaan (%)</label>
                                <input type="number" name="progress_percentage" id="progress_percentage" min="0" max="100" step="0.1" value="{{ old('progress_percentage', $goal->progress_percentage ?? 0) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                @error('progress_percentage')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $goal->category) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            </div>

                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mulai</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $goal->start_date->format('Y-m-d')) }}" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selesai</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $goal->end_date->format('Y-m-d')) }}" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                    <option value="active" {{ old('status', $goal->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status', $goal->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $goal->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 pt-4">
                                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2.5 px-6 rounded-xl transition-all duration-200">
                                    Update Target
                                </button>
                                <a href="{{ route('goals.index') }}" class="w-full bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-2.5 px-6 rounded-xl transition-all duration-200 text-center">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div id="depositModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Deposit</h3>
                    <button onclick="document.getElementById('depositModal').classList.add('hidden')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('deposits.store', $goal) }}" class="space-y-4">
                    @csrf

                    <!-- Account Selection -->
                    <div>
                        <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Akun Sumber Dana</label>
                        <select name="account_id" id="account_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <option value="">Pilih Akun</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} - Rp {{ number_format($account->balance, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Donor Name -->
                    <div>
                        <label for="donor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Donatur</label>
                        <input type="text" name="donor_name" id="donor_name" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                        @error('donor_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah (Rp)</label>
                        <input type="text" id="amount_display" placeholder="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                        <input type="hidden" name="amount" id="amount">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deposit Date -->
                    <div>
                        <label for="deposit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Deposit</label>
                        <input type="date" name="deposit_date" id="deposit_date" value="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Metode Pembayaran</label>
                        <input type="text" name="payment_method" id="payment_method" placeholder="Contoh: Transfer Bank, Tunai"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all resize-none"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2.5 px-6 rounded-xl transition-all duration-200">
                            Simpan Deposit
                        </button>
                        <button type="button" onclick="document.getElementById('depositModal').classList.add('hidden')" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-2.5 px-6 rounded-xl transition-all duration-200">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format number with Indonesian format
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            }

            // Target Amount Formatting
            const targetAmountInput = document.getElementById('target_amount_display');
            const targetAmountHidden = document.getElementById('target_amount');

            if (targetAmountInput && targetAmountHidden) {
                targetAmountInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value) {
                        e.target.value = formatNumber(parseInt(value));
                        targetAmountHidden.value = parseInt(value);
                    } else {
                        e.target.value = '';
                        targetAmountHidden.value = '';
                    }
                });
            }

            // Deposit Amount Formatting
            const amountInput = document.getElementById('amount_display');
            const amountHidden = document.getElementById('amount');

            if (amountInput && amountHidden) {
                amountInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value) {
                        e.target.value = formatNumber(parseInt(value));
                        amountHidden.value = parseInt(value);
                    } else {
                        e.target.value = '';
                        amountHidden.value = '';
                    }
                });
            }

            // Close modal on outside click
            document.getElementById('depositModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
