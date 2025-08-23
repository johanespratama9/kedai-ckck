<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
            'phone'         => 'required|string|max:20',
            'keterangan'    => 'nullable|string',
            'selected_menu' => 'required|exists:menus,id',
            'quantity'      => 'required|array',
            'quantity.*'    => 'required|integer|min:1',
        ]);

        $menuId   = $data['selected_menu'];
        $quantity = $data['quantity'][$menuId] ?? 1;

        // Cari menu
        $menu     = Menu::findOrFail($menuId);
        $subtotal = $menu->harga * $quantity;

        // Update customer_name, phone dan keterangan
        $order->customer_name = $data['customer_name'];
        $order->phone         = $data['phone'];
        $order->keterangan    = $data['keterangan'] ?? '';
        $order->total_harga += $subtotal;
        $order->save();

        // Tambah item ke order
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id'  => $menu->id,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $menu->stok -= $quantity;
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
        $order->status         = 'submitted';
        $order->status_makanan = 'pesanan diterima';
        $order->save();

        return redirect()->route('order.invoice', $order->id)
            ->with('success', 'Order berhasil disubmit!');

    }

    public function invoice(Order $order)
    {
        $order->load('orderItems.menu');
        return view('order.invoice', compact('order'));
    }

    public function showPayment(Order $order)
    {
        return view('order.payment', compact('order'));
    }

    public function processPayment(Order $order, Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
        ]);

        $paymentMethod = $request->payment_method;

        return view('order.payment-process', compact('order', 'paymentMethod'));
    }

    public function confirmPayment(Order $order, Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
        ]);

        // Update order status to paid
        $order->update([
            'status'         => 'paid',
            'status_makanan' => 'preparing',
            'payment_method' => $request->payment_method,
            'paid_at'        => now(),
        ]);

        // Redirect to invoice with success message
        return redirect()->route('order.invoice', $order->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function downloadInvoicePdf(Order $order)
    {
        $pdf = $pdf = Pdf::loadView('order.struck', compact('order'))
            ->setPaper('a4', 'portrait'); // optional: atur ukuran kertas

        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

}
