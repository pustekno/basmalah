<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Basmallah') }} – Sistem Informasi Manajemen Masjid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1b9b8a',
                            light: '#2cb8a0',
                            lightest: '#e8f7f4',
                            dark: '#0d5d52',
                            darker: '#044139',
                        }
                    },
                    fontFamily: {
                        display: ['Sora', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Form slide animation */
        .form-container {
            position: relative;
            overflow: hidden;
        }
        
        .form-wrapper {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .form-wrapper.login-active {
            transform: translateX(0);
        }
        
        .form-wrapper.register-active {
            transform: translateX(-50%);
        }
        
        /* Individual forms */
        .auth-form {
            width: 200%;
            display: flex;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .auth-form.show-register {
            transform: translateX(-50%);
        }
        
        .form-left, .form-right {
            width: 50%;
            padding: 0 1rem;
        }
        
        /* Input focus */
        .input-focus {
            transition: all 0.2s ease;
        }
        .input-focus:focus {
            border-color: #1b9b8a;
            box-shadow: 0 0 0 3px rgba(27, 155, 138, 0.1);
        }
        
        /* Button hover */
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0d5d52;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(27, 155, 138, 0.4);
        }
        
        /* Link hover */
        .link-hover {
            transition: all 0.2s ease;
        }
        .link-hover:hover {
            color: #0d5d52;
        }
        .link-hover:hover svg {
            transform: translateX(4px);
        }
        .link-hover svg {
            transition: transform 0.2s ease;
        }
        
        /* Reveal animation */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        
        /* Checkbox custom */
        .checkbox-custom {
            transition: all 0.2s ease;
        }
        .checkbox-custom:checked {
            background-color: #1b9b8a;
            border-color: #1b9b8a;
        }
        
        /* Password strength */
        .strength-bar {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex">
        
        <!-- LEFT PANEL - Brand Info -->
        <div class="hidden lg:flex lg:w-[45%] bg-primary relative overflow-hidden flex-col justify-between">
            <!-- Geometric patterns -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-40 h-40 bg-white rounded-full"></div>
                <div class="absolute bottom-40 right-20 w-60 h-60 bg-white/30 rounded-full"></div>
                <div class="absolute top-1/2 left-1/3 w-4 h-4 bg-white rounded-full"></div>
                <div class="absolute top-1/4 right-1/4 w-6 h-6 bg-white/50 rounded-full"></div>
            </div>
            
            <!-- Gold accent line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-white/20"></div>
            
            <!-- Main content -->
            <div class="relative z-10 flex flex-col justify-center flex-1 px-12 xl:px-16 py-12">
                <!-- Logo & Brand -->
                <div class="reveal mb-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                <circle cx="12" cy="6" r="1.5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-white/70 uppercase tracking-widest mb-1">Sistem Informasi</div>
                            <h1 class="text-2xl xl:text-3xl font-display font-extrabold text-white leading-tight">Masjid Basmallah</h1>
                        </div>
                    </div>
                    
                    <h2 class="text-3xl xl:text-4xl font-display font-extrabold text-white leading-tight mb-4">
                        Kelola Keuangan<br>
                        Masjid Dengan Mudah
                    </h2>
                    <p class="text-white/80 text-base xl:text-lg leading-relaxed max-w-sm">
                        Sistem manajemen keuangan mosque yang modern, transparan, dan terpercaya.
                    </p>
                </div>
                
                <!-- Feature list -->
                <div class="reveal delay-200 space-y-4">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-white text-sm font-medium">Manajemen Transparan</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-white text-sm font-medium">Laporan Real-time</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <span class="text-white text-sm font-medium">Akuntabilitas Penuh</span>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="relative z-10 px-12 xl:px-16 pb-8">
                <div class="border-t border-white/20 pt-6">
                    <p class="text-white/50 text-xs">
                        &copy; {{ date('Y') }} Masjid Basmallah. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- RIGHT PANEL - Auth Forms -->
        <div class="w-full lg:w-[55%] flex items-center justify-center p-6 sm:p-8 lg:p-10 relative bg-white">
            <div class="w-full max-w-md">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-4 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                            <circle cx="12" cy="6" r="1.5"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-display font-extrabold text-gray-900">Masjid Basmallah</h2>
                    <p class="text-sm text-gray-500 mt-1">Sistem Manajemen Keuangan Masjid</p>
                </div>
                
                <!-- Auth Forms Container -->
                <div class="form-container">
                    <div class="auth-form" :class="{ 'show-register': showRegister }">
                        
                        <!-- LOGIN FORM -->
                        <div class="form-left">
                            <div class="reveal">
                                <span class="inline-block text-xs font-bold text-primary uppercase tracking-widest mb-2">Masuk Akun</span>
                                <h3 class="text-2xl sm:text-3xl font-display font-extrabold text-gray-900 mb-2">
                                    Selamat Datang Kembali 👋
                                </h3>
                                <p class="text-gray-500 text-sm mb-6">
                                    Masuk ke akun Anda untuk mengelola sistem informasi masjid.
                                </p>
                            </div>
                            
                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-600">{{ session('status') }}</p>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('login') }}" class="space-y-5 reveal delay-100">
                                @csrf
                                
                                <!-- Email -->
                                <div>
                                    <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat Email
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="login-email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                            autocomplete="username"
                                            placeholder="nama@email.com"
                                            class="input-focus block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('email') border-red-400 bg-red-50 @enderror"
                                        />
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div x-data="{ showPass: false }">
                                    <div class="flex items-center justify-between mb-2">
                                        <label for="login-password" class="block text-sm font-semibold text-gray-700">
                                            Password
                                        </label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="login-password"
                                            :type="showPass ? 'text' : 'password'"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Masukkan password Anda"
                                            class="input-focus block w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('password') border-red-400 bg-red-50 @enderror"
                                        />
                                        <button
                                            type="button"
                                            @click="showPass = !showPass"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors z-10"
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
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Remember Me -->
                                <div class="flex items-center">
                                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                        <input
                                            id="remember_me"
                                            type="checkbox"
                                            name="remember"
                                            class="checkbox-custom w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary"
                                        />
                                        <span class="ml-3 text-sm font-medium text-gray-600">
                                            Ingat saya
                                        </span>
                                    </label>
                                </div>
                                
                                <!-- Submit -->
                                <button
                                    type="submit"
                                    class="btn-primary w-full bg-primary text-white font-bold py-4 px-6 rounded-xl shadow-lg text-sm"
                                >
                                    Masuk Sekarang
                                </button>
                                
                                <!-- Divider -->
                                <div class="relative flex items-center gap-3 py-1">
                                    <div class="flex-1 h-px bg-gray-200"></div>
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">atau</span>
                                    <div class="flex-1 h-px bg-gray-200"></div>
                                </div>
                                
                                <!-- Switch to Register -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">
                                        Belum punya akun?
                                        <a href="#" @click.prevent="showRegister = true" class="link-hover font-bold text-primary ml-1 inline-flex items-center">
                                            Daftar sekarang
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                        
                        <!-- REGISTER FORM -->
                        <div class="form-right">
                            <div class="reveal">
                                <span class="inline-block text-xs font-bold text-primary uppercase tracking-widest mb-2">Buat Akun</span>
                                <h3 class="text-2xl sm:text-3xl font-display font-extrabold text-gray-900 mb-2">
                                    Daftar Akun Baru ✨
                                </h3>
                                <p class="text-gray-500 text-sm mb-6">
                                    Bergabunglah dengan sistem manajemen keuangan mosque yang modern.
                                </p>
                            </div>
                            
                            <form 
                                method="POST" 
                                action="{{ route('register') }}" 
                                class="space-y-5 reveal delay-100"
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
                                        const colors = ['', 'bg-red-400', 'bg-yellow-400', 'bg-primary', 'bg-primary-dark'];
                                        return colors[this.strength] || '';
                                    },
                                    get strengthTextColor() {
                                        const colors = ['', 'text-red-500', 'text-yellow-600', 'text-primary', 'text-primary-dark'];
                                        return colors[this.strength] || '';
                                    },
                                    showPass: false,
                                    showConfirm: false
                                }"
                            >
                                @csrf
                                
                                <!-- Name -->
                                <div>
                                    <label for="register-name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="register-name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            required
                                            autofocus
                                            autocomplete="name"
                                            placeholder="Masukkan nama lengkap Anda"
                                            class="input-focus block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('name') border-red-400 bg-red-50 @enderror"
                                        />
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label for="register-email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat Email
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="register-email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="username"
                                            placeholder="nama@email.com"
                                            class="input-focus block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('email') border-red-400 bg-red-50 @enderror"
                                        />
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div>
                                    <label for="register-password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="register-password"
                                            :type="showPass ? 'text' : 'password'"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                            placeholder="Minimal 8 karakter"
                                            x-model="password"
                                            class="input-focus block w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('password') border-red-400 bg-red-50 @enderror"
                                        />
                                        <button
                                            type="button"
                                            @click="showPass = !showPass"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors z-10"
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
                                    
                                    <!-- Password Strength -->
                                    <div x-show="password.length > 0" x-transition class="mt-2.5">
                                        <div class="flex gap-1.5 mb-1.5">
                                            <template x-for="i in 4" :key="i">
                                                <div
                                                    class="h-1.5 flex-1 rounded-full strength-bar"
                                                    :class="i <= strength ? strengthColor : 'bg-gray-200'"
                                                ></div>
                                            </template>
                                        </div>
                                        <p class="text-xs font-semibold" :class="strengthTextColor" x-text="'Kekuatan: ' + strengthLabel"></p>
                                    </div>
                                    
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div>
                                    <label for="register-password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </div>
                                        <input
                                            id="register-password_confirmation"
                                            :type="showConfirm ? 'text' : 'password'"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                            placeholder="Ulangi password Anda"
                                            class="input-focus block w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none @error('password_confirmation') border-red-400 bg-red-50 @enderror"
                                        />
                                        <button
                                            type="button"
                                            @click="showConfirm = !showConfirm"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors z-10"
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
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Terms -->
                                <div class="bg-primary-lightest border border-primary/20 rounded-xl px-4 py-3">
                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        <svg class="w-4 h-4 inline-block mr-1 -mt-0.5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Dengan mendaftar, Anda menyetujui penggunaan data untuk keperluan manajemen mosque sesuai kebijakan privasi kami.
                                    </p>
                                </div>
                                
                                <!-- Submit -->
                                <button
                                    type="submit"
                                    class="btn-primary w-full bg-primary text-white font-bold py-4 px-6 rounded-xl shadow-lg text-sm"
                                >
                                    Buat Akun Sekarang
                                </button>
                                
                                <!-- Divider -->
                                <div class="relative flex items-center gap-3 py-1">
                                    <div class="flex-1 h-px bg-gray-200"></div>
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">atau</span>
                                    <div class="flex-1 h-px bg-gray-200"></div>
                                </div>
                                
                                <!-- Switch to Login -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">
                                        Sudah punya akun?
                                        <a href="#" @click.prevent="showRegister = false" class="link-hover font-bold text-primary ml-1 inline-flex items-center">
                                            Masuk di sini
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Mobile -->
                <div class="lg:hidden text-center mt-8 text-xs text-gray-400">
                    <p>&copy; {{ date('Y') }} Masjid Basmallah. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('authPage', () => ({
                showRegister: {{ $showRegister ?? 'false' }},
                selectedPlan: '{{ $selectedPlan ?? '' }}'
            }))
        })
    </script>
    
    <!-- Main Alpine Component -->
    <div x-data="authPage"></div>
</body>
</html>
