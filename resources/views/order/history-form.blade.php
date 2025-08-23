<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Histori Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': {
                            50: '#f0f9ff',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen py-8">
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand-800 to-brand-900 px-6 py-8">
            <div class="text-center text-white">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm inline-block mb-4">
                    <span class="text-4xl">📱</span>
                </div>
                <h1 class="text-3xl font-bold mb-2">Cek Histori Pesanan</h1>
                <p class="text-brand-100 text-lg">Masukkan nomor HP untuk melihat riwayat pesanan Anda</p>
            </div>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form method="POST" action="{{ route('order.searchHistory') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-4 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors text-lg">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white py-4 px-6 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Histori Pesanan
                </button>
            </form>

            <!-- Info Section -->
            <div class="mt-8 bg-slate-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-3">ℹ️ Informasi</h3>
                <ul class="text-slate-600 space-y-2">
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        Masukkan nomor HP yang sama dengan yang digunakan saat melakukan pemesanan
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        Anda dapat melihat semua pesanan yang pernah dibuat dengan nomor HP tersebut
                    </li>
                    <li class="flex items-start">
                        <span class="text-brand-600 mr-2">•</span>
                        Status pesanan dan detail pembayaran akan ditampilkan
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
