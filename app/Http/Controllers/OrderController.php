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
            ['total_harga' => 0, 'started_at' => now()]
        );

        $menus = Menu::where('status', true)->get();

        return view('order.form', compact('order', 'menus', 'nomorMeja'));
    }

    public function addItem(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|regex:/^[0-9]+$/|min:10|max:15',
            'keterangan'    => 'nullable|string',
            'selected_menu' => 'required|exists:menus,id',
            'quantity'      => 'required|array',
            'quantity.*'    => 'required|integer|min:1',
        ], [
            'phone.regex'    => 'No. HP hanya boleh berisi angka (0-9)',
            'phone.min'      => 'No. HP minimal 10 angka',
            'phone.max'      => 'No. HP maksimal 15 angka',
            'phone.required' => 'No. HP tidak boleh kosong',
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
        $order->approval_status = 'pending_approval'; // Set ke pending approval
        $order->save();

        return redirect()->route('order.invoice', $order->id)
            ->with('success', 'Order berhasil disubmit! Menunggu persetujuan dari admin/kasir.');

    }

    public function invoice(Order $order)
    {
        $order->load('orderItems.menu');
        return view('order.invoice', compact('order'));
    }

    public function showPayment(Order $order)
    {
        // Jika order sudah paid, redirect ke invoice
        if ($order->status === 'paid') {
            return redirect()->route('order.invoice', $order->id)
                ->with('info', 'Order sudah disetujui dan diproses. Terima kasih!');
        }

        return view('order.payment', compact('order'));
    }

    public function processPayment(Order $order, Request $request)
    {
        // Jika GET request, tampilkan form
        if ($request->method() === 'GET') {
            // Parse payment_method dari query string jika ada
            $paymentMethod = $request->query('payment_method');
            if (!$paymentMethod) {
                // Redirect ke payment page jika payment_method tidak diberikan
                return redirect()->route('order.payment', $order->id);
            }
            return view('order.payment-process', compact('order', 'paymentMethod'));
        }

        // Jika POST request, validasi payment_method
        $request->validate([
            'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
        ]);

        $paymentMethod = $request->payment_method;

        return view('order.payment-process', compact('order', 'paymentMethod'));
    }

    public function confirmPayment(Order $order, Request $request)
    {
        // Cek apakah order sudah disetujui/paid
        if ($order->status !== 'paid') {
            return redirect()->back()->with('error', 'Order belum disetujui oleh admin/kasir. Pembayaran tidak bisa diproses.');
        }

        $paymentMethod = $request->payment_method;

        // Validasi berdasarkan metode pembayaran
        if (in_array($paymentMethod, ['qris', 'bank_transfer'])) {
            $request->validate([
                'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
                'bukti_transfer' => 'required|image|max:5120', // max 5MB
            ], [
                'bukti_transfer.required' => 'Bukti pembayaran wajib diupload',
                'bukti_transfer.image'    => 'File harus berupa gambar (JPG, PNG, dll)',
                'bukti_transfer.max'      => 'Ukuran file maksimal 5MB',
            ]);
        } else {
            $request->validate([
                'payment_method' => 'required|in:cash,qris,bank_transfer,ewallet',
            ]);
        }

        // Upload bukti transfer jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        // Update order dengan payment method dan bukti transfer
        $order->update([
            'payment_method' => $request->payment_method,
            'bukti_transfer' => $buktiPath,
            'status_makanan' => 'pesanan sedang diproses',
        ]);

        // Redirect to invoice with success message
        return redirect()->route('order.invoice', $order->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan sedang diproses di dapur.');
    }

    public function downloadInvoicePdf(Order $order)
    {
        $pdf = $pdf = Pdf::loadView('order.struck', compact('order'))
            ->setPaper('a4', 'portrait'); // optional: atur ukuran kertas

        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

    public function showHistoryForm()
    {
        return view('order.history-form');
    }

    public function searchHistory(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:15',
        ], [
            'phone.regex'    => 'No. HP hanya boleh berisi angka (0-9)',
            'phone.min'      => 'No. HP minimal 10 angka',
            'phone.max'      => 'No. HP maksimal 15 angka',
            'phone.required' => 'No. HP tidak boleh kosong',
        ]);

        $phone = $request->phone;

        // Search orders by phone number
        $orders = Order::with(['orderItems.menu'])
            ->where('phone', $phone)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.history-results', compact('orders', 'phone'));
    }

    // API endpoint untuk polling status order
    public function getOrderStatus(Order $order)
    {
        return response()->json([
            'id'             => $order->id,
            'status'         => $order->status,
            'status_makanan' => $order->status_makanan,
            'customer_name'  => $order->customer_name,
            'nomor_meja'     => $order->nomor_meja,
        ]);
    }

    /**
     * Tampilkan daftar order yang menunggu persetujuan
     */
    public function showPendingApproval()
    {
        $pendingOrders = Order::where('approval_status', 'pending_approval')
            ->with('orderItems.menu', 'approvedBy')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.pending-approval', compact('pendingOrders'));
    }

    /**
     * Approve order
     */
    public function approveOrder(Order $order)
    {
        $order->update([
            'approval_status' => 'approved',
            'approved_at'     => now(),
            'approved_by'     => auth()->id(),
            'status'          => 'paid',  // Set status ke paid saat diapprove
            'paid_at'         => now(),
            'status_makanan'  => 'pesanan diterima',
        ]);

        return redirect()->back()->with('success', "Order #{$order->id} berhasil disetujui dan siap diproses!");
    }

    /**
     * Reject order dengan alasan
     */
    public function rejectOrder(Request $request, Order $order)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5|max:500',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi',
            'rejection_reason.min'      => 'Alasan minimal 5 karakter',
            'rejection_reason.max'      => 'Alasan maksimal 500 karakter',
        ]);

        $order->update([
            'approval_status'  => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by'      => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Order #{$order->id} berhasil ditolak!");
    }

}
