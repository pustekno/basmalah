<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Income Categories
        $zakatCategory = Category::create([
            'name' => 'Zakat',
            'type' => 'income',
            'description' => 'Zakat dari jamaah',
            'color' => '#10B981',
            'order' => 1,
        ]);

        $infaqCategory = Category::create([
            'name' => 'Infaq',
            'type' => 'income',
            'description' => 'Infaq dan sedekah',
            'color' => '#3B82F6',
            'order' => 2,
        ]);

        $sedekahCategory = Category::create([
            'name' => 'Sedekah',
            'type' => 'income',
            'description' => 'Sedekah dari jamaah',
            'color' => '#8B5CF6',
            'order' => 3,
        ]);

        $donasiCategory = Category::create([
            'name' => 'Donasi',
            'type' => 'income',
            'description' => 'Donasi untuk pembangunan dan program masjid',
            'color' => '#F59E0B',
            'order' => 4,
        ]);

        // Expense Categories
        $operasionalCategory = Category::create([
            'name' => 'Operasional',
            'type' => 'expense',
            'description' => 'Biaya operasional masjid',
            'color' => '#EF4444',
            'order' => 1,
        ]);

        // Sub-categories for Operasional
        Category::create([
            'name' => 'Listrik & Air',
            'type' => 'expense',
            'parent_id' => $operasionalCategory->id,
            'description' => 'Biaya listrik dan air',
            'color' => '#EF4444',
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Kebersihan',
            'type' => 'expense',
            'parent_id' => $operasionalCategory->id,
            'description' => 'Biaya kebersihan dan perawatan',
            'color' => '#EF4444',
            'order' => 2,
        ]);

        $perlengkapanCategory = Category::create([
            'name' => 'Perlengkapan',
            'type' => 'expense',
            'description' => 'Pembelian perlengkapan masjid',
            'color' => '#F97316',
            'order' => 2,
        ]);

        $pengajianCategory = Category::create([
            'name' => 'Pengajian',
            'type' => 'expense',
            'description' => 'Biaya pengajian dan kajian',
            'color' => '#06B6D4',
            'order' => 3,
        ]);

        $santunanCategory = Category::create([
            'name' => 'Santunan',
            'type' => 'expense',
            'description' => 'Santunan untuk anak yatim dan dhuafa',
            'color' => '#8B5CF6',
            'order' => 4,
        ]);

        $pembangunanCategory = Category::create([
            'name' => 'Pembangunan',
            'type' => 'expense',
            'description' => 'Biaya pembangunan dan renovasi',
            'color' => '#EC4899',
            'order' => 5,
        ]);

        $this->command->info('Categories created successfully!');
        $this->command->info('- Created 4 income categories');
        $this->command->info('- Created 5 expense categories with 2 sub-categories');
    }
}
