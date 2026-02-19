<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Basmallah') }} – Sistem Informasi Manajemen Masjid</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            emerald: {
                                50:  '#ecfdf5',
                                100: '#d1fae5',
                                200: '#a7f3d0',
                                300: '#6ee7b7',
                                400: '#34d399',
                                500: '#10b981',
                                600: '#059669',
                                700: '#047857',
                                800: '#065f46',
                                900: '#064e3b',
                            },
                            gold: {
                                300: '#fde68a',
                                400: '#fbbf24',
                                500: '#D4AF37',
                                600: '#b7950b',
                            }
                        },
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                        boxShadow: {
                            '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
                        }
                    }
                }
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }

            /* Gradient backgrounds */
            .hero-gradient {
                background: linear-gradient(145deg, #064e3b 0%, #065f46 30%, #047857 60%, #0f766e 100%);
            }

            /* Islamic geometric SVG pattern overlay */
            .islamic-pattern-overlay {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1'%3E%3Cpolygon points='40,5 75,22.5 75,57.5 40,75 5,57.5 5,22.5'/%3E%3Cpolygon points='40,15 65,27.5 65,52.5 40,65 15,52.5 15,27.5'/%3E%3Cline x1='40' y1='5' x2='40' y2='15'/%3E%3Cline x1='75' y1='22.5' x2='65' y2='27.5'/%3E%3Cline x1='75' y1='57.5' x2='65' y2='52.5'/%3E%3Cline x1='40' y1='75' x2='40' y2='65'/%3E%3Cline x1='5' y1='57.5' x2='15' y2='52.5'/%3E%3Cline x1='5' y1='22.5' x2='15' y2='27.5'/%3E%3C/g%3E%3C/svg%3E");
            }

            /* Gradient text */
            .gradient-text {
                background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #D4AF37 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Gold accent text */
            .gold-text {
                background: linear-gradient(135deg, #fbbf24 0%, #D4AF37 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Glass morphism */
            .glass {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.15);
            }

            /* Floating animation */
            .animate-float {
                animation: float 8s ease-in-out infinite;
            }
            .animate-float-delayed {
                animation: float 8s ease-in-out infinite;
                animation-delay: 3s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-18px) rotate(3deg); }
            }

            /* Fade in animations */
            .fade-in-up {
                animation: fadeInUp 0.7s ease-out both;
            }
            .fade-in-up-delay-1 { animation-delay: 0.1s; }
            .fade-in-up-delay-2 { animation-delay: 0.2s; }
            .fade-in-up-delay-3 { animation-delay: 0.3s; }
            .fade-in-up-delay-4 { animation-delay: 0.4s; }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(24px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* Pulse glow for logo */
            .logo-glow {
                box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4);
                animation: pulseGlow 3s ease-in-out infinite;
            }
            @keyframes pulseGlow {
                0%, 100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.3); }
                50%       { box-shadow: 0 0 30px 8px rgba(212, 175, 55, 0.15); }
            }

            /* Input focus glow */
            .input-glow:focus {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2), 0 1px 3px rgba(0,0,0,0.1);
            }

            /* Button hover lift */
            .btn-primary {
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 28px rgba(5, 150, 105, 0.4);
            }
            .btn-primary:active {
                transform: translateY(0);
            }

            /* Stat card hover */
            .stat-card {
                transition: all 0.3s ease;
            }
            .stat-card:hover {
                transform: translateX(4px);
                background: rgba(255, 255, 255, 0.14);
            }

            /* Dark mode card */
            .dark .auth-card {
                background: #1a2332;
                border-color: rgba(255,255,255,0.08);
            }

            /* Scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 3px; }

            /* Smooth dark mode transition */
            *, *::before, *::after {
                transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            }
            /* Exclude animations from transition override */
            .animate-float, .animate-float-delayed, .logo-glow {
                transition: none;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-slate-50 via-white to-emerald-50/40 dark:bg-slate-900 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 min-h-screen">
        <div class="min-h-screen flex">

            <!-- ═══════════════════════════════════════════════════════════
                 LEFT HERO PANEL
            ═══════════════════════════════════════════════════════════ -->
            <div class="hidden lg:flex lg:w-[52%] xl:w-1/2 bg-gradient-to-br from-gray-50 to-gray-100 dark:hero-gradient dark:islamic-pattern-overlay relative overflow-hidden flex-col">

                <!-- Decorative blobs -->
                <div class="absolute top-[-80px] left-[-80px] w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
                <div class="absolute bottom-[-60px] right-[-60px] w-96 h-96 bg-teal-300/15 rounded-full blur-3xl animate-float-delayed pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Gold accent line top -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent opacity-60"></div>

                <!-- Main content -->
                <div class="relative z-10 flex flex-col justify-center flex-1 px-12 xl:px-16 py-12">

                    <!-- Logo & Brand -->
                    <div class="fade-in-up mb-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-16 h-16 glass rounded-2xl flex items-center justify-center logo-glow flex-shrink-0">
                                <!-- Mosque SVG icon -->
                                <svg class="w-9 h-9 text-gold-400" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 2C21.8 2 20 3.8 20 6C20 7.5 20.8 8.8 22 9.5V12H18C16.9 12 16 12.9 16 14V16H14C12.9 16 12 16.9 12 18V20H10C8.9 20 8 20.9 8 22V44H40V22C40 20.9 39.1 20 38 20H36V18C36 16.9 35.1 16 34 16H32V14C32 12.9 31.1 12 30 12H26V9.5C27.2 8.8 28 7.5 28 6C28 3.8 26.2 2 24 2ZM24 5C24.6 5 25 5.4 25 6C25 6.6 24.6 7 24 7C23.4 7 23 6.6 23 6C23 5.4 23.4 5 24 5ZM20 23H28V44H20V23ZM12 23H18V44H12V23ZM30 23H36V44H30V23Z"/>
                                    <path d="M24 14C22.3 14 21 15.3 21 17C21 18.7 22.3 20 24 20C25.7 20 27 18.7 27 17C27 15.3 25.7 14 24 14Z" opacity="0.7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-300/80 uppercase tracking-widest mb-1">Sistem Informasi</div>
                                <h1 class="text-2xl xl:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">Basmallah</h1>
                            </div>
                        </div>

                        <h2 class="text-3xl xl:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight mb-4">
                            Selamat Datang di<br>
                            <span class="gold-text">Basmallah</span>
                        </h2>
                        <p class="text-gray-700 dark:text-emerald-100/80 text-base xl:text-lg leading-relaxed max-w-sm">
                            Sistem Informasi Manajemen Masjid Modern &amp; Transparan untuk pengelolaan yang lebih baik.
                        </p>
                    </div>

                    <!-- Statistics -->
                    <div class="fade-in-up fade-in-up-delay-1 grid grid-cols-2 gap-3 mb-10">
                        <div class="bg-white/60 dark:glass rounded-2xl p-4 stat-card border border-gray-200/50 dark:border-transparent">
                            <div class="text-2xl xl:text-3xl font-extrabold gold-text mb-1">2,500+</div>
                            <div class="text-gray-700 dark:text-emerald-100/70 text-sm font-medium">Jama'ah Terdaftar</div>
                        </div>
                        <div class="bg-white/60 dark:glass rounded-2xl p-4 stat-card border border-gray-200/50 dark:border-transparent">
                            <div class="text-2xl xl:text-3xl font-extrabold gold-text mb-1">50+</div>
                            <div class="text-gray-700 dark:text-emerald-100/70 text-sm font-medium">Kegiatan / Bulan</div>
                        </div>
                        <div class="bg-white/60 dark:glass rounded-2xl p-4 stat-card border border-gray-200/50 dark:border-transparent">
                            <div class="text-2xl xl:text-3xl font-extrabold gold-text mb-1">100%</div>
                            <div class="text-gray-700 dark:text-emerald-100/70 text-sm font-medium">Transparan</div>
                        </div>
                        <div class="bg-white/60 dark:glass rounded-2xl p-4 stat-card border border-gray-200/50 dark:border-transparent">
                            <div class="text-2xl xl:text-3xl font-extrabold gold-text mb-1">24/7</div>
                            <div class="text-gray-700 dark:text-emerald-100/70 text-sm font-medium">Akses Online</div>
                        </div>
                    </div>

                    <!-- Feature list -->
                    <div class="fade-in-up fade-in-up-delay-2 space-y-3">
                        @foreach([
                            ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Kelola keuangan masjid dengan mudah'],
                            ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'text' => 'Laporan keuangan transparan & akurat'],
                            ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'text' => 'Keamanan data terjamin & terenkripsi'],
                        ] as $feature)
                        <div class="flex items-center gap-3 bg-white/60 dark:glass rounded-xl px-4 py-3 stat-card border border-gray-200/50 dark:border-transparent">
                            <div class="w-8 h-8 bg-emerald-500/20 dark:bg-emerald-400/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 dark:text-emerald-100/85 text-sm font-medium">{{ $feature['text'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer left -->
                <div class="relative z-10 px-12 xl:px-16 pb-8">
                    <div class="border-t border-gray-300/50 dark:border-white/10 pt-6">
                        <p class="text-gray-500 dark:text-emerald-200/50 text-xs">
                            &copy; {{ date('Y') }} Basmallah – Sistem Informasi Manajemen Masjid
                        </p>
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 RIGHT AUTH PANEL
            ═══════════════════════════════════════════════════════════ -->
            <div class="w-full lg:w-[48%] xl:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-10 relative">

                <!-- Dark mode toggle -->
                <button
                    @click="darkMode = !darkMode"
                    class="absolute top-6 right-6 w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-200 z-20"
                    :title="darkMode ? 'Mode Terang' : 'Mode Gelap'"
                >
                    <!-- Sun icon (shown in dark mode) -->
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <div class="w-full max-w-md fade-in-up">

                    <!-- Mobile logo (hidden on desktop) -->
                    <div class="lg:hidden text-center mb-8 fade-in-up">
                        <div class="inline-flex items-center justify-center w-16 h-16 hero-gradient rounded-2xl mb-4 shadow-xl logo-glow">
                            <svg class="w-9 h-9 text-gold-400" viewBox="0 0 48 48" fill="currentColor">
                                <path d="M24 2C21.8 2 20 3.8 20 6C20 7.5 20.8 8.8 22 9.5V12H18C16.9 12 16 12.9 16 14V16H14C12.9 16 12 16.9 12 18V20H10C8.9 20 8 20.9 8 22V44H40V22C40 20.9 39.1 20 38 20H36V18C36 16.9 35.1 16 34 16H32V14C32 12.9 31.1 12 30 12H26V9.5C27.2 8.8 28 7.5 28 6C28 3.8 26.2 2 24 2ZM24 5C24.6 5 25 5.4 25 6C25 6.6 24.6 7 24 7C23.4 7 23 6.6 23 6C23 5.4 23.4 5 24 5ZM20 23H28V44H20V23ZM12 23H18V44H12V23ZM30 23H36V44H30V23Z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Basmallah</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sistem Informasi Manajemen Masjid</p>
                    </div>

                    <!-- Auth Card -->
                    <div class="auth-card bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-slate-700 p-8 sm:p-10 fade-in-up fade-in-up-delay-1">
                        {{ $slot }}
                    </div>

                    <!-- Footer mobile -->
                    <div class="text-center mt-6 text-xs text-gray-400 dark:text-slate-500 fade-in-up fade-in-up-delay-2">
                        <p>&copy; {{ date('Y') }} Basmallah. Semua hak dilindungi.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
