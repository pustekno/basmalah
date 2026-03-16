<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan {{ $masjid->name }} - Basmallah</title>
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
        
        .pattern-dots {
            background-image: radial-gradient(rgba(212, 160, 23, 0.08) 1px, transparent 1px);
            background-size: 16px 16px;
        }
        
        /* Custom scrollbar for table */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F5F0E1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #D4A017;
            border-radius: 3px;
        }
    </style>
</head>
<body class="font-sans text-dark antialiased bg-cream min-h-screen">
    
    <!-- Header - Simple, Clean -->
    <header class="bg-white shadow-sm border-b border-amber-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo + Masjid Name -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-amber rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-dark hidden sm:block">Basmallah</span>
                    </a>
                    
                    <!-- Divider -->
                    <div class="hidden sm:block w-px h-6 bg-amber/30"></div>
                    
                    <!-- Masjid Name -->
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold text-dark">{{ $masjid->name }}</h1>
                        <p class="text-xs text-dark-lighter">{{ $masjid->city ?? 'Indonesia' }}</p>
                    </div>
                </div>
                
                <!-- Right Side: Badge + Share -->
                <div class="flex items-center gap-3">
                    <!-- Laporan Publik Badge -->
                    <span class="px-3 py-1.5 bg-amber-100 text-amber text-xs font-semibold rounded-full">
                        Laporan Publik
                    </span>
                    
                    <!-- Share Button -->
                    <button onclick="shareReport()" class="p-2 border-2 border-amber text-amber rounded-lg hover:bg-amber hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content - Full Width, Clean -->
    <main class="py-8 lg:py-12 pattern-dots">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Period Selector -->
            <div class="bg-white rounded-2xl p-4 shadow-amber-sm mb-8">
                <form action="{{ route('public.reports.show', $masjid->id) }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
                    <span class="text-dark-lighter font-medium">Periode:</span>
                    <div class="flex gap-3">
                        <select name="month" class="px-4 py-2 border-2 border-amber/30 rounded-xl text-dark focus:outline-none focus:border-amber bg-white">
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <select name="year" class="px-4 py-2 border-2 border-amber/30 rounded-xl text-dark focus:outline-none focus:border-amber bg-white">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-amber text-white font-semibold rounded-xl hover:bg-amber-dark transition-all">
                        Tampilkan
                    </button>
                </form>
            </div>
            
            <!-- Summary Cards (Read Only) -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- Total Income -->
                <div class="bg-white rounded-2xl p-6 shadow-amber-sm border-l-4 border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-dark-lighter font-medium">Total Pemasukan</span>
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl lg:text-3xl font-bold text-green-600">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </div>
                </div>
                
                <!-- Total Expense -->
                <div class="bg-white rounded-2xl p-6 shadow-amber-sm border-l-4 border-red-500">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-dark-lighter font-medium">Total Pengeluaran</span>
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl lg:text-3xl font-bold text-red-600">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </div>
                </div>
                
                <!-- Balance -->
                <div class="bg-white rounded-2xl p-6 shadow-amber-sm border-l-4 border-amber">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-dark-lighter font-medium">Saldo Akhir</span>
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl lg:text-3xl font-bold text-amber">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            
            <!-- Chart Section -->
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-amber-sm mb-8">
                <h2 class="text-xl font-bold text-dark mb-6">Grafik Pemasukan vs Pengeluaran</h2>
                
                <!-- Bar Chart -->
                <div class="h-64 flex items-end justify-between gap-2 lg:gap-4">
                    @foreach($monthlyData as $data)
                        <div class="flex-1 flex flex-col items-center gap-2">
                            <!-- Bars Container -->
                            <div class="w-full flex items-end justify-center gap-1 h-48">
                                <!-- Income Bar -->
                                <div class="w-6 lg:w-8 bg-green-500 rounded-t-lg relative group" style="height: {{ $data['income'] > 0 ? min(($data['income'] / max(array_column($monthlyData, 'income'), 0) * 100), 100) : 0 }}%">
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-dark text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        +Rp {{ number_format($data['income'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <!-- Expense Bar -->
                                <div class="w-6 lg:w-8 bg-red-500 rounded-t-lg relative group" style="height: {{ $data['expense'] > 0 ? min(($data['expense'] / max(array_column($monthlyData, 'expense'), 0) * 100), 100) : 0 }}%">
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-dark text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        -Rp {{ number_format($data['expense'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <!-- Month Label -->
                            <span class="text-xs text-dark-lighter">{{ $data['month'] }}</span>
                        </div>
                    @endforeach
                </div>
                
                <!-- Legend -->
                <div class="flex justify-center gap-6 mt-6">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-dark-lighter">Pemasukan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-dark-lighter">Pengeluaran</span>
                    </div>
                </div>
            </div>
            
            <!-- Transaction Table -->
            <div class="bg-white rounded-2xl shadow-amber-sm overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-amber/10">
                    <h2 class="text-xl font-bold text-dark">Riwayat Transaksi</h2>
                    <p class="text-dark-lighter text-sm mt-1">{{ $months[$month] }} {{ $year }}</p>
                </div>
                
                @if($transactions->count() > 0)
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full">
                            <thead class="bg-cream-dark">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-dark uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-dark uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-dark uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-dark uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber/10">
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-cream-light transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-lighter">
                                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-dark">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->category)
                                                <span class="px-3 py-1 bg-amber-50 text-amber text-xs font-medium rounded-full">
                                                    {{ $transaction->category->name }}
                                                </span>
                                            @else
                                                <span class="text-dark-lighter text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span class="text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($transactions->count() > 10)
                        <div class="p-4 border-t border-amber/10 text-center">
                            <p class="text-dark-lighter text-sm">Menampilkan {{ $transactions->count() }} transaksi</p>
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-dark-lighter">Tidak ada transaksi pada periode ini</p>
                    </div>
                @endif
            </div>
            
            <!-- Watermark -->
            <div class="mt-8 text-center relative">
                <div class="absolute right-0 bottom-0 opacity-10">
                    <svg class="w-24 h-24 text-amber" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">
                Data dipublikasikan oleh pengurus masjid. Dikelola menggunakan Basmallah.
            </p>
            <p class="text-gray-500 text-xs mt-2">
                © 2026 Basmallah - Sistem Manajemen Keuangan Masjid
            </p>
        </div>
    </footer>

    <script>
        function shareReport() {
            if (navigator.share) {
                navigator.share({
                    title: 'Laporan Keuangan {{ $masjid->name }}',
                    text: 'Lihat laporan keuangan {{ $masjid->name }} secara transparan',
                    url: window.location.href,
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link laporan berhasil disalin!');
                });
            }
        }
    </script>

</body>
</html>
