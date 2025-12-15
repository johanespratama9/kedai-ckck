<?php
namespace App\Console\Commands;

use App\Models\Menu;
use Illuminate\Console\Command;

class FixMenuCategory extends Command
{
    protected $signature   = 'menu:fix-category';
    protected $description = 'Fix and standardize menu categories';

    public function handle()
    {
        $this->info('Starting menu category fix...');

        $updated = 0;
        $menus   = Menu::all();

        foreach ($menus as $menu) {
            if (! in_array($menu->kategori, ['makanan', 'minuman'])) {
                $menu->kategori = strtolower(trim($menu->kategori));
                $menu->save();
                $updated++;
            }
        }

        $this->info("Fixed {$updated} menu items.");
        return Command::SUCCESS;
    }
}
