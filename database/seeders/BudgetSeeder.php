<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Masjid;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjid = Masjid::first();
        if (!$masjid) {
            $this->command->info('Masjid not found, skipping budget seeder');
            return;
        }

        $categories = [
            'Operasional' => 100000000, // 100 juta
            'Zakat' => 50000000,        // 50 juta
            'Infaq' => 30000000,        // 30 juta
        ];

        foreach ($categories as $catName => $amount) {
            $category = Category::where('name', $catName)->first();
            if ($category) {
                Budget::create([
                    'category_id' => $category->id,
                    'masjid_id' => $masjid->id,
                    'name' => "Test Budget - {$catName}",
                    'amount' => $amount,
                    'period' => 'monthly',
                    'start_date' => now()->startOfMonth(),
                    'end_date' => now()->endOfMonth(),
                    'is_active' => true,
                ]);
                $this->command->info("Budget created: {$catName} - Rp " . number_format($amount, 0, ',', '.'));
            }
        }

        $this->command->info('Budget seeder completed!');
    }
}
