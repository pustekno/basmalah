<x-guest-layout>
    <!-- Page header -->
    <div class="mb-7 fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full"></div>
            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Buat Akun</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
            Daftar Akun Baru ✨
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Bergabunglah dengan sistem manajemen masjid modern dan transparan.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('register') }}"
        class="space-y-5 fade-in-up fade-in-up-delay-1"
        x-data="{
            password: '',
            get strength() {
                if (!this.password) return 0;
                let s = 0;
                if (this.password.length >= 8) s++;
                if (/[A-Z]/.test(this.password)) s++;
                if (/[0-9]/.test(this.password)) s++;
                if (/[^A-Za-z0-9]/.test(this.password)) s++;
                return s;
            },
            get strengthLabel() {
                const labels = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                return labels[this.strength] || '';
            },
            get strengthColor() {
                const colors = ['', 'bg-red-400', 'bg-yellow-400', 'bg-emerald-400', 'bg-emerald-600'];
                return colors[this.strength] || '';
            },
            get strengthTextColor() {
                const colors = ['', 'text-red-500', 'text-yellow-600', 'text-emerald-600', 'text-emerald-700'];
                return colors[this.strength] || '';
            },
            showPass: false,
            showConfirm: false
        }"
    >
        @csrf

        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Nama Lengkap
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap Anda"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('name') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Alamat Email
            </label>
            <div class="relative group">
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
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('email') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="showPass ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    x-model="password"
                    class="block w-full pl-12 pr-12 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('password') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
                <button
                    type="button"
                    @click="showPass = !showPass"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 z-10"
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

            <!-- Password Strength Indicator -->
            <div x-show="password.length > 0" x-transition class="mt-2.5">
                <div class="flex gap-1.5 mb-1.5">
                    <template x-for="i in 4" :key="i">
                        <div
                            class="h-1.5 flex-1 rounded-full transition-all duration-300"
                            :class="i <= strength ? strengthColor : 'bg-gray-200 dark:bg-slate-600'"
                        ></div>
                    </template>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold" :class="strengthTextColor" x-text="'Kekuatan: ' + strengthLabel"></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Gunakan huruf besar, angka & simbol</p>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Konfirmasi Password
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    id="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password Anda"
                    class="block w-full pl-12 pr-12 py-3.5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 dark:focus:border-emerald-400 input-glow transition-all duration-200 @error('password_confirmation') border-red-400 dark:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                />
                <button
                    type="button"
                    @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 z-10"
                >
                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms notice -->
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/40 rounded-xl px-4 py-3">
            <p class="text-xs text-emerald-700 dark:text-emerald-300 leading-relaxed">
                <svg class="w-4 h-4 inline-block mr-1 -mt-0.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Dengan mendaftar, Anda menyetujui penggunaan data untuk keperluan manajemen masjid sesuai kebijakan privasi kami.
            </p>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="btn-primary w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg text-sm tracking-wide"
        >
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Buat Akun Sekarang
            </span>
        </button>

        <!-- Divider -->
        <div class="relative flex items-center gap-3 py-1">
            <div class="flex-1 h-px bg-gray-200 dark:bg-slate-600"></div>
            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-1">atau</span>
            <div class="flex-1 h-px bg-gray-200 dark:bg-slate-600"></div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors duration-200 ml-1">
                    Masuk di sini →
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
