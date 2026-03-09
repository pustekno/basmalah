<x-guest-layout>
    <!-- Page header -->
    <div class="mb-8 fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-6 bg-yellow-600 rounded-full"></div>
            <span class="text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-widest">Verifikasi Email</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-2">
            Verifikasi Email Anda 📧
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda dengan mengklik tautan yang kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/30 rounded-xl">
            <p class="text-sm font-medium text-green-700 dark:text-green-400">
                Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </p>
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="px-5 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition-all"
            >
                Kirim Ulang Tautan Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md transition-colors"
            >
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
