<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Order #{{ $order->id }}</title>
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
<div class="max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-brand-100 p-3 rounded-xl">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-10 w-10 rounded-lg">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Pembayaran Order</h1>
                    <p class="text-slate-600">Order #{{ $order->id }} - Meja {{ $order->nomor_meja }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-600">Total Pembayaran</p>
                <p class="text-2xl font-bold text-brand-900">Rp{{ number_format($order->total_harga,0,',','.') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Methods -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Pilih Metode Pembayaran</h2>
                
                <form method="POST" action="{{ route('order.processPayment', $order->id) }}" class="space-y-4">
                    @csrf
                    
                    <!-- Cash Payment -->
                    <div class="border border-slate-200 rounded-xl p-4 hover:border-brand-300 transition-colors">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="mr-4 text-brand-600" required>
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Tunai</h3>
                                    <p class="text-sm text-slate-600">Bayar langsung di kasir</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- QRIS Payment -->
                    <div class="border border-slate-200 rounded-xl p-4 hover:border-brand-300 transition-colors">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="mr-4 text-brand-600" required>
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">QRIS</h3>
                                    <p class="text-sm text-slate-600">Scan QR Code untuk pembayaran</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="border border-slate-200 rounded-xl p-4 hover:border-brand-300 transition-colors">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" class="mr-4 text-brand-600" required>
                            <div class="flex items-center space-x-4">
                                <div class="bg-purple-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Transfer Bank</h3>
                                    <p class="text-sm text-slate-600">Transfer ke rekening bank</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- E-Wallet -->
                    {{-- <div class="border border-slate-200 rounded-xl p-4 hover:border-brand-300 transition-colors">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="ewallet" class="mr-4 text-brand-600" required>
                            <div class="flex items-center space-x-4">
                                <div class="bg-orange-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">E-Wallet</h3>
                                    <p class="text-sm text-slate-600">GoPay, OVO, DANA, ShopeePay</p>
                                </div>
                            </div>
                        </label>
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white py-4 px-6 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Order ID:</span>
                        <span class="font-semibold">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Meja:</span>
                        <span class="font-semibold">{{ $order->nomor_meja }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Customer:</span>
                        <span class="font-semibold">{{ $order->customer_name }}</span>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-4 mb-4">
                    <h4 class="font-semibold text-slate-900 mb-3">Item Pesanan:</h4>
                    <div class="space-y-2">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">{{ $item->menu->nama }} ({{ $item->quantity }}x)</span>
                                <span class="font-semibold">Rp{{ number_format($item->subtotal,0,',','.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-slate-900">Total:</span>
                        <span class="text-xl font-bold text-brand-900">Rp{{ number_format($order->total_harga,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to selected payment method
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        this.closest('.border').scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
});
</script>
</body>
</html>
