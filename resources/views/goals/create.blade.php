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
                        Buat Target Baru
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tambahkan target fundraising baru</p>
                </div>
            </div>
        </div>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format number with Indonesian format
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            }

            const targetAmountInput = document.getElementById('target_amount_display');
            const targetAmountHidden = document.getElementById('target_amount');

            if (targetAmountInput) {
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
        });
    </script>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('goals.store') }}" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Target</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Renovasi Masjid"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" placeholder="Deskripsi singkat tentang target ini"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Amount -->
                        <div>
                            <label for="target_amount_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Dana (Rp)</label>
                            <input type="text" id="target_amount_display" placeholder="0" value="{{ old('target_amount') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            <input type="hidden" name="target_amount" id="target_amount" value="{{ old('target_amount') }}">
                            @error('target_amount')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                            <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="Contoh: Renovasi Masjid, Santunan, dll"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                            @error('category')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3.5 px-6 rounded-xl transition-all duration-200">
                                Create Target
                            </button>
                            <a href="{{ route('goals.index') }}" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium py-3.5 px-6 rounded-xl transition-all duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
