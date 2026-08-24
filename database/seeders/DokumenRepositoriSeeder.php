<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenRepositoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = ['Berita Acara', 'Surat Keputusan', 'Laporan', 'Lainnya'];
        for ($i = 1; $i <= 15; $i++) {
            \App\Models\DokumenRepositori::create([
                'nama' => 'Dokumen Legal Museum ' . $i,
                'kategori' => $kategori[array_rand($kategori)],
                'path_file' => 'dummy/path/doc_' . $i . '.pdf',
                'ukuran' => rand(1, 20) . '.' . rand(1, 9) . ' MB',
                'created_at' => now()->subDays(rand(1, 60))
            ]);
        }
    }
}
