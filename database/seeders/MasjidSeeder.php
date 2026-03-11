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
                'nama' => 'Masjid Al-Ikhlas',
                'alamat' => 'Jl. Raya Bogor No. 123, Jakarta Timur',
                'telepon' => '021-12345678',
                'email' => 'info@masjid-alikhlas.com',
                'deskripsi' => 'Masjid Al-Ikhlas adalah masjid yang terletak di Jakarta Timur',
            ],
            [
                'nama' => 'Masjid An-Nur',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta Pusat',
                'telepon' => '021-87654321',
                'email' => 'info@masjid-annur.com',
                'deskripsi' => 'Masjid An-Nur adalah masjid yang terletak di Jakarta Pusat',
            ],
            [
                'nama' => 'Masjid At-Taqwa',
                'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'telepon' => '021-11223344',
                'email' => 'info@masjid-attaqwa.com',
                'deskripsi' => 'Masjid At-Taqwa adalah masjid yang terletak di Jakarta Selatan',
            ],
        ];

        foreach ($masjids as $masjid) {
            \App\Models\Masjid::create($masjid);
        }
    }
}
