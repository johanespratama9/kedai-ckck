<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('🔐 Membuat akun users dengan role...');
        $this->command->newLine();

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@kedai-ckck.local'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123456'),
                'role'     => 'admin',
            ]
        );
        $this->command->line('   ✅ Admin: admin@kedai-ckck.local / admin123456 (Role: admin)');

        // Dapur
        User::updateOrCreate(
            ['email' => 'dapur@kedai-ckck.local'],
            [
                'name'     => 'Staff Dapur',
                'password' => Hash::make('dapur123456'),
                'role'     => 'dapur',
            ]
        );
        $this->command->line('   ✅ Dapur: dapur@kedai-ckck.local / dapur123456 (Role: dapur)');

        // Kasir
        User::updateOrCreate(
            ['email' => 'kasir@kedai-ckck.local'],
            [
                'name'     => 'Staff Kasir',
                'password' => Hash::make('kasir123456'),
                'role'     => 'kasir',
            ]
        );
        $this->command->line('   ✅ Kasir: kasir@kedai-ckck.local / kasir123456 (Role: kasir)');

        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('✨ Role Seeder Selesai!');
        $this->command->info('═══════════════════════════════════════════════════════════');
    }
}
