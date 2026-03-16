<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan Masjid - Basmallah</title>
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
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        html { scroll-behavior: smooth; }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212, 160, 23, 0.15);
        }
        
        .pattern-dots {
            background-image: radial-gradient(rgba(212, 160, 23, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="font-sans text-dark antialiased bg-cream min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber rounded-xl flex items-center justify-center shadow-amber-sm">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-dark">Basmallah</span>
                </a>
                
                <!-- Back to Home -->
                <a href="{{ route('welcome') }}" class="text-dark-lighter hover:text-amber font-medium transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 border-2 border-amber text-amber text-sm font-semibold rounded-full mb-4">TRANSPARANSI PUBLIK</span>
                <h1 class="text-3xl lg:text-4xl font-bold text-dark mb-4">Laporan Keuangan Masjid</h1>
                <p class="text-dark-lighter max-w-2xl mx-auto">Pilih masjid untuk melihat laporan keuangan secara transparan</p>
            </div>
            
            <!-- Search Box -->
            <div class="max-w-2xl mx-auto mb-12">
                <form action="{{ route('public.reports.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-dark-lighter" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q"
                            value="{{ request('q', '') }}"
                            placeholder="Cari nama masjid atau kota..." 
                            class="w-full pl-12 pr-4 py-4 bg-white border-2 border-amber/30 rounded-xl text-dark placeholder-dark-lighter focus:outline-none focus:border-amber focus:ring-2 focus:ring-amber/20 transition-all"
                        >
                    </div>
                    <button 
                        type="submit"
                        class="px-8 py-4 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all duration-300 shadow-amber whitespace-nowrap"
                    >
                        Cari
                    </button>
                </form>
            </div>
            
            <!-- Masjids Grid -->
            @if($masjids->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($masjids as $masjid)
                        <a href="{{ route('public.reports.show', $masjid->id) }}" class="bg-white rounded-2xl p-6 shadow-amber-sm hover-lift block">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                                    </svg>
                                </div>
                                <span class="px-2 py-1 bg-amber-100 text-amber text-xs font-semibold rounded-full">Terverifikasi</span>
                            </div>
                            <h3 class="text-lg font-bold text-dark mb-1">{{ $masjid->name }}</h3>
                            <p class="text-dark-lighter text-sm mb-3">{{ $masjid->city }}</p>
                            <div class="text-xs text-dark-lighter">
                                Terakhir diperbarui: {{ $masjid->updated_at->format('d M Y') }}
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $masjids->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-2">Masjid Tidak Ditemukan</h3>
                    <p class="text-dark-lighter mb-6">Coba kata kunci pencarian yang berbeda</p>
                    <a href="{{ route('public.reports.index') }}" class="inline-flex items-center gap-2 text-amber font-semibold hover:text-amber-dark transition-colors">
                        Lihat Semua Masjid
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-500 text-sm">
                © 2026 Basmallah. Sistem Manajemen Keuangan Masjid.
            </p>
        </div>
    </footer>

</body>
</html>
