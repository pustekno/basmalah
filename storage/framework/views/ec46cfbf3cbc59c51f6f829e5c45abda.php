<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basmallah - Sistem Manajemen Keuangan Masjid</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        amber: {
                            DEFAULT: '#D4A017',
                            light: '#E0B532',
                            dark: '#B8890D',
                            darker: '#9A7209',
                            50: '#FDF6E8',
                            100: '#FAE9C5',
                            200: '#F5D78B',
                            300: '#F0C151',
                            400: '#EBAA17',
                            500: '#D4A017',
                            600: '#B8890D',
                            700: '#9A7209',
                            800: '#7C5B06',
                            900: '#5E4404',
                        },
                        cream: {
                            DEFAULT: '#FDFBF4',
                            light: '#FEFDF8',
                            dark: '#F5F0E1',
                        },
                        dark: {
                            DEFAULT: '#1A1A1A',
                            light: '#333333',
                            lighter: '#4A4A4A',
                        },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        'amber': '0 4px 14px 0 rgba(212, 160, 23, 0.15)',
                        'amber-lg': '0 10px 40px 0 rgba(212, 160, 23, 0.2)',
                        'amber-sm': '0 2px 8px 0 rgba(212, 160, 23, 0.1)',
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-15px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        html { scroll-behavior: smooth; }
        
        /* Islamic Geometric Pattern - 8 Point Star */
        .pattern-star {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0L37.5 22.5L60 30L37.5 37.5L30 60L22.5 37.5L0 30L22.5 22.5L30 0Z' fill='%23D4A017' fill-opacity='0.08'/%3E%3C/svg%3E");
        }
        
        /* Arabesque Pattern */
        .pattern-arabesque {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 10 C60 20 70 30 70 50 C70 70 60 80 50 90 C40 80 30 70 30 50 C30 30 40 20 50 10Z' fill='none' stroke='%23D4A017' stroke-opacity='0.1' stroke-width='2'/%3E%3Cpath d='M40 30 Q50 40 60 30' fill='none' stroke='%23D4A017' stroke-opacity='0.08' stroke-width='1.5'/%3E%3Cpath d='M40 70 Q50 60 60 70' fill='none' stroke='%23D4A017' stroke-opacity='0.08' stroke-width='1.5'/%3E%3C/svg%3E");
        }
        
        /* Subtle dot pattern */
        .pattern-dots {
            background-image: radial-gradient(rgba(212, 160, 23, 0.12) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        /* Button hover effects */
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #B8890D;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(212, 160, 23, 0.4);
        }
        
        .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #FDF6E8;
            transform: translateY(-2px);
            border-color: #D4A017;
        }
        
        .btn-outline:hover {
            background-color: rgba(212, 160, 23, 0.1);
            border-color: #D4A017;
        }
        
        /* Card hover lift */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212, 160, 23, 0.15);
        }
        
        /* Animated gradient */
        .gradient-bg {
            background: linear-gradient(135deg, #FDFBF4 0%, #FAE9C5 50%, #FDFBF4 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Smartphone Mockup */
        .smartphone {
            background: linear-gradient(180deg, #2d2d2d 0%, #1d1d1d 100%);
            border-radius: 40px;
            position: relative;
            box-shadow: 
                0 0 0 3px #333,
                0 0 0 4px #444,
                0 30px 60px rgba(212, 160, 23, 0.25);
        }
        
        .smartphone-notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 28px;
            background: #1a1a1a;
            border-radius: 0 0 20px 20px;
            z-index: 10;
        }
        
        .smartphone-screen {
            background: linear-gradient(180deg, #FDFBF4 0%, #F5F0E1 100%);
            position: relative;
            border-radius: 32px;
        }
        
        /* Smartphone home indicator */
        .smartphone-home {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: #333;
            border-radius: 2px;
        }
        
        /* Bar chart animation */
        @keyframes barGrow {
            0% { height: 0; }
            100% { height: var(--bar-height); }
        }
        
        .bar-animate {
            animation: barGrow 0.5s ease-out forwards;
            animation-delay: var(--bar-delay);
        }
        
        /* Counter animation */
        @keyframes countUp {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .counter-animate {
            animation: countUp 0.3s ease-out forwards;
        }
        
        /* Floating notification */
        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.8) translateY(10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        
        .pop-in {
            animation: popIn 0.4s ease-out forwards;
            animation-delay: 800ms;
            opacity: 0;
        }
        
        /* Stats counter */
        .stat-item {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }
        
        .stat-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Testimonial card animation */
        .testimonial-card {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.6s ease-out;
        }
        
        .testimonial-card.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Pricing card highlight */
        .pricing-highlight {
            position: relative;
            border: 2px solid #D4A017;
        }
        .pricing-highlight::before {
            content: 'POPULER';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #D4A017;
            color: white;
            padding: 4px 16px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="font-sans text-dark antialiased">
    
    <!-- ==================== NAVBAR ==================== -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-cream/95 backdrop-blur-sm border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber rounded-xl flex items-center justify-center shadow-amber-sm">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.18l6.9 3.82L12 11.82 5.1 8 12 4.18zM5 9.64l6 3.33v6.39l-6-3.33V9.64zm8 9.72v-6.39l6-3.33v6.39l-6 3.33z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-dark">Basmallah</span>
                </div>
                
                <!-- Menu Links - Desktop -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-dark-lighter hover:text-amber font-medium transition-colors">Beranda</a>
                    <a href="#fitur" class="text-dark-lighter hover:text-amber font-medium transition-colors">Fitur</a>
                    <a href="#harga" class="text-dark-lighter hover:text-amber font-medium transition-colors">Harga</a>
                    <a href="#laporan" class="text-dark-lighter hover:text-amber font-medium transition-colors">Lihat Laporan Masjid</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center gap-3">
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-5 py-2.5 border-2 border-amber text-amber font-semibold rounded-xl hover:bg-amber hover:text-white transition-all duration-300 btn-outline">
                        Dashboard
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-5 py-2.5 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all duration-300 btn-primary shadow-amber">
                            Keluar
                        </button>
                    </form>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="px-5 py-2.5 border-2 border-amber text-amber font-semibold rounded-xl hover:bg-amber hover:text-white transition-all duration-300 btn-outline">
                        Masuk
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="px-5 py-2.5 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all duration-300 btn-primary shadow-amber">
                        Daftar Gratis
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 text-dark-lighter hover:text-amber" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-cream border-t border-amber-100 px-4 py-4">
            <div class="flex flex-col gap-4">
                <a href="#beranda" class="text-dark-lighter hover:text-amber font-medium py-2">Beranda</a>
                <a href="#fitur" class="text-dark-lighter hover:text-amber font-medium py-2">Fitur</a>
                <a href="#harga" class="text-dark-lighter hover:text-amber font-medium py-2">Harga</a>
                <a href="#laporan" class="text-dark-lighter hover:text-amber font-medium py-2">Lihat Laporan Masjid</a>
                <div class="flex flex-col gap-3 pt-4 border-t border-amber-100">
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-5 py-2.5 border-2 border-amber text-amber font-semibold rounded-xl text-center">Dashboard</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full px-5 py-2.5 bg-amber text-white font-semibold rounded-xl text-center">Keluar</button>
                    </form>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="px-5 py-2.5 border-2 border-amber text-amber font-semibold rounded-xl text-center">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="px-5 py-2.5 bg-amber text-white font-semibold rounded-xl text-center">Daftar Gratis</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO SECTION ==================== -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 gradient-bg pattern-star overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-32 h-32 border border-amber/10 rounded-full"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 border border-amber/10 rotate-45"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-amber/5 rounded-full"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left animate-fade-in">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-dark leading-tight mb-6">
                        Kelola Keuangan Masjid Dengan 
                        <span class="text-amber">Modern</span>
                    </h1>
                    <p class="text-lg text-dark-lighter mb-8 max-w-xl mx-auto lg:mx-0">
                        Transparan, akuntabel, dan terintegrasi. Semua dalam satu platform manajemen keuangan masjid yang mudah digunakan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="<?php echo e(route('register')); ?>" class="px-8 py-4 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all duration-300 btn-primary shadow-amber-lg text-lg">
                            Mulai Sekarang
                        </a>
                        <a href="#" class="px-8 py-4 border-2 border-amber text-amber font-semibold rounded-xl hover:bg-amber hover:text-white transition-all duration-300 btn-outline text-lg">
                            Lihat Demo
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Social Proof / Testimonials -->
                <div class="relative" id="testimonials">
                    <!-- Overall Rating - Modern Clean Design -->
                    <div class="text-center mb-10 animate-fade-in">
                        <div class="inline-flex flex-col items-center">
                            <div class="text-6xl lg:text-7xl font-bold text-dark tracking-tight">4.9</div>
                            <div class="flex gap-1.5 mb-2">
                                <svg class="w-5 h-5 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-5 h-5 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-5 h-5 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-5 h-5 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-5 h-5 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <div class="text-dark-lighter text-sm font-medium">200+ ulasan pengurus masjid</div>
                        </div>
                    </div>
                    
                    <!-- Testimonial Cards - Modern Sliding Carousel -->
                    <div class="relative overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out" id="testimonial-slider">
                            <!-- Card 1 -->
                            <div class="testimonial-card flex-shrink-0 w-full px-2">
                                <div class="bg-white rounded-2xl p-5 shadow-amber-sm hover:shadow-amber-lg transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-amber font-bold text-sm">AH</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="font-semibold text-dark text-sm truncate">Ahmad Hakim</span>
                                                <div class="flex gap-0.5">
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </div>
                                            </div>
                                            <div class="text-xs text-dark-lighter truncate">Masjid Al-Ikhlas, Jakarta</div>
                                        </div>
                                    </div>
                                    <p class="text-dark text-sm mt-3 truncate">"Laporan keuangan lebih transparan"</p>
                                </div>
                            </div>
                            
                            <!-- Card 2 -->
                            <div class="testimonial-card flex-shrink-0 w-full px-2">
                                <div class="bg-white rounded-2xl p-5 shadow-amber-sm hover:shadow-amber-lg transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-amber font-bold text-sm">MR</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="font-semibold text-dark text-sm truncate">M. Ridwan</span>
                                                <div class="flex gap-0.5">
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </div>
                                            </div>
                                            <div class="text-xs text-dark-lighter truncate">Masjid Baitul Aman, Bandung</div>
                                        </div>
                                    </div>
                                    <p class="text-dark text-sm mt-3 truncate">"Build trust with jama'ah"</p>
                                </div>
                            </div>
                            
                            <!-- Card 3 -->
                            <div class="testimonial-card flex-shrink-0 w-full px-2">
                                <div class="bg-white rounded-2xl p-5 shadow-amber-sm hover:shadow-amber-lg transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-amber font-bold text-sm">SF</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="font-semibold text-dark text-sm truncate">Siti Fatimah</span>
                                                <div class="flex gap-0.5">
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <svg class="w-3 h-3 text-amber" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </div>
                                            </div>
                                            <div class="text-xs text-dark-lighter truncate">Masjid Nurul Huda, Surabaya</div>
                                        </div>
                                    </div>
                                    <p class="text-dark text-sm mt-3 truncate">"Mudah digunakan siapa saja"</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Dots -->
                        <div class="flex justify-center gap-2 mt-4" id="testimonial-dots">
                            <button class="w-2 h-2 rounded-full bg-amber transition-all" data-index="0"></button>
                            <button class="w-2 h-2 rounded-full bg-amber/30 transition-all" data-index="1"></button>
                            <button class="w-2 h-2 rounded-full bg-amber/30 transition-all" data-index="2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== STATS SECTION ==================== -->
    <section id="stats" class="py-10" style="background: linear-gradient(180deg, #FDFBF4 0%, #FDF6E3 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 items-center">
                <!-- Stat 1 -->
                <div class="text-center stat-item relative" data-delay="0">
                    <div class="text-4xl lg:text-5xl font-bold text-dark mb-2 counter" data-target="500">0</div>
                    <div class="text-[#6B6B6B] text-sm lg:text-base">Masjid Terdaftar</div>
                    <div class="hidden lg:block absolute right-0 top-1/2 transform -translate-y-1/2">
                        <div class="w-1 h-12 bg-amber/30 rounded-full"></div>
                    </div>
                </div>
                <!-- Stat 2 -->
                <div class="text-center stat-item relative" data-delay="150">
                    <div class="text-4xl lg:text-5xl font-bold text-amber-dark mb-2 counter" data-target="50000" data-prefix="">0</div>
                    <div class="text-[#6B6B6B] text-sm lg:text-base">Transaksi</div>
                    <div class="hidden lg:block absolute right-0 top-1/2 transform -translate-y-1/2">
                        <div class="w-1 h-12 bg-amber/30 rounded-full"></div>
                    </div>
                </div>
                <!-- Stat 3 -->
                <div class="text-center stat-item relative" data-delay="300">
                    <div class="text-4xl lg:text-5xl font-bold text-dark mb-2 counter" data-target="99.9" data-suffix="%" data-decimals="1">0</div>
                    <div class="text-[#6B6B6B] text-sm lg:text-base">Uptime</div>
                    <div class="hidden lg:block absolute right-0 top-1/2 transform -translate-y-1/2">
                        <div class="w-1 h-12 bg-amber/30 rounded-full"></div>
                    </div>
                </div>
                <!-- Stat 4 -->
                <div class="text-center stat-item" data-delay="450">
                    <div class="text-4xl lg:text-5xl font-bold text-amber-dark mb-2 counter" data-target="4.9" data-suffix="" data-decimals="1">0</div>
                    <div class="text-[#6B6B6B] text-sm lg:text-base">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FITUR SECTION ==================== -->
    <section id="fitur" class="py-20 lg:py-28 bg-cream pattern-arabesque">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-amber-100 text-amber text-sm font-semibold rounded-full mb-4">FITUR</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-dark mb-4">Semua yang Masjid Anda Butuhkan</h2>
                <p class="text-dark-lighter max-w-2xl mx-auto">Kelola keuangan masjid dengan mudah, transparan, dan profesional.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Laporan Keuangan</h3>
                    <p class="text-dark-lighter">Buat dan lihat laporan keuangan dengan mudah. Grafik yang jelas membantu memahami kondisi keuangan.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Kelola Transaksi</h3>
                    <p class="text-dark-lighter">Catat setiap pemasukan dan pengeluaran dengan kategori yang terstruktur dan mudah dipahami.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Multi Rekening</h3>
                    <p class="text-dark-lighter">Kelola beberapa rekening bank sekaligus. Semua transaksi tercatat dengan rapi dan terorganisir.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Transparansi Publik</h3>
                    <p class="text-dark-lighter">Publikasikan laporan keuangan untuk jamaidah. Tingkatkan kepercayaan dengan transparansi penuh.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Budget & Target</h3>
                    <p class="text-dark-lighter">Rencanakan anggaran dengan target fundraising yang jelas. Pantau progres pencapaian tujuan.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm hover-lift">
                    <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3">Akses Multi Device</h3>
                    <p class="text-dark-lighter">Akses data keuangan masjid kapan saja dan dari mana saja melalui smartphone atau laptop.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== LIHAT LAPORAN MASJID SECTION ==================== -->
    <section id="laporan" class="py-20 lg:py-28 bg-cream border-t border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 border-2 border-amber text-amber text-sm font-semibold rounded-full mb-4">TRANSPARANSI PUBLIK</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-dark mb-4">Lihat Laporan Keuangan Masjid Anda</h2>
                <p class="text-dark-lighter max-w-2xl mx-auto">Jamaah dapat memantau keuangan masjid secara transparan tanpa perlu login</p>
            </div>
            
            <!-- Search Box -->
            <div class="max-w-3xl mx-auto mb-12">
                <form action="<?php echo e(route('login')); ?>" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-dark-lighter" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q"
                            placeholder="Cari nama masjid atau kota..." 
                            class="w-full pl-12 pr-4 py-4 bg-white border-2 border-amber/30 rounded-xl text-dark placeholder-dark-lighter focus:outline-none focus:border-amber focus:ring-2 focus:ring-amber/20 transition-all"
                        >
                    </div>
                    <button 
                        type="submit"
                        class="px-8 py-4 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all duration-300 btn-primary shadow-amber whitespace-nowrap"
                    >
                        Cari Masjid
                    </button>
                </form>
            </div>
            
            <!-- Popular Masjids Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Sample Masjid Card 1 -->
                <a href="<?php echo e(route('login')); ?>" class="bg-white rounded-2xl p-6 shadow-amber-sm hover-lift block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber text-xs font-semibold rounded-full">Terverifikasi</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-1">Masjid Al-Amdin</h3>
                    <p class="text-dark-lighter text-sm mb-3">Jakarta Selatan</p>
                    <div class="text-xs text-dark-lighter">Terakhir diperbarui: 15 Mar 2026</div>
                </a>
                
                <!-- Sample Masjid Card 2 -->
                <a href="<?php echo e(route('login')); ?>" class="bg-white rounded-2xl p-6 shadow-amber-sm hover-lift block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber text-xs font-semibold rounded-full">Terverifikasi</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-1">Masjid Al-Ikhlas</h3>
                    <p class="text-dark-lighter text-sm mb-3">Bandung</p>
                    <div class="text-xs text-dark-lighter">Terakhir diperbarui: 14 Mar 2026</div>
                </a>
                
                <!-- Sample Masjid Card 3 -->
                <a href="<?php echo e(route('login')); ?>" class="bg-white rounded-2xl p-6 shadow-amber-sm hover-lift block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber text-xs font-semibold rounded-full">Terverifikasi</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-1">Masjid Nurullah</h3>
                    <p class="text-dark-lighter text-sm mb-3">Surabaya</p>
                    <div class="text-xs text-dark-lighter">Terakhir diperbarui: 13 Mar 2026</div>
                </a>
                
                <!-- Sample Masjid Card 4 -->
                <a href="<?php echo e(route('login')); ?>" class="bg-white rounded-2xl p-6 shadow-amber-sm hover-lift block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber text-xs font-semibold rounded-full">Terverifikasi</span>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-1">Masjid Ar-Rohman</h3>
                    <p class="text-dark-lighter text-sm mb-3">Yogyakarta</p>
                    <div class="text-xs text-dark-lighter">Terakhir diperbarui: 12 Mar 2026</div>
                </a>
            </div>
            
            <!-- View All Link -->
            <div class="text-center mt-10">
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 text-amber font-semibold hover:text-amber-dark transition-colors">
                    Lihat Semua Masjid
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== PRICING SECTION ==================== -->
    <section id="harga" class="py-20 lg:py-28 bg-cream-light pattern-dots">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-amber-100 text-amber text-sm font-semibold rounded-full mb-4">HARGA</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-dark mb-4">Paket Harga Terjangkau</h2>
                <p class="text-dark-lighter max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan masjid Anda</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-amber-sm">
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-bold text-dark mb-2">Gratis</h3>
                        <div class="text-4xl font-bold text-dark mb-1">Rp 0</div>
                        <div class="text-dark-lighter text-sm">Selamanya</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>1 Masjid</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>3 Pengguna</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Laporan Publik</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Manajemen Kategori</span>
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="block w-full py-3 border-2 border-amber text-amber font-semibold rounded-xl text-center hover:bg-amber hover:text-white transition-all btn-outline">
                        Mulai Gratis
                    </a>
                </div>
                
                <!-- Pro Plan (Highlighted) -->
                <div class="bg-white rounded-2xl p-8 shadow-amber-lg pricing-highlight transform scale-105">
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-bold text-dark mb-2">Pro</h3>
                        <div class="text-4xl font-bold text-amber mb-1">Rp 99.000</div>
                        <div class="text-dark-lighter text-sm">per bulan</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">1 Masjid</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">10 Pengguna</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Laporan Publik</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Budget & Target</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Export Laporan</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark">
                            <svg class="w-5 h-5 text-amber flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Prioritas Support</span>
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="block w-full py-3 bg-amber text-white font-semibold rounded-xl text-center hover:bg-amber-dark transition-all btn-primary shadow-amber">
                        Pilih Pro
                    </a>
                </div>
                
                <!-- Premium Plan -->
                <div class="bg-white rounded-2xl p-8 shadow-amber-sm">
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-bold text-dark mb-2">Premium</h3>
                        <div class="text-4xl font-bold text-dark mb-1">Rp 299.000</div>
                        <div class="text-dark-lighter text-sm">per bulan</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>5 Masjid</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Unlimited Pengguna</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Laporan Publik</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Budget & Target</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Export Laporan</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>API Access</span>
                        </li>
                        <li class="flex items-center gap-3 text-dark-lighter">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Dedicated Support</span>
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="block w-full py-3 border-2 border-amber text-amber font-semibold rounded-xl text-center hover:bg-amber hover:text-white transition-all btn-outline">
                        Hubungi Kami
                    </a>
                </div>
            </div>
            
            <!-- Note -->
            <div class="text-center mt-8">
                <p class="text-dark-lighter text-sm">✨ Semua paket sudah termasuk fitur Laporan Publik untuk jamaidah</p>
            </div>
        </div>
    </section>

    <!-- ==================== CTA CLOSING SECTION ==================== -->
    <section class="py-16 lg:py-20 bg-amber">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Siap Mengelola Keuangan Masjid Anda?</h2>
            <p class="text-amber-100 text-lg mb-8">Bergabung dengan ribuan masjid yang sudah menggunakan Basmallah</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('register')); ?>" class="px-8 py-4 bg-white text-amber font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300 shadow-lg">
                    Daftar sebagai Pengurus Masjid
                </a>
                <a href="<?php echo e(route('login')); ?>" class="px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all duration-300">
                    Lihat Laporan Masjid Saya
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-dark py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-amber rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Basmallah</span>
                    </div>
                    <p class="text-gray-400 max-w-md">
                        Sistem manajemen keuangan masjid yang transparan, akuntabel, dan terintegrasi untuk kemajuan pengelolaan harta benda mosque.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-gray-400 hover:text-amber transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-amber transition-colors">Fitur</a></li>
                        <li><a href="#harga" class="text-gray-400 hover:text-amber transition-colors">Harga</a></li>
                        <li><a href="#laporan" class="text-gray-400 hover:text-amber transition-colors">Laporan Masjid</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>info@basmallah.id</li>
                        <li>+62 812 3456 7890</li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">© 2026 Basmallah. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 hover:text-amber transition-colors text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-amber transition-colors text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== JAVASCRIPT FOR ANIMATIONS ==================== -->
    <script>
        // Check for reduced motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        // Stats Counter Animation with Intersection Observer
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statItems = entry.target.querySelectorAll('.stat-item');
                    statItems.forEach((item, index) => {
                        const delay = parseInt(item.dataset.delay) || 0;
                        
                        setTimeout(() => {
                            item.classList.add('visible');
                            
                            // Animate counter
                            const counter = item.querySelector('.counter');
                            if (counter && !prefersReducedMotion) {
                                animateCounter(counter);
                            } else if (counter) {
                                // Set final value directly for reduced motion
                                const target = parseFloat(counter.dataset.target);
                                const suffix = counter.dataset.suffix || '+';
                                const decimals = parseInt(counter.dataset.decimals) || 0;
                                counter.textContent = formatNumber(target, decimals) + suffix;
                            }
                        }, delay);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        
        // Observe stats section
        const statsSection = document.getElementById('stats');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
        
        // Counter animation function
        function animateCounter(element) {
            const target = parseFloat(element.dataset.target);
            const suffix = element.dataset.suffix || (target >= 100 ? 'K+' : '+');
            const prefix = element.dataset.prefix || '';
            const decimals = parseInt(element.dataset.decimals) || 0;
            const duration = 1500; // 1.5 seconds
            const startTime = performance.now();
            
            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Ease out function
                const easeOut = 1 - Math.pow(1 - progress, 3);
                
                const currentValue = target * easeOut;
                element.textContent = prefix + formatNumber(currentValue, decimals) + suffix;
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = prefix + formatNumber(target, decimals) + suffix;
                }
            }
            
            requestAnimationFrame(updateCounter);
        }
        
        // Format number with commas
        function formatNumber(num, decimals) {
            if (decimals > 0) {
                return num.toFixed(decimals);
            }
            if (num >= 1000) {
                return (num / 1000).toFixed(0) + 'K';
            }
            return Math.round(num).toLocaleString('id-ID');
        }
        
        // Hero mockup floating animation (subtle)
        const heroMockup = document.getElementById('hero-mockup');
        if (heroMockup && !prefersReducedMotion) {
            heroMockup.style.animation = 'float 3s ease-in-out infinite';
            heroMockup.style.animationDelay = '600ms';
        }
        
        // Bar chart animation trigger
        const barObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bars = entry.target.querySelectorAll('.bar-animate');
                    bars.forEach(bar => {
                        bar.style.animationPlayState = 'running';
                    });
                    barObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        // Observe bars for animation
        const heroSection = document.getElementById('beranda');
        if (heroSection) {
            barObserver.observe(heroSection);
        }
        
        // Testimonial cards animation
        const testimonialObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const cards = entry.target.querySelectorAll('.testimonial-card');
                    cards.forEach((card, index) => {
                        const delay = parseInt(card.dataset.delay) || 0;
                        setTimeout(() => {
                            card.classList.add('visible');
                        }, delay);
                    });
                    testimonialObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        
        // Observe testimonials section
        const testimonialsSection = document.getElementById('testimonials');
        if (testimonialsSection) {
            testimonialObserver.observe(testimonialsSection);
            
            // Auto-sliding testimonial carousel
            const slider = document.getElementById('testimonial-slider');
            const dots = document.querySelectorAll('#testimonial-dots button');
            let currentSlide = 0;
            const totalSlides = 3;
            let slideInterval;
            
            function goToSlide(index) {
                currentSlide = index;
                if (slider) {
                    slider.style.transform = `translateX(-${index * 100}%)`;
                }
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-amber', i === index);
                    dot.classList.toggle('bg-amber/30', i !== index);
                });
            }
            
            function nextSlide() {
                goToSlide((currentSlide + 1) % totalSlides);
            }
            
            // Start auto-slide
            function startSlide() {
                slideInterval = setInterval(nextSlide, 4000);
            }
            
            function stopSlide() {
                clearInterval(slideInterval);
            }
            
            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    stopSlide();
                    startSlide();
                });
            });
            
            // Pause on hover
            const testimonialContainer = testimonialsSection;
            testimonialContainer.addEventListener('mouseenter', stopSlide);
            testimonialContainer.addEventListener('mouseleave', startSlide);
            
            // Start sliding
            startSlide();
        }
    </script>

</body>
</html>
<?php /**PATH C:\laragon\www\basmalah\resources\views/welcome.blade.php ENDPATH**/ ?>