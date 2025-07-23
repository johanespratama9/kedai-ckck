<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Order Meja {{ $nomorMeja }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .menu-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">🪑 Order untuk Meja <b>{{ $nomorMeja }}</b></h3>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- FORM TAMBAH ITEM + NAMA --}}
            <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="row g-3 mb-4">
                @csrf

                <div class="col-md-6">
                    <label for="customer_name" class="form-label">Nama Konsumen</label>
                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                           value="{{ old('customer_name', $order->customer_name) }}" placeholder="Nama konsumen" required>
                </div>

                <div class="col-md-6">
                    <label for="menu_id" class="form-label">Pilih Menu</label>
                    <select name="menu_id" id="menu_id" class="form-select" required>
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->nama }} - Rp{{ number_format($menu->harga,0,',','.') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="quantity" class="form-label">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                </div>

                <div class="col-md-8 d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary w-100">
                        ➕ Tambah Item Baru
                    </button>
                </div>
            </form>

            {{-- ITEM SUDAH DIPESAN --}}
            <h4>📦 Item Sudah Dipesan:</h4>
            @if($order->items->count())
                <div class="list-group mb-3">
                    @foreach($order->items as $item)
                        <div class="list-group-item d-flex align-items-center">
                            @if($item->menu->foto)
                                <img src="{{ asset('storage/menus/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}" class="menu-thumb">
                            @else
                                <img src="https://via.placeholder.com/60?text=No+Image" alt="No Image" class="menu-thumb">
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->menu->nama }} x {{ $item->quantity }}</div>
                                <small class="text-muted">Subtotal: Rp{{ number_format($item->subtotal,0,',','.') }}</small>
                            </div>
                            <div class="ms-auto text-end">
                                <div class="fw-bold mb-1">Rp{{ number_format($item->subtotal,0,',','.') }}</div>
                                <form method="POST" action="{{ route('order.removeItem', [$order->id, $item->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="fw-bold text-end">💰 Total: Rp{{ number_format($order->total_harga,0,',','.') }}</p>

                {{-- Tombol submit order --}}
                <form method="POST" action="{{ route('order.submit', $order->id) }}" class="text-end mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">✅ Submit Order</button>
                </form>
            @else
                <p class="text-muted">Belum ada item yang ditambahkan.</p>
            @endif

        </div>
    </div>
</div>

</body>
</html>
