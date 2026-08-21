<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['nama' => 'Senjata Tradisional', 'kode' => 'SNJ'],
            ['nama' => 'Pakaian Adat', 'kode' => 'PKD'],
            ['nama' => 'Alat Musik', 'kode' => 'MUS'],
            ['nama' => 'Perhiasan', 'kode' => 'PRH'],
            ['nama' => 'Alat Rumah Tangga', 'kode' => 'ART'],
        ]);
    }
}
