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
                            DEFAULT: '#B8860B',
                            light: '#DAA520',
                            lightest: '#FEF3C7',
                            dark: '#8B6508',
                            darker: '#654C0F',
                        },
                        dark: {
                            DEFAULT: '#1a1a1a',
                            light: '#333333',
                            lighter: '#4a4a4a',
                        },
                        silver: {
                            DEFAULT: '#C0C0C0',
                            light: '#E8E8E8',
                            dark: '#A8A8A8',
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
        
        /* Macbook Pro Style */
        .macbook-pro {
            background: linear-gradient(180deg, #2d2d2d 0%, #1d1d1d 100%);
            border-radius: 20px 20px 0 0;
            position: relative;
            box-shadow: 
                0 0 0 3px #333,
                0 0 0 4px #444,
                0 30px 60px rgba(0,0,0,0.4);
        }
        
        /* Macbook notch */
        .macbook-notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 160px;
            height: 28px;
            background: #1a1a1a;
            border-radius: 0 0 18px 18px;
            z-index: 10;
        }
        
        /* Macbook notch camera */
        .macbook-notch::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 10px;
            height: 10px;
            background: #2a2a2a;
            border-radius: 50%;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.5);
        }
        
        /* Macbook screen */
        .macbook-screen {
            background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
            position: relative;
        }
        
        /* Macbook base */
        .macbook-base {
            background: linear-gradient(180deg, #C0C0C0 0%, #A8A8A8 100%);
            position: relative;
            box-shadow: 
                0 2px 4px rgba(0,0,0,0.1),
                inset 0 1px 0 rgba(255,255,255,0.5);
        }
        
        /* Macbook base notch */
        .macbook-base::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 8px;
            background: linear-gradient(180deg, #888 0%, #999 50%, #888 100%);
            border-radius: 0 0 4px 4px;
        }
        
        /* Keyboard */
        .keyboard-row {
            display: flex;
            justify-content: center;
            gap: 6px;
        }
        
        .key {
            background: linear-gradient(180deg, #f0f0f0 0%, #d8d8d8 100%);
            border-radius: 4px;
            box-shadow: 
                0 1px 2px rgba(0,0,0,0.2),
                inset 0 1px 0 rgba(255,255,255,0.8);
        }
        
        .key-space {
            background: linear-gradient(180deg, #f0f0f0 0%, #d8d8d8 100%);
            border-radius: 4px;
            box-shadow: 
                0 1px 2px rgba(0,0,0,0.2),
                inset 0 1px 0 rgba(255,255,255,0.8);
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Button styles */
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #8B6508;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(184, 134, 11, 0.4);
        }
        
        .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #FEF3C7;
            transform: translateY(-2px);
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
        
        /* Gradient text - gold */
        .gradient-text {
            color: #B8860B;
        }
        
        /* Subtle pattern */
        .pattern-dots {
            background-image: radial-gradient(rgba(184, 134, 11, 0.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        /* Hover animations */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(184, 134, 11, 0.15);
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        /* Feature card hover */
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(184, 134, 11, 0.12);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        
        .feature-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Macbook hover */
        .macbook-container {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .macbook-container:hover {
            transform: translateY(-15px);
        }
        
        /* Stats hover */
        .stats-item {
            transition: all 0.3s ease;
        }
        .stats-item:hover {
            transform: translateY(-5px);
        }
        .stats-item:hover .stats-number {
            color: #DAA520;
        }
        
        /* Pricing card hover */
        .pricing-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(184, 134, 11, 0.12);
        }
    </style>
</head>
<body class="bg-gray-50 font-body text-gray-900 antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-3 hover-scale">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                <circle cx="12" cy="6" r="1.5"/>
                            </svg>
                        </div>
                        <span class="text-xl font-display font-bold text-primary">Basmallah</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="text-gray-600 hover:text-primary font-medium transition-colors">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-primary font-medium transition-colors hover:scale-105 inline-block">Masuk</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary bg-primary text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30">Daftar Gratis</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Enhanced Macbook -->
    <section class="pt-24 pb-16 lg:pt-32 lg:pb-24 pattern-dots relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[700px] bg-primary/5 rounded-full blur-[150px] pointer-events-none"></div>
        
        <!-- Decorative elements -->
        <div class="absolute top-40 left-20 w-4 h-4 bg-primary/30 rounded-full"></div>
        <div class="absolute top-60 right-32 w-3 h-3 bg-primary/40 rounded-full"></div>
        <div class="absolute bottom-40 left-1/4 w-2 h-2 bg-primary/50 rounded-full"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Badge -->
            <div class="text-center mb-8 reveal">
                <span class="inline-flex items-center px-4 py-1.5 bg-primary-lightest border border-primary/20 rounded-full text-primary text-sm font-medium hover-scale cursor-default">
                    <span class="w-2 h-2 bg-primary rounded-full mr-2 animate-pulse"></span>
                    Sistem Manajemen Keuangan Masjid
                </span>
            </div>
            
            <!-- Main Heading -->
            <div class="text-center mb-12 reveal delay-100">
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-gray-900">
                    Kelola Keuangan 
                    <span class="gradient-text">Masjid</span><br>
                    Dengan Modern
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Transparan, akuntabel, dan terintegrasi. Wawasan keuangan real-time untuk manajemen masjid yang lebih baik.
                </p>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16 reveal delay-200">
                <a href="<?php echo e(route('register')); ?>" class="btn-primary bg-primary text-white px-8 py-4 rounded-xl font-semibold text-center shadow-lg shadow-primary/30 inline-flex items-center justify-center hover-scale">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Mulai Sekarang
                </a>
                <a href="#macbook-demo" class="btn-secondary text-primary border-2 border-primary px-8 py-4 rounded-xl font-semibold text-center inline-flex items-center justify-center hover-lift">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Demo
                </a>
            </div>
            
            <!-- Enhanced Macbook Pro Mockup with Light Dashboard -->
            <div class="reveal delay-300 float-animation" id="macbook-demo">
                <div class="max-w-5xl mx-auto macbook-container">
                    <!-- Macbook Screen (Top) -->
                    <div class="macbook-pro relative">
                        <!-- Notch -->
                        <div class="macbook-notch"></div>
                        
                        <!-- Screen Content -->
                        <div class="macbook-screen pt-14 pb-3 px-3">
                            <!-- Browser Bar -->
                            <div class="flex items-center justify-between mb-3 px-2">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div class="flex-1 max-w-lg mx-4">
                                    <div class="bg-dark-light rounded-lg px-4 py-2 text-xs text-gray-400 text-center">
                                        basmallah.dashboard
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-dark-light flex items-center justify-center">
                                        <svg class="w-2 h-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dashboard Preview - LIGHT THEME -->
                            <div class="px-2">
                                <div class="bg-white rounded-xl p-4 shadow-lg">
                                    <!-- Dashboard Header -->
                                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-md">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                                    <circle cx="12" cy="6" r="1.5"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">Basmallah</div>
                                                <div class="text-xs text-gray-500">Dashboard Keuangan</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 bg-primary-lightest text-primary text-xs font-medium rounded-lg">Pro</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Stats Cards -->
                                    <div class="grid grid-cols-3 gap-3 mb-4">
                                        <!-- Stat Card 1 -->
                                        <div class="bg-gray-50 rounded-xl p-3 hover-lift cursor-pointer">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-xs text-green-600 font-semibold">+12%</span>
                                            </div>
                                            <div class="text-xs text-gray-500">Total Pemasukan</div>
                                            <div class="text-sm font-bold text-gray-900">Rp 25.000.000</div>
                                        </div>
                                        <!-- Stat Card 2 -->
                                        <div class="bg-gray-50 rounded-xl p-3 hover-lift cursor-pointer">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-xs text-red-600 font-semibold">-5%</span>
                                            </div>
                                            <div class="text-xs text-gray-500">Total Pengeluaran</div>
                                            <div class="text-sm font-bold text-gray-900">Rp 18.500.000</div>
                                        </div>
                                        <!-- Stat Card 3 -->
                                        <div class="bg-gray-50 rounded-xl p-3 hover-lift cursor-pointer">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="w-8 h-8 bg-primary-lightest rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">Saldo Akhir</div>
                                            <div class="text-sm font-bold text-primary">Rp 6.500.000</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Chart Area -->
                                    <div class="bg-gray-50 rounded-xl p-3 mb-4 hover-lift cursor-pointer">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="text-xs font-semibold text-gray-700">Grafik Keuangan</div>
                                            <div class="flex space-x-2">
                                                <span class="px-2 py-0.5 bg-white rounded text-xs text-gray-500 shadow-sm">Minggu</span>
                                                <span class="px-2 py-0.5 bg-primary text-white rounded text-xs shadow-sm">Bulan</span>
                                                <span class="px-2 py-0.5 bg-white rounded text-xs text-gray-500 shadow-sm">Tahun</span>
                                            </div>
                                        </div>
                                        <div class="h-20 flex items-end justify-between gap-2">
                                            <div class="flex-1 bg-primary/20 rounded-t-lg h-8 hover:bg-primary/40 transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary/40 rounded-t-lg h-12 hover:bg-primary/60 transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary/30 rounded-t-lg h-10 hover:bg-primary/50 transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary/60 rounded-t-lg h-14 hover:bg-primary/80 transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary rounded-t-lg h-16 hover:bg-primary-dark transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary/50 rounded-t-lg h-11 hover:bg-primary/70 transition-colors cursor-pointer"></div>
                                            <div class="flex-1 bg-primary/70 rounded-t-lg h-13 hover:bg-primary/90 transition-colors cursor-pointer"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bottom Stats -->
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="bg-gray-50 rounded-xl p-3 text-center hover-lift cursor-pointer">
                                            <div class="text-xs text-gray-500">Transaksi</div>
                                            <div class="text-base font-bold text-gray-900">156</div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-3 text-center hover-lift cursor-pointer">
                                            <div class="text-xs text-gray-500">Kategori</div>
                                            <div class="text-base font-bold text-gray-900">12</div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-3 text-center hover-lift cursor-pointer">
                                            <div class="text-xs text-gray-500">Rekening</div>
                                            <div class="text-base font-bold text-gray-900">3</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Macbook Base -->
                        <div class="macbook-base px-8 py-4">
                            <!-- Keyboard -->
                            <div class="space-y-1">
                                <!-- Row 1 -->
                                <div class="keyboard-row">
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-8 h-5"></div>
                                </div>
                                <!-- Row 2 -->
                                <div class="keyboard-row">
                                    <div class="key w-8 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-8 h-5"></div>
                                </div>
                                <!-- Row 3 -->
                                <div class="keyboard-row">
                                    <div class="key w-10 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                    <div class="key w-10 h-5"></div>
                                </div>
                                <!-- Row 4 -->
                                <div class="keyboard-row">
                                    <div class="key w-12 h-5"></div>
                                    <div class="key w-12 h-5"></div>
                                    <div class="key-space w-48 h-5"></div>
                                    <div class="key w-12 h-5"></div>
                                    <div class="key w-5 h-5"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bottom Edge -->
                        <div class="h-2 bg-silver-dark rounded-b-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 lg:py-28 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="reveal inline-block text-primary font-semibold text-sm uppercase tracking-widest mb-4">
                    Fitur Unggulan
                </span>
                <h2 class="reveal delay-100 font-display text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Solusi Lengkap untuk Masjid
                </h2>
                <p class="reveal delay-200 text-gray-600 max-w-xl mx-auto">
                    Sistem terintegrasi untuk manajemen keuangan yang modern dan terpercaya
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="reveal delay-100 feature-card bg-gray-50 border border-gray-100 rounded-2xl p-6 cursor-pointer">
                    <div class="feature-icon w-12 h-12 bg-primary-lightest rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Transparan</h3>
                    <p class="text-gray-600 text-sm">Catat setiap transaksi dengan detail lengkap dan laporan keuangan yang jelas.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="reveal delay-200 feature-card bg-gray-50 border border-gray-100 rounded-2xl p-6 cursor-pointer">
                    <div class="feature-icon w-12 h-12 bg-primary-lightest rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Real-time</h3>
                    <p class="text-gray-600 text-sm">Pantau keuangan masjid kapan saja dengan laporan otomatis yang selalu terkini.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="reveal delay-300 feature-card bg-gray-50 border border-gray-100 rounded-2xl p-6 cursor-pointer">
                    <div class="feature-icon w-12 h-12 bg-primary-lightest rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Aman</h3>
                    <p class="text-gray-600 text-sm">Sistem izin berbasis peran dengan akses terkontrol sesuai tanggung jawab.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="reveal delay-400 feature-card bg-gray-50 border border-gray-100 rounded-2xl p-6 cursor-pointer">
                    <div class="feature-icon w-12 h-12 bg-primary-lightest rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Modern</h3>
                    <p class="text-gray-600 text-sm">Dibangun dengan teknologi terkini dan antarmuka responsif di semua perangkat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-primary-lightest border-y border-primary/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="reveal stats-item cursor-pointer">
                    <div class="stats-number text-3xl lg:text-4xl font-display font-bold text-primary mb-2 transition-colors">500+</div>
                    <div class="text-gray-600 text-sm">Masjid Terdaftar</div>
                </div>
                <div class="reveal delay-100 stats-item cursor-pointer">
                    <div class="stats-number text-3xl lg:text-4xl font-display font-bold text-primary mb-2 transition-colors">50K+</div>
                    <div class="text-gray-600 text-sm">Transaksi</div>
                </div>
                <div class="reveal delay-200 stats-item cursor-pointer">
                    <div class="stats-number text-3xl lg:text-4xl font-display font-bold text-primary mb-2 transition-colors">99.9%</div>
                    <div class="text-gray-600 text-sm">Uptime</div>
                </div>
                <div class="reveal delay-300 stats-item cursor-pointer">
                    <div class="stats-number text-3xl lg:text-4xl font-display font-bold text-primary mb-2 transition-colors">4.9</div>
                    <div class="text-gray-600 text-sm">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 lg:py-28 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="reveal inline-block text-primary font-semibold text-sm uppercase tracking-widest mb-4">
                    Harga
                </span>
                <h2 class="reveal delay-100 font-display text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Pilih Paket yang Sesuai
                </h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Gratis Plan -->
                <div class="reveal delay-100 pricing-card bg-white border-2 border-gray-100 rounded-2xl p-6 cursor-pointer hover:border-primary/30">
                    <div class="text-center mb-4">
                        <h3 class="font-display text-xl font-bold text-gray-900 mb-1">Gratis</h3>
                        <p class="text-gray-500 text-sm">Untuk masjid kecil</p>
                    </div>
                    <div class="text-center mb-6">
                        <span class="font-display text-3xl font-bold text-gray-900">Rp 0</span>
                        <span class="text-gray-500 text-sm">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            1 Masjid
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            3 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            100 Transaksi/bulan
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="block w-full border-2 border-primary text-primary py-2.5 rounded-xl font-semibold text-center hover:bg-primary hover:text-white transition-colors text-sm">
                        Mulai Gratis
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div class="reveal delay-200 pricing-card bg-primary-lightest border-2 border-primary rounded-2xl p-6 relative transform scale-105 shadow-xl shadow-primary/10 cursor-pointer">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">
                        TERPOPULER
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="font-display text-xl font-bold text-gray-900 mb-1">Pro</h3>
                        <p class="text-gray-500 text-sm">Untuk masjid menengah</p>
                    </div>
                    <div class="text-center mb-6">
                        <span class="font-display text-3xl font-bold text-primary">Rp 299rb</span>
                        <span class="text-gray-500 text-sm">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            1 Masjid
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            10 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Transaksi Unlimited
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Laporan Lengkap
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>?plan=pro" class="block w-full bg-primary text-white py-2.5 rounded-xl font-semibold text-center hover:bg-primary-dark transition-colors text-sm">
                        Pilih Pro
                    </a>
                </div>
                
                <!-- Premium Plan -->
                <div class="reveal delay-300 pricing-card bg-white border-2 border-gray-100 rounded-2xl p-6 cursor-pointer hover:border-primary/30">
                    <div class="text-center mb-4">
                        <h3 class="font-display text-xl font-bold text-gray-900 mb-1">Premium</h3>
                        <p class="text-gray-500 text-sm">Untuk yayasan besar</p>
                    </div>
                    <div class="text-center mb-6">
                        <span class="font-display text-3xl font-bold text-gray-900">Rp 899rb</span>
                        <span class="text-gray-500 text-sm">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 Masjid
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            50 Akun Pengguna
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Semua Fitur Pro
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Prioritas Support
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>?plan=premium" class="block w-full border-2 border-gray-300 text-gray-600 py-2.5 rounded-xl font-semibold text-center hover:border-primary hover:text-primary transition-colors text-sm">
                        Pilih Premium
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary-lightest hover-lift">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Siap Memulai?
            </h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">
                Bergabunglah dengan ratusan masjid yang telah menggunakan sistem manajemen keuangan kami
            </p>
            <a href="<?php echo e(route('register')); ?>" class="btn-primary inline-block bg-primary text-white px-10 py-4 rounded-xl font-semibold shadow-lg shadow-primary/30 hover-scale">
                Daftar Gratis Sekarang
            </a>
            <p class="mt-4 text-sm text-gray-500">Tidak memerlukan kartu kredit</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0 hover-scale">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                            <circle cx="12" cy="6" r="1.5"/>
                        </svg>
                    </div>
                    <span class="text-lg font-display font-bold text-primary">Basmallah</span>
                </div>
                <div class="flex items-center space-x-6 text-sm text-gray-600">
                    <a href="#features" class="hover:text-primary transition-colors hover:scale-105 inline-block">Fitur</a>
                    <a href="<?php echo e(route('login')); ?>" class="hover:text-primary transition-colors hover:scale-105 inline-block">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="hover:text-primary transition-colors hover:scale-105 inline-block">Daftar</a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-100 text-center text-gray-500 text-sm">
                <p>&copy; <?php echo e(date('Y')); ?> Basmallah. All rights reserved.</p>
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
<?php /**PATH C:\laragon\www\gitclone\masjid\basmalah\resources\views/welcome.blade.php ENDPATH**/ ?>