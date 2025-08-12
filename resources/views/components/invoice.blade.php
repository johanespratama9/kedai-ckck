<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
    <!-- Header with gradient -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-6">
        <div class="flex items-center justify-between text-white">
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-10 w-10 rounded">
                </div>
                <div>
                    <h1 class="text-xl font-bold">Kedai CKCK</h1>
                    <p class="text-blue-100 text-xs">Premium Coffee & Kitchen</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-blue-200 text-xs font-medium">INVOICE</span>
                <p class="text-white font-bold">#{{ $record->id }}</p>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-4">
        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="bg-slate-50 rounded-lg p-3">
                <span class="text-slate-600 block text-xs font-medium mb-1">Meja</span>
                <span class="font-semibold text-slate-900 text-lg">{{ $record->nomor_meja }}</span>
            </div>
            <div class="bg-slate-50 rounded-lg p-3">
                <span class="text-slate-600 block text-xs font-medium mb-1">Status</span>
                <span class="font-semibold uppercase text-sm px-2 py-1 rounded-full
                    {{ $record->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $record->status }}
                </span>
            </div>
        </div>
        
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-600">Nama Konsumen:</span>
                <span class="font-semibold text-slate-900">{{ $record->customer_name }}</span>
            </div>
            @if($record->keterangan)
            <div class="flex justify-between">
                <span class="text-slate-600">Catatan:</span>
                <span class="font-medium text-slate-900 italic">{{ $record->keterangan }}</span>
            </div>
            @endif
        </div>

        <!-- Items Table -->
        <div class="bg-slate-50 rounded-lg overflow-hidden mt-4">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="py-2 px-3 text-left font-semibold text-slate-700">Menu</th>
                        <th class="py-2 px-3 text-center font-semibold text-slate-700">Qty</th>
                        <th class="py-2 px-3 text-right font-semibold text-slate-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @if($record->orderItems && $record->orderItems->count())
                        @foreach($record->orderItems as $item)
                            <tr>
                                <td class="py-2 px-3 font-medium text-slate-900">{{ $item->menu->nama }}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold text-xs">{{ $item->quantity }}</span>
                                </td>
                                <td class="py-2 px-3 text-right font-semibold text-slate-900">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="py-4 text-center text-slate-500">Belum ada item.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200 mt-4">
            <div class="flex justify-between items-center">
                <span class="font-medium text-slate-700">Total</span>
                <span class="text-xl font-bold text-blue-900">Rp{{ number_format($record->total_harga,0,',','.') }}</span>
            </div>
        </div>
    </div>
</div>
