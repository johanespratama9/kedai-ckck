@extends('layouts.app')

@section('title', 'Persetujuan Order Pending')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">📋 Persetujuan Order Pending</h1>
        <p class="text-gray-600">Daftar order yang menunggu persetujuan dari admin/kasir</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if ($pendingOrders->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <p class="text-yellow-800 text-lg">📭 Tidak ada order yang menunggu persetujuan</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($pendingOrders as $order)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <!-- Header -->
                    <div class="bg-blue-50 px-6 py-4 border-b-2 border-blue-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-blue-900">Order #{{ $order->id }}</h2>
                                <p class="text-sm text-blue-700 mt-1">
                                    🕐 {{ $order->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                ⏳ Menunggu Approval
                            </span>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama Pelanggan</p>
                                <p class="font-semibold text-gray-900">{{ $order->customer_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">No. Meja</p>
                                <p class="font-semibold text-gray-900">Meja {{ $order->nomor_meja }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">No. HP</p>
                                <p class="font-semibold text-gray-900">{{ $order->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pembayaran</p>
                                <p class="font-semibold text-gray-900">{{ ucfirst($order->status) }}</p>
                            </div>
                        </div>
                        @if ($order->keterangan)
                            <div class="mt-3 pt-3 border-t">
                                <p class="text-sm text-gray-600">Keterangan</p>
                                <p class="text-sm text-gray-700 italic">{{ $order->keterangan }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="px-6 py-4">
                        <h3 class="font-bold text-gray-800 mb-3">📝 Detail Pesanan:</h3>
                        <div class="space-y-2">
                            @foreach ($order->orderItems as $item)
                                <div class="flex justify-between items-center text-sm border-b pb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item->menu->nama }}</p>
                                        <p class="text-gray-600">{{ $item->quantity }}x @ Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t-2 border-gray-300 flex justify-between items-center">
                            <span class="font-bold text-lg text-gray-800">Total:</span>
                            <span class="text-2xl font-bold text-blue-600">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 py-4 bg-gray-50 border-t-2 border-gray-200">
                        <div class="space-y-2">
                            <!-- Approve Button -->
                            <form action="{{ route('order.approve', $order) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                                    ✅ Setujui Order
                                </button>
                            </form>

                            <!-- Reject Button (Toggle) -->
                            <button type="button" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition" 
                                    onclick="toggleRejectForm({{ $order->id }})">
                                ❌ Tolak Order
                            </button>

                            <!-- Reject Form (Hidden by default) -->
                            <div id="reject-form-{{ $order->id }}" class="hidden mt-3 p-4 bg-red-50 border border-red-200 rounded">
                                <form action="{{ route('order.reject', $order) }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan:</label>
                                    <textarea name="rejection_reason" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" 
                                              rows="3" placeholder="Jelaskan alasan penolakan order..." required></textarea>
                                    <div class="flex gap-2 mt-3">
                                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                                            Kirim Penolakan
                                        </button>
                                        <button type="button" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded transition" 
                                                onclick="toggleRejectForm({{ $order->id }})">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function toggleRejectForm(orderId) {
        const form = document.getElementById(`reject-form-${orderId}`);
        form.classList.toggle('hidden');
    }
</script>

<style>
    @media (max-width: 640px) {
        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
