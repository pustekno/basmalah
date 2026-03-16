<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Basmallah')); ?> – Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #FDFBF4; min-height: 100vh; }
        
        .container { display: flex; min-height: 100vh; }
        
        /* Left Panel - Amber Brand - Brighter & Lighter */
        .left-panel {
            width: 55%;
            background: linear-gradient(180deg, #F5D87D 0%, #E8C94A 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Islamic Geometric Pattern */
        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0L37.5 22.5L60 30L37.5 37.5L30 60L22.5 37.5L0 30L22.5 22.5L30 0Z' fill='%23FFFFFF' fill-opacity='0.08'/%3E%3C/svg%3E");
            opacity: 0.5;
        }
        
        .logo-left {
            position: absolute;
            top: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10;
        }
        .logo-icon-left {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.35);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        .logo-icon-left svg { width: 26px; height: 26px; color: white; }
        .logo-text-left { color: white; font-size: 20px; font-weight: 800; }
        
        /* Floating Cards */
        .floating-cards {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
        }
        
        .floating-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            animation: floatCard 3s ease-in-out infinite;
        }
        
        .floating-card:nth-child(1) { animation-delay: 0s; }
        .floating-card:nth-child(2) { animation-delay: 0.5s; margin-left: 2rem; }
        .floating-card:nth-child(3) { animation-delay: 1s; margin-left: 1rem; }
        
        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            background: #FFF9E6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .card-icon svg { width: 24px; height: 24px; color: #D4A017; }
        .card-text h4 { font-size: 14px; font-weight: 700; color: #1A1A1A; margin-bottom: 2px; }
        .card-text p { font-size: 12px; color: #6B6B6B; }
        
        /* Bottom Branding */
        .bottom-branding {
            position: absolute;
            bottom: 2rem;
            text-align: center;
            z-index: 10;
        }
        .brand-title {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: white;
            margin-bottom: 0.25rem;
        }
        .brand-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 14px;
        }
        
        /* Right Panel - Form */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #FDFBF4;
        }
        .form-container {
            width: 100%;
            max-width: 420px;
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .form-header { margin-bottom: 2rem; }
        .form-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: #D4A017;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }
        .form-title {
            font-family: 'Sora', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: #1A1A1A;
            margin-bottom: 0.5rem;
        }
        .form-subtitle {
            color: #6B6B6B;
            font-size: 14px;
        }
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 0.5rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            width: 20px;
            height: 20px;
            transition: color 0.2s;
        }
        .form-input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 1.5px solid #E0E0E0;
            border-radius: 12px;
            font-size: 14px;
            background: white;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #D4A017;
            box-shadow: 0 0 0 3px rgba(212, 160, 23, 0.1);
            background: white;
        }
        .form-input:focus + .input-icon,
        .form-input:focus ~ .input-icon {
            color: #D4A017;
        }
        .form-input::placeholder { color: #9CA3AF; }
        
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: #E8C94A;
            color: #1A1A1A;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            height: 52px;
        }
        .btn-primary:hover {
            background: #D4B83D;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(212, 160, 23, 0.3);
        }
        .btn-primary:active {
            transform: scale(0.98);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6B6B6B;
            font-size: 14px;
        }
        .form-footer a {
            color: #D4A017;
            font-weight: 600;
            text-decoration: none;
        }
        .form-footer a:hover { text-decoration: underline; }
        
        .error-msg {
            color: #DC2626;
            font-size: 13px;
            margin-top: 0.5rem;
        }
        .success-msg {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #059669;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 1rem;
        }
        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .checkbox-wrapper input {
            width: 18px;
            height: 18px;
            accent-color: #E8C94A;
        }
        .checkbox-wrapper label {
            color: #6B6B6B;
            font-size: 14px;
        }
        .forgot-link {
            color: #D4A017;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        .forgot-link:hover { text-decoration: underline; }
        
        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .password-toggle:hover { color: #D4A017; }
        
        /* Responsive */
        @media (max-width: 900px) {
            .container { flex-direction: column; }
            .left-panel { width: 100%; padding: 2rem 1rem; display: none; }
            .right-panel { width: 100%; }
            .mobile-logo { 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                gap: 0.5rem; 
                margin-bottom: 2rem;
            }
            .mobile-logo .logo-icon-left {
                width: 36px;
                height: 36px;
                background: #E8C94A;
            }
            .mobile-logo .logo-text-left {
                color: #1A1A1A;
                font-size: 18px;
            }
        }
        
        @media (min-width: 901px) {
            .mobile-logo { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- LEFT PANEL - Amber with Floating Cards -->
        <div class="left-panel">
            <div class="logo-left">
                <div class="logo-icon-left">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.18l6.9 3.82L12 11.82 5.1 8 12 4.18zM5 9.64l6 3.33v6.39l-6-3.33V9.64zm8 9.72v-6.39l6-3.33v6.39l-6 3.33z"/>
                    </svg>
                </div>
                <span class="logo-text-left">Basmallah</span>
            </div>
            
            <div class="floating-cards">
                <!-- Card 1 -->
                <div class="floating-card">
                    <div class="card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="card-text">
                        <h4>Akses Aman & Terenkripsi</h4>
                        <p>Data keuangan mosque Anda aman bersama kami</p>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="floating-card">
                    <div class="card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="card-text">
                        <h4>Laporan Real-time</h4>
                        <p>Pantau keuangan mosque kapan saja</p>
                    </div>
                </div>
                
                <!-- Card 3 -->
                <div class="floating-card">
                    <div class="card-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.18l6.9 3.82L12 11.82 5.1 8 12 4.18zM5 9.64l6 3.33v6.39l-6-3.33V9.64zm8 9.72v-6.39l6-3.33v6.39l-6 3.33z"/>
                        </svg>
                    </div>
                    <div class="card-text">
                        <h4>500+ Masjid Terpercaya</h4>
                        <p>Bergabung dengan komunitas pengelolaan keuangan mosque</p>
                    </div>
                </div>
            </div>
            
            <div class="bottom-branding">
                <div class="brand-title">Basmallah</div>
                <div class="brand-subtitle">Sistem Manajemen Keuangan Masjid</div>
            </div>
        </div>
        
        <!-- Right Panel - Login/Register Form -->
        <div class="right-panel">
            <div class="form-container" x-data="{
                showRegister: <?php echo e($showRegister ?? false ? 'true' : 'false'); ?>

            }">
                <!-- Mobile Logo -->
                <div class="mobile-logo">
                    <div class="logo-icon-left">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="text-white">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.18l6.9 3.82L12 11.82 5.1 8 12 4.18zM5 9.64l6 3.33v6.39l-6-3.33V9.64zm8 9.72v-6.39l6-3.33v6.39l-6 3.33z"/>
                        </svg>
                    </div>
                    <span class="logo-text-left">Basmallah</span>
                </div>
                
                <!-- LOGIN FORM -->
                <div x-show="!showRegister" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="form-header">
                        <div class="form-badge">Masuk Akun</div>
                        <h1 class="form-title">Selamat Datang Kembali 👋</h1>
                        <p class="form-subtitle">Masuk ke akun Anda untuk mengelola sistem informasi mosque.</p>
                    </div>
                    
                    <!-- Session Status -->
                    <?php if(session('status')): ?>
                        <div class="success-msg">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo e(route('auth.login')); ?>" x-data="{ showPass: false }">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="login-email" class="form-label">Alamat Email</label>
                            <div class="input-wrapper">
                                <input type="email" id="login-email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" placeholder="nama@email.com" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="login-password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <input :type="showPass ? 'text' : 'password'" id="login-password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <button type="button" @click="showPass = !showPass" class="password-toggle">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Remember Me & Forgot -->
                        <div class="form-options">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="forgot-link">Lupa password?</a>
                        </div>
                        
                        <!-- Submit -->
                        <button type="submit" class="btn-primary">Masuk Sekarang</button>
                        
                        <!-- Register Link -->
                        <div class="form-footer">
                            Belum punya akun? <a href="#" @click.prevent="showRegister = true">Daftar sekarang</a>
                        </div>
                    </form>
                </div>
                
                <!-- REGISTER FORM -->
                <div x-show="showRegister" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="form-header">
                        <div class="form-badge">Daftar Akun</div>
                        <h1 class="form-title">Buat Akun Baru 👋</h1>
                        <p class="form-subtitle">Daftar untuk mengelola sistem informasi mosque.</p>
                    </div>
                    
                    <?php if(session('status')): ?>
                        <div class="success-msg">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo e(route('auth.register')); ?>" x-data="{ showPass: false, showPassConfirm: false }">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="register-name" class="form-label">Nama Lengkap</label>
                            <div class="input-wrapper">
                                <input type="text" id="register-name" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="register-email" class="form-label">Alamat Email</label>
                            <div class="input-wrapper">
                                <input type="email" id="register-email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="username" placeholder="nama@email.com" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="register-password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <input :type="showPass ? 'text' : 'password'" id="register-password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <button type="button" @click="showPass = !showPass" class="password-toggle">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="register-password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-wrapper">
                                <input :type="showPassConfirm ? 'text' : 'password'" id="register-password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan password lagi" class="form-input">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <button type="button" @click="showPassConfirm = !showPassConfirm" class="password-toggle">
                                    <svg x-show="!showPassConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-msg"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Submit -->
                        <button type="submit" class="btn-primary">Daftar Sekarang</button>
                        
                        <!-- Login Link -->
                        <div class="form-footer">
                            Sudah punya akun? <a href="#" @click.prevent="showRegister = false">Masuk sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/auth/auth-page.blade.php ENDPATH**/ ?>