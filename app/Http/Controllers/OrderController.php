<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showForm(Request $request)
    {
        $nomorMeja = $request->query('meja');
        if (! $nomorMeja) {
            abort(404);
        }

        $order = Order::firstOrCreate(
            ['nomor_meja' => $nomorMeja, 'status' => 'pending'],
            ['total_harga' => 0]
        );

        $menus = Menu::where('status', true)->get();

        return view('order.form', compact('order', 'menus', 'nomorMeja'));
    }

    public function addItem(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'menu_id'       => 'required|exists:menus,id',
            'quantity'      => 'required|integer|min:1',
        ]);

        $menu     = Menu::findOrFail($data['menu_id']);
        $subtotal = $menu->harga * $data['quantity'];

        // Update order
        $order->customer_name = $data['customer_name'];
        $order->total_harga += $subtotal;
        $order->save();

        // Buat item
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id'  => $menu->id,
            'quantity' => $data['quantity'],
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $menu->stok -= $data['quantity'];
        $menu->save();

        return redirect()->back()->with('success', 'Item berhasil ditambahkan!');
    }

    public function submit(Order $order)
    {
        $order->status = 'submitted';
        $order->save();
        return redirect()->route('order.invoice', $order->id);
    }

    public function invoice(Order $order)
    {
        return view('order.invoice', compact('order'));
    }

    // Dummy: Konfirmasi pembayaran
    public function pay(Order $order)
    {
        $order->status = 'paid';
        $order->save();
        return redirect()->route('order.invoice', $order->id)->with('success', 'Pembayaran berhasil!');
    }
}
