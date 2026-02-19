<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masjid Basmallah - Sistem Manajemen Keuangan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #115e59 100%); }
        .gradient-text { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-8px); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed w-full z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                            <circle cx="12" cy="6" r="1.5"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold gradient-text">Masjid Basmallah</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-teal-600 font-semibold transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-teal-600 font-semibold transition">Masuk</a>
                        <a href="{{ route('register') }}" class="gradient-bg text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-105">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center text-white">
                <div class="mb-8 inline-block">
                    <div class="w-32 h-32 glass rounded-3xl flex items-center justify-center mx-auto shadow-2xl animate-float">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                            <circle cx="12" cy="6" r="1.5"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-6xl md:text-7xl font-extrabold mb-6 leading-tight">Masjid Basmallah</h1>
                <p class="text-2xl md:text-3xl text-teal-50 mb-6 font-semibold">Sistem Manajemen Keuangan Masjid</p>
                <p class="text-xl text-teal-100 max-w-3xl mx-auto mb-12 leading-relaxed">Kelola keuangan masjid dengan mudah, transparan, dan akuntabel menggunakan teknologi modern</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-teal-600 px-10 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition transform hover:scale-105 hover:-translate-y-1">Mulai Sekarang →</a>
                    <a href="#features" class="glass text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-white/20 transition">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-teal-600 font-bold text-sm uppercase tracking-wider">Fitur Unggulan</span>
                <h2 class="text-5xl font-extrabold text-gray-900 mb-6 mt-4">Solusi Lengkap untuk Masjid</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Sistem terintegrasi untuk manajemen keuangan masjid yang modern</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group hover-lift bg-gradient-to-br from-teal-50 to-white p-10 rounded-3xl shadow-lg hover:shadow-2xl border border-teal-100">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Manajemen Transaksi</h3>
                    <p class="text-gray-600 leading-relaxed">Catat pemasukan dan pengeluaran dengan mudah, terstruktur, dan real-time</p>
                </div>
                <div class="group hover-lift bg-gradient-to-br from-teal-50 to-white p-10 rounded-3xl shadow-lg hover:shadow-2xl border border-teal-100">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Laporan Keuangan</h3>
                    <p class="text-gray-600 leading-relaxed">Laporan lengkap dan transparan untuk akuntabilitas masjid yang terpercaya</p>
                </div>
                <div class="group hover-lift bg-gradient-to-br from-teal-50 to-white p-10 rounded-3xl shadow-lg hover:shadow-2xl border border-teal-100">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem keamanan berlapis dengan role-based access control modern</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-24 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-20 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="glass p-8 rounded-3xl">
                    <div class="text-6xl font-extrabold text-white mb-3">100%</div>
                    <div class="text-teal-100 text-lg font-semibold">Transparan</div>
                </div>
                <div class="glass p-8 rounded-3xl">
                    <div class="text-6xl font-extrabold text-white mb-3">24/7</div>
                    <div class="text-teal-100 text-lg font-semibold">Akses Online</div>
                </div>
                <div class="glass p-8 rounded-3xl">
                    <div class="text-6xl font-extrabold text-white mb-3">Aman</div>
                    <div class="text-teal-100 text-lg font-semibold">Data Terenkripsi</div>
                </div>
                <div class="glass p-8 rounded-3xl">
                    <div class="text-6xl font-extrabold text-white mb-3">Mudah</div>
                    <div class="text-teal-100 text-lg font-semibold">User Friendly</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-extrabold text-gray-900 mb-6">Siap Memulai?</h2>
            <p class="text-2xl text-gray-600 mb-10">Bergabunglah dengan sistem manajemen keuangan masjid yang modern</p>
            <a href="{{ route('register') }}" class="inline-block gradient-bg text-white px-12 py-5 rounded-2xl font-bold text-xl shadow-2xl hover:shadow-3xl transition transform hover:scale-105">Daftar Gratis Sekarang →</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center">
                            <svg class="h-7 w-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L6 8v14h12V8l-6-6zm0 2.83L16 9v11h-3v-6h-2v6H8V9l4-4.17z"/>
                                <circle cx="12" cy="6" r="1.5"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Masjid Basmallah</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Sistem manajemen keuangan masjid yang modern, transparan, dan terpercaya</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Menu</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#features" class="hover:text-teal-400 transition">Fitur</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-teal-400 transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-teal-400 transition">Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Kontak</h4>
                    <p class="text-gray-400 mb-2">Email: info@masjidbasmallah.com</p>
                    <p class="text-gray-400">Telp: (021) 1234-5678</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Masjid Basmallah. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

