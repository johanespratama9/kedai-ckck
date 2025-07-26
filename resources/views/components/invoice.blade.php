<div class="bg-white rounded-lg shadow">
    <div class="flex items-center justify-between px-4 py-3 border-b">
        <div class="flex items-center">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-10 w-10 mr-3">
            <h1 class="text-lg md:text-xl font-bold">Kedai CKCK</h1>
        </div>
        <span class="text-gray-500 text-xs md:text-sm">Invoice</span>
    </div>

    <div class="bg-gray-800 text-white px-4 py-3">
        <h4 class="text-base md:text-lg font-semibold">🧾 Invoice Order #{{ $record->id }}</h4>
    </div>
    <div class="p-4 space-y-3 text-sm md:text-base">
        <div class="flex justify-between">
            <span class="text-gray-600">Meja:</span>
            <span class="font-semibold">{{ $record->nomor_meja }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Nama Konsumen:</span>
            <span class="font-semibold">{{ $record->customer_name }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Status:</span>
            <span class="font-semibold uppercase">{{ $record->status }}</span>
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
                @if($record->orderItems && $record->orderItems->count())
                    @foreach($record->orderItems as $item)
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
            <h5 class="text-base md:text-lg font-semibold">💰 Total: Rp{{ number_format($record->total_harga,0,',','.') }}</h5>
        </div>
    </div>
</div>
