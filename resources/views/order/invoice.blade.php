<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Order #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<div class="max-w-xl mx-auto p-4 md:p-6">
    <div class="bg-white rounded-lg shadow">
        <div class="bg-gray-800 text-white px-4 py-3 rounded-t-lg">
            <h4 class="text-base md:text-lg font-semibold">🧾 Invoice Order #{{ $order->id }}</h4>
        </div>
        <div class="p-4 space-y-3 text-sm md:text-base">
            <div class="flex justify-between">
                <span class="text-gray-600">Meja:</span>
                <span class="font-semibold">{{ $order->nomor_meja }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Nama Konsumen:</span>
                <span class="font-semibold">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Status:</span>
                <span class="font-semibold uppercase">{{ $order->status }}</span>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-left text-xs md:text-sm">
                    <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="py-2 px-2">Menu</th>
                        <th class="py-2 px-2">Qty</th>
                        <th class="py-2 px-2 text-right">Subtotal</th>
                    </tr>
                    </thead>
            <tbody>
                @if($order->orderItems && $order->orderItems->count())
                    @foreach($order->orderItems as $item)
                        <tr class="border-b">
                            <td class="py-2 px-2">{{ $item->menu->nama }}</td>
                            <td class="py-2 px-2">{{ $item->quantity }}</td>
                            <td class="py-2 px-2 text-right">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="py-2 px-2 text-center text-gray-500">Belum ada item.</td>
                    </tr>
                @endif
                </tbody>


                </table>
            </div>

            <div class="flex justify-end mt-4">
                <h5 class="text-base md:text-lg font-semibold">💰 Total: Rp{{ number_format($order->total_harga,0,',','.') }}</h5>
            </div>

            @if($order->status !== 'paid')
                <form method="POST" action="{{ route('order.pay', $order->id) }}" class="flex justify-end">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm md:text-base">
                        ✅ Konfirmasi Pembayaran (Dummy)
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
</body>
</html>
