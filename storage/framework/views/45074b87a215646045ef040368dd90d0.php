<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true, sidebarCollapsed: false }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Basmallah')); ?> – Dashboard</title>

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
                            primary: {
                                DEFAULT: '#B8860B',
                                light: '#DAA520',
                                lightest: '#FEF3C7',
                                dark: '#8B6508',
                                darker: '#654C0F',
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
            
            /* Card hover effect */
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            
            /* Smooth transitions */
            .smooth-transition {
                transition: all 0.2s ease-in-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-slate-900 flex flex-col min-h-screen" x-data="toastNotification()">
        <!-- Toast Notification Container -->
        <div x-cloak>
            <!-- Success Toast -->
            <div x-show="showSuccess" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-y-4 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0 opacity-100"
                 x-transition:leave-end="-translate-y-4 opacity-0"
                 class="fixed top-20 right-6 z-50 max-w-sm w-full">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-gray-100 dark:border-slate-700 p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Success</p>
                        <p x-text="successMessage" class="text-sm text-gray-600 dark:text-gray-300 mt-0.5"></p>
                    </div>
                    <button @click="showSuccess = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Error Toast -->
            <div x-show="showError" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-y-4 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0 opacity-100"
                 x-transition:leave-end="-translate-y-4 opacity-0"
                 class="fixed top-20 right-6 z-50 max-w-sm w-full">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-red-100 dark:border-red-900/30 p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Error</p>
                        <p x-text="errorMessage" class="text-sm text-gray-600 dark:text-gray-300 mt-0.5"></p>
                    </div>
                    <button @click="showError = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Data Initialization -->
        <?php if(session('success')): ?>
            <div x-init="showSuccessMessage('<?php echo e(session('success')); ?>')"></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div x-init="showErrorMessage('<?php echo e(session('error')); ?>')"></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div x-init="showErrorMessage('<?php echo e($errors->first()); ?>')"></div>
        <?php endif; ?>

        <script>
            function toastNotification() {
                return {
                    showSuccess: false,
                    showError: false,
                    successMessage: '',
                    errorMessage: '',
                    
                    showSuccessMessage(message) {
                        this.successMessage = message;
                        this.showSuccess = true;
                        setTimeout(() => {
                            this.showSuccess = false;
                        }, 5000);
                    },
                    
                    showErrorMessage(message) {
                        this.errorMessage = message;
                        this.showError = true;
                        setTimeout(() => {
                            this.showError = false;
                        }, 5000);
                    }
                }
            }
        </script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        <div class="flex-1 flex">
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content Area -->
            <main class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? (sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64') : 'lg:ml-0'">
                <!-- Top Bar -->
                <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
                    <div class="px-4 sm:px-6 lg:px-8 py-3">
                        <div class="flex items-center justify-between gap-4">
                            <!-- Left Section - Title & Actions -->
                            <?php if(isset($header)): ?>
                                <div class="flex items-center gap-6 flex-1">
                                    <?php echo e($header); ?>

                                </div>
                            <?php else: ?>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">Dashboard</div>
                            <?php endif; ?>

                            <!-- Right Section - Icons -->
                            <div class="flex items-center gap-2">
                                <!-- Language Switcher -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" type="button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase"><?php echo e(app()->getLocale()); ?></span>
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
                                        
                                        <form method="POST" action="<?php echo e(route('language.switch')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="locale" value="id">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 <?php echo e(app()->getLocale() == 'id' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : ''); ?>">
                                                🇮🇩 Indonesia
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('language.switch')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="locale" value="en">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 <?php echo e(app()->getLocale() == 'en' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : ''); ?>">
                                                🇬🇧 English
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('language.switch')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="locale" value="es">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 <?php echo e(app()->getLocale() == 'es' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : ''); ?>">
                                                🇪🇸 Español
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('language.switch')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="locale" value="tr">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 <?php echo e(app()->getLocale() == 'tr' ? 'bg-gray-50 dark:bg-slate-700 font-semibold' : ''); ?>">
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
                <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-24">
                    <?php echo e($slot); ?>

                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 mt-12 lg:mt-16 px-6 lg:px-8 py-3">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p class="text-xs text-gray-500">
                            &copy; <?php echo e(date('Y')); ?> <a href="#" class="text-primary hover:underline">Basmallah</a>. All rights reserved.
                        </p>
                        <div class="flex items-center gap-3 text-xs">
                            <a href="#" class="text-primary hover:underline">Privacy</a>
                            <span class="text-gray-300">|</span>
                            <a href="#" class="text-primary hover:underline">Terms</a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\laragon\www\basmalah\resources\views/layouts/app.blade.php ENDPATH**/ ?>