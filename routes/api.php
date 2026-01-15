<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

Route::get('/order/{order}/status', function (Order $order) {
    return response()->json([
        'status' => $order->status,
        'approval_status' => $order->approval_status,
        'status_makanan' => $order->status_makanan,
        'approved_by_name' => $order->approvedBy ? $order->approvedBy->name : null,
        'approved_at' => $order->approved_at ? $order->approved_at->format('d M Y H:i') : null,
    ]);
});
