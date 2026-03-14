<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasjidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjids = [
            [
                'name' => 'Masjid Al-Ikhlas',
                'address' => 'Jl. Raya Bogor No. 123, Jakarta Timur',
                'phone' => '021-12345678',
                'email' => 'info@masjid-alikhlas.com',
                'description' => 'Masjid Al-Ikhlas adalah masjid yang terletak di Jakarta Timur',
                'is_active' => true,
            ],
            [
                'name' => 'Masjid An-Nur',
                'address' => 'Jl. Sudirman No. 456, Jakarta Pusat',
                'phone' => '021-87654321',
                'email' => 'info@masjid-annur.com',
                'description' => 'Masjid An-Nur adalah masjid yang terletak di Jakarta Pusat',
                'is_active' => true,
            ],
            [
                'name' => 'Masjid At-Taqwa',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'phone' => '021-11223344',
                'email' => 'info@masjid-attaqwa.com',
                'description' => 'Masjid At-Taqwa adalah masjid yang terletak di Jakarta Selatan',
                'is_active' => true,
            ],
        ];

        foreach ($masjids as $masjid) {
            \App\Models\Masjid::firstOrCreate(
                ['name' => $masjid['name']], // Cek berdasarkan nama
                $masjid // Data lengkap
            );
        }
    }
}
