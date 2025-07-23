<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Order #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4>🧾 Invoice Order #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <p>Meja: <strong>{{ $order->nomor_meja }}</strong></p>
            <p>Nama Konsumen: <strong>{{ $order->customer_name }}</strong></p>
            <p>Status: <strong class="text-uppercase">{{ $order->status }}</strong></p>

            <table class="table">
                <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->menu->nama }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h5 class="text-end">💰 Total: Rp{{ number_format($order->total_harga,0,',','.') }}</h5>

            @if($order->status !== 'paid')
                <form method="POST" action="{{ route('order.pay', $order->id) }}" class="text-end">
                    @csrf
                    <button type="submit" class="btn btn-success">✅ Konfirmasi Pembayaran (Dummy)</button>
                </form>
            @endif
        </div>
    </div>
</div>
</body>
</html>
