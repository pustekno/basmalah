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
    <link rel="stylesheet" href="/build/assets/app-DjlVECeQ.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f9fafb; min-height: 100vh; }
        .container { display: flex; min-height: 100vh; }
        
        /* Left Panel - Dark */
        .left-panel {
            width: 45%;
            background: #07006b;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: 400px;
            background: rgba(184, 134, 11, 0.2);
            border-radius: 50%;
            filter: blur(100px);
        }
        .macbook {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 10;
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .macbook-screen {
            background: #333;
            border-radius: 12px 12px 0 0;
            padding: 4px;
        }
        .macbook-screen-inner {
            background: linear-gradient(180deg, #1a1a1a 0%, #2a2a2a 100%);
            border-radius: 8px;
            overflow: hidden;
        }
        .macbook-notch {
            height: 20px;
            background: #1a1a1a;
            position: relative;
        }
        .macbook-notch::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 16px;
            background: #1a1a1a;
            border-radius: 0 0 8px 8px;
        }
        .macbook-content {
            padding: 1.5rem;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .logo-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: #B8860B;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-icon svg { width: 24px; height: 24px; color: white; }
        .logo-text { color: white; font-size: 14px; font-weight: bold; }
        .logo-sub { color: #888; font-size: 11px; }
        .badge {
            background: rgba(184, 134, 11, 0.2);
            color: #DAA520;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
        .stat-card {
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 0.75rem;
        }
        .stat-label { color: #888; font-size: 10px; }
        .stat-value { color: white; font-size: 18px; font-weight: bold; }
        .chart-box {
            margin-top: 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 1rem;
        }
        .chart-title { color: #888; font-size: 11px; margin-bottom: 0.5rem; }
        .chart-bars { display: flex; align-items: flex-end; gap: 4px; height: 40px; }
        .chart-bar { flex: 1; background: rgba(184, 134, 11, 0.3); border-radius: 2px; }
        .chart-bar:nth-child(1) { height: 30%; }
        .chart-bar:nth-child(2) { height: 50%; background: rgba(184, 134, 11, 0.5); }
        .chart-bar:nth-child(3) { height: 80%; background: #B8860B; }
        .macbook-base {
            background: linear-gradient(180deg, #ccc 0%, #999 100%);
            height: 10px;
            border-radius: 0 0 4px 4px;
            position: relative;
        }
        .macbook-base::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #888;
            border-radius: 2px;
        }
        .left-title {
            margin-top: 2rem;
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
        }
        .left-subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 0.5rem;
        }
        
        /* Right Panel - Form */
        .right-panel {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: white;
        }
        .form-container {
            width: 100%;
            max-width: 420px;
        }
        .form-header { margin-bottom: 2rem; }
        .form-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: bold;
            color: #B8860B;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        .form-title {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }
        .form-subtitle {
            color: #666;
            font-size: 14px;
        }
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 18px;
            height: 18px;
        }
        .form-input {
            width: 100%;
            padding: 14px 14px 14px 44px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            background: #f9fafb;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #B8860B;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
            background: white;
        }
        .form-input::placeholder { color: #9ca3af; }
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: #B8860B;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #8B6508;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px rgba(184, 134, 11, 0.4);
        }
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 14px;
        }
        .form-footer a {
            color: #B8860B;
            font-weight: 600;
            text-decoration: none;
        }
        .form-footer a:hover { text-decoration: underline; }
        .error-msg {
            color: #ef4444;
            font-size: 13px;
            margin-top: 0.5rem;
        }
        .success-msg {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 900px) {
            .container { flex-direction: column; }
            .left-panel { width: 100%; padding: 2rem 1rem; }
            .right-panel { width: 100%; }
            .macbook { max-width: 300px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- LEFT PANEL - Macbook -->
        <div class="left-panel">
            <div class="macbook">
                <div class="macbook-screen">
                    <div class="macbook-screen-inner">
                        <div class="macbook-notch"></div>
                        <div class="macbook-content">
                            <div class="dashboard-header">
                                <div class="logo-box">
                                    <div class="logo-icon">
                                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/><circle cx="12" cy="6" r="1.5"/></svg>
                                    </div>
                                    <div>
                                        <div class="logo-text">Basmallah</div>
                                        <div class="logo-sub">Login Dashboard</div>
                                    </div>
                                </div>
                                <span class="badge">Pro</span>
                            </div>
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-label">Total Pemasukan</div>
                                    <div class="stat-value">Rp 25.5M</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Total Pengeluaran</div>
                                    <div class="stat-value">Rp 18.2M</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Transaksi</div>
                                    <div class="stat-value">1,234</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-label">Masjid Aktif</div>
                                    <div class="stat-value">12</div>
                                </div>
                            </div>
                            <div class="chart-box">
                                <div class="chart-title">Grafik Keuangan Bulan Ini</div>
                                <div class="chart-bars">
                                    <div class="chart-bar"></div>
                                    <div class="chart-bar"></div>
                                    <div class="chart-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="macbook-base"></div>
            </div>
            <h2 class="left-title">Masjid Basmallah</h2>
            <p class="left-subtitle">Sistem Manajemen Keuangan Masjid</p>
        </div>
        
        <!-- Right Panel - Login/Register Form -->
        <div class="right-panel">
            <div class="form-container" x-data="{
                showRegister: <?php echo e($showRegister ?? false ? 'true' : 'false'); ?>

            }">
                
                <!-- LOGIN FORM -->
                <div x-show="!showRegister" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="form-header">
                        <div class="form-badge">Masuk Akun</div>
                        <h1 class="form-title">Selamat Datang Kembali 👋</h1>
                        <p class="form-subtitle">Masuk ke akun Anda untuk mengelola sistem informasi masjid.</p>
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
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <input type="email" id="login-email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" placeholder="nama@email.com" class="form-input">
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
                            <div class="input-wrapper" style="position: relative;">
                                <svg class="input-icon" style="left: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <input :type="showPass ? 'text' : 'password'" id="login-password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" class="form-input" style="padding-right: 45px;">
                                <button type="button" @click="showPass = !showPass" x-cloak style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                                    <svg x-show="!showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        
                        <!-- Remember Me -->
                        <div class="form-group" style="display: flex; align-items: center;">
                            <input type="checkbox" id="remember" name="remember" style="width: 18px; height: 18px; accent-color: #B8860B; margin-right: 8px;">
                            <label for="remember" style="margin: 0; color: #6b7280; font-size: 14px;">Ingat saya</label>
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
                        <p class="form-subtitle">Daftar untuk mengelola sistem informasi masjid.</p>
                    </div>
                    
                    <!-- Session Status -->
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
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <input type="text" id="register-name" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" class="form-input">
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
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <input type="email" id="register-email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="username" placeholder="nama@email.com" class="form-input">
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
                            <div class="input-wrapper" style="position: relative;">
                                <svg class="input-icon" style="left: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <input :type="showPass ? 'text' : 'password'" id="register-password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="form-input" style="padding-right: 45px;">
                                <button type="button" @click="showPass = !showPass" x-cloak style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                                    <svg x-show="!showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <div class="input-wrapper" style="position: relative;">
                                <svg class="input-icon" style="left: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <input :type="showPassConfirm ? 'text' : 'password'" id="register-password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan password lagi" class="form-input" style="padding-right: 45px;">
                                <button type="button" @click="showPassConfirm = !showPassConfirm" x-cloak style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                                    <svg x-show="!showPassConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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