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
                    <span class="text-brand-200 text-sm font-medium">FAKTUR</span>
                    <p class="text-white font-bold text-lg">#{{ $order->id }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        @php
            $items = $order->orderItems;

            if (! $items instanceof \Illuminate\Support\Collection) {
                $items = collect($items ?? []);
            }

            if ($items instanceof \Illuminate\Database\Eloquent\Collection) {
                $items->loadMissing('menu');
            }
        @endphp

        <!-- Approval Status Alert -->
        @if($order->approval_status === 'pending_approval')
            <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 space-y-3">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.343 3.665c.886-.887 2.318-.887 3.203 0l6.364 6.364c.884.884.884 2.317 0 3.2l-6.364 6.364c-.885.884-2.317.884-3.203 0L3.14 13.23c-.884-.883-.884-2.316 0-3.2l6.364-6.364zm5.656 1.414a1 1 0 01-1.414 0L7.171 9.05a1 1 0 010-1.414l5.656-5.657a1 1 0 011.414 0l5.657 5.657a1 1 0 010 1.414l-5.657 5.656z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-800">⏳ Menunggu Persetujuan Admin</h3>
                        <p class="text-yellow-700 text-sm mt-1">
                            @if($order->payment_method)
                                Pembayaran Anda sudah dikonfirmasi. Admin sedang memeriksa bukti pembayaran. Silakan tunggu persetujuan.
                            @else
                                Order Anda menunggu pembayaran. Silakan lakukan pembayaran terlebih dahulu.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @elseif($order->approval_status === 'rejected')
            <div class="p-6 bg-red-50 border-l-4 border-red-400 space-y-3">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800">❌ Order Ditolak</h3>
                        <p class="text-red-700 text-sm mt-1">
                            <strong>Alasan:</strong> {{ $order->rejection_reason ?? 'Tidak ada alasan yang diberikan' }}
                        </p>
                        <p class="text-red-700 text-sm mt-2">Silakan hubungi kasir untuk membuat order baru atau mendapatkan informasi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'paid' || $order->approval_status === 'approved')
            <div class="p-6 bg-green-50 border-l-4 border-green-400 space-y-3">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">✅ Order Disetujui & Pembayaran Diterima</h3>
                        <p class="text-green-700 text-sm mt-1">Pembayaran Anda telah diverifikasi dan disetujui oleh admin. Pesanan sedang diproses di dapur.</p>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'submitted')
            <div class="p-6 bg-blue-50 border-l-4 border-blue-400 space-y-3">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800">💳 Silakan Lakukan Pembayaran</h3>
                        <p class="text-blue-700 text-sm mt-1">Order Anda sudah dibuat. Silakan lakukan pembayaran untuk melanjutkan proses.</p>
                    </div>
                </div>
            </div>
        @endif

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
                                <span class="text-slate-600 text-sm">Status Pembayaran</span>
                                <span class="font-semibold uppercase px-3 py-1 rounded-full text-xs
                                    {{ ($order->status === 'paid' || $order->approval_status === 'approved') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ($order->status === 'paid' || $order->approval_status === 'approved') ? 'Sudah Bayar' : 'Belum Bayar' }}
                                </span>
                            </div>
                            @if($order->status === 'paid' || $order->approval_status === 'approved')
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600 text-sm">Status Makanan</span>
                                    <span class="font-semibold uppercase px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                        {{ $order->status_makanan ?? 'pesanan diterima' }}
                                    </span>
                                </div>
                            @endif
                            @if($order->payment_method)
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600 text-sm">Metode Pembayaran</span>
                                    <span class="font-semibold px-3 py-1 rounded-lg text-xs bg-indigo-100 text-indigo-800">
                                        {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                                    </span>
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
                            @if($items->isNotEmpty())
                                @foreach($items as $item)
                                    <tr class="hover:bg-slate-25">
                                        <td class="py-4 px-6">
                                            <div class="font-medium text-slate-900">{{ optional($item->menu)->nama ?? '-' }}</div>
                                            @if($item->note_selera)
                                                <div class="text-xs text-orange-600 mt-1 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <em>{{ $item->note_selera }}</em>
                                                </div>
                                            @endif
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

            <!-- Catatan Khusus Section -->
            @if($order->keterangan)
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <h3 class="text-sm font-semibold text-blue-900 uppercase tracking-wide mb-2">📝 Catatan Khusus</h3>
                    <p class="text-blue-800 text-sm italic">{{ $order->keterangan }}</p>
                </div>
            @endif

            <!-- Total Section -->
            <div class="bg-gradient-to-r from-brand-50 to-blue-50 rounded-xl p-6 border border-brand-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-slate-700">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-brand-900">Rp{{ number_format($order->total_harga,0,',','.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                @if($order->approval_status === 'rejected')
                    <!-- Order ditolak -->
                    <button class="flex-1 bg-red-400 cursor-not-allowed text-white text-center px-6 py-3 rounded-xl font-semibold opacity-75" disabled>
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Order Ditolak
                    </button>
                @elseif($order->status === 'submitted' && !$order->payment_method)
                    <!-- Belum bayar -->
                    <a href="{{ route('order.payment', $order->id) }}"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Lanjut ke Pembayaran
                    </a>
                @elseif($order->approval_status === 'pending_approval')
                    <!-- Menunggu persetujuan admin -->
                    <button class="flex-1 bg-yellow-400 cursor-not-allowed text-white text-center px-6 py-3 rounded-xl font-semibold opacity-75" disabled>
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Menunggu Persetujuan Admin
                    </button>
                @elseif($order->status === 'paid' || $order->approval_status === 'approved')
                    <!-- Order sudah disetujui -->
                    <a href="{{ route('order.downloadInvoice', $order->id) }}"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white text-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh Invoice (PDF)
                    </a>
                @else
                    <!-- Fallback -->
                    <button class="flex-1 bg-gray-400 cursor-not-allowed text-white text-center px-6 py-3 rounded-xl font-semibold opacity-75" disabled>
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Menunggu Konfirmasi
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" class="fixed bottom-4 right-4 space-y-3 z-50"></div>

<script>
function showNotification(message, type = 'info') {
    const container = document.getElementById('notificationContainer');
    
    // Cek apakah notification dengan pesan yang sama sudah ada
    const existing = Array.from(container.children).find(el => el.textContent.includes(message.substring(0, 20)));
    if (existing) return; // Jangan duplicate
    
    const bgColor = {
        'success': 'bg-green-500',
        'warning': 'bg-yellow-500',
        'info': 'bg-blue-500',
        'error': 'bg-red-500'
    }[type] || 'bg-blue-500';
    
    const notification = document.createElement('div');
    notification.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-lg animate-fade-in`;
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove setelah 5 detik
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Polling untuk status order
let pollingInterval;
let hasNotifiedApproval = false;
let hasNotifiedRejection = false;

function checkOrderStatus() {
    const orderId = {{ $order->id }};
    
    fetch(`/api/order/${orderId}/status`)
        .then(response => response.json())
        .then(data => {
            // Notifikasi saat approved (hanya sekali)
            if (data.approval_status === 'approved' && !hasNotifiedApproval) {
                const adminName = data.approved_by_name || 'Admin';
                const approvedTime = data.approved_at || '';
                showNotification(`✅ Pesanan diterima oleh ${adminName} pada ${approvedTime}`, 'success');
                hasNotifiedApproval = true;
                
                // Auto reload halaman setelah 2 detik
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
            
            // Notifikasi saat rejected (hanya sekali)
            if (data.approval_status === 'rejected' && !hasNotifiedRejection) {
                const adminName = data.approved_by_name || 'Admin';
                showNotification(`❌ Pesanan ditolak oleh ${adminName}. Cek alasan penolakan di atas.`, 'error');
                hasNotifiedRejection = true;
                
                // Auto reload halaman setelah 2 detik
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        })
        .catch(error => console.error('Error checking order status:', error));
}

// Mulai polling jika status masih pending_approval
@if($order->approval_status === 'pending_approval')
    // Check status setiap 3 detik
    pollingInterval = setInterval(checkOrderStatus, 3000);
    // Juga check sekali saat page load
    checkOrderStatus();
@endif

// Tambahkan CSS untuk animation
const style = document.createElement('style');
style.innerHTML = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);
</script>

</body>
</html>
