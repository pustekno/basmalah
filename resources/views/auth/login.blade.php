<x-guest-layout>
    <!-- Page header -->
    <div class="mb-8 fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full"></div>
            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Masuk Akun</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
            Selamat Datang Kembali 👋
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Masuk ke akun Anda untuk mengelola sistem informasi masjid.
        </p>
    </div>

    <!-- Session status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 fade-in-up fade-in-up-delay-1">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Alamat Email
            </label>
            <div class="relative group">
                <!-- Icon -->
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('email') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div x-data="{ showPass: false }">
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors duration-200">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <!-- Lock icon -->
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <!-- Input -->
                <input
                    id="password"
                    :type="showPass ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda"
                    class="block w-full pl-12 pr-12 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('password') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
                <!-- Toggle visibility -->
                <button
                    type="button"
                    @click="showPass = !showPass"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 z-10"
                    :aria-label="showPass ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group select-none">
                <div class="relative">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="sr-only peer"
                    />
                    <div class="w-10 h-5 bg-gray-200 dark:bg-slate-600 peer-checked:bg-emerald-500 rounded-full transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-emerald-500/30"></div>
                    <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors duration-200">
                    Ingat saya
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="btn-primary w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg text-sm tracking-wide mt-2"
        >
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk Sekarang
            </span>
        </button>

        <!-- Divider -->
        <div class="relative flex items-center gap-3 py-1">
            <div class="flex-1 h-px bg-gray-200 dark:bg-slate-600"></div>
            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-1">atau</span>
            <div class="flex-1 h-px bg-gray-200 dark:bg-slate-600"></div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors duration-200 ml-1">
                    Daftar sekarang →
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
