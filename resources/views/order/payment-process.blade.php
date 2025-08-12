<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Pembayaran #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .payment-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 32px;
            color: white;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .method-card {
            background: white;
            border-radius: 15px;
            padding: 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .method-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }
        .bank-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin: 12px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .bank-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        .ewallet-btn {
            border-radius: 15px;
            padding: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
        }
        .ewallet-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .success-animation {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        .copy-btn {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .copy-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        .instruction-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            padding: 20px;
            border-left: 5px solid #667eea;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen py-8">
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
        <!-- Header yang menarik -->
        <div class="payment-card">
            <div class="text-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4">
                    <span class="text-4xl mb-4 block">💳</span>
                    <h1 class="text-3xl font-bold mb-2">Proses Pembayaran</h1>
                    <p class="text-blue-100 text-lg">{{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</p>
                </div>
                <div class="flex justify-between items-center bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div>
                        <p class="text-blue-100 text-sm">Pesanan</p>
                        <p class="font-bold text-xl">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Total Bayar</p>
                        <p class="font-bold text-2xl">Rp{{ number_format($order->total_harga,0,',','.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8">
            @if($paymentMethod === 'cash')
                <!-- Pembayaran Tunai -->
                <div class="method-card text-center">
                    <div class="success-animation text-6xl mb-6">💵</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pembayaran Tunai</h2>
                    <div class="bg-gradient-to-r from-green-100 to-emerald-100 p-6 rounded-2xl mb-6">
                        <p class="text-green-800 text-lg font-semibold mb-2">Silakan bayar di kasir</p>
                        <p class="text-3xl font-bold text-green-600">Rp{{ number_format($order->total_harga,0,',','.') }}</p>
                    </div>
                    
                    <div class="instruction-card mb-6">
                        <h3 class="font-bold text-gray-800 mb-3">📋 Langkah Pembayaran:</h3>
                        <ol class="text-left text-gray-700 space-y-2">
                            <li class="flex items-center"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">1</span>Datang ke kasir</li>
                            <li class="flex items-center"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">2</span>Sebutkan nomor pesanan: <strong>#{{ $order->id }}</strong></li>
                            <li class="flex items-center"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">3</span>Bayar sejumlah Rp{{ number_format($order->total_harga,0,',','.') }}</li>
                            <li class="flex items-center"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">4</span>Tunggu pesanan siap</li>
                        </ol>
                    </div>
                    
                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash">
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-10 py-4 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            ✅ Konfirmasi Pembayaran Tunai
                        </button>
                    </form>
                </div>

            @elseif($paymentMethod === 'bank_transfer')
                <!-- Transfer Bank -->
                <div class="method-card">
                    <div class="text-center mb-6">
                        <span class="text-5xl mb-4 block">🏦</span>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Transfer Bank</h2>
                        <p class="text-gray-600">Pilih bank dan transfer ke nomor rekening</p>
                    </div>

                    <div class="grid gap-4 mb-6">
                        <!-- BCA -->
                        <div class="bank-card" onclick="copyToClipboard('1234567890')">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Bank BCA</h3>
                                    <p class="text-blue-100">a/n Kedai CKCK</p>
                                    <p class="font-mono text-xl font-bold">1234567890</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl">🏦</span>
                                    <p class="text-xs text-blue-100 mt-1">Klik untuk salin</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mandiri -->
                        <div class="bank-card bg-gradient-to-r from-yellow-600 to-orange-600" onclick="copyToClipboard('0987654321')">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Bank Mandiri</h3>
                                    <p class="text-yellow-100">a/n Kedai CKCK</p>
                                    <p class="font-mono text-xl font-bold">0987654321</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl">🏛️</span>
                                    <p class="text-xs text-yellow-100 mt-1">Klik untuk salin</p>
                                </div>
                            </div>
                        </div>

                        <!-- BRI -->
                        <div class="bank-card bg-gradient-to-r from-blue-800 to-indigo-800" onclick="copyToClipboard('1122334455')">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Bank BRI</h3>
                                    <p class="text-blue-100">a/n Kedai CKCK</p>
                                    <p class="font-mono text-xl font-bold">1122334455</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl">🏢</span>
                                    <p class="text-xs text-blue-100 mt-1">Klik untuk salin</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="instruction-card mb-6">
                        <h3 class="font-bold text-gray-800 mb-3">📱 Cara Transfer:</h3>
                        <ol class="text-gray-700 space-y-2">
                            <li class="flex items-start"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">1</span>Buka aplikasi mobile banking</li>
                            <li class="flex items-start"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">2</span>Pilih menu transfer antar bank</li>
                            <li class="flex items-start"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">3</span>Masukkan nomor rekening (klik untuk salin)</li>
                            <li class="flex items-start"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">4</span>Masukkan nominal: <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong></li>
                            <li class="flex items-start"><span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">5</span>Tulis keterangan: <strong>Order #{{ $order->id }}</strong></li>
                        </ol>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}" class="text-center">
                        @csrf
                        <input type="hidden" name="payment_method" value="bank_transfer">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-10 py-4 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            ✅ Konfirmasi Transfer Selesai
                        </button>
                    </form>
                </div>

            @elseif($paymentMethod === 'ewallet')
                <!-- E-Wallet Payment -->
                <div class="method-card">
                    <div class="text-center mb-6">
                        <span class="text-5xl mb-4 block">📱</span>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran E-Wallet</h2>
                        <p class="text-gray-600">Pilih aplikasi e-wallet favorit Anda</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button class="ewallet-btn bg-gradient-to-br from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700">
                            <div>
                                <span class="text-3xl block mb-2">💚</span>
                                <span class="font-bold">GoPay</span>
                            </div>
                        </button>
                        <button class="ewallet-btn bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:from-purple-600 hover:to-purple-700">
                            <div>
                                <span class="text-3xl block mb-2">💜</span>
                                <span class="font-bold">OVO</span>
                            </div>
                        </button>
                        <button class="ewallet-btn bg-gradient-to-br from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700">
                            <div>
                                <span class="text-3xl block mb-2">💙</span>
                                <span class="font-bold">DANA</span>
                            </div>
                        </button>
                        <button class="ewallet-btn bg-gradient-to-br from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700">
                            <div>
                                <span class="text-3xl block mb-2">🧡</span>
                                <span class="font-bold">ShopeePay</span>
                            </div>
                        </button>
                    </div>

                    <div class="instruction-card mb-6">
                        <p class="text-gray-700 text-center font-medium">
                            <span class="text-2xl mr-2">ℹ️</span>
                            Pilih e-wallet di atas, Anda akan diarahkan ke aplikasi untuk menyelesaikan pembayaran sebesar <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('order.confirmPayment', $order->id) }}" class="text-center">
                        @csrf
                        <input type="hidden" name="payment_method" value="ewallet">
                        <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-10 py-4 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            ✅ Konfirmasi E-Wallet Selesai
                        </button>
                    </form>
                </div>
            @endif

            <!-- Back Button yang menarik -->
            <div class="text-center mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('order.payment', $order->id) }}" class="inline-flex items-center text-slate-600 hover:text-slate-800 font-medium transition-colors group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke pilihan pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Tampilkan notifikasi yang menarik
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="text-xl mr-2">✅</span>
                <span class="font-semibold">Nomor rekening berhasil disalin!</span>
            </div>
            <p class="text-sm text-green-100 mt-1">${text}</p>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Animate out after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }).catch(function() {
        alert('Nomor rekening: ' + text);
    });
}

// Animation untuk elemen saat load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.method-card, .bank-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
</body>
</html>
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
