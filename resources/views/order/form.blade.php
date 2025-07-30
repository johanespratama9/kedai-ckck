<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order - Meja {{ $nomorMeja }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-6 px-4">

<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-lg p-6">
    <!-- Header -->
    <div class="flex items-center mb-6 border-b pb-3">
        <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-12 w-12 mr-3">
        <h1 class="text-2xl font-bold">Kedai CKCK</h1>
    </div>

    <h1 class="text-2xl font-bold mb-2">Order - Meja {{ $nomorMeja }}</h1>
    <p class="text-gray-500 mb-6">Order ID: <span class="font-semibold">{{ $order->id }}</span></p>

    <!-- Form -->
    <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="mb-8">
        @csrf
        <!-- Nama customer -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
            <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <!-- Keterangan (satu saja, di bawah nama) -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <input type="text" name="keterangan" value="{{ old('keterangan', $order->keterangan) }}"
                   placeholder="Contoh: tanpa pedas, extra saus"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <!-- Grid menu (mirip marketplace) -->
        <h2 class="text-xl font-semibold mb-4">Pilih Menu</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($menus as $menu)
                <div class="border rounded-lg p-3 flex flex-col items-center bg-gray-50">
                    <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}"
                         class="h-32 w-32 object-cover rounded mb-2">
                    <div class="text-center mb-2">
                        <p class="font-semibold">{{ $menu->nama }}</p>
                        <p class="text-indigo-600">Rp {{ number_format($menu->harga) }}</p>
                    </div>
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                   <input type="number" name="quantity[{{ $menu->id }}]" value="1" min="1"
       class="w-16 mb-2 rounded-md border-gray-300 shadow-sm text-center">
<button type="submit" name="selected_menu" value="{{ $menu->id }}"
        class="bg-indigo-600 text-white text-sm px-3 py-1 rounded-md w-full">Tambah ke Keranjang</button>

                </div>
            @endforeach
        </div>
    </form>

    <!-- Detail Order (keranjang) -->
    <h2 class="text-xl font-semibold mb-4 mt-8">Keranjang</h2>
    @if ($order->orderItems->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Foto</th>
                    <th class="px-4 py-2">Menu</th>
                    <th class="px-4 py-2 text-right">Harga</th>
                    <th class="px-4 py-2 text-center">Jumlah</th>
                    <th class="px-4 py-2 text-right">Subtotal</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->orderItems as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}"
                                 class="h-16 w-16 object-cover rounded">
                        </td>
                        <td class="px-4 py-2">{{ $item->menu->nama }}</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($item->menu->harga) }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal) }}</td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('order.removeItem', $item->id) }}"
                                  onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <p class="mt-4 text-lg font-semibold">Total Harga:
            <span class="text-indigo-600">Rp {{ number_format($order->total_harga) }}</span>
        </p>
    @else
        <p class="text-gray-500">Belum ada item.</p>
    @endif

    <!-- Submit order -->
    <form method="POST" action="{{ route('order.submit', $order->id) }}" class="mt-4">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Submit Order</button>
    </form>
</div>

</body>
</html>
