<x-guest-layout>
    <!-- Page header -->
    <div class="mb-8 fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-6 bg-yellow-600 rounded-full"></div>
            <span class="text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-widest">Reset Password</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
            Buat Password Baru 🔑
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Masukkan password baru yang kuat untuk akun Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5 fade-in-up fade-in-up-delay-1">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Alamat Email
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-yellow-500/40 focus:border-yellow-500 dark:focus:border-yellow-400 input-glow transition-all duration-200"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password Baru
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
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-yellow-500/40 focus:border-yellow-500 dark:focus:border-yellow-400 input-glow transition-all duration-200 @error('password') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Konfirmasi Password
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password Anda"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-yellow-500/40 focus:border-yellow-500 dark:focus:border-yellow-400 input-glow transition-all duration-200 @error('password_confirmation') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm font-medium text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 transition-colors duration-200">
                ← Kembali ke login
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-xl shadow-lg text-sm tracking-wide transition-all"
            >
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
