<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriMenus = [
            ['nama_kategori' => 'Hasil Laut'],
            ['nama_kategori' => 'Hasil Tani/Kebun']
        ];

        foreach ($kategoriMenus as $kategori) {
            \App\Models\Kategori::create($kategori);
        }
    }
}
