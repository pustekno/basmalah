<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Basmallah') }} – Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
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
                        }
                    }
                }
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- Dinero.js for currency formatting -->
        <script src="https://cdn.jsdelivr.net/npm/dinero.js@1.9.1/build/umd/dinero.min.js"></script>
        <script>
            // Helper function to format currency using Dinero.js
            window.formatCurrency = function(amountInCents) {
                return Dinero({ amount: amountInCents, currency: 'IDR' })
                    .toFormat('$0,0');
            };
            
            // Helper function to parse currency input to cents
            window.parseCurrency = function(value) {
                // Remove non-numeric characters except decimal point
                const cleaned = value.toString().replace(/[^\d.]/g, '');
                const amount = parseFloat(cleaned) || 0;
                return Math.round(amount * 100); // Convert to cents
            };
        </script>
        
        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }
            
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
            
            /* Card hover effect */
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            /* Smooth transitions */
            .smooth-transition {
                transition: all 0.2s ease-in-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-white to-emerald-50/40 dark:bg-slate-900 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-b border-gray-200 dark:border-slate-700 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-t border-gray-200 dark:border-slate-700 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Brand Section -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 48 48" fill="currentColor">
                                        <path d="M24 2C21.8 2 20 3.8 20 6C20 7.5 20.8 8.8 22 9.5V12H18C16.9 12 16 12.9 16 14V16H14C12.9 16 12 16.9 12 18V20H10C8.9 20 8 20.9 8 22V44H40V22C40 20.9 39.1 20 38 20H36V18C36 16.9 35.1 16 34 16H32V14C32 12.9 31.1 12 30 12H26V9.5C27.2 8.8 28 7.5 28 6C28 3.8 26.2 2 24 2ZM24 5C24.6 5 25 5.4 25 6C25 6.6 24.6 7 24 7C23.4 7 23 6.6 23 6C23 5.4 23.4 5 24 5ZM20 23H28V44H20V23ZM12 23H18V44H12V23ZM30 23H36V44H30V23Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Sistem Informasi</div>
                                    <div class="text-sm font-extrabold text-gray-900 dark:text-white">Basmallah</div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Sistem Informasi Manajemen Masjid Modern & Transparan untuk pengelolaan yang lebih baik.
                            </p>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Menu Cepat</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                        Dashboard
                                    </a>
                                </li>
                                @can('view transactions')
                                <li>
                                    <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                        Transaksi
                                    </a>
                                </li>
                                @endcan
                                @can('view reports')
                                <li>
                                    <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                        Laporan
                                    </a>
                                </li>
                                @endcan
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                        Profil
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Kontak</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">info@basmallah.com</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">+62 812-3456-7890</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Jl. Masjid Raya No. 123, Jakarta</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left">
                                &copy; {{ date('Y') }} <span class="font-semibold text-emerald-600 dark:text-emerald-400">Basmallah</span>. Semua hak dilindungi.
                            </p>
                            <div class="flex items-center gap-4">
                                <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                    Kebijakan Privasi
                                </a>
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                                    Syarat & Ketentuan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
