<?php
namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding database Kedai CKCK...');
        $this->command->newLine();

        // =====================
        // SEED USERS
        // =====================
        $this->command->info('👤 Membuat akun users...');

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@kedai-ckck.local'],
            [
                'name'     => 'admin',
                'password' => Hash::make('admin123456'),
                'role'     => 'admin',
            ]
        );
        $this->command->line('   ✅ Admin: admin@kedai-ckck.local / admin123456');

        // Dapur
        User::updateOrCreate(
            ['email' => 'dapur@kedai-ckck.local'],
            [
                'name'     => 'dapur',
                'password' => Hash::make('dapur123456'),
                'role'     => 'dapur',
            ]
        );
        $this->command->line('   ✅ Dapur: dapur@kedai-ckck.local / dapur123456');

        // Kasir
        User::updateOrCreate(
            ['email' => 'kasir@kedai-ckck.local'],
            [
                'name'     => 'kasir',
                'password' => Hash::make('kasir123456'),
                'role'     => 'kasir',
            ]
        );
        $this->command->line('   ✅ Kasir: kasir@kedai-ckck.local / kasir123456');

        $this->command->newLine();

        // =====================
        // SEED MENUS
        // =====================
        $this->command->info('🍔 Membuat data menu...');

        $menus = [
            // MAKANAN
            ['nama' => 'Nasi Goreng Spesial', 'kategori' => 'makanan', 'harga' => 25000, 'stok' => 50, 'keterangan' => 'Nasi goreng dengan telur, ayam, dan sayuran', 'status' => true],
            ['nama' => 'Mie Goreng Jawa', 'kategori' => 'makanan', 'harga' => 22000, 'stok' => 50, 'keterangan' => 'Mie goreng bumbu khas Jawa', 'status' => true],
            ['nama' => 'Ayam Geprek', 'kategori' => 'makanan', 'harga' => 20000, 'stok' => 40, 'keterangan' => 'Ayam crispy dengan sambal geprek pedas', 'status' => true],
            ['nama' => 'Ayam Bakar Madu', 'kategori' => 'makanan', 'harga' => 28000, 'stok' => 30, 'keterangan' => 'Ayam bakar dengan saus madu manis', 'status' => true],
            ['nama' => 'Sate Ayam', 'kategori' => 'makanan', 'harga' => 25000, 'stok' => 35, 'keterangan' => '10 tusuk sate dengan bumbu kacang', 'status' => true],
            ['nama' => 'Bakso Urat Jumbo', 'kategori' => 'makanan', 'harga' => 20000, 'stok' => 40, 'keterangan' => 'Bakso urat dengan mie dan tahu', 'status' => true],
            ['nama' => 'Indomie Goreng', 'kategori' => 'makanan', 'harga' => 12000, 'stok' => 100, 'keterangan' => 'Indomie goreng dengan telur', 'status' => true],
            ['nama' => 'Indomie Kuah', 'kategori' => 'makanan', 'harga' => 12000, 'stok' => 100, 'keterangan' => 'Indomie kuah dengan telur', 'status' => true],
            ['nama' => 'French Fries', 'kategori' => 'makanan', 'harga' => 15000, 'stok' => 50, 'keterangan' => 'Kentang goreng crispy dengan saus', 'status' => true],
            ['nama' => 'Roti Bakar Coklat', 'kategori' => 'makanan', 'harga' => 15000, 'stok' => 30, 'keterangan' => 'Roti bakar dengan selai coklat', 'status' => true],

            // MINUMAN
            ['nama' => 'Es Kopi Susu', 'kategori' => 'minuman', 'harga' => 18000, 'stok' => 100, 'keterangan' => 'Kopi susu dengan gula aren', 'status' => true],
            ['nama' => 'Americano', 'kategori' => 'minuman', 'harga' => 15000, 'stok' => 100, 'keterangan' => 'Espresso dengan air panas', 'status' => true],
            ['nama' => 'Cappuccino', 'kategori' => 'minuman', 'harga' => 20000, 'stok' => 80, 'keterangan' => 'Espresso dengan susu foam', 'status' => true],
            ['nama' => 'Latte', 'kategori' => 'minuman', 'harga' => 22000, 'stok' => 80, 'keterangan' => 'Espresso dengan susu steamed', 'status' => true],
            ['nama' => 'Matcha Latte', 'kategori' => 'minuman', 'harga' => 25000, 'stok' => 50, 'keterangan' => 'Green tea latte dengan susu', 'status' => true],
            ['nama' => 'Es Teh Manis', 'kategori' => 'minuman', 'harga' => 8000, 'stok' => 200, 'keterangan' => 'Teh manis dingin segar', 'status' => true],
            ['nama' => 'Es Jeruk', 'kategori' => 'minuman', 'harga' => 10000, 'stok' => 150, 'keterangan' => 'Jeruk peras segar dengan es', 'status' => true],
            ['nama' => 'Jus Alpukat', 'kategori' => 'minuman', 'harga' => 18000, 'stok' => 50, 'keterangan' => 'Jus alpukat dengan susu coklat', 'status' => true],
            ['nama' => 'Jus Mangga', 'kategori' => 'minuman', 'harga' => 15000, 'stok' => 50, 'keterangan' => 'Jus mangga segar', 'status' => true],
            ['nama' => 'Air Mineral', 'kategori' => 'minuman', 'harga' => 5000, 'stok' => 300, 'keterangan' => 'Air mineral botol 600ml', 'status' => true],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['nama' => $menu['nama']],
                $menu
            );
        }

        $makananCount = Menu::where('kategori', 'makanan')->count();
        $minumanCount = Menu::where('kategori', 'minuman')->count();
        $this->command->line("   ✅ Makanan: {$makananCount} items");
        $this->command->line("   ✅ Minuman: {$minumanCount} items");

        $this->command->newLine();

        // =====================
        // SEED TABLES
        // =====================
        $this->command->info('🪑 Membuat data meja...');

        for ($i = 1; $i <= 10; $i++) {
            Table::updateOrCreate(
                ['nomor_meja' => (string) $i],
                [
                    'qr_code_path' => null,
                ]
            );
        }
        $this->command->line('   ✅ 10 meja berhasil dibuat');

        $this->command->newLine();

        // =====================
        // SUMMARY
        // =====================
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('✨ Seeding Selesai!');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->newLine();
        $this->command->line('📱 Akses Aplikasi:');
        $this->command->line('   Admin: http://localhost:8000/admin');
        $this->command->line('   Order: http://localhost:8000/order?meja=1');
        $this->command->newLine();
        $this->command->line('🔐 Login Credentials:');
        $this->command->line('   Admin: admin@kedai-ckck.local / admin123456');
        $this->command->line('   Dapur: dapur@kedai-ckck.local / dapur123456');
        $this->command->line('   Kasir: kasir@kedai-ckck.local / kasir123456');
        $this->command->newLine();
    }
}
