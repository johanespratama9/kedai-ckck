<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Histori Pesanan - {{ $phone }}</title>
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
<div class="max-w-6xl mx-auto px-4">
    <!-- Header -->
    <div class="bg-gradient-to-r from-brand-800 to-brand-900 rounded-3xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">📱 Histori Pesanan</h1>
                <p class="text-brand-100 text-lg">Nomor HP: {{ $phone }}</p>
            </div>
            <div class="text-right">
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                    <p class="text-brand-100 text-sm">Total Pesanan</p>
                    <p class="text-3xl font-bold">{{ $orders->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <span class="text-2xl">✅</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pesanan Selesai</p>
                        <p class="text-2xl font-bold text-green-600">{{ $orders->where('status', 'paid')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Belanja</p>
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($orders->sum('total_harga')) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                        <span class="text-2xl">📅</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pesanan Pertama</p>
                        <p class="text-lg font-bold text-purple-600">{{ $orders->last()->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order List -->
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200 hover:shadow-xl transition-shadow">
                    <!-- Order Header -->
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div class="flex items-center space-x-4">
                                <div class="bg-brand-600 text-white rounded-xl p-3 font-bold">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Order #{{ $order->id }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-slate-600">
                                        <span>🪑 Meja {{ $order->nomor_meja }}</span>
                                        <span>📅 {{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 text-right">
                                <p class="text-sm text-slate-600">Total</p>
                                <p class="text-2xl font-bold text-brand-900">Rp {{ number_format($order->total_harga) }}</p>
                                <div class="flex flex-wrap gap-2 justify-end mt-2">
                                    @if($order->status === 'paid')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">✅ Lunas</span>
                                    @elseif($order->status === 'submitted')
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">📋 Submitted</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">⏳ Pending</span>
                                    @endif
                                    
                                    @if($order->status_makanan === 'pesanan selesai')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">🍽️ Selesai</span>
                                    @elseif($order->status_makanan === 'preparing')
                                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">👨‍🍳 Preparing</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">📝 Diterima</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="p-6">
                        @if($order->orderItems->count() > 0)
                            <h4 class="text-lg font-semibold text-slate-900 mb-4">📦 Item Pesanan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center space-x-3 bg-slate-50 rounded-xl p-4">
                                        <div class="bg-brand-100 text-brand-800 rounded-lg p-2 font-bold">
                                            {{ $item->quantity }}x
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900">{{ $item->menu->nama }}</p>
                                            <p class="text-sm text-slate-600">Rp {{ number_format($item->menu->harga) }} per item</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-slate-900">Rp {{ number_format($item->subtotal) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <span class="text-4xl mb-2 block">🍽️</span>
                                <p>Belum ada item dalam pesanan ini</p>
                            </div>
                        @endif

                        <!-- Order Actions -->
                        <div class="mt-6 pt-4 border-t border-slate-200 flex flex-wrap gap-3">
                            <a href="{{ route('order.invoice', $order->id) }}" 
                               class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl font-semibold transition-colors inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Lihat Invoice
                            </a>
                            @if($order->status !== 'paid')
                                <a href="{{ route('order.payment', $order->id) }}"
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-semibold transition-colors inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- No Orders Found -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <span class="text-6xl mb-6 block">😔</span>
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Tidak Ada Pesanan Ditemukan</h2>
            <p class="text-slate-600 text-lg mb-6">Nomor HP <strong>{{ $phone }}</strong> belum memiliki riwayat pesanan.</p>
            <div class="space-y-2 text-sm text-slate-500">
                <p>Pastikan nomor HP yang Anda masukkan benar</p>
                <p>atau mulai buat pesanan pertama Anda!</p>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('order.historyForm') }}" 
           class="inline-flex items-center bg-slate-600 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>
</body>
</html>
