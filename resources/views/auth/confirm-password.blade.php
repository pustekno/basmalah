<x-guest-layout>
    <!-- Page header -->
    <div class="mb-8 fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-6 bg-yellow-600 rounded-full"></div>
            <span class="text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-widest">Konfirmasi</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
            Konfirmasi Password 🔒
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Ini adalah area aman aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5 fade-in-up fade-in-up-delay-1">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-yellow-500/40 focus:border-yellow-500 dark:focus:border-yellow-400 input-glow transition-all duration-200 @error('password') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <button
                type="submit"
                class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-xl shadow-lg text-sm tracking-wide transition-all"
            >
                Konfirmasi
            </button>
        </div>
    </form>
</x-guest-layout>
