<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
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
                                DEFAULT: '#D4A017',
                                light: '#E8C94A',
                                lightest: '#F5D87D',
                                dark: '#B8890D',
                                darker: '#8B6508',
                            },
                            amber: {
                                50: '#FFF9E6',
                                100: '#FFF3CC',
                                200: '#FFE699',
                                300: '#FFD966',
                                400: '#F5D87D',
                                500: '#E8C94A',
                                600: '#D4A017',
                                700: '#B8890D',
                                800: '#8B6508',
                                900: '#654C0F',
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
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-amber-200 dark:border-amber-800 p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Berhasil</p>
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
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-red-200 dark:border-red-900/30 p-4 flex items-start gap-3">
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
            
            // Global function to trigger notifications from anywhere
            window.addNotification = function(type, title, message) {
                const event = new CustomEvent('show-notification', {
                    detail: { type, title, message }
                });
                window.dispatchEvent(event);
            };
            
            // Helper functions for common notification types
            window.notifySuccess = function(title, message) {
                addNotification('success', title, message);
            };
            
            window.notifyError = function(title, message) {
                addNotification('error', title, message);
            };
            
            window.notifyInfo = function(title, message) {
                addNotification('info', title, message);
            };
            
            window.notifyWarning = function(title, message) {
                addNotification('warning', title, message);
            };
        </script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        <div class="flex-1 flex">
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content Area -->
            <main class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? 'lg:ml-64' : ''">
                <!-- Top Bar -->
                <header class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm sticky top-0 z-30">
                    <div class="px-4 sm:px-6 lg:px-8 py-3">
                        <div class="flex items-center justify-between gap-4">
                            <!-- Sidebar Toggle Button (visible when sidebar is hidden) -->
                            <button @click="sidebarOpen = !sidebarOpen" 
                                x-show="!sidebarOpen"
                                x-transition
                                class="p-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md transition-all duration-300"
                                title="Buka Sidebar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            
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
                                <div class="relative" x-data="{
                                    notifications: [],
                                    open: false,
                                    init() {
                                        // Load notifications from localStorage
                                        const stored = localStorage.getItem('basmallah_notifications');
                                        if (stored) {
                                            this.notifications = JSON.parse(stored);
                                        }
                                        // Listen for custom notification events
                                        window.addEventListener('show-notification', (e) => {
                                            this.addNotification(e.detail);
                                        });
                                    },
                                    addNotification(notif) {
                                        this.notifications.unshift({
                                            id: Date.now(),
                                            ...notif,
                                            time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                                            read: false
                                        });
                                        // Keep only last 20 notifications
                                        if (this.notifications.length > 20) {
                                            this.notifications = this.notifications.slice(0, 20);
                                        }
                                        localStorage.setItem('basmallah_notifications', JSON.stringify(this.notifications));
                                    },
                                    markAsRead(id) {
                                        const notif = this.notifications.find(n => n.id === id);
                                        if (notif) notif.read = true;
                                        localStorage.setItem('basmallah_notifications', JSON.stringify(this.notifications));
                                    },
                                    markAllRead() {
                                        this.notifications.forEach(n => n.read = true);
                                        localStorage.setItem('basmallah_notifications', JSON.stringify(this.notifications));
                                    },
                                    clearAll() {
                                        this.notifications = [];
                                        localStorage.setItem('basmallah_notifications', JSON.stringify(this.notifications));
                                    },
                                    get unreadCount() {
                                        return this.notifications.filter(n => !n.read).length;
                                    }
                                }">
                                    <button @click="open = !open" @click.away="open = false" type="button" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <span x-show="unreadCount > 0" class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full" x-text="unreadCount"></span>
                                    </button>

                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-xl bg-white dark:bg-slate-800 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                         style="display: none;">
                                        <!-- Header -->
                                        <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
                                            <button x-show="notifications.length > 0" @click="markAllRead()" class="text-xs text-amber-600 hover:text-amber-700 font-medium">Tandai dibaca</button>
                                        </div>
                                        
                                        <!-- Notification List -->
                                        <div class="max-h-80 overflow-y-auto">
                                            <template x-if="notifications.length === 0">
                                                <div class="px-4 py-8 text-center">
                                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                    </svg>
                                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada notifikasi</p>
                                                </div>
                                            </template>
                                            
                                            <template x-for="notif in notifications" :key="notif.id">
                                                <div @click="markAsRead(notif.id)" class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer border-b border-gray-50 dark:border-slate-700/50 last:border-0" :class="{ 'bg-amber-50/50 dark:bg-amber-900/10': !notif.read }">
                                                    <div class="flex items-start gap-3">
                                                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" :class="notif.type === 'success' ? 'bg-amber-100 dark:bg-amber-900/30' : notif.type === 'error' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-blue-100 dark:bg-blue-900/30'">
                                                            <svg x-show="notif.type === 'success'" class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            <svg x-show="notif.type === 'error'" class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            <svg x-show="notif.type === 'info' || notif.type === 'warning'" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notif.title"></p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="notif.message"></p>
                                                            <p class="text-xs text-amber-600 dark:text-amber-400 mt-1" x-text="notif.time"></p>
                                                        </div>
                                                        <div x-show="!notif.read" class="flex-shrink-0 w-2 h-2 rounded-full bg-amber-500 mt-2"></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        
                                        <!-- Footer -->
                                        <div x-show="notifications.length > 0" class="px-4 py-2 border-t border-gray-100 dark:border-slate-700">
                                            <button @click="clearAll()" class="w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-center">Hapus semua notifikasi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-24">
                    <?php echo e($slot); ?>

                </main>

                <!-- Footer -->
                <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 mt-12 lg:mt-16 px-6 lg:px-8 py-3">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            &copy; <?php echo e(date('Y')); ?> <button type="button" @click="$dispatch('open-modal', 'about')" class="text-primary hover:underline">Basmallah</button>. All rights reserved.
                        </p>
                        <div class="flex items-center gap-3 text-xs">
                            <button type="button" @click="$dispatch('open-modal', 'privacy')" class="text-primary hover:underline">Privacy</button>
                            <span class="text-gray-300 dark:text-gray-600">|</span>
                            <button type="button" @click="$dispatch('open-modal', 'terms')" class="text-primary hover:underline">Terms</button>
                        </div>
                    </div>
                </footer>

                <!-- Privacy Modal -->
                <div x-data="{ open: false }" 
                     @open-modal.window="if ($event.detail === 'privacy') open = true"
                     x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div x-show="open" 
                             @click="open = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!-- Modal panel -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             class="relative inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Privacy Policy</h3>
                                    <button @click="open = false" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-5 max-h-[60vh] overflow-y-auto">
                                <div class="prose prose-sm dark:prose-invert max-w-none">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Kebijakan Privasi Basmallah</h4>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                        Kami menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Pengumpulan Data</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Basmallah mengumpulkan data yang diperlukan untuk pengelolaan keuangan masjid, termasuk informasi transaksi, data rekening, dan informasi pengurus.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Penggunaan Data</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Data yang dikumpulkan digunakan solely untuk menyediakan layanan pengelolaan keuangan masjid yang terbaik.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Keamanan</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Kami menggunakan standar industri untuk melindungi data Anda. Semua data disimpan secara aman dengan enkripsi.
                                    </p>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 rounded-b-2xl flex justify-end">
                                <button @click="open = false" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms Modal -->
                <div x-data="{ open: false }" 
                     @open-modal.window="if ($event.detail === 'terms') open = true"
                     x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div x-show="open" 
                             @click="open = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!-- Modal panel -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             class="relative inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Terms of Service</h3>
                                    <button @click="open = false" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-5 max-h-[60vh] overflow-y-auto">
                                <div class="prose prose-sm dark:prose-invert max-w-none">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Ketentuan Layanan Basmallah</h4>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                        Dengan menggunakan Basmallah, Anda setuju dengan ketentuan layanan berikut.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Penggunaan Layanan</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Layanan Basmallah disediakan untuk pengelolaan keuangan masjid secara digital. Pengguna bertanggung jawab atas keamanan akun mereka.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Kewajiban Pengguna</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Pengguna wajib menjaga kerahasiaan informasi akun dan tidak membagikan akses kepada pihak ketiga tanpa izin.
                                    </p>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Batasan Tanggung Jawab</h5>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        Basmallah tidak bertanggung jawab atas kerugian yang timbul dari penggunaan layanan di luar kendali kami.
                                    </p>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 rounded-b-2xl flex justify-end">
                                <button @click="open = false" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About/Basmallah Profile Modal -->
                <div x-data="{ open: false }" 
                     @open-modal.window="if ($event.detail === 'about') open = true"
                     x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="open" 
                             @click="open = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             class="relative inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tentang Basmallah</h3>
                                    <button @click="open = false" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-5 max-h-[60vh] overflow-y-auto">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.18l6.9 3.82L12 11.82 5.1 8 12 4.18zM5 9.64l6 3.33v6.39l-6-3.33V9.64zm8 9.72v-6.39l6-3.33v6.39l-6 3.33z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">Basmallah</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Sistem Manajemen Keuangan Masjid</p>
                                        <p class="text-xs text-primary font-medium mt-1">Versi 1.0.0</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800 mb-4">
                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Visi Kami</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Menjadi solusi digital terbaik untuk pengelolaan keuangan masjid yang transparan, akuntabel, dan terintegrasi.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-slate-700/30 rounded-xl mb-4">
                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Misi Kami</h5>
                                    <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                                        <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Mempermudah pengelolaan keuangan masjid</span></li>
                                        <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Menyediakan laporan keuangan yang transparan</span></li>
                                        <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Mendukung transparansi publik untuk jama'ah</span></li>
                                        <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Mengintegrasikan berbagai fitur manajemen</span></li>
                                    </ul>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-slate-700/30 rounded-xl mb-4">
                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Fitur Utama</h5>
                                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Manajemen Akun</span></div>
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Transaksi</span></div>
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Budgeting</span></div>
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Goals & Target</span></div>
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Laporan Publik</span></div>
                                        <div class="flex items-center gap-2"><span class="w-2 h-2 bg-primary rounded-full"></span><span>Kalender</span></div>
                                    </div>
                                </div>
                                <div class="text-center pt-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">© <?php echo e(date('Y')); ?> Basmallah. All rights reserved.</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Dibuat dengan ❤️ untuk ummat</p>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 rounded-b-2xl flex justify-end">
                                <button @click="open = false" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/layouts/app.blade.php ENDPATH**/ ?>