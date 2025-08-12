<?php
namespace App\Filament\Pages;

use App\Exports\OrdersExport;
use App\Models\Order;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SalesDashboard extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static string $view             = 'filament.pages.sales-dashboard';
    protected static ?string $title           = 'Dasbor Penjualan';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static ?int $navigationSort     = -1;
    protected static string $routePath        = '/'; // Set as root path

    public $totalOrder;
    public $totalPendapatan;
    public $orderSelesai;

    // Laporan Harian
    public $totalOrderHari;
    public $totalPendapatanHari;
    public $orderSelesaiHari;

    // Laporan Mingguan
    public $totalOrderMinggu;
    public $totalPendapatanMinggu;
    public $orderSelesaiMinggu;

    // Laporan Bulanan
    public $totalOrderBulan;
    public $totalPendapatanBulan;
    public $orderSelesaiBulan;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->name === 'admin';
    }

    public function mount(): void
    {
        $today        = Carbon::today();
        $startOfWeek  = Carbon::now()->startOfWeek();
        $endOfWeek    = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // Total keseluruhan
        $this->totalOrder      = Order::count();
        $this->totalPendapatan = Order::sum('total_harga');
        $this->orderSelesai    = Order::where('status_makanan', 'pesanan selesai')->count();

        // Laporan harian (hari ini)
        $this->totalOrderHari      = Order::whereDate('created_at', $today)->count();
        $this->totalPendapatanHari = Order::whereDate('created_at', $today)->sum('total_harga');
        $this->orderSelesaiHari    = Order::whereDate('created_at', $today)
            ->where('status_makanan', 'pesanan selesai')->count();

        // Laporan mingguan (minggu ini)
        $this->totalOrderMinggu      = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $this->totalPendapatanMinggu = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_harga');
        $this->orderSelesaiMinggu    = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status_makanan', 'pesanan selesai')->count();

        // Laporan bulanan (bulan ini)
        $this->totalOrderBulan      = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $this->totalPendapatanBulan = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_harga');
        $this->orderSelesaiBulan    = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status_makanan', 'pesanan selesai')->count();
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'laporan_penjualan.xlsx');
    }
}
