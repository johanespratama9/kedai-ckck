<?php
namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua dulu biar bersih
        Order::truncate();

        // Buat data 30 hari terakhir
        foreach (range(1, 30) as $day) {
            $date = Carbon::now()->subDays(30 - $day);

            // Buat random 1–5 order per hari
            foreach (range(1, rand(1, 5)) as $i) {
                Order::create([
                    'nomor_meja'  => rand(1, 10),
                    'status'      => 'pending', // gunakan status yg valid sesuai check constraint
                    'total_harga' => rand(20000, 150000),
                    'created_at'  => $date->copy()->addMinutes(rand(0, 1440)),
                    'updated_at'  => $date->copy()->addMinutes(rand(0, 1440)),
                ]);
            }
        }
    }
}
