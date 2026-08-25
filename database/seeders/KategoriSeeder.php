<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insertOrIgnore([
            ['nama' => 'Senjata Tradisional', 'kode' => 'SNJ'],
            ['nama' => 'Seni Rupa / Kriya', 'kode' => 'SRK'],
            ['nama' => 'Alat Musik', 'kode' => 'MUS'],
            ['nama' => 'Perhiasan', 'kode' => 'PRH'],
            ['nama' => 'Alat Rumah Tangga', 'kode' => 'ART'],
            ['nama' => 'Alat Pertanian', 'kode' => 'APN'],
            ['nama' => 'Alat Pertukangan', 'kode' => 'APT'],
            ['nama' => 'Alat Memakan Sirih', 'kode' => 'AMS'],
            ['nama' => 'Alat Berburu dan Menangkap Ikan', 'kode' => 'ABMI'],
            ['nama' => 'Jenis Patung', 'kode' => 'PTG'], // <-- sudah diperbaiki
            ['nama' => 'Numismatika', 'kode' => 'NMA'],
            ['nama' => 'Jenis Tongkat', 'kode' => 'JKT'],
        ]);
    }
}