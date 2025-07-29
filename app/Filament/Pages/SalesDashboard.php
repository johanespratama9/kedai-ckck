<?php
namespace App\Filament\Pages;

use App\Exports\OrdersExport;
use App\Models\Order;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;

class SalesDashboard extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static string $view             = 'filament.pages.sales-dashboard';
    protected static ?string $title           = 'Dashboard Penjualan';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static ?int $navigationSort     = -1;

    public $totalOrder;
    public $totalPendapatan;
    public $orderSelesai;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->name === 'admin';
    }
    public function mount(): void
    {
        $this->totalOrder      = Order::count();
        $this->totalPendapatan = Order::sum('total_harga');
        $this->orderSelesai    = Order::where('status_makanan', 'pesanan selesai')->count();
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
