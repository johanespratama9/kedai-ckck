<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Ambil data pesanan untuk di-export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::with(['orderItems.menu'])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Header kolom untuk file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Tanggal Pesanan',
            'Nomor Meja',
            'Status Makanan',
            'Status Pembayaran',
            'Total Harga',
            'Detail Menu',
            'Jumlah Item',
        ];
    }

    /**
     * Mapping data untuk setiap baris
     *
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        $menuDetails = $order->orderItems->map(function ($item) {
            return $item->menu->nama . ' (x' . $item->quantity . ')';
        })->implode(', ');

        $totalItems = $order->orderItems->sum('quantity');

        return [
            $order->id,
            $order->created_at->format('d/m/Y H:i:s'),
            $order->nomor_meja,
            ucfirst($order->status_makanan),
            ucfirst($order->status_pembayaran),
            'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            $menuDetails,
            $totalItems,
        ];
    }

    /**
     * Styling untuk worksheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header row
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }
}
