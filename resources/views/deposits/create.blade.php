<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catat Deposit untuk: ') }} {{ $goal->title }}
            </h2>
            <a href="{{ route('goals.show', $goal) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Goal Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-3 bg-blue-50 rounded">
                            <p class="text-xs text-gray-600">Target</p>
                            <p class="font-bold text-blue-600">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded">
                            <p class="text-xs text-gray-600">Terkumpul</p>
                            <p class="font-bold text-green-600">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded">
                            <p class="text-xs text-gray-600">Sisa</p>
                            <p class="font-bold text-orange-600">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposit Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('deposits.store', $goal) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="donor_name" class="block text-sm font-medium text-gray-700">Nama Donatur</label>
                            <input type="text" name="donor_name" id="donor_name" value="{{ old('donor_name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Nama lengkap donatur">
                            @error('donor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Deposit (Rp)</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deposit_date" class="block text-sm font-medium text-gray-700">Tanggal Deposit</label>
                            <input type="date" name="deposit_date" id="deposit_date" value="{{ old('deposit_date', date('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('deposit_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih metode</option>
                                <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Transfer Bank" {{ old('payment_method') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="E-Wallet" {{ old('payment_method') === 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="Lainnya" {{ old('payment_method') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('goals.show', $goal) }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">
                                Simpan Deposit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
