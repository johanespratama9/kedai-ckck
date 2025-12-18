<?php
namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Console\Command;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup {--fix-menu-status : Fix menu status yang tidak muncul}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup database - fix menu status dan buat akun dapur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->displayBanner();

        if ($this->option('fix-menu-status')) {
            $this->fixMenuStatus();
        }

        $this->line('');
        $this->createDapurAccount();

        $this->line('');
        $this->displayStatus();
    }

    private function displayBanner()
    {
        $this->info('');
        $this->info('╔═══════════════════════════════════════════════════════════╗');
        $this->info('║                    KEDAI CKCK SETUP                        ║');
        $this->info('║              Coffee & Kitchen Management System             ║');
        $this->info('╚═══════════════════════════════════════════════════════════╝');
        $this->info('');
    }

    private function fixMenuStatus()
    {
        $this->line('📋 <info>Memperbaiki Menu Status...</info>');
        $this->line('');

        // Count menu sebelum fix
        $beforeCount = Menu::where('status', '!=', 1)->count();

        if ($beforeCount > 0) {
            // Fix menu status
            Menu::query()->update(['status' => 1]);

            $this->info('   ✅ Berhasil diperbaiki: ' . $beforeCount . ' menu');
            $this->line('');
        } else {
            $this->info('   ✅ Semua menu status sudah benar');
            $this->line('');
        }

        // Display menu statistics
        $totalMenus   = Menu::count();
        $makananCount = Menu::where('kategori', 'makanan')->count();
        $minumanCount = Menu::where('kategori', 'minuman')->count();

        $this->line('   📊 Statistik Menu:');
        $this->line('   ├─ Total Menu: <fg=cyan>' . $totalMenus . '</> items');
        $this->line('   ├─ Makanan: <fg=yellow>' . $makananCount . '</> items');
        $this->line('   └─ Minuman: <fg=blue>' . $minumanCount . '</> items');
        $this->line('');
    }

    private function createDapurAccount()
    {
        $this->line('👨‍🍳 <info>Setup Akun Dapur...</info>');
        $this->line('');

        // Check apakah akun dapur sudah ada
        $dapurUser = User::where('name', 'dapur')->first();

        if ($dapurUser) {
            $this->info('   ⚠️  Akun dapur sudah ada');
            $this->line('');
            $this->line('   Informasi Akun:');
            $this->line('   ├─ Nama: <fg=cyan>dapur</>');
            $this->line('   ├─ Email: <fg=cyan>' . $dapurUser->email . '</>');
            $this->line('   └─ Password: <fg=yellow>silahkan reset jika lupa</>');
        } else {
            // Create akun dapur baru
            $email    = 'dapur@kedai-ckck.local';
            $password = 'dapur123456';

            User::create([
                'name'     => 'dapur',
                'email'    => $email,
                'password' => bcrypt($password),
            ]);

            $this->info('   ✅ Akun dapur berhasil dibuat');
            $this->line('');
            $this->line('   Informasi Akun:');
            $this->line('   ├─ Nama: <fg=cyan>dapur</>');
            $this->line('   ├─ Email: <fg=cyan>' . $email . '</>');
            $this->line('   └─ Password: <fg=yellow>' . $password . '</>');
        }

        $this->line('');
    }

    private function displayStatus()
    {
        $this->line('═══════════════════════════════════════════════════════════');
        $this->info('✨ <info>Setup Selesai!</info>');
        $this->line('═══════════════════════════════════════════════════════════');
        $this->line('');
        $this->line('📱 Akses Aplikasi:');
        $this->line('   Admin: <fg=cyan>http://localhost:8000/admin</> (admin@example.com)');
        $this->line('   Dapur: <fg=cyan>http://localhost:8000/admin</> (dapur@kedai-ckck.local)');
        $this->line('   Order: <fg=cyan>http://localhost:8000/order?meja=1</>');
        $this->line('');
        $this->line('💡 Tips:');
        $this->line('   • Gunakan fix menu status jika menu tidak muncul');
        $this->line('   • Akun dapur bisa login ke halaman dapur untuk lihat pesanan');
        $this->line('');
    }
}
