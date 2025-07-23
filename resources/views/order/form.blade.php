<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order - Meja {{ $nomorMeja }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-6 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 w-full max-w-3xl">
        <h1 class="text-2xl font-bold mb-2">Order - Meja {{ $nomorMeja }}</h1>
        <p class="text-gray-500 mb-6">Order ID: <span class="font-semibold">{{ $order->id }}</span></p>

        <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="space-y-4 mb-8">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                <input type="text" name="customer_name" value="{{ session('customer_name', old('customer_name')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Menu</label>
                <select name="menu_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->nama }} (Rp {{ number_format($menu->harga) }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required class="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Tambah Item</button>
            </div>
        </form>

        <h2 class="text-xl font-semibold mb-4">Detail Order</h2>

        @if ($order->orderItems && count($order->orderItems) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Menu</th>
                            <th class="px-4 py-2 text-right font-medium text-gray-700">Harga Satuan</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-700">Jumlah</th>
                            <th class="px-4 py-2 text-right font-medium text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
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
            <p class="text-gray-500">Belum ada item.</p>
        @endif

        <p class="mt-4 text-lg font-semibold">Total Harga: <span class="text-indigo-600">Rp {{ number_format($order->total_harga) }}</span></p>

        <form method="POST" action="{{ route('order.submit', $order->id) }}" class="mt-4">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Submit Order</button>
        </form>
    </div>
</body>
</html>
