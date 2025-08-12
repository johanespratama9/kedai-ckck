<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dasbor - Semua Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-selesai {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
        }
        .status-proses {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: white;
        }
        .status-pending {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
            color: white;
        }
        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .table-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }
        .order-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }
        .price-highlight {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }
        .no-data {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="header-gradient rounded-3xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">🍽️ Dasbor Pesanan</h1>
                    <p class="text-blue-100 text-lg">Kelola semua pesanan dari satu tempat</p>
                </div>
                <div class="text-right">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                        <p class="text-blue-100 text-sm">Total Pesanan Hari Ini</p>
                        <p class="text-3xl font-bold">{{ $orders->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($orders->count())
            <!-- Statistik Singkat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-xl mr-4">
                            <span class="text-2xl">📋</span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Pesanan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-xl mr-4">
                            <span class="text-2xl">💰</span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Pendapatan</p>
                            <p class="text-2xl font-bold price-highlight">Rp {{ number_format($orders->sum('total_harga')) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-xl mr-4">
                            <span class="text-2xl">✅</span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Pesanan Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status_makanan', 'pesanan selesai')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pesanan -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl p-4 font-bold text-lg">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Pesanan #{{ $order->id }}</h3>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <div class="flex items-center text-gray-600">
                                            <span class="text-lg mr-2">🪑</span>
                                            <span class="font-medium">Meja {{ $order->nomor_meja }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <span class="text-lg mr-2">📅</span>
                                            <span class="text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 lg:mt-0 text-right">
                                <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold price-highlight">Rp {{ number_format($order->total_harga) }}</p>
                                <div class="mt-3 flex flex-wrap gap-2 justify-end">
                                    @if($order->status_makanan == 'pesanan selesai')
                                        <span class="status-badge status-selesai">✅ Selesai</span>
                                    @elseif($order->status_makanan == 'sedang dimasak')
                                        <span class="status-badge status-proses">🍳 Dimasak</span>
                                    @else
                                        <span class="status-badge status-pending">⏳ Menunggu</span>
                                    @endif
                                    
                                    @if($order->status_pembayaran == 'lunas')
                                        <span class="status-badge status-selesai">💳 Lunas</span>
                                    @else
                                        <span class="status-badge status-pending">💸 Belum Bayar</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($order->orderItems->count())
                            <div class="table-modern overflow-hidden">
                                <table class="min-w-full">
                                    <thead class="table-header">
                                        <tr>
                                            <th class="px-6 py-4 text-left font-semibold">Menu</th>
                                            <th class="px-6 py-4 text-right font-semibold">Harga Satuan</th>
                                            <th class="px-6 py-4 text-center font-semibold">Jumlah</th>
                                            <th class="px-6 py-4 text-right font-semibold">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($order->orderItems as $item)
                                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        <span class="text-lg mr-3">🍽️</span>
                                                        <span class="font-medium text-gray-900">{{ $item->menu->nama }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-right font-semibold text-gray-700">
                                                    Rp {{ number_format($item->menu->harga) }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold">
                                                        {{ $item->quantity }}x
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right font-bold text-green-600">
                                                    Rp {{ number_format($item->subtotal) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-xl p-6 text-center">
                                <span class="text-4xl mb-4 block">😕</span>
                                <p class="text-gray-500 font-medium">Belum ada item dalam pesanan ini</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-data">
                <span class="text-6xl mb-6 block">📝</span>
                <h2 class="text-2xl font-bold mb-3">Belum Ada Pesanan</h2>
                <p class="text-lg">Pesanan akan muncul di sini setelah pelanggan melakukan pemesanan.</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="mt-12 text-center">
            <div class="bg-white rounded-2xl p-6 inline-block">
                <p class="text-gray-600">
                    <span class="font-semibold">Kedai CKCK</span> - Sistem Manajemen Pesanan
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Update terakhir: {{ now()->format('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh setiap 30 detik
        setInterval(function() {
            location.reload();
        }, 30000);

        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
