<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Elektronik',
            'Dokumen & Kartu Penting',
            'Kunci',
            'Tas & Dompet',
            'Pakaian & Aksesoris',
            'Buku & Alat Tulis',
            'Lainnya',
        ];

        foreach ($kategori as $item) {
            Kategori::create([
                'nama_kategori' => $item,
                'slug' => Str::slug($item)
            ]);
        }
    }
}
