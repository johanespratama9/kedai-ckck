<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Order Meja {{ $nomorMeja }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .menu-thumb { width: 50px; height: 50px; object-fit: cover; margin-right: 8px; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>🪑 Order untuk Meja <b>{{ $nomorMeja }}</b></h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="row g-3 mb-4">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Nama Konsumen</label>
                    <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pilih Menu</label>
                    <select name="menu_id" class="form-select" required>
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->nama }} - Rp{{ number_format($menu->harga,0,',','.') }} (Stok: {{ $menu->stok }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-8 d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary w-100">➕ Tambah Item</button>
                </div>
            </form>

            <h4>📦 Item Dipesan:</h4>
            @if($order->items->count())
                <div class="list-group mb-3">
                    @foreach($order->items as $item)
                        <div class="list-group-item d-flex align-items-center">
                            @if($item->menu->foto)
                                <img src="{{ asset('storage/menus/'.$item->menu->foto) }}" class="menu-thumb">
                            @endif
                            <div class="flex-grow-1">
                                {{ $item->menu->nama }} x {{ $item->quantity }}
                                <small class="text-muted">Subtotal: Rp{{ number_format($item->subtotal,0,',','.') }}</small>
                            </div>
                            <div class="ms-auto fw-bold">Rp{{ number_format($item->subtotal,0,',','.') }}</div>
                        </div>
                    @endforeach
                </div>
                <p class="fw-bold text-end">💰 Total: Rp{{ number_format($order->total_harga,0,',','.') }}</p>

                <form method="POST" action="{{ route('order.submit', $order->id) }}" class="text-end mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">✅ Submit Order</button>
                </form>
            @else
                <p class="text-muted">Belum ada item ditambahkan.</p>
            @endif
        </div>
    </div>
</div>
</body>
</html>
