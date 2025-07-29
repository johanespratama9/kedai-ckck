<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Semua Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-6 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Dashboard - Semua Order</h1>

        @if($orders->count())
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
                            <div>
                                <p class="font-semibold">Order ID: <span class="text-indigo-600">{{ $order->id }}</span></p>
                                <p class="text-gray-600">Meja: {{ $order->nomor_meja }}</p>
                            </div>
                            <p class="mt-2 md:mt-0 text-lg font-semibold text-green-600">Total: Rp {{ number_format($order->total_harga) }}</p>
                        </div>

                        @if($order->orderItems->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white text-sm border border-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Menu</th>
                                            <th class="px-4 py-2 text-right">Harga Satuan</th>
                                            <th class="px-4 py-2 text-center">Jumlah</th>
                                            <th class="px-4 py-2 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">{{ $item->menu->nama }}</td>
                                                <td class="px-4 py-2 text-right">Rp {{ number_format($item->menu->harga) }}</td>
                                                <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                                <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 mt-2">Belum ada item.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada order.</p>
        @endif
    </div>
</body>
</html>
