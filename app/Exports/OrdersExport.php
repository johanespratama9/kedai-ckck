<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
     * Ambil data order untuk di-export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::all(); // bisa tambahkan ->select(...) untuk kolom tertentu
    }
}
