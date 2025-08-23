<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Order #{{ $order->id }}</title>
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
        <!-- Header with gradient -->
        <div class="bg-gradient-to-r from-brand-800 to-brand-900 px-6 py-8">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-12 w-12 rounded-lg">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Kedai CKCK</h1>
                        <p class="text-brand-100 text-sm">Premium Coffee & Kitchen</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-brand-200 text-sm font-medium">INVOICE</span>
                    <p class="text-white font-bold text-lg">#{{ $order->id }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Order Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <h3 class="text-sm font-semibold text-slate-600 uppercase tracking-wide mb-3">Detail Pesanan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Nomor Meja</span>
                                <span class="font-semibold text-slate-900 bg-white px-3 py-1 rounded-lg text-lg">{{ $order->nomor_meja }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Nama Konsumen</span>
                                <span class="font-semibold text-slate-900">{{ $order->customer_name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">No. HP</span>
                                <span class="font-semibold text-slate-900">{{ $order->phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <h3 class="text-sm font-semibold text-slate-600 uppercase tracking-wide mb-3">Status & Info</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Status Pembayaran</span>
                                <span class="font-semibold uppercase px-3 py-1 rounded-full text-sm
                                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            @if($order->status === 'paid')
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Status Makanan</span>
                                    <span class="font-semibold uppercase px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                        {{ $order->status_makanan }}
                                    </span>
                                </div>
                            @endif
                            @if($order->keterangan)
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Catatan</span>
                                    <span class="font-medium text-slate-900 text-sm italic">{{ $order->keterangan }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-slate-50 rounded-xl overflow-hidden">
                <div class="px-6 py-4 bg-slate-100 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Detail Pesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">Menu</th>
                                <th class="py-4 px-6 text-center text-sm font-semibold text-slate-700">Qty</th>
                                <th class="py-4 px-6 text-right text-sm font-semibold text-slate-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @if($order->orderItems && $order->orderItems->count())
                                @foreach($order->orderItems as $item)
                                    <tr class="hover:bg-slate-25">
                                        <td class="py-4 px-6">
                                            <div class="font-medium text-slate-900">{{ $item->menu->nama }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="bg-brand-100 text-brand-800 px-3 py-1 rounded-full font-semibold">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-right font-semibold text-slate-900">
                                            Rp{{ number_format($item->subtotal,0,',','.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-slate-500">
                                        <div class="flex flex-col items-center space-y-2">
                                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <span>Belum ada item</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Section -->
            <div class="bg-gradient-to-r from-brand-50 to-blue-50 rounded-xl p-6 border border-brand-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-slate-700">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-brand-900">Rp{{ number_format($order->total_harga,0,',','.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                @if($order->status === 'paid')
                    <a href="{{ route('order.downloadInvoice', $order->id) }}"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white text-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Invoice (PDF)
                    </a>
                @endif
                @if($order->status !== 'paid')
                    <a href="{{ route('order.payment', $order->id) }}"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Lanjut ke Pembayaran
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
