<?php
namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-expired {--minutes=30 : Waktu dalam menit sebelum order di-cancel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending orders yang telah melampaui waktu timeout (default 30 menit)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minutes    = $this->option('minutes');
        $expiryTime = Carbon::now()->subMinutes($minutes);

        // Cari semua pending orders yang sudah melebihi waktu timeout
        $expiredOrders = Order::where('status', 'pending')
            ->where('started_at', '<=', $expiryTime)
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada order yang perlu di-cancel.');
            return 0;
        }

        // Cancel all expired orders
        $count = 0;
        foreach ($expiredOrders as $order) {
            try {
                $order->update([
                    'status' => 'canceled',
                ]);

                // Kembalikan stok menu
                foreach ($order->orderItems as $item) {
                    $item->menu->increment('stok', $item->quantity);
                }

                $count++;
                $this->info("✓ Order #{$order->id} (Meja {$order->nomor_meja}) berhasil di-cancel.");
            } catch (\Exception $e) {
                $this->error("✗ Gagal cancel order #{$order->id}: {$e->getMessage()}");
            }
        }

        $this->info("Total order yang di-cancel: {$count}");
        return 0;
    }
}
