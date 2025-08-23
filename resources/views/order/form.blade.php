<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order - Meja {{ $nomorMeja }}</title>
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
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-slate-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-brand-100 p-3 rounded-xl">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-12 w-12 rounded-lg">
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Kedai CKCK</h1>
                    <p class="text-slate-600">Premium Coffee & Kitchen</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-brand-600 text-white px-6 py-3 rounded-xl">
                    <p class="text-sm font-medium">Meja</p>
                    <p class="text-2xl font-bold">{{ $nomorMeja }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
            <p class="text-slate-600">Order ID: <span class="font-semibold text-brand-700">#{{ $order->id }}</span></p>
            
            <!-- Button Cek Histori -->
            <a href="{{ route('order.historyForm') }}" 
               class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                {{-- 📱 --}}
                 Cek Histori Pesanan
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="space-y-8">
        @csrf
        
        <!-- Customer Info Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Customer</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $order->phone) }}" required
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $order->keterangan) }}"
                           placeholder="Contoh: tanpa pedas, extra saus"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>
            </div>
        </div>

        <!-- Menu Selection Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Pilih Menu</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($menus as $menu)
                    <div class="group bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-brand-300 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="aspect-square mb-4 overflow-hidden rounded-xl bg-white shadow-sm">
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="text-center space-y-3">
                            <h3 class="font-bold text-slate-900 text-lg">{{ $menu->nama }}</h3>
                            <p class="text-brand-600 font-bold text-xl">Rp {{ number_format($menu->harga) }}</p>
                            
                            <div class="flex items-center justify-center space-x-2">
                                <label class="text-sm font-medium text-slate-600">Qty:</label>
                                <input type="number" name="quantity[{{ $menu->id }}]" value="1" min="1"
                                       class="w-20 px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            </div>
                            
                            <button type="submit" name="selected_menu" value="{{ $menu->id }}"
                                    class="w-full bg-brand-600 hover:bg-brand-700 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <!-- Cart Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900">🛒 Keranjang Belanja</h2>
            @if ($order->orderItems->count() > 0)
                <span class="bg-brand-100 text-brand-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $order->orderItems->count() }} item
                </span>
            @endif
        </div>

        @if ($order->orderItems->count() > 0)
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full bg-white">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Foto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Menu</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Harga</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Jumlah</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Subtotal</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}"
                                         class="h-16 w-16 object-cover rounded-xl shadow-sm">
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $item->menu->nama }}</p>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-slate-700">Rp {{ number_format($item->menu->harga) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-brand-100 text-brand-800 px-3 py-1 rounded-full font-semibold">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('order.removeItem', $item->id) }}"
                                          onsubmit="return confirm('Hapus item ini?')" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Total and Submit -->
            <div class="mt-6 space-y-4">
                <div class="bg-gradient-to-r from-brand-50 to-blue-50 rounded-xl p-6 border border-brand-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-slate-700">Total Harga:</span>
                        <span class="text-3xl font-bold text-brand-900">Rp {{ number_format($order->total_harga) }}</span>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('order.submit', $order->id) }}">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 px-6 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Order
                    </button>
                </form>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-600 mb-2">Keranjang masih kosong</h3>
                <p class="text-slate-500">Pilih menu di atas untuk menambahkan item ke keranjang</p>
            </div>
        @endif
    </div>
</div>

</body>
</html>
