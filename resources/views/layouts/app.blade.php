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
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="lg:ml-64">
                <!-- Top Bar -->
                <header class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-b border-gray-200 dark:border-slate-700 shadow-sm sticky top-0 z-30">
                    <div class="px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex items-center justify-between">
                            <!-- Page Title -->
                            @isset($header)
                                <div>
                                    {{ $header }}
                                </div>
                            @else
                                <div class="text-xl font-bold text-gray-900 dark:text-white">Dashboard</div>
                            @endisset

                            <!-- Right Side Actions -->
                            <div class="flex items-center gap-4">
                                <!-- Language Switcher -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" type="button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">{{ app()->getLocale() }}</span>
                                    </button>

                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white dark:bg-slate-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                         style="display: none;">
                                        
                                        <form method="POST" action="{{ route('language.switch') }}">
                                            @csrf
                                            <input type="hidden" name="locale" value="id">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 {{ app()->getLocale() == 'id' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : '' }}">
                                                🇮🇩 Indonesia
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('language.switch') }}">
                                            @csrf
                                            <input type="hidden" name="locale" value="en">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 {{ app()->getLocale() == 'en' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : '' }}">
                                                🇬🇧 English
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('language.switch') }}">
                                            @csrf
                                            <input type="hidden" name="locale" value="es">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 {{ app()->getLocale() == 'es' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : '' }}">
                                                🇪🇸 Español
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('language.switch') }}">
                                            @csrf
                                            <input type="hidden" name="locale" value="tr">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 {{ app()->getLocale() == 'tr' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : '' }}">
                                                🇹🇷 Türkçe
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Dark Mode Toggle -->
                                <button @click="darkMode = !darkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                    <svg x-show="!darkMode" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                    <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </button>

                                <!-- Notifications -->
                                <button class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-t border-gray-200 dark:border-slate-700 px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} <span class="font-semibold text-emerald-600 dark:text-emerald-400">Basmallah</span>. All rights reserved.
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Privacy</a>
                            <span>|</span>
                            <a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Terms</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
