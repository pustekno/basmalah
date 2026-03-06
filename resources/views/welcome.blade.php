<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basmallah - Sistem Manajemen Keuangan Masjid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        /* Smooth reveal animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Staggered animation delays */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        
        /* Hover effects */
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(27, 155, 138, 0.25);
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
        
        .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #e8f7f4;
            transform: translateY(-2px);
        }
        
        /* Geometric pattern */
        .pattern-grid {
            background-image: 
                linear-gradient(rgba(27, 155, 138, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(27, 155, 138, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-white font-body text-gray-900 antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                <circle cx="12" cy="6" r="1.5"/>
                            </svg>
                        </div>
                        <span class="text-xl font-display font-bold text-primary">Basmallah</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary bg-primary text-white px-8 py-3 rounded-xl font-semibold shadow-lg">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Asymmetric Layout -->
    <section class="pt-32 pb-24 lg:pb-32 pattern-grid relative overflow-hidden">
        <!-- Geometric Accents -->
        <div class="absolute top-40 right-0 w-96 h-96 bg-primary/5 rounded-full"></div>
        <div class="absolute bottom-20 left-20 w-64 h-64 bg-primary/10 rounded-full"></div>
        <div class="absolute top-60 left-1/3 w-4 h-4 bg-primary rounded-full"></div>
        <div class="absolute top-80 right-1/4 w-6 h-6 bg-primary/30 rounded-full"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="order-2 lg:order-1">
                    <div class="reveal">
                        <span class="inline-block px-4 py-2 bg-primary-lightest text-primary-dark text-sm font-semibold rounded-full mb-6">
                            Sistem Manajemen Keuangan Masjid
                        </span>
                    </div>
                    <h1 class="reveal delay-100 font-display text-5xl lg:text-6xl xl:text-7xl font-extrabold text-gray-900 leading-[1.1] mb-6">
                        Kelola Keuangan
                        <span class="text-primary">Masjid</span>
                        Dengan Mudah
                    </h1>
                    <p class="reveal delay-200 text-xl text-gray-600 leading-relaxed mb-10 max-w-xl">
                        Transparan, akuntabel, dan modern. Sistem terintegrasi untuk manajemen keuangan masjid yang terpercaya.
                    </p>
                    <div class="reveal delay-300 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="btn-primary bg-primary text-white px-10 py-4 rounded-xl font-semibold text-center">
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="btn-secondary border-2 border-primary text-primary px-10 py-4 rounded-xl font-semibold text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                
                <!-- Right Visual - Abstract Mosque Illustration -->
                <div class="order-1 lg:order-2 relative">
                    <div class="reveal delay-200 relative">
                        <!-- Large Card -->
                        <div class="bg-primary-lightest rounded-3xl p-8 lg:p-12 border border-primary/10">
                            <div class="bg-white rounded-2xl p-6 shadow-xl">
                                <!-- Dashboard Preview -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Total Pemasukan</div>
                                            <div class="text-xl font-bold text-gray-900">Rp 25.000.000</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-green-600 font-semibold">+12%</div>
                                </div>
                                <div class="h-3 bg-gray-100 rounded-full overflow-hidden mb-4">
                                    <div class="h-full bg-primary rounded-full" style="width: 75%"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <div class="text-xs text-gray-500">Transaksi</div>
                                        <div class="font-bold text-gray-900">156</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <div class="text-xs text-gray-500">Kategori</div>
                                        <div class="font-bold text-gray-900">12</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <div class="text-xs text-gray-500">Rekening</div>
                                        <div class="font-bold text-gray-900">3</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Element -->
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-4 shadow-xl border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Status</div>
                                    <div class="font-semibold text-gray-900">Terverifikasi</div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Element 2 -->
                        <div class="absolute -top-6 -right-6 bg-primary text-white rounded-2xl p-4 shadow-xl">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="font-semibold">100% Akurat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 lg:mb-20">
                <span class="reveal inline-block text-primary font-semibold text-sm uppercase tracking-widest mb-4">
                    Fitur Unggulan
                </span>
                <h2 class="reveal delay-100 font-display text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Solusi Lengkap untuk Masjid
                </h2>
                <p class="reveal delay-200 text-xl text-gray-600 max-w-2xl mx-auto">
                    Sistem terintegrasi untuk manajemen keuangan masjid yang modern dan terpercaya
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="reveal delay-100 hover-lift bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="w-14 h-14 bg-primary-lightest rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-3">Manajemen Transparan</h3>
                    <p class="text-gray-600 leading-relaxed">Catat setiap transaksi dengan detail lengkap. Laporan keuangan yang jelas dan dapat dipertanggungjawabkan.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="reveal delay-200 hover-lift bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="w-14 h-14 bg-primary-lightest rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-3">Laporan Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">Pantau keuangan masjid kapan saja. Laporan otomatis yang selalu up-to-date dengan data terkini.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="reveal delay-300 hover-lift bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="w-14 h-14 bg-primary-lightest rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-3">Akuntabilitas Penuh</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem izin berbasis peran. Setiap pengguna memiliki akses sesuai tanggung jawab masing-masing.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="reveal delay-400 hover-lift bg-white rounded-3xl p-8 border border-gray-100">
                    <div class="w-14 h-14 bg-primary-lightest rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-3">Teknologi Modern</h3>
                    <p class="text-gray-600 leading-relaxed">Dibangun dengan teknologi terkini. Antarmuka responsif yang mudah digunakan di berbagai perangkat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 lg:mb-20">
                <span class="reveal inline-block text-primary font-semibold text-sm uppercase tracking-widest mb-4">
                    Harga
                </span>
                <h2 class="reveal delay-100 font-display text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Pilih Paket yang Sesuai
                </h2>
                <p class="reveal delay-200 text-xl text-gray-600 max-w-2xl mx-auto">
                    three flexible options for your mosque's needs
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Gratis Plan -->
                <div class="reveal delay-100 hover-lift bg-white rounded-3xl p-8 border-2 border-gray-100">
                    <div class="text-center mb-6">
                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-2">Gratis</h3>
                        <p class="text-gray-500">Untuk masjid kecil</p>
                    </div>
                    <div class="text-center mb-8">
                        <span class="font-display text-4xl font-bold text-gray-900">Rp 0</span>
                        <span class="text-gray-500">/bulan</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            1 Masjid
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            3 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            100 Transaksi/bulan
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Laporan Dasar
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full border-2 border-primary text-primary py-3 rounded-xl font-semibold text-center hover:bg-primary-lightest transition-colors">
                        Mulai Gratis
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div class="reveal delay-200 hover-lift bg-primary-lightest rounded-3xl p-8 border-2 border-primary">
                    <div class="absolute top-0 right-0 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-bl-xl rounded-tr-2xl">
                        TERPOPULER
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-2">Pro</h3>
                        <p class="text-gray-500">Untuk masjid menengah</p>
                    </div>
                    <div class="text-center mb-8">
                        <span class="font-display text-4xl font-bold text-primary">Rp 299.000</span>
                        <span class="text-gray-500">/bulan</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            1 Masjid
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            10 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Transaksi Unlimited
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Laporan Lengkap
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Export PDF/Excel
                        </li>
                    </ul>
                    <a href="{{ route('register') }}?plan=pro" class="block w-full bg-primary text-white py-3 rounded-xl font-semibold text-center hover:bg-primary-dark transition-colors">
                        Pilih Pro
                    </a>
                </div>
                
                <!-- Premium Ultra Plan -->
                <div class="reveal delay-300 hover-lift bg-white rounded-3xl p-8 border-2 border-gray-100">
                    <div class="text-center mb-6">
                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-2">Premium Ultra</h3>
                        <p class="text-gray-500">Untuk yayasan besar</p>
                    </div>
                    <div class="text-center mb-8">
                        <span class="font-display text-4xl font-bold text-gray-900">Rp 899.000</span>
                        <span class="text-gray-500">/bulan</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 Masjid
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            50 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Transaksi Unlimited
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Laporan Analitik
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Prioritas Support
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            API Access
                        </li>
                    </ul>
                    <a href="{{ route('register') }}?plan=ultra" class="block w-full border-2 border-gray-900 text-gray-900 py-3 rounded-xl font-semibold text-center hover:bg-gray-900 hover:text-white transition-colors">
                        Pilih Premium Ultra
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 lg:py-32 bg-primary-lightest">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Siap Memulai?
            </h2>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ratusan masjid yang telah menggunakan sistem manajemen keuangan kami
            </p>
            <a href="{{ route('register') }}" class="btn-primary inline-block bg-primary text-white px-12 py-5 rounded-xl font-semibold text-lg shadow-lg">
                Daftar Gratis Sekarang
            </a>
            <p class="mt-6 text-sm text-gray-500">Tidak memerlukan kartu kredit</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center">
                            <svg class="h-7 w-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                <circle cx="12" cy="6" r="1.5"/>
                            </svg>
                        </div>
                        <span class="text-xl font-display font-bold">Masjid Basmallah</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Sistem manajemen keuangan masjid yang modern, transparan, dan terpercaya.</p>
                </div>
                <div>
                    <h4 class="font-display font-bold text-lg mb-6">Menu</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#features" class="hover:text-primary transition-colors">Fitur</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-primary transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-primary transition-colors">Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-display font-bold text-lg mb-6">Kontak</h4>
                    <p class="text-gray-400 mb-2">Email: info@masjidbasmallah.com</p>
                    <p class="text-gray-400">Telp: (021) 1234-5678</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Masjid Basmallah. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Reveal animations on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');
            
            const revealOnScroll = () => {
                const windowHeight = window.innerHeight;
                reveals.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const revealPoint = 100;
                    
                    if (elementTop < windowHeight - revealPoint) {
                        element.classList.add('active');
                    }
                });
            };
            
            // Initial check
            revealOnScroll();
            
            // Check on scroll
            window.addEventListener('scroll', revealOnScroll);
        });
    </script>
</body>
</html>
