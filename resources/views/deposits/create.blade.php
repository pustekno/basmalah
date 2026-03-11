<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Catat Deposit untuk: ') }} {{ $goal->title }}
            </h2>
            <a href="{{ route('goals.show', $goal) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium text-sm transition-colors">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Goal Summary -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-100 dark:border-yellow-800/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Target</p>
                            <p class="font-bold text-yellow-700 dark:text-yellow-400 text-lg mt-1">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-800/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Terkumpul</p>
                            <p class="font-bold text-green-700 dark:text-green-400 text-lg mt-1">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-xl border border-orange-100 dark:border-orange-800/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Sisa</p>
                            <p class="font-bold text-orange-700 dark:text-orange-400 text-lg mt-1">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposit Form -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Form Deposit Baru</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('deposits.store', $goal) }}">
                        @csrf

                        <div class="mb-6">
                            <label for="donor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Donatur</label>
                            <input type="text" name="donor_name" id="donor_name" value="{{ old('donor_name') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all"
                                placeholder="Nama lengkap donatur">
                            @error('donor_name')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Deposit (Rp)</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            @error('amount')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="deposit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Deposit</label>
                            <input type="date" name="deposit_date" id="deposit_date" value="{{ old('deposit_date', date('Y-m-d')) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            @error('deposit_date')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                <option value="">Pilih metode</option>
                                <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Transfer Bank" {{ old('payment_method') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="E-Wallet" {{ old('payment_method') === 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="Lainnya" {{ old('payment_method') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all"
                                placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('goals.show', $goal) }}" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium text-sm transition-colors">
                                Simpan Deposit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
