<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Order #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 15px; }
        .logo { width: 80px; margin-bottom: 5px; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 6px; }
        th { background-color: #f8f8f8; text-align: left; }
        .info { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('storage/logo.png') }}" alt="Logo" class="logo">
        <h2 style="margin: 0;">Kedai CKCK</h2>
        <small>Invoice Order #{{ $order->id }}</small>
    </div>

    <div class="info">
        <p><strong>Meja:</strong> {{ $order->nomor_meja }}</p>
        <p><strong>Nama Konsumen:</strong> {{ $order->customer_name }}</p>
        <p><strong>No. HP:</strong> {{ $order->phone }}</p>
        <p><strong>Status:</strong> {{ strtoupper($order->status) }}</p>
        <p><strong>Catatan:</strong> {{ strtoupper($order->keterangan) }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Kasir:</strong> Admin CKCK</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th style="text-align:right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->orderItems as $item)
                <tr>
                    <td>{{ $item->menu->nama }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align:right">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center">Belum ada item.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align:right; margin-top:10px;">
        <strong>Total: Rp{{ number_format($order->total_harga,0,',','.') }}</strong>
    </p>

    {{-- Tambahkan QR code (contoh: link ke halaman order) --}}
    <div style="margin-top:20px; text-align:center;">
        @php
            $url = url('/order/' . $order->id . '/invoice');
        @endphp
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate($url)) !!} " alt="QR Code">
        <p style="font-size:10px; color:#666;">Scan untuk lihat detail order</p>
    </div>

    <div class="footer">
        Terima kasih telah memesan di Kedai CKCK
    </div>
</body>
</html>
