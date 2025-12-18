<?php
namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Makanan
        $makananList = [
            [
                'nama'       => 'Nasi Goreng Spesial',
                'kategori'   => 'makanan',
                'harga'      => 35000,
                'stok'       => 50,
                'keterangan' => 'Nasi goreng dengan telur, udang, dan sayuran',
                'status'     => true,
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Mie Goreng',
                'kategori'   => 'makanan',
                'harga'      => 32000,
                'stok'       => 45,
                'keterangan' => 'Mie goreng dengan telur dan sayuran pilihan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Ayam Goreng Crispy',
                'kategori'   => 'makanan',
                'harga'      => 42000,
                'stok'       => 40,
                'keterangan' => 'Ayam goreng dengan kulit krispy, nasi putih dan sambal',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Ikan Bakar',
                'kategori'   => 'makanan',
                'harga'      => 45000,
                'stok'       => 30,
                'keterangan' => 'Ikan bakar bumbu khas dengan nasi dan lalapan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Soto Ayam',
                'kategori'   => 'makanan',
                'harga'      => 28000,
                'stok'       => 50,
                'keterangan' => 'Soto ayam tradisional dengan kuning telur dan kuah gurih',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Rendang Daging',
                'kategori'   => 'makanan',
                'harga'      => 48000,
                'stok'       => 35,
                'keterangan' => 'Rendang daging sapi dengan santan dan rempah pilihan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Lumpia Goreng',
                'kategori'   => 'makanan',
                'harga'      => 18000,
                'stok'       => 60,
                'keterangan' => 'Lumpia goreng dengan isi daging dan sayuran (5 pcs)',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Satay Ayam',
                'kategori'   => 'makanan',
                'harga'      => 25000,
                'stok'       => 40,
                'keterangan' => 'Satay ayam dengan bumbu kacang dan siraman kuah',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Perkedel',
                'kategori'   => 'makanan',
                'harga'      => 12000,
                'stok'       => 70,
                'keterangan' => 'Perkedel kentang gurih (4 pcs)',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Tahu Goreng',
                'kategori'   => 'makanan',
                'harga'      => 15000,
                'stok'       => 65,
                'keterangan' => 'Tahu goreng krispy dengan saus kental (4 pcs)',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Martabak Telur',
                'kategori'   => 'makanan',
                'harga'      => 22000,
                'stok'       => 55,
                'keterangan' => 'Martabak telur dengan daging cincang dan bawang',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Bakso Daging',
                'kategori'   => 'makanan',
                'harga'      => 30000,
                'stok'       => 50,
                'keterangan' => 'Bakso daging sapi dalam kuah kaldu gurih',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
        ];

        // Data Minuman
        $minumanList = [
            [
                'nama'       => 'Kopi Hitam',
                'kategori'   => 'minuman',
                'harga'      => 12000,
                'stok'       => 100,
                'keterangan' => 'Kopi hitam premium dari biji pilihan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Kopi Susu',
                'kategori'   => 'minuman',
                'harga'      => 15000,
                'stok'       => 100,
                'keterangan' => 'Kopi susu dengan susu segar dan manis pas',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Cappuccino',
                'kategori'   => 'minuman',
                'harga'      => 18000,
                'stok'       => 80,
                'keterangan' => 'Cappuccino dengan espresso dan foam susu lembut',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Latte',
                'kategori'   => 'minuman',
                'harga'      => 18000,
                'stok'       => 80,
                'keterangan' => 'Latte creamy dengan perpaduan espresso dan susu hangat',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Americano',
                'kategori'   => 'minuman',
                'harga'      => 14000,
                'stok'       => 90,
                'keterangan' => 'Americano dengan espresso dan air panas',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Teh Tarik',
                'kategori'   => 'minuman',
                'harga'      => 10000,
                'stok'       => 100,
                'keterangan' => 'Teh tarik tradisional dengan susu kental manis',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Teh Hijau',
                'kategori'   => 'minuman',
                'harga'      => 9000,
                'stok'       => 100,
                'keterangan' => 'Teh hijau segar tanpa gula tambahan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Es Jeruk',
                'kategori'   => 'minuman',
                'harga'      => 8000,
                'stok'       => 120,
                'keterangan' => 'Es jeruk segar dengan es batu',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Es Teh Manis',
                'kategori'   => 'minuman',
                'harga'      => 7000,
                'stok'       => 120,
                'keterangan' => 'Es teh manis tradisional',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Es Kelapa Muda',
                'kategori'   => 'minuman',
                'harga'      => 15000,
                'stok'       => 70,
                'keterangan' => 'Es kelapa muda segar dengan daging kelapa',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Jus Mangga',
                'kategori'   => 'minuman',
                'harga'      => 18000,
                'stok'       => 60,
                'keterangan' => 'Jus mangga segar dari buah pilihan',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Jus Strawberry',
                'kategori'   => 'minuman',
                'harga'      => 18000,
                'stok'       => 60,
                'keterangan' => 'Jus strawberry segar dengan susu dan madu',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Smoothie Bowl',
                'kategori'   => 'minuman',
                'harga'      => 25000,
                'stok'       => 50,
                'keterangan' => 'Smoothie bowl dengan granola dan topping buah',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Milkshake Vanilla',
                'kategori'   => 'minuman',
                'harga'      => 20000,
                'stok'       => 70,
                'keterangan' => 'Milkshake vanilla dengan es krim premium',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
            [
                'nama'       => 'Milkshake Coklat',
                'kategori'   => 'minuman',
                'harga'      => 20000,
                'stok'       => 70,
                'keterangan' => 'Milkshake coklat dengan es krim berkualitas',
                'status'     => 'active',
                'foto'       => 'default.jpg',
            ],
        ];

        // Insert semua data
        foreach (array_merge($makananList, $minumanList) as $menu) {
            Menu::create($menu);
        }

        $this->command->info('✅ Menu dummy berhasil dibuat! (12 Makanan + 15 Minuman)');
    }
}
