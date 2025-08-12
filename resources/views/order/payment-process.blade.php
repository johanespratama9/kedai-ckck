<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Pembayaran #{{ $order->id }}</title>
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
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand-800 to-brand-900 px-6 py-6">
            <div class="text-center text-white">
                <h1 class="text-2xl font-bold">Pembayaran {{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</h1>
                <p class="text-brand-100">Order #{{ $order->id }} - Rp{{ number_format($order->total_harga,0,',','.') }}</p>
            </div>
        </div>

        <div class="p-6">
            @if($paymentMethod === 'cash')
                <!-- Cash Payment Instructions -->
                <div class="text-center space-y-6">
                    <div class="bg-green-100 p-6 rounded-xl">
                        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-green-800 mb-2">Pembayaran Tunai</h2>
                        <p class="text-green-700">Silakan bayar di kasir dengan total:</p>
                        <p class="text-2xl font-bold text-green-800 mt-2">Rp{{ number_format($order->total_harga,0,',','.') }}</p>
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <h3 class="font-semibold mb-2">Instruksi:</h3>
                        <ol class="text-left text-sm text-slate-600 space-y-1">
                            <li>1. Tunjukkan order ID ini ke kasir: <strong>#{{ $order->id }}</strong></li>
                            <li>2. Bayar sejumlah <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></li>
                            <li>3. Kasir akan mengkonfirmasi pembayaran</li>
                        </ol>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold">
                            Konfirmasi Sudah Bayar
                        </button>
                    </form>
                </div>

            @elseif($paymentMethod === 'qris')
                <!-- QRIS Payment -->
                <div class="text-center space-y-6">
                    <div class="bg-blue-100 p-6 rounded-xl">
                        <svg class="w-16 h-16 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-blue-800 mb-2">Scan QR Code</h2>
                        <p class="text-blue-700">Total pembayaran: <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></p>
                    </div>

                    <!-- QR Code placeholder -->
                    <div class="bg-white p-8 rounded-xl border-2 border-slate-200 mx-auto max-w-xs">
                        <div class="w-48 h-48 bg-slate-100 rounded-lg flex items-center justify-center mx-auto">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                <p class="text-sm text-slate-500">QR Code QRIS</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Order #{{ $order->id }}</p>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl text-left">
                        <h3 class="font-semibold mb-2">Cara Pembayaran:</h3>
                        <ol class="text-sm text-slate-600 space-y-1">
                            <li>1. Buka aplikasi e-wallet atau mobile banking</li>
                            <li>2. Scan QR Code di atas</li>
                            <li>3. Konfirmasi pembayaran sebesar Rp{{ number_format($order->total_harga,0,',','.') }}</li>
                            <li>4. Klik tombol "Sudah Bayar" setelah transaksi berhasil</li>
                        </ol>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="qris">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">
                            Sudah Bayar via QRIS
                        </button>
                    </form>
                </div>

            @elseif($paymentMethod === 'bank_transfer')
                <!-- Bank Transfer -->
                <div class="space-y-6">
                    <div class="bg-purple-100 p-6 rounded-xl text-center">
                        <svg class="w-16 h-16 text-purple-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-purple-800 mb-2">Transfer Bank</h2>
                        <p class="text-purple-700">Total: <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></p>
                    </div>

                    <div class="grid gap-4">
                        <div class="bg-slate-50 p-4 rounded-xl">
                            <h3 class="font-semibold mb-3">Rekening Tujuan:</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg">
                                    <div>
                                        <p class="font-semibold">Bank BCA</p>
                                        <p class="text-sm text-slate-600">1234567890</p>
                                    </div>
                                    <button onclick="copyToClipboard('1234567890')" class="text-blue-600 text-sm hover:underline">Copy</button>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg">
                                    <div>
                                        <p class="font-semibold">Bank Mandiri</p>
                                        <p class="text-sm text-slate-600">0987654321</p>
                                    </div>
                                    <button onclick="copyToClipboard('0987654321')" class="text-blue-600 text-sm hover:underline">Copy</button>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mt-3">a.n. <strong>Kedai CKCK</strong></p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl">
                            <h3 class="font-semibold mb-2">Instruksi Transfer:</h3>
                            <ol class="text-sm text-slate-600 space-y-1">
                                <li>1. Transfer ke salah satu rekening di atas</li>
                                <li>2. Jumlah: <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></li>
                                <li>3. Berita: <strong>Order {{ $order->id }}</strong></li>
                                <li>4. Simpan bukti transfer</li>
                                <li>5. Klik "Konfirmasi Transfer" setelah berhasil</li>
                            </ol>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}" class="text-center">
                        @csrf
                        <input type="hidden" name="payment_method" value="bank_transfer">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-semibold">
                            Konfirmasi Transfer
                        </button>
                    </form>
                </div>

            @elseif($paymentMethod === 'ewallet')
                <!-- E-Wallet Payment -->
                <div class="space-y-6">
                    <div class="bg-orange-100 p-6 rounded-xl text-center">
                        <svg class="w-16 h-16 text-orange-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-orange-800 mb-2">Pembayaran E-Wallet</h2>
                        <p class="text-orange-700">Total: <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-green-500 text-white p-4 rounded-xl font-semibold hover:bg-green-600 transition-colors">
                            <div class="text-center">
                                <div class="w-8 h-8 bg-white rounded mx-auto mb-2"></div>
                                <p>GoPay</p>
                            </div>
                        </button>
                        <button class="bg-purple-500 text-white p-4 rounded-xl font-semibold hover:bg-purple-600 transition-colors">
                            <div class="text-center">
                                <div class="w-8 h-8 bg-white rounded mx-auto mb-2"></div>
                                <p>OVO</p>
                            </div>
                        </button>
                        <button class="bg-blue-500 text-white p-4 rounded-xl font-semibold hover:bg-blue-600 transition-colors">
                            <div class="text-center">
                                <div class="w-8 h-8 bg-white rounded mx-auto mb-2"></div>
                                <p>DANA</p>
                            </div>
                        </button>
                        <button class="bg-orange-500 text-white p-4 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                            <div class="text-center">
                                <div class="w-8 h-8 bg-white rounded mx-auto mb-2"></div>
                                <p>ShopeePay</p>
                            </div>
                        </button>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl">
                        <p class="text-sm text-slate-600 text-center">
                            Pilih e-wallet di atas, Anda akan diarahkan ke aplikasi untuk menyelesaikan pembayaran.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}" class="text-center">
                        @csrf
                        <input type="hidden" name="payment_method" value="ewallet">
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-xl font-semibold">
                            Pembayaran Selesai
                        </button>
                    </form>
                </div>
            @endif

            <!-- Back Button -->
            <div class="text-center mt-6 pt-6 border-t border-slate-200">
                <a href="{{ route('order.payment', $order->id) }}" class="text-slate-600 hover:text-slate-800 underline">
                    ← Kembali ke pilihan pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening berhasil disalin: ' + text);
    });
}
</script>
</body>
</html>
