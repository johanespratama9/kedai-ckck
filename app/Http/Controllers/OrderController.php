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

        // Ambil order pending + orderItems
        $order = Order::with('orderItems.menu')->firstOrCreate(
            ['nomor_meja' => $nomorMeja, 'status' => 'pending'],
            ['total_harga' => 0]
        );

        $menus = Menu::where('status', true)->get();

        return view('order.form', compact('order', 'menus', 'nomorMeja'));
    }

    public function addItem(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'menu_id'       => 'required|exists:menus,id',
            'quantity'      => 'required|integer|min:1',
        ]);

        $menu     = Menu::findOrFail($data['menu_id']);
        $subtotal = $menu->harga * $data['quantity'];

        // Update customer_name dan total_harga
        $order->customer_name = $data['customer_name'];
        $order->total_harga += $subtotal;
        $order->save();

        // Tambah item
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

    public function editItem(Request $request, OrderItem $item)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $menu        = $item->menu;
        $oldQuantity = $item->quantity;
        $diff        = $data['quantity'] - $oldQuantity;

        // Update stok
        $menu->stok -= $diff;
        $menu->save();

        // Update subtotal & quantity
        $item->quantity = $data['quantity'];
        $item->subtotal = $menu->harga * $data['quantity'];
        $item->save();

        // Update total harga order
        $order              = $item->order;
        $order->total_harga = $order->orderItems()->sum('subtotal');
        $order->save();

        return redirect()->back()->with('success', 'Item berhasil diubah!');
    }

    public function removeItem(OrderItem $item)
    {
        $order = $item->order;
        $menu  = $item->menu;

        // Balikkan stok
        $menu->stok += $item->quantity;
        $menu->save();

        // Hapus item
        $item->delete();

        // Update total harga order
        $order->total_harga = $order->orderItems()->sum('subtotal');
        $order->save();

        return redirect()->back()->with('success', 'Item berhasil dihapus!');
    }

    public function submit(Order $order)
    {
        $order->status = 'submitted';
        $order->save();

        return redirect()->route('order.invoice', $order->id)
            ->with('success', 'Order berhasil disubmit!');

    }

    public function invoice(Order $order)
    {
        $order->load('orderItems.menu');
        return view('order.invoice', compact('order'));
    }

    public function pay(Order $order)
    {
        $order->status = 'paid';
        $order->save();

        return redirect()->route('order.invoice', $order->id)->with('success', 'Pembayaran berhasil!');
    }
}
